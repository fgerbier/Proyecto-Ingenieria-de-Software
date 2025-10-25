window.toggleDetalles = function(id) {
    const detalles = document.getElementById('detalles-' + id);
    const iconSpan = document.getElementById('icon-' + id);
    const isOpen = detalles.classList.contains('max-h-[500px]');

    const minusSVG = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-5 h-5 text-eprimary">
            <path d="M3.75 7.25a.75.75 0 0 0 0 1.5h8.5a.75.75 0 0 0 0-1.5h-8.5Z" />
        </svg>`;

    const plusSVG = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-5 h-5 text-eprimary">
            <path d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
        </svg>`;

    if (isOpen) {
        detalles.classList.remove('max-h-[500px]', 'opacity-100');
        detalles.classList.add('max-h-0', 'opacity-0');
        iconSpan.innerHTML = plusSVG;
    } else {
        detalles.classList.remove('max-h-0', 'opacity-0');
        detalles.classList.add('max-h-[500px]', 'opacity-100');
        iconSpan.innerHTML = minusSVG;
    }
};
