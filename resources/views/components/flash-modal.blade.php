@if (session('status'))
    @php
        $status = session('status');
        $type = $status['type'] ?? 'info';
        $message = $status['message'] ?? 'Mensaje de Alerta.';
        $title = match($type) {
            'success' => '¡Operación Exitosa!',
            'danger' => '¡Error!',
            'warning' => 'Advertencia',
            default => 'Notificación',
        };
        $modalId = 'flash-modal';
        $colorClass = 'bg-' . $type;
    @endphp

    <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" data-bs-backdrop="static"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header {{ $colorClass }} text-white">
                    <h5 class="modal-title" id="{{ $modalId }}Label">{{ $title }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-{{ $type }}" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
@endif