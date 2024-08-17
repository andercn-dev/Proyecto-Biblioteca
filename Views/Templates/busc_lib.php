<div class="frmbusqueda">
    <form class="busqueda" id="frmBusqueda" onsubmit="buscarLibro(event);">
        <h2>Buscar Libros</h2>
        <input type="text" id="searchInput" name="searchInput" placeholder="Buscar...">
        <button type="submit" id="submitSearch">Buscar</button>
        <a href="<?php echo base_url; ?>HomeBibl/busqavanzada" id="busqavanzada">Búsqueda Avanzada</a>
    </form>
</div>