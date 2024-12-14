document.addEventListener('DOMContentLoaded', function () {
    const currentLocation = window.location.href;
    const links = document.querySelectorAll('.link-button');

    links.forEach(link => {
        if (link.href === currentLocation) {
            link.classList.add('active');
        }
    });
});

function adjustOpacity(event) {
    const card = event.currentTarget;
    const rect = card.getBoundingClientRect();
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;

    const highlight = card.querySelector('.highlight');
    highlight.style.opacity = 1;
    highlight.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0) 60%)`;
}

function resetOpacity(event) {
    const card = event.currentTarget;
    const highlight = card.querySelector('.highlight');
    highlight.style.opacity = 0;
}
