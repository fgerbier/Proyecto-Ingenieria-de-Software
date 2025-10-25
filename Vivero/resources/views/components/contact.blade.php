<section class="bg-blueLight" id="contact">
    <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
        <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-blueDark">¡Contáctanos!</h2>
        <p class="mb-8 lg:mb-16 font-light text-center text-blueDark sm:text-xl">
            ¿Tienes dudas sobre nuestras plantas, productos o servicios? ¡Estamos aquí para ayudarte!
            Escríbenos o visítanos, y con gusto responderemos todas tus consultas.
        </p>
        <form action="{{ route('contact.send') }}" method="POST" class="space-y-8">
            @csrf
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-blueDark">Tu Correo</label>
                <input type="email" id="email" name="email" required
                    class="shadow-sm bg-white border border-greenMid text-blueDark text-sm rounded-lg
                    focus:ring-greenPrimary focus:border-greenPrimary block w-full p-2.5
                    placeholder-greenDark/70"
                    placeholder="tunombre@correo.cl">
            </div>
            <div>
                <label for="subject" class="block mb-2 text-sm font-medium text-blueDark">Asunto</label>
                <input type="text" id="subject" name="subject" required
                    class="block p-3 w-full text-sm text-blueDark bg-white rounded-lg border border-greenMid shadow-sm
                    focus:ring-greenPrimary focus:border-greenPrimary
                    placeholder-greenDark/70"
                    placeholder="Dinos cómo podemos ayudarte">
            </div>
            <div class="sm:col-span-2">
                <label for="message" class="block mb-2 text-sm font-medium text-blueDark">Cuerpo</label>
                <textarea id="message" name="message" rows="6" required
                    class="block p-2.5 w-full text-sm text-blueDark bg-white rounded-lg shadow-sm border border-greenMid
                    focus:ring-greenPrimary focus:border-greenPrimary
                    placeholder-greenDark/70"
                    placeholder="Cuéntanos más detalles"></textarea>
            </div>
            <button type="submit"
                class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-greenPrimary sm:w-fit
                hover:bg-greenDark focus:ring-4 focus:outline-none focus:ring-greenMid transition-colors duration-200">
                Enviar Mensaje
            </button>
        </form>
    </div>
</section>
