document.addEventListener('click', function (event) {
    const trigger = event.target.closest('[data-lightbox-src]');

    if (trigger) {
        const modal = document.getElementById('motifImageModal');
        const modalImage = modal?.querySelector('[data-lightbox-image]');
        const modalTitle = modal?.querySelector('[data-lightbox-title]');

        if (modalImage) {
            modalImage.src = trigger.getAttribute('data-lightbox-src');
        }

        if (modalTitle) {
            modalTitle.textContent = trigger.getAttribute('data-lightbox-title') || 'Gambar Motif';
        }

        if (window.bootstrap && modal) {
            bootstrap.Modal.getOrCreateInstance(modal).show();
        }
    }

    const shareTrigger = event.target.closest('[data-share-url]');

    if (shareTrigger) {
        const url = shareTrigger.getAttribute('data-share-url');
        const title = shareTrigger.getAttribute('data-share-title') || document.title;

        if (navigator.share) {
            navigator.share({ title, url }).catch(() => null);
            return;
        }

        window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank', 'noopener');
    }
});