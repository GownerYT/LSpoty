document.querySelectorAll('.playlist-form').forEach(form => {
    const select = form.querySelector('.playlist-selector');
    const originalAction = form.getAttribute('action');
    const trackId = form.dataset.trackId;

    if (select) {
        const selectedPlaylistId = select.value;
        form.setAttribute('action', originalAction.replace('__PLAYLIST_ID__', selectedPlaylistId));

        select.addEventListener('change', () => {
            const newPlaylistId = select.value;
            const updatedAction = originalAction.replace('__PLAYLIST_ID__', newPlaylistId);
            form.setAttribute('action', updatedAction);
        });
    }
});

document.querySelectorAll('.playlist-form').forEach(form => {
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: form.method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });

            if (response.ok) {
                alert('Track added successfully!');
            } else {
                alert('Failed to add track.');
            }
        } catch (error) {
            alert('Error while adding track.');
            console.error(error);
        }
    });
});