<script>
function toggleDetalles(id) {
    const detalles = document.getElementById('detalles-' + id);
    const iconSpan = document.getElementById('icon-' + id);
    const isOpen = detalles.classList.contains('max-h-[500px]');

    const minusSVG = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-5 h-5 text-eprimary"><path d="M3.75 7.25a.75.75 0 0 0 0 1.5h8.5a.75.75 0 0 0 0-1.5h-8.5Z" /></svg>`;
    const plusSVG = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-5 h-5 text-eprimary"><path d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" /></svg>`;

    if (isOpen) {
        detalles.classList.remove('max-h-[500px]', 'opacity-100');
        detalles.classList.add('max-h-0', 'opacity-0');
        iconSpan.innerHTML = plusSVG;
    } else {
        detalles.classList.remove('max-h-0', 'opacity-0');
        detalles.classList.add('max-h-[500px]', 'opacity-100');
        iconSpan.innerHTML = minusSVG;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const pdfModal = document.getElementById('pdf-modal');
    const pdfContent = document.getElementById('pdf-modal-content');
    const pdfClose = document.getElementById('pdf-modal-close');

    document.querySelectorAll('.open-modal-pdf').forEach(btn => {
        btn.addEventListener('click', () => {
            const pdfUrl = btn.getAttribute('data-pdf');
            pdfContent.innerHTML = `<iframe src="${pdfUrl}" class="w-full h-96 rounded border"></iframe>`;
            pdfModal.classList.remove('hidden');
        });
    });

    pdfClose.addEventListener('click', () => {
        pdfModal.classList.add('hidden');
        pdfContent.innerHTML = '';
    });

    const uploadModal = document.getElementById('upload-modal');
    const uploadForm = document.getElementById('upload-form');
    const uploadClose = document.getElementById('upload-modal-close');

    document.querySelectorAll('.open-modal-upload').forEach(btn => {
        btn.addEventListener('click', () => {
            const actionUrl = btn.getAttribute('data-action');
            uploadForm.action = actionUrl;
            uploadModal.classList.remove('hidden');
        });
    });

    uploadClose.addEventListener('click', () => {
        uploadModal.classList.add('hidden');
        uploadForm.reset();
    });

    const provisoriaModal = document.getElementById('provisoria-modal');
    const provisoriaIframe = document.getElementById('provisoria-iframe');
    const provisoriaClose = document.getElementById('provisoria-modal-close');

    document.querySelectorAll('.open-modal-provisoria').forEach(btn => {
        btn.addEventListener('click', () => {
            const provisoriaUrl = btn.getAttribute('data-url');
            provisoriaIframe.src = provisoriaUrl;
            provisoriaModal.classList.remove('hidden');
        });
    });

    provisoriaClose.addEventListener('click', () => {
        provisoriaModal.classList.add('hidden');
        provisoriaIframe.src = '';
    });
});

    setTimeout(function() {
        const msg = document.getElementById('success-message');
        if (msg) {
            msg.style.display = 'none';
        }
    }, 10000); // 10000 ms = 10 segundos

    // Función para abrir el modal de eliminación
    function openDeleteModal(id, nombre) {
        document.getElementById('modalProductName').textContent = nombre; // Mostrar nombre en el modal
        document.getElementById('deleteForm').action = `/pedidos/${id}`; // Cambiar la acción del formulario
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    // Función para cerrar el modal de eliminación
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }

    // Cerrar el modal al hacer clic en el botón de cierre
    document.getElementById('delete-modal-close').addEventListener('click', closeDeleteModal);
</script>
