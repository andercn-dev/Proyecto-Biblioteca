<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1><i class="fa fa-dashboard"></i> Solicitudes</h1>
    </div>
</div>
<div class="tile">
    <div class="tile-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped mt-4" id="tblSolicitud">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Libro</th>
                        <th>Estudiante</th>
                        <th>Fecha Prestamo</th>
                        <th>Fecha Devolución</th>
                        <th>Cant</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?>