<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1><i class="fa fa-dashboard"></i> Estudiantes</h1>
    </div>
</div>
<button class="btn btn-primary mb-2" type="button" onclick="frmEstudiante()"><i class="fa fa-plus"></i></button>
<div class="row">
    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-light mt-4" id="tblEst">
                        <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Dni</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Telefono</th>
                                <th>Fecha de Nacimiento</th>
                                <th>Correo</th>
                                <th>Carrera</th>
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
    </div>
</div>
<div id="nuevoEstudiante" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="title">Registro Estudiante</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmEstudiante">
                    <div class="row">
                        <div class="form-group">
                            <input type="hidden" id="id" name="id">
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="clave" name="clave">
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="dni">Dni</label>
                                <input id="dni" class="form-control" type="number" name="dni" required placeholder="Ingresar el Dni" maxlength="8">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input id="nombre" class="form-control" type="text" name="nombre" required placeholder="Ingresar un Nombre">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellido">Apellido</label>
                                <input id="apellido" class="form-control" type="text" name="apellido" required placeholder="Ingresar Apellidos Completos">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="telefono">Telefono</label>
                                <input id="telefono" class="form-control" type="number" name="telefono" required placeholder="Ingresar un telefono" maxlength="9">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                <input id="fecha_nacimiento" class="form-control" type="date" name="fecha_nacimiento" required">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input id="correo" class="form-control" type="email" name="correo" required placeholder="Ingresar un Correo">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="carrera">Especialidad</label>
                                <select id="carrera" class="custom-select" name="carrera" required>
                                    <option value="" disabled selected>Selecciona una carrera</option>
                                    <option value="Computación e Informática">Computación e Informática</option>
                                    <option value="Desarrollo de Sistemas de Información">Desarrollo de Sistemas de Información</option>
                                    <option value="Enfermería Tecnica">Enfermería Tecnica</option>
                                    <option value="Industrias Alimentarias">Industrias Alimentarias</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" onclick="registrarEstudiante(event)" id="btnAccion">Registrar</button>
                                <button class="btn btn-danger" type="button" data-dismiss="modal">Atras</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('dni').addEventListener('input', function() {
        document.getElementById('clave').value = this.value;
    });
</script>
<?php include "Views/Templates/footer.php"; ?>