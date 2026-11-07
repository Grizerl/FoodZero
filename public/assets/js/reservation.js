// Reservation form: slots per date and submit without reloading the page.
// Works as progressive enhancement: without JS the form posts normally and the server re-renders it.
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form.reservation-form').forEach(initForm);
});

function initForm(form) {
    const slotsUrl = form.dataset.slotsUrl;
    const dateInput = form.querySelector('[name="reservation_date"]');
    const slotsList = form.querySelector('[data-slots-list]');
    const slotsHint = form.querySelector('[data-slots-hint]');
    const statusBox = form.querySelector('[data-form-status]');
    const submit = form.querySelector('[type="submit"]');

    if (!slotsUrl || !dateInput || !slotsList || !statusBox || !submit) {
        return;
    }

    const GENERIC_ERROR = 'Something went wrong. Please try again in a moment.';
    let slotsRequest = null;
    let sending = false;

    function errorBox(name) {
        return form.querySelector('[data-error-for="' + name + '"]');
    }

    function clearErrors() {
        form.querySelectorAll('[data-error-for]').forEach(function (box) {
            box.textContent = '';
        });
        form.querySelectorAll('[aria-invalid]').forEach(function (field) {
            field.removeAttribute('aria-invalid');
        });
    }

    function showError(name, message) {
        const box = errorBox(name);
        if (box) {
            box.textContent = message;
        }
        form.querySelectorAll('[name="' + name + '"]').forEach(function (field) {
            field.setAttribute('aria-invalid', 'true');
        });
    }

    function showStatus(message, ok) {
        statusBox.className = 'form-status ' + (ok ? 'form-success' : 'form-failure');
        statusBox.textContent = message;
    }

    function clearStatus() {
        statusBox.className = 'form-status';
        statusBox.textContent = '';
    }

    function renderSlots(slots) {
        slotsList.textContent = '';

        slots.forEach(function (slot) {
            const id = 'slot-' + slot.time.replace(':', '');
            const input = document.createElement('input');
            input.id = id;
            input.className = 'slots__input';
            input.type = 'radio';
            input.name = 'reservation_slot';
            input.value = slot.time;
            input.disabled = !slot.available;

            const label = document.createElement('label');
            label.className = 'slots__slot';
            label.htmlFor = id;
            label.textContent = slot.label;

            slotsList.append(input, label);
        });

        slotsHint.textContent = slots.length && !slots.some(function (slot) { return slot.available; })
            ? 'No free tables on this day. Please choose another date.'
            : '';
    }

    // Loads the slots of the chosen date; a newer request cancels the older one.
    async function loadSlots() {
        const date = dateInput.value;

        if (slotsRequest) {
            slotsRequest.abort();
        }

        errorBox('reservation_date').textContent = '';
        dateInput.removeAttribute('aria-invalid');

        if (!date) {
            renderSlots([]);
            slotsHint.textContent = 'Choose a date to see the available times.';
            return;
        }

        const controller = new AbortController();
        slotsRequest = controller;
        slotsList.setAttribute('aria-busy', 'true');

        try {
            const response = await fetch(slotsUrl + '?date=' + encodeURIComponent(date), {
                headers: { Accept: 'application/json' },
                signal: controller.signal,
            });
            const data = await response.json();

            if (response.status === 422) {
                renderSlots([]);
                slotsHint.textContent = '';
                showError('reservation_date', (data.errors && data.errors.date && data.errors.date[0]) || 'Please choose another date.');
            } else if (response.ok) {
                renderSlots(data.slots);
            } else {
                throw new Error('slots');
            }
        } catch (error) {
            if (error.name === 'AbortError') {
                return;
            }
            renderSlots([]);
            slotsHint.textContent = 'Could not load the available times. Please try again.';
        } finally {
            if (slotsRequest === controller) {
                slotsRequest = null;
                slotsList.removeAttribute('aria-busy');
            }
        }
    }

    function focusFirstInvalid() {
        const invalid = form.querySelector('[aria-invalid="true"]');
        if (!invalid) {
            return;
        }
        if (invalid.name === 'reservation_slot') {
            const first = form.querySelector('[name="reservation_slot"]:not(:disabled)');
            (first || dateInput).focus();
        } else {
            invalid.focus();
        }
    }

    async function send() {
        sending = true;
        submit.disabled = true;
        submit.setAttribute('aria-busy', 'true');
        clearErrors();
        clearStatus();

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            });

            if (response.status === 201) {
                const data = await response.json();
                const date = dateInput.value;
                form.reset();
                dateInput.value = date;
                showStatus(data.message, true);
                await loadSlots();
            } else if (response.status === 422) {
                const data = await response.json();
                const errors = data.errors || {};
                // The slot may have been taken meanwhile: refresh the list so it turns grey.
                if (errors.reservation_slot || errors.reservation_date) {
                    await loadSlots();
                }
                Object.keys(errors).forEach(function (name) {
                    showError(name, errors[name][0]);
                });
                focusFirstInvalid();
            } else if (response.status === 419) {
                showStatus('Your session has expired. Please reload the page and try again.', false);
            } else {
                showStatus(GENERIC_ERROR, false);
            }
        } catch (error) {
            showStatus(GENERIC_ERROR, false);
        } finally {
            sending = false;
            submit.disabled = false;
            submit.removeAttribute('aria-busy');
        }
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        if (!sending) {
            send();
        }
    });

    dateInput.addEventListener('change', function () {
        clearStatus();
        loadSlots();
    });
}
