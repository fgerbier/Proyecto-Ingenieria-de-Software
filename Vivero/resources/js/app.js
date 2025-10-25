import './bootstrap';
import 'flowbite';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// ================= Carrito de Compras =================

// Clave para almacenar en localStorage
const CART_KEY = 'mi_carrito';

// Funciones de gestión del carrito
function getCart() {
  return JSON.parse(localStorage.getItem(CART_KEY) || '{}');
}
function saveCart(cart) {
  localStorage.setItem(CART_KEY, JSON.stringify(cart));
}

// Función para enviar el carrito al backend
function enviarCarritoAlBackend() {
  const cart = getCart(); // Obtén el carrito desde localStorage (ya en el frontend)

  fetch('/guardar-carrito', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Asegúrate de incluir el token CSRF
    },
    body: JSON.stringify({ items: Object.values(cart) })
  })
  .then(response => response.json())
  .then(data => {
    console.log('Carrito guardado:', data);
  })
  .catch(error => {
    console.error('Error al guardar el carrito:', error);
  });
}

// Función para obtener el carrito del backend
function obtenerCarritoDelBackend() {
  fetch('/obtener-carrito')
    .then(response => response.json())
    .then(data => {
      if (data.items) {
        // Aquí puedes actualizar el DOM con los datos del carrito
        console.log('Carrito recuperado:', data.items);
        renderCartItems(data.items);
      } else {
        console.log(data.message); // Mensaje si no hay carrito
      }
    })
    .catch(error => {
      console.error('Error al obtener el carrito:', error);
    });
}

// Función para renderizar el carrito en el frontend
function renderCartItems(cartItems) {
  const container = document.getElementById('cart-items');
  if (!container) return;
  container.innerHTML = '';
  let total = 0;
  cartItems.forEach(item => {
    const sub = item.precio * item.cantidad;
    total += sub;
    const div = document.createElement('div');
    div.className = 'flex items-center justify-between bg-white p-4 rounded shadow';
    div.innerHTML = `
      <div class="flex items-center space-x-4">
        <img src="/storage/${item.imagen}" class="w-12 h-12 object-cover rounded">
        <div>
          <h4 class="font-semibold">${item.nombre}</h4>
          <p class="text-sm text-gray-600">$${item.precio.toFixed(2)} c/u</p>
        </div>
      </div>
      <div class="flex items-center space-x-2">
        <button class="px-2 bg-gray-200 rounded decrement" data-id="${item.id}">−</button>
        <span>${item.cantidad}</span>
        <button class="px-2 bg-gray-200 rounded increment" data-id="${item.id}">+</button>
        <button class="ml-4 text-red-500 remove" data-id="${item.id}">Eliminar</button>
      </div>
      <div class="ml-4 font-semibold">$${sub.toFixed(2)}</div>
    `;
    container.appendChild(div);
  });
  const totalEl = document.getElementById('cart-total');
  if (totalEl) totalEl.innerText = total.toFixed(2);

  // Listeners para botones de incremento, decremento y eliminación
  document.querySelectorAll('.increment').forEach(btn => {
    btn.onclick = () => updateQty(btn.dataset.id, +1);
  });
  document.querySelectorAll('.decrement').forEach(btn => {
    btn.onclick = () => updateQty(btn.dataset.id, -1);
  });
  document.querySelectorAll('.remove').forEach(btn => {
    btn.onclick = () => removeItem(btn.dataset.id);
  });
}

// Función para actualizar la cantidad de un item
function updateQty(id, delta) {
  const cart = getCart();
  if (!cart[id]) return;
  cart[id].cantidad += delta;
  if (cart[id].cantidad < 1) delete cart[id];
  saveCart(cart);
  renderCart();
  enviarCarritoAlBackend(); // Opcional: Enviar los cambios al backend
}

// Función para eliminar un item del carrito
function removeItem(id) {
  const cart = getCart();
  delete cart[id];
  saveCart(cart);
  renderCart();
  enviarCarritoAlBackend(); // Opcional: Enviar los cambios al backend
}

// Función para vaciar el carrito
document.getElementById('clear-cart').addEventListener('click', () => {
  if (confirm('¿Estás seguro de vaciar el carrito?')) {
    // Vaciar carrito en el backend
    fetch('/vaciar-carrito', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Asegúrate de incluir el token CSRF
      }
    })
    .then(response => response.json())
    .then(data => {
      console.log('Carrito vaciado en el backend:', data);
      localStorage.removeItem(CART_KEY); // Vaciar localStorage
      renderCart(); // Actualizar vista
    })
    .catch(error => {
      console.error('Error al vaciar el carrito:', error);
    });
  }
});

// Inicializar el carrito al cargar la página
document.addEventListener('DOMContentLoaded', () => {
  obtenerCarritoDelBackend(); // Obtener el carrito del backend al cargar la página

  // Botones "Agregar al carrito"
  document.querySelectorAll('.add-to-cart').forEach(btn => {
    btn.onclick = () => {
      const id = btn.dataset.id;
      const cantidad = parseInt(btn.dataset.cantidad) || 1;
      const nombre = btn.closest('div').querySelector('h3').innerText;
      const precio = parseFloat(btn.closest('div').querySelector('p').innerText.replace('$', ''));
      const imagen = btn.dataset.imagen || '';
      const cart = getCart();
      const item = { id, nombre, precio, imagen, cantidad };

      if (cart[id]) {
        cart[id].cantidad += cantidad;
      } else {
        cart[id] = item;
      }

      saveCart(cart);
      renderCart();
      // Opcionalmente puedes guardar el carrito en el backend aquí
      enviarCarritoAlBackend();
    };
  });
});
