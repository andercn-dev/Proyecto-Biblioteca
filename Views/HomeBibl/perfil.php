<?php include "Views/Templates/nav_footer/nav_perfil.php"; ?>

<div class="profile-container">
    <form id="perfil-form">
        <div class="profile-picture">
            <img id="img-preview" src="default-profile.png">
            <label class="file-label">
                Selecciona una imagen
                <input type="file" id="imagenp" name="imagen" accept=".png, .jpeg, .jpg" onchange="imagenprevp(event)">
                </label>
            <div id="icon-cerrar"></div>
        </div>

        <div class="profile-details">
            <div class="form-group">
                <label for="dni">DNI:</label>
                <input type="hidden" id="id" name="id" value="<?php echo isset($_SESSION['id_estudiante']) ? $_SESSION['id_estudiante'] : ''; ?>">

                <input type="text" id="dni" name="dni" maxlength="8" required disabled>
            </div>
            <div class="form-group-inline">
                <div class="form-group">
                    <label for="nombre">Nombres:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellidos Completos:</label>
                    <input type="text" id="apellido" name="apellido" required>
                </div>
            </div>
            <div class="form-group">
                <label for="telefono">Telefono:</label> 
                <input type="number" id="telefono" name="telefono" maxlength="9">
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" disabled>
            </div>
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo">
            </div>
            <div class="form-group">
                <label for="carrera">Especialidad</label>
                <select id="carrera" name="carrera" class="form-control" required>
                    <option disabled selected>Selecciona una carrera</option>
                    <option value="Computación e Informática">Computación e Informática</option>
                    <option value="Desarrollo de Sistemas de Información">Desarrollo de Sistemas de Información</option>
                    <option value="Enfermería Tecnica">Enfermería Tecnica</option>
                    <option value="Industrias Alimentarias">Industrias Alimentarias</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" onclick="actualizarPerfil(event)" id="btn_svPerfil">Guardar cambios</button>
            </div>
        </div>
    </form>

</div>

<?php include "Views/Templates/nav_footer/footer_perfil.php"; ?>