<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1><i class="fa fa-dashboard"></i> Panel de Administración</h1>
    </div>
</div>
<div class="row">

    <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <a class="info" href="<?php echo base_url; ?>Usuarios">
                <h4>Usuarios</h4>
                <p><b><?php echo $data['usuarios']['total'] ?></b></p>
            </a>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="widget-small info coloured-icon"><i class="icon fa fa-book fa-3x"></i>
            <a class="info" href="<?php echo base_url; ?>Libros">
                <h4>Libros</h4>
                <p><b><?php echo $data['libros']['total'] ?></b></p>
            </a>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="widget-small warning coloured-icon"><i class="icon fa fa-graduation-cap fa-3x"></i>
            <a class="info" href="<?php echo base_url; ?>Estudiantes">
                <h4>Estudiantes</h4>
                <p><b><?php echo $data['estudiantes']['total'] ?></b></p>
            </a>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="widget-small danger coloured-icon"><i class="icon fa fa-hourglass-start fa-3x"></i>
            <a class="info" href="<?php echo base_url; ?>Prestamos">
                <h4>Prestamos</h4>
                <p><b><?php echo $data['prestamos']['total'] ?></b></p>
            </a>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Libros más pedidos</h3>
            <div class="embed-responsive embed-responsive-16by9">
                <canvas class="embed-responsive-item" id="reportePrestamo"></canvas>
            </div>
        </div>
    </div>
    <!-- <div class="col-md-6">
        <div class="tile">
            <h3 class="tile-title">Gráfica 2</h3>
            <div class="embed-responsive embed-responsive-16by9">
                <canvas class="embed-responsive-item" id="reporteLibro"></canvas>
            </div>
        </div>
    </div> -->
</div>

<?php include "Views/Templates/footer.php"; ?>