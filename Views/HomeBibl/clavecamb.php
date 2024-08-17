<?php include "Views/Templates/nav_footer/nav_clave.php"; ?>

<div class="profile-containerc">
    <div>
        <form id="frmCambiarContraseña">
            <div class="form-groupc">
                <label for="clv_actual">Contraseña Actual:</label>
                <div> 
                    <input type="password" id="clv_actual" name="clv_actual" required>
                    <i class="fa fa-eye" id="togglePassword"></i>
                </div>
            </div>
            <div class="form-groupc">
                <label for="clv_nueva">Nueva Contraseña:</label>
                <div> 
                    <input type="password" id="clv_nueva" name="clv_nueva" required>
                    <i class="fa fa-eye" id="togglePassword"></i>
                </div>
            </div>
            <div class="form-groupc">
                <label for="clv_confirmar">Confirmar Nueva Contraseña:</label>
                <div> 
                    <input type="password" id="clv_confirmar" name="clv_confirmar" required>
                    <i class="fa fa-eye" id="togglePassword"></i>
                </div>
            </div>
            <div class="form-group">
                <button type="button" id="btn_uptClave" onclick="modificarContraseña(event)">Cambiar Contraseña</button>
            </div>
        </form>
    </div>
</div>

<?php include "Views/Templates/nav_footer/footer_clave.php"; ?>
