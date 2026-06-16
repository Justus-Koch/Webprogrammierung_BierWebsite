document.addEventListener('change', async function (e) {
    const checkbox = e.target.closest('.favourite-checkbox');
    if (!checkbox) return;

    e.preventDefault();
    const form = checkbox.closest('form');
    const reviewId = checkbox.dataset.reviewId;
    const originalState = !checkbox.checked;

    try {
        const res = await fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: 'review_id=' + encodeURIComponent(reviewId),
        });

        const data = await res.json();

        if (!data.success) {
            if (data.error === 'not_logged_in') {
                window.location.href = data.redirect;
                return;
            }
            checkbox.checked = originalState;
            console.error('Fehler:', data.error);
        }
    } catch {
        checkbox.checked = originalState;
    }
});