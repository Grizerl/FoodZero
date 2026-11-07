// "Call us": on touch devices the tel: link dials; with a mouse it opens a dialog with the number.
document.addEventListener('DOMContentLoaded', function () {
    const trigger = document.querySelector('[data-call-dialog]');
    const dialog = trigger && document.getElementById(trigger.dataset.callDialog);

    if (!trigger || !dialog || typeof dialog.showModal !== 'function') {
        return;
    }

    const copyButton = dialog.querySelector('[data-call-copy]');
    const closeButton = dialog.querySelector('[data-call-close]');
    const numberEl = dialog.querySelector('[data-call-number]');
    const touchOnly = window.matchMedia('(hover: none) and (pointer: coarse)');
    let copyLabel = copyButton ? copyButton.textContent : '';
    let copyTimer = null;

    trigger.addEventListener('click', function (event) {
        if (touchOnly.matches) {
            return; // let the browser follow tel:
        }
        event.preventDefault();
        dialog.showModal();
    });

    closeButton && closeButton.addEventListener('click', function () {
        dialog.close();
    });

    // A click on the backdrop lands on the dialog element itself.
    dialog.addEventListener('click', function (event) {
        if (event.target === dialog) {
            dialog.close();
        }
    });

    dialog.addEventListener('close', function () {
        trigger.focus();
        window.clearTimeout(copyTimer);
        if (copyButton) {
            copyButton.textContent = copyLabel;
        }
    });

    function selectNumber() {
        const range = document.createRange();
        range.selectNodeContents(numberEl);
        const selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
    }

    // navigator.clipboard only exists in secure contexts (HTTPS / localhost); on plain http
    // the selection + execCommand('copy') route still puts the number into the clipboard.
    function copyBySelection() {
        selectNumber();

        try {
            return document.execCommand('copy');
        } catch (error) {
            return false;
        }
    }

    async function copyNumber(number) {
        if (navigator.clipboard && window.isSecureContext) {
            try {
                await navigator.clipboard.writeText(number);
                return true;
            } catch (error) {
                // permission denied or document not focused: try the selection route
            }
        }

        return copyBySelection();
    }

    copyButton && copyButton.addEventListener('click', async function () {
        const copied = await copyNumber(numberEl.textContent.trim());

        window.clearTimeout(copyTimer);

        if (!copied) {
            selectNumber(); // nothing worked: leave the number selected for Ctrl+C
            copyButton.textContent = 'Press Ctrl+C';
        } else {
            window.getSelection().removeAllRanges(); // the selection was only needed for copying
            copyButton.textContent = 'Copied';
        }

        copyTimer = window.setTimeout(function () {
            copyButton.textContent = copyLabel;
        }, 2000);
    });
});
