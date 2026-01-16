 <style>
     /* El overlay ahora cubre absolutamente todo */
     .modal-overlay {
         position: fixed;
         top: 0;
         left: 0;
         width: 100vw;
         height: 100vh;
         background: rgba(0, 0, 0, 0.7);
         /* Fondo un poco más oscuro */
         backdrop-filter: blur(10px);
         display: flex;
         justify-content: center;
         align-items: center;
         z-index: 99999;
         /* Valor máximo para estar sobre todo */
     }

     .modal-content {
         background: white;
         padding: 30px;
         border-radius: 20px;
         text-align: center;
         width: 90%;
         max-width: 400px;
         position: relative;
         overflow: hidden;
         /* Para la barra de progreso */
     }

     /* Barra de progreso de 10 segundos */
     .progress-bar {
         position: absolute;
         bottom: 0;
         left: 0;
         height: 5px;
         background: #ff4d4d;
         width: 100%;
         animation: timer 10s linear forwards;
     }

     @keyframes timer {
         from {
             width: 100%;
         }

         to {
             width: 0%;
         }
     }

     /* Animación de entrada */
     @keyframes slideIn {
         from {
             transform: translateY(-20px);
             opacity: 0;
         }

         to {
             transform: translateY(0);
             opacity: 1;
         }
     }
 </style>
 @if (session('error'))
 <div id="errorModal" class="modal-overlay">
     <div class="modal-content">
         <div class="modal-icon">❌</div>
         <h3>Error de Acceso</h3>
         <p>{{ session('error') }}</p>
         <button onclick="closeModal()" class="btn-close-modal">Cerrar</button>
         <div class="progress-bar"></div>
     </div>
 </div>
 @endif

 <script>
     document.addEventListener('DOMContentLoaded', () => {
         const modal = document.getElementById('errorModal');

         if (modal) {
             // Configurar el cierre automático tras 10 segundos
             const timer = setTimeout(() => {
                 closeModal();
             }, 10000);

             // Función para cerrar manualmente y limpiar el timer
             window.closeModal = function() {
                 modal.style.transition = "opacity 0.5s ease";
                 modal.style.opacity = "0";
                 setTimeout(() => {
                     modal.remove(); // Elimina el elemento del DOM
                     clearTimeout(timer);
                 }, 250);
             };
         }
     });
 </script>