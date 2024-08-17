<?php include "Views/Templates/b_nav.php"; ?>

<div class="container">
    <div class="welcome-hero2">
        <?php include "Views/Templates/Detalle_listaL.php"; ?>
        <div class="welcome-hero-txt2">
            <h2>Biblioteca-MAC</h2>
            <?php include "Views/Templates/busc_lib.php"; ?>
        </div>
    </div>
</div>

<div class="container_busq">
    <div class="panel">
        <div class="left-panel">
            <div class="list-group">
                <h3>Especialidad</h3>
                <ul id="especialidad-list"></ul>
            </div>
            <div class="list-group">
                <h3>Autor</h3>
                <ul id="autor-list" class="scrollable-list"></ul>
            </div>
            <div class="list-group">
                <h3>Año</h3>
                <ul id="anio-list" class="scrollable-list"></ul>
            </div>
            <div class="list-group">
                <h3>Archivos</h3>
                <ul id="archivo-list"></ul>
            </div>
        </div>


        <form class="resultado">
            <h2>Resultado de Búsqueda</h2>
            <p id="numTotalLibros" class="total-libros"></p><br>
            <div id="pagination" class="pagination-container"></div>
            <div id="resultadoBusqueda"></div>
        </form>
    </div>
</div>

<?php include "Views/Templates/b_footer.php"; ?>