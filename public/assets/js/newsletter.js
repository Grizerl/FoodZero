// Footer newsletter form: submits without reloading the page.
// Progressive enhancement: without JS the form posts normally and the server re-renders the message.
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form[data-newsletter-form]').forEach(initForm);
});

function initForm(form) {
    const status = document.querySelector('[data-newsletter-status]');
    const email = form.querySelector('[name="email"]');
    const submit = form.querySelector('[type="submit"]');

    if (!status || !email || !submit || !window.fetch) {
        return;
    }

    const GENERIC_ERROR = 'Something went wrong. Please try again in a moment.';
    let sending = false;

    function show(message, ok) {
        status.className = 'newsletter-status ' + (ok ? 'is-success' : 'is-error');
        status.textContent = message;
        email.toggleAttribute('aria-invalid', !ok);
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        if (sending) {
            return;
        }

        sending = true;
        submit.disabled = true;

        fetch(form.action, {
            method: 'POST',
            headers: { 'Accept': 'application/json' },
            body: new FormData(form),
        })
            .then(function (response) {
                return response.json().catch(function () { return {}; }).then(function (data) {
                    return { status: response.status, data: data };
                });
            })
            .then(function (result) {
                if (result.status === 422 && result.data.errors && result.data.errors.email) {
                    show(result.data.errors.email[0], false);
                } else if (result.status === 429) {
                    show('Too many attempts. Please wait a minute and try again.', false);
                } else if (result.status >= 200 && result.status < 300) {
                    show(result.data.message || 'Please check your inbox to confirm.', true);
                    form.reset();
                } else {
                    show(GENERIC_ERROR, false);
                }
            })
            .catch(function () {
                show(GENERIC_ERROR, false);
            })
            .finally(function () {
                sending = false;
                submit.disabled = false;
            });
    });
}
