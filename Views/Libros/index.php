<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1><i class="fa fa-dashboard"></i> Libros</h1>
    </div>
</div>
<button class="btn btn-primary mb-2" onclick="frmLibros()"><i class="fa fa-plus"></i></button>
<div class="row">
    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-light mt-4" id="tblLibros">
                        <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Especialidad</th>
                                <th>Orden en Página</th>
                                <th>Número de Especialidad</th>
                                <th>Título del Tema</th>
                                <th>Código Título Autor</th>
                                <th>Número Único</th>
                                <th>Imagen</th>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Resumen</th>
                                <th>Cantidad</th>
                                <th>Precio por Unidad</th>
                                <th>Valor Total</th>
                                <th>Estado Físico</th>
                                <th>Fecha de Ingreso</th>
                                <th>Estante de Ubicación</th>
                                <th>Nivel del Estante</th>
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

<div id="nuevoLibro" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="title">Registro Libro</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmLibro" class="row" onsubmit="registrarLibro(event)">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="titulo">Título*</label>
                            <input type="hidden" id="id" name="id">
                            <input id="titulo" class="form-control" type="text" name="titulo"
                                placeholder="Título del libro" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="autor">Autor*</label>
                            <input id="autor" class="form-control" type="text" name="autor" placeholder="autor"
                                required>
                        </div>
                    </div>

                    <div class="col-md-4">
                            <div class="form-group">
                                <label for="especialidad">Especialidad*</label>
                                <select id="especialidad" class="custom-select" name="especialidad" required>
                                    <option value="" disabled selected>Selecciona una carrera</option>
                                    <option value="CULTURA GENERAL">Cultura General</option>
                                    <option value="Computación e Informática">Computación e Informática</option>
                                    <option value="Enfermería Tecnica">Enfermería Tecnica</option>
                                    <option value="Industrias Alimentarias">Industrias Alimentarias</option>
                                </select>
                            </div>
                        </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="n_especialidad">Numero de Especialidad</label>
                            <input id="n_especialidad" class="form-control" type="text" name="n_especialidad"
                                placeholder="Numero de Especialidad">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tema_titulo">Tema-Titulo</label>
                            <input id="tema_titulo" class="form-control" type="text" name="tema_titulo"
                                placeholder="Tema-Titulo">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="codigo_titulo_autor">Codigo de Libro-Autor</label>
                            <input id="codigo_titulo_autor" class="form-control" type="text" name="codigo_titulo_autor"
                                placeholder="Codigo de Libro-Autor">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="n_unico">Numero Unico</label>
                            <input id="n_unico" class="form-control" type="text" name="n_unico"
                                placeholder="Numero Unico">
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="orden_pagina">Orden de Pagina</label>
                            <input id="orden_pagina" class="form-control" type="text" name="orden_pagina"
                                placeholder="Orden de Pagina">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cantidad">Cantidad*</label>
                            <input id="cantidad" class="form-control" type="number" name="cantidad" placeholder="Cantidad"
                                required>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="precio_unidad">Precio Unidad</label>
                            <input id="precio_unidad" class="form-control" type="text" name="precio_unidad"
                                placeholder="Precio Unidad">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="valor_total">Valor Total</label>
                            <input id="valor_total" class="form-control" type="text" name="valor_total"
                                placeholder="Valor Total">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="estado_fisico">Estado Fisico</label>
                            <input id="estado_fisico" class="form-control" type="text" name="estado_fisico"
                                placeholder="Estado Fisico">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha_ingreso">Fecha de Ingreso*</label>
                            <input id="fecha_ingreso" class="form-control" type="date" name="fecha_ingreso"
                                value="<?php echo date("Y-m-d"); ?>" required>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="estante_ubicacion">Estante de Ubicación</label>
                            <input id="estante_ubicacion" class="form-control" type="text" name="estante_ubicacion"
                                placeholder="Estante de Ubicación">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nivel_estante">Nivel de Estante</label>
                            <input id="nivel_estante" class="form-control" type="text" name="nivel_estante"
                                placeholder="Nivel de Estante">
                        </div>
                    </div>

                    <div class="col-md-12" style="margin-bottom: 15px;">
                        <label for="resumen">Resumen</label>
                        <textarea id="resumen" class="form-control" placeholder="Ingrese un resumen del libro" name="resumen" rows="3"></textarea>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Portada de Libro</label>
                            <div class="card border-primary">
                                <div class="card-body">
                                    <input type="hidden" id="foto_actual" name="foto_actual">
                                    <label for="imagen" id="icon-image" class="btn btn-primary"><i
                                            class="fa fa-cloud-upload"></i></label>
                                    <span id="icon-cerrar"></span>
                                    <input id="imagen" class="d-none" type="file" name="imagen"
                                        onchange="preview(event)">
                                    <img class="img-thumbnail" id="img-preview" src="" width="150">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" id="btnAccion">Registrar</button>
                            <button class="btn btn-danger" data-dismiss="modal" type="button">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>