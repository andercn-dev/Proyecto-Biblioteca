<?php include "Views/Templates/p_nav.php"; ?>
<!-- Pagina Diseñada por Anderson Cobeñas Neyra -->

<div class="container">

    <div class="welcome-hero">
        <div class="welcome-hero-txt">
            <h2>Bienvenidos</h2>

            <div class="busc-container">
                <form class="busc-form" method="GET" action="https://www.google.com/search" target="_blank"
                    rel="noopener">
                    <div class="input-container">
                        <input class="txt-input" type="text" name="q" size="45" maxlength="255"
                            placeholder="Buscar en Google">
                        <input class="btn-buscar" type="submit" name="btnG" value="Buscar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "Views/Templates/slider.php"; ?>

<?php include "Views/Templates/p_footer.php"; ?>