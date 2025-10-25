<div class="w-full h-screen px-10" x-data="{
    currentSlide: 0,
    slides: 3,
    interval: null,
    init() {
        this.startAutoSlide();
    },
    startAutoSlide() {
        this.interval = setInterval(() => {
            this.nextSlide();
        }, 7000);
    },
    stopAutoSlide() {
        clearInterval(this.interval);
    },
    nextSlide() {
        this.currentSlide = (this.currentSlide + 1) % this.slides;
    },
    prevSlide() {
        this.currentSlide = (this.currentSlide - 1 + this.slides) % this.slides;
    }
}" @mouseenter="stopAutoSlide()" @mouseleave="startAutoSlide()">
  <div class="relative w-full bg-white rounded-4xl h-4/5 overflow-hidden">
    <!-- Flecha izquierda -->
    <button @click="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 bg-black/30 hover:bg-black/50 rounded-full p-2 transition-all duration-300">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M15 18l-6-6 6-6"/>
      </svg>
    </button>

    <!-- Flecha derecha -->
    <button @click="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 bg-black/30 hover:bg-black/50 rounded-full p-2 transition-all duration-300">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 18l6-6-6-6"/>
      </svg>
    </button>

    <!-- Slide 1 -->
    <div x-show="currentSlide === 0" x-transition:enter="fade transition ease-in-out duration-500"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="fade transition ease-in-out duration-500"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="absolute inset-0 w-full h-full bg-white rounded-4xl overflow-hidden">
      <div class="absolute inset-0 flex items-center justify-center z-10 flex-col">
        <h1 class="text-4xl font-bold text-center text-white font-['Roboto_Condensed']">
          Tu espacio verde comienza aquí.
        </h1>
        <button class="mt-4 px-4 py-2 bg-green-800 text-white rounded-lg hover:bg-green-600 transition duration-300">
            <a href="/home#quienes-somos">Descubre más</a>
        </button>
      </div>
      <img src='/storage/images/slide1.jpg' alt="Slide 1" class="absolute inset-0 w-full h-full object-cover rounded-3xl brightness-50">
    </div>

    <!-- Slide 2 -->
    <div x-show="currentSlide === 1" x-transition:enter="fade transition ease-in-out duration-500"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="fade transition ease-in-out duration-500"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="absolute inset-0 w-full h-full bg-white rounded-4xl overflow-hidden">
      <div class="absolute inset-0 flex items-center justify-center z-10 flex-col">
        <h1 class="text-4xl font-bold text-center text-white font-['Roboto_Condensed']">
          Plantas que transforman espacios.
        </h1>
        <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-500 transition duration-300">
          <a href="/productos">Descubrir colección</a>
        </button>
      </div>
      <img src='/storage/images/slide2.jpg' alt="Slide 2" class="absolute inset-0 w-full h-full object-cover rounded-3xl brightness-50">
    </div>

    <!-- Slide 3 -->
    <div x-show="currentSlide === 2" x-transition:enter="fade transition ease-in-out duration-500"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="fade transition ease-in-out duration-500"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="absolute inset-0 w-full h-full bg-white rounded-4xl overflow-hidden">
      <div class="absolute inset-0 flex items-center justify-center z-10 flex-col">
        <h1 class="text-4xl font-bold text-center text-white font-['Roboto_Condensed']">
          Naturaleza en tu hogar.
        </h1>
        <button class="mt-4 px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-500 transition duration-300">
         <a href="/productos" class="text-white">Explorar productos</a>
        </button>
      </div>
      <img src='/storage/images/slide3.jpg' alt="Slide 3" class="absolute inset-0 w-full h-full object-cover rounded-3xl brightness-50">
    </div>

    <!-- Controles de navegación personalizados -->
    <div class="absolute bottom-20 left-1/2 -translate-x-1/2 flex space-x-4 z-20">
      <template x-for="i in slides">
        <button @click="currentSlide = i - 1" class="w-6 h-6 flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="w-5 h-5 transition-all duration-300"
               :class="{'fill-green-500': currentSlide === i - 1, 'fill-black': currentSlide !== i - 1}">
            <path d="M205.41,159.07a60.9,60.9,0,0,1-31.83,8.86,71.71,71.71,0,0,1-27.36-5.66A55.55,55.55,0,0,0,136,194.51V224a8,8,0,0,1-8.53,8,8.18,8.18,0,0,1-7.47-8.25V211.31L81.38,172.69A52.5,52.5,0,0,1,63.44,176a45.82,45.82,0,0,1-23.92-6.67C17.73,156.09,6,125.62,8.27,87.79a8,8,0,0,1,7.52-7.52c37.83-2.23,68.3,9.46,81.5,31.25A46,46,0,0,1,103.74,140a4,4,0,0,1-6.89,2.43l-19.2-20.1a8,8,0,0,0-11.31,11.31l53.88,55.25c.06-.78.13-1.56.21-2.33a68.56,68.56,0,0,1,18.64-39.46l50.59-53.46a8,8,0,0,0-11.31-11.32l-49,51.82a4,4,0,0,1-6.78-1.74c-4.74-17.48-2.65-34.88,6.4-49.82,17.86-29.48,59.42-45.26,111.18-42.22a8,8,0,0,1,7.52,7.52C250.67,99.65,234.89,141.21,205.41,159.07Z"/>
          </svg>
        </button>
      </template>
    </div>

    <!-- Notch inferior -->
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-42 h-10 bg-white rounded-t-xl w-1/6">
      <div class="absolute inset-0 flex items-center justify-center">
        <img src='/storage/images/arrowdown.svg' alt="Flecha hacia abajo" class="w-8 h-8 animate-float">
      </div>
    </div>
  </div>
</div>

<style>
  @keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-3px); }
  }
  .animate-float { animation: float 2s ease-in-out infinite; }
</style>

<script src="//unpkg.com/alpinejs" defer></script>
