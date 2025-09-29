<!-- Drilling parameters -->
<div class="max-w-4xl mx-auto bg-white rounded-lg p-5 shadow-lg">
    <div class="w-full h-96 overflow-auto border-2 border-gray-300 rounded flex items-center justify-center bg-gray-50 relative" id="imageBox">
        <div class="transition-transform duration-300 origin-center cursor-grab active:cursor-grabbing select-none" id="imageContent">
            <img src="{{ Vite::asset('resources/images/drillingParameters.jpeg') }}"
                 alt="Drilling Parameters"
                 class="block max-w-full h-auto pointer-events-none"
            >
        </div>
    </div>

    <div class="mt-4 flex gap-3 justify-center items-center">
        <button
            onclick="changeZoom(-25)"
            id="zoomOut"
            class="px-4 py-2 text-sm border border-gray-300 bg-white rounded hover:bg-gray-100 transition-colors disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-white"
        >
            ➖ Alejar
        </button>

        <div class="px-4 py-2 bg-gray-800 text-white rounded min-w-[80px] text-center text-sm" id="zoomDisplay">
            100%
        </div>

        <button
            onclick="changeZoom(25)"
            id="zoomIn"
            class="px-4 py-2 text-sm border border-gray-300 bg-white rounded hover:bg-gray-100 transition-colors disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-white"
        >
            ➕ Acercar
        </button>

        <button
            onclick="resetZoom()"
            class="px-4 py-2 text-sm border border-gray-300 bg-white rounded hover:bg-gray-100 transition-colors"
        >
            ↻ Restablecer
        </button>
    </div>
</div>

<script>
    let currentZoom = 100;
    const minZoom = 50;
    const maxZoom = 200;

    // Variables para el arrastre
    let isDragging = false;
    let startX, startY;
    let scrollLeft, scrollTop;

    function updateZoom() {
        const imageContent = document.getElementById('imageContent');
        const zoomDisplay = document.getElementById('zoomDisplay');
        const zoomInBtn = document.getElementById('zoomIn');
        const zoomOutBtn = document.getElementById('zoomOut');

        imageContent.style.transform = `scale(${currentZoom / 100})`;
        zoomDisplay.textContent = `${currentZoom}%`;

        // Deshabilitar botones en límites
        zoomOutBtn.disabled = currentZoom <= minZoom;
        zoomInBtn.disabled = currentZoom >= maxZoom;

        // Cambiar cursor según el nivel de zoom
        if (currentZoom > 100) {
            imageContent.style.cursor = 'grab';
        } else {
            imageContent.style.cursor = 'default';
        }
    }

    function changeZoom(amount) {
        currentZoom = Math.max(minZoom, Math.min(maxZoom, currentZoom + amount));
        updateZoom();
    }

    function resetZoom() {
        currentZoom = 100;
        updateZoom();

        // Centrar el scroll
        const imageBox = document.getElementById('imageBox');
        imageBox.scrollLeft = (imageBox.scrollWidth - imageBox.clientWidth) / 2;
        imageBox.scrollTop = (imageBox.scrollHeight - imageBox.clientHeight) / 2;
    }

    // Funcionalidad de arrastre
    const imageContent = document.getElementById('imageContent');
    const imageBox = document.getElementById('imageBox');

    imageContent.addEventListener('mousedown', function(e) {
        // Solo permitir arrastre si hay zoom
        if (currentZoom <= 100) return;

        isDragging = true;
        startX = e.pageX - imageBox.offsetLeft;
        startY = e.pageY - imageBox.offsetTop;
        scrollLeft = imageBox.scrollLeft;
        scrollTop = imageBox.scrollTop;
        imageContent.style.cursor = 'grabbing';

        // Prevenir selección de texto durante el arrastre
        e.preventDefault();
    });

    document.addEventListener('mouseup', function() {
        if (isDragging) {
            isDragging = false;
            if (currentZoom > 100) {
                imageContent.style.cursor = 'grab';
            }
        }
    });

    document.addEventListener('mousemove', function(e) {
        if (!isDragging) return;
        e.preventDefault();

        const x = e.pageX - imageBox.offsetLeft;
        const y = e.pageY - imageBox.offsetTop;
        const walkX = (x - startX) * 1.5; // Multiplicador para hacer el arrastre más suave
        const walkY = (y - startY) * 1.5;

        imageBox.scrollLeft = scrollLeft - walkX;
        imageBox.scrollTop = scrollTop - walkY;
    });

    // Prevenir el arrastre de la imagen del navegador
    imageContent.addEventListener('dragstart', function(e) {
        e.preventDefault();
    });

    // Zoom con rueda del ratón (opcional - con Ctrl o Cmd)
    imageBox.addEventListener('wheel', function(e) {
        if (e.ctrlKey || e.metaKey) {
            e.preventDefault();
            changeZoom(e.deltaY > 0 ? -25 : 25);
        }
    });

    // Inicializar
    updateZoom();
</script>
