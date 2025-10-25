<section id="quienes-somos">
    <div class="flex flex-col md:flex-row w-full overflow-hidden h-fit">
  <!-- Sección Izquierda -->
  <div class="text-center md:w-1/2 flex items-center justify-center h-full bg-white py-8 md:py-20">
    <div class="bg-blueLight px-4 py-16 my-20 w-full flex flex-col items-center">
      <h2 class="text-3xl font-semibold text-blueDark">¿Quiénes Somos?</h2>
      <p class="text-blueDark text-2xl mt-4">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam luctus
        neque sed neque volutpat luctus. Cras gravida, mi in molestie volutpat,
        ex enim venenatis odio, vel ultricies nunc nisl nec elit.
      </p>
      <div class="flex gap-4 mt-6">
        <button class="border border-blueDark text-blueDark px-4 py-2 rounded-md hover:bg-blueLight transition">
          <a href="/home#mision">Conócenos más</a>
        </button>
        <button class="bg-blueDark text-white px-4 py-2 rounded-md hover:bg-blueDark transition">
            <a href="/productos">Ver productos</a>
        </button>
      </div>
    </div>
  </div>

  <!-- Sección Derecha (Imagen) -->
  <div class="md:w-1/2 flex items-center justify-center md:my-0 pr-4">
    <img
      src={{ asset('/storage/images/quienes.jpg') }}
      alt="Manos unidas sobre un tronco"
      class="w-full max-h-[500px] object-cover rounded-[50px]"
    />
  </div>
</div>

</section>
