<form action="{{ route('materiales.create') }}" method="post" class="row g-3 needs-validation" novalidate>
    @csrf
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre del material</label>
        <input
            type="varchar"
            class="form-control"
            id="nombre"
            name="nombre"
            maxlength="25"
            required />
    </div>
    <div class="mb-3">
        <label for="descripcion" class="form-label">descripcion</label><input
            type="text"
            class="form-control"
            id="descripcion"
            name="descripcion"
            maxlength="25"
            required />
    </div>
    <div class="mb-3">
    <label for="unidad_medida" class="form-label">Unidad de Medida</label>
    <div class="dropdown">
        <button class="form-select text-start" type="button" id="btnUnidad" data-bs-toggle="dropdown">
            --Elige una medida--
        </button>
        <ul class="dropdown-menu w-100 shadow-sm custom-select-scroll">
            @foreach ($unidades as $unidad)
            <li>
                <button class="dropdown-item" type="button" onclick="updateDropdown('Unidad', '{{ $unidad->id }}', '{{ $unidad->nombre_unidad }} ({{ $unidad->simbolo }})')">
                    {{ $unidad->nombre_unidad }} ({{ $unidad->simbolo }})
                </button>
            </li>
            @endforeach
        </ul>
        <input type="hidden" name="unidad_medida" id="hiddenUnidad" required>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Categoría General</label>
    <div class="dropdown">
        <button class="form-select text-start" type="button" id="btnCategoria" data-bs-toggle="dropdown">
            -- Elige una Categoria --
        </button>
        <ul class="dropdown-menu w-100 shadow-sm custom-select-scroll">
            @foreach($categorias as $cat)
            <li>
                <button class="dropdown-item" type="button" onclick="handleCategoriaChange('{{ $cat->id }}', '{{ $cat->nombre_categoria }}')">
                    {{ $cat->nombre_categoria }}
                </button>
            </li>
            @endforeach
        </ul>
        <input type="hidden" name="categoria_id" id="hiddenCategoria" required>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Categoría Específica</label>
    <div class="dropdown">
        <button class="form-select text-start" type="button" id="btnEspecifica" data-bs-toggle="dropdown" disabled>
            -- Primero selecciona una Categoría --
        </button>
        <ul class="dropdown-menu w-100 shadow-sm custom-select-scroll" id="list-especifica">
            </ul>
        <input type="hidden" name="categoria_especifica_id" id="hiddenEspecifica">
    </div>
</div>
    <button type="submit" class="btn btn-primary">Agregar Proveedor</button>
</form>

<script>
   

    const categoriasBase = @json($categorias);

    // Función genérica para actualizar texto y valor oculto
    function updateDropdown(tipo, id, texto) {
        document.getElementById('btn' + tipo).innerText = texto;
        document.getElementById('hidden' + tipo).value = id;
    }

    // Función específica para filtrar subcategorías
    function handleCategoriaChange(id, nombre) {
        // 1. Actualizar Categoría Padre
        updateDropdown('Categoria', id, nombre);
        
        // 2. Resetear y preparar Categoría Específica
        const btnEsp = document.getElementById('btnEspecifica');
        const listEsp = document.getElementById('list-especifica');
        const hiddenEsp = document.getElementById('hiddenEspecifica');
        
        btnEsp.innerText = '-- Elige una opción específica --';
        btnEsp.disabled = false;
        hiddenEsp.value = '';
        listEsp.innerHTML = '';

        // 3. Buscar subcategorías
        const catFound = categoriasBase.find(c => c.id == id);
        
        if (catFound && catFound.categorias_especificas.length > 0) {
            catFound.categorias_especificas.forEach(sub => {
                const li = document.createElement('li');
                li.innerHTML = `
                    <button class="dropdown-item" type="button" 
                        onclick="updateDropdown('Especifica', '${sub.id}', '${sub.nombre_especifico}')">
                        ${sub.nombre_especifico}
                    </button>`;
                listEsp.appendChild(li);
            });
        } else {
            btnEsp.disabled = true;
            btnEsp.innerText = 'Sin subcategorías';
        }
    }
</script>