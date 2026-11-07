// "It looks delicious": the play button opens a dialog and plays the video.
// Without JS the button is a plain link to the video file.
document.addEventListener('DOMContentLoaded', function () {
    const trigger = document.querySelector('[data-video-open]');
    const dialog = trigger && document.getElementById(trigger.dataset.videoOpen);

    if (!trigger || !dialog || typeof dialog.showModal !== 'function') {
        return;
    }

    const video = dialog.querySelector('video');
    const closeButton = dialog.querySelector('[data-video-close]');

    trigger.addEventListener('click', function (event) {
        event.preventDefault();
        dialog.showModal();

        if (video) {
            // The click is a user gesture, so autoplay with sound is allowed.
            const started = video.play();
            if (started && typeof started.catch === 'function') {
                started.catch(function () {
                    // Playback blocked: the visible controls let the visitor start it.
                });
            }
        }
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
        if (video) {
            video.pause();
            video.currentTime = 0;
        }
        trigger.focus({ preventScroll: true });
    });
});
