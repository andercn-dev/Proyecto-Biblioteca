<!-- Lista Flotante -->
<div class="floating-container">
    <div class="floating-button" onclick="toggleList()">
        <i class="fa-solid fa-book-bookmark"></i>
    </div>
    <div class="floating-list" id="floatingList">
        <ul id="floatingBookList">
            <li id="emptyMessage"><i class="fa-solid fa-bookmark"></i>&nbsp;Selecciona unos libros</li>
        </ul>
        <button id="confirmButton" onclick="confirmarSeleccion()" disabled>Confirmar Selección</button>
    </div>
</div>

<!-- Modal de Detalles del Libro -->
<div class="modal" id="detalleLibroModal">
    <div class="modal-dialog">
        <div class="modal-contentb">
            <span class="close" id="closeDetalleLibroBtn">&times;</span>
            <div class="modal-body">
                <h2 class="book-title" id="detalleTitulo">Título del Libro</h2>
                <div class="book-container">
                    <img id="detalleImagen" src="" alt="Imagen del libro" class="book-image">
                    <div class="book-info">
                        <p id="detalleResumen">Resumen del libro...</p>
                        <p><strong>Código Título Autor:</strong> <span id="detalleCodigo">No disponible</span></p>
                        <p><strong>Disponibles:</strong> <span id="detalleDisponibles">No disponible</span></p>
                    </div>
                </div>
                <div class="book-info2">
                    <p><strong>Fecha de Publicación:</strong> <span id="detalleFecha">No disponible</span></p>
                    <p><strong>Autor:</strong> <span id="detalleAutor">No disponible</span></p>
                    <p><strong>Especialidad:</strong> <span id="detalleEspecialidad">No disponible</span></p>
                </div>
                <button class="add-book-btn" id="agregarLibroBtn">Añadir libro</button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop" id="detalleLibroBackdrop"></div>




<!-- Modal de Confirmación de Selección -->
<div class="modal3" id="confirmacionModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <button type="button" class="close" id="closeConfirmacionModalBtn">&times;</button>
        </div>
        <div class="modal-body3">
            <div class="row">
                <div class="col part-col3">
                    <ul id="confirmacionListaLibros"></ul>
                </div>
                <div class="col form-col">
                    <input type="hidden" id="idEst" value="<?php echo isset($_SESSION['id_estudiante']) ? $_SESSION['id_estudiante'] : ''; ?>">
                    <div class="form-group">
                        <label for="nombreUsuario">Nombre Completo:</label>
                        <input type="text" id="nombreUsuario" class="form-control" value="<?php echo isset($_SESSION['nombre']) && isset($_SESSION['apellido']) ? $_SESSION['nombre'] . ' ' . $_SESSION['apellido'] : ''; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="dniUsuario">DNI:</label>
                        <input type="text" id="dniUsuario" class="form-control" value="<?php echo isset($_SESSION['dni']) ? $_SESSION['dni'] : ''; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="fechaPrestamo">Fecha de Préstamo:</label>
                        <input type="date" id="fechaPrestamo" class="form-control" value="<?php echo date('Y-m-d'); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="fechaDevolucion">Fecha de Devolución:</label>
                        <input type="date" id="fechaDevolucion" class="form-control" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+3 days')); ?>">
                    </div>
                    <div class="btn-confirmar">
                        <button type="button" class="btn btn-primary" onclick="solicitarLibros(event)">Solicitar Libros</button>
                        <button type="button" class="btn btn-secondary" id="cancelarConfirmacionBtn">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop" id="confirmacionBackdrop"></div>