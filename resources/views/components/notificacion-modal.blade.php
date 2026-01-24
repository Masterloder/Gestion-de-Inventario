<style>
    /* Nombres únicos para evitar conflictos */
    .notif-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(10px);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 999999; /* Un nivel más arriba que todo */
    }

    .notif-box {
        background: white !important;
        padding: 30px;
        border-radius: 20px;
        text-align: center;
        width: 90%;
        max-width: 400px;
        position: relative;
        overflow: hidden;
        animation: slideInNotif 0.4s ease-out;
    }

    .notif-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 5px;
        background: #ff4d4d;
        width: 100%;
        animation: timerNotif 10s linear forwards;
    }

    .btn-notif-close {
        background: #eee;
        border: none;
        padding: 8px 20px;
        border-radius: 10px;
        margin-top: 15px;
        cursor: pointer;
        color: #333;
        font-weight: bold;
    }

    @keyframes timerNotif {
        from { width: 100%; }
        to { width: 0%; }
    }

    @keyframes slideInNotif {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
</style>

@if (session('error') || $errors->any())
<div id="errorNotif" class="notif-overlay">
    <div class="notif-box">
        <div style="font-size: 40px; margin-bottom: 10px;">❌</div>
        <h3 style="color: #333; margin-bottom: 10px;">Error</h3>
        <p style="color: #666; font-size: 14px; line-height: 1.5;">
            {{ session('error') }}
            @if($errors->any())
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            @endif
        </p>
        <button onclick="closeNotif()" class="btn-notif-close">Cerrar</button>
        <div class="notif-progress"></div>
    </div>
</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const notif = document.getElementById('errorNotif');
        if (notif) {
            const timer = setTimeout(() => { closeNotif(); }, 10000);

            window.closeNotif = function() {
                notif.style.transition = "opacity 0.4s ease";
                notif.style.opacity = "0";
                setTimeout(() => {
                    notif.remove();
                    clearTimeout(timer);
                }, 400);
            };
        }
    });
</script>