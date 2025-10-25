{{-- Modal Provisoria --}}
<div id="provisoria-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow p-4 max-w-3xl w-full relative">
        <button id="provisoria-modal-close" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl">✕</button>
        <iframe src="" class="w-full h-96 rounded border" id="provisoria-iframe"></iframe>
    </div>
</div>

{{-- Modal PDF --}}
<div id="pdf-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow p-4 max-w-3xl w-full relative">
        <button id="pdf-modal-close" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl">✕</button>
        <div id="pdf-modal-content" class="p-4"></div>
    </div>
</div>

{{-- Modal Upload --}}
<div id="upload-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow p-4 max-w-md w-full relative">
        <button id="upload-modal-close" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl">✕</button>
        <h2 class="text-lg font-bold mb-4 text-eprimary">Subir Boleta SII</h2>
        <form id="upload-form" method="POST" action="" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="file" name="boleta" accept="application/pdf" required class="w-full border rounded px-3 py-2">
            <button type="submit"
                class="bg-eaccent hover:bg-eaccent2 text-eprimary font-semibold px-4 py-2 rounded shadow transition w-full">
                Subir Boleta
            </button>
        </form>
    </div>
</div>
{{-- Modal Eliminar --}}
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow p-6 max-w-md w-full relative">
        <button id="delete-modal-close" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl">✕</button>
        <h2 class="text-lg font-bold text-gray-800 mb-4">¿Eliminar pedido?</h2>
        <p class="text-gray-700 mb-4">
            ¿Estás seguro que deseas eliminar el <span id="modalProductName" class="font-semibold"></span>?
        </p>
        <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Eliminar
                </button>
            </div>
        </form>
    </div>
</div>

