// Burger menu: open/close, Escape, click outside, aria-expanded and focus return.
document.addEventListener('DOMContentLoaded', function () {
    const burgerIcon = document.querySelector('.adaptive-icon');
    const closeButton = document.querySelector('.close-btn');
    const burgerMenu = document.querySelector('.burger-menu');

    if (!burgerIcon || !burgerMenu) {
        return;
    }

    function setOpen(open) {
        burgerMenu.classList.toggle('active', open);
        burgerIcon.setAttribute('aria-expanded', open ? 'true' : 'false');
        burgerMenu.setAttribute('aria-hidden', open ? 'false' : 'true');
        document.documentElement.classList.toggle('menu-open', open);

        if ('inert' in burgerMenu) {
            burgerMenu.inert = !open;
        }
    }

    function open() {
        setOpen(true);
        (closeButton || burgerMenu).focus?.();
    }

    function close(returnFocus) {
        if (!burgerMenu.classList.contains('active')) {
            return;
        }

        setOpen(false);

        if (returnFocus) {
            burgerIcon.focus();
        }
    }

    setOpen(false);

    burgerIcon.addEventListener('click', function (event) {
        event.stopPropagation();
        open();
    });

    if (closeButton) {
        closeButton.addEventListener('click', function () {
            close(true);
        });
    }

    document.addEventListener('click', function (event) {
        if (!burgerMenu.contains(event.target) && !burgerIcon.contains(event.target)) {
            close(false);
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            close(true);
        }
    });
});
