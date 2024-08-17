<?php include "Views/Templates/nav_footer/nav_busqavan.php"; ?>

<div class="container">

    <div class="welcome-hero2">

        <?php include "Views/Templates/Detalle_listaL.php"; ?>

        <div class="welcome-hero-txt2">
            <h2>Biblioteca-MAC</h2>
        </div>
    </div>
</div>

<div class="container_busq">
    <div class="panel">
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

    <?php include "Views/Templates/busc_avanz.php"; ?>

</div>

<?php include "Views/Templates/nav_footer/footer_busqavan.php"; ?>