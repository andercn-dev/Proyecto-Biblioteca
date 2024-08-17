<?php
class Usuarios extends Controller{
    public function __construct() {
        session_start();
        parent::__construct();
    }
    public function index()
{
    if (empty($_SESSION['activo'])) {
        header("location: " . base_url);
        exit;
    }
    
    $rol = $_SESSION['rol'];
    
    if ($rol === 'admin') {
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "Usuarios");
        
        if (!$perm && $id_user != 1) {
            $this->views->getView($this, "permisos");
            exit;
        }
        
        $this->views->getView($this, "index");
    } else {
        // Si es estudiante, redirige a la página de inicio
        header("location: " . base_url . "HomeBibl/");
        exit;
    }
}

    public function listar()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        $data = $this->model->getUsuarios();
        for ($i=0; $i < count($data); $i++) { 
            if ($data[$i]['estado'] == 1) {
                if ($data[$i]['id'] != 1) {
                    $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                    $data[$i]['acciones'] = '<div>
                    <button class="btn btn-dark" onclick="btnRolesUser(' . $data[$i]['id'] . ')"><i class="fa fa-key"></i></button>
                    <button class="btn btn-primary" type="button" onclick="btnEditarUser(' . $data[$i]['id'] . ');"><i class="fa fa-pencil-square-o"></i></button>
                    <button class="btn btn-danger" type="button" onclick="btnEliminarUser(' . $data[$i]['id'] . ');"><i class="fa fa-trash-o"></i></button>
                    <div/>';
                }else{
                    $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                    $data[$i]['acciones'] = '<div class"text-center">
                    <span class="badge-primary p-1 rounded">Super Administrador</span>
                    </div>'; 
                }
            }else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarUser(' . $data[$i]['id'] . ');"><i class="fa fa-reply-all"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function validar() {
        $usuario = strClean($_POST['usuario']);
        $clave = strClean($_POST['clave']);
        
        if (empty($usuario) || empty($clave)) {
            $msg = array('msg' => 'Todos los campos son requeridos', 'icono' => 'warning');
        } else {
            $hash = hash("SHA256", $clave);
            
            // Intentar encontrar el usuario en la tabla de administradores
            $data = $this->model->getUsuario($usuario, $hash);
            
            if ($data) {
                $_SESSION['id_usuario'] = $data['id'];
                $_SESSION['usuario'] = $data['usuario'];
                $_SESSION['nombre'] = $data['nombre'];
                $_SESSION['activo'] = true;
                $_SESSION['rol'] = 'admin';  // Usuario es administrador
                
                $msg = array('msg' => 'Bienvenido, ' . $data['nombre'], 'icono' => 'success', 'redireccion' => "Configuracion/admin");
            } else {
                // Intentar encontrar el usuario en la tabla de estudiantes
                $data = $this->model->getEstudiante($usuario, $hash);
                
                if ($data) {
                    $_SESSION['id_estudiante'] = $data['id'];
                    $_SESSION['usuario'] = $data['correo'];
                    $_SESSION['nombre'] = $data['nombre'];
                    $_SESSION['apellido'] = $data['apellido'];
                    $_SESSION['telefono'] = $data['telefono'];
                    $_SESSION['fecha_nacimiento'] = $data['fecha_nacimiento'];
                    $_SESSION['correo'] = $data['correo'];
                    $_SESSION['foto'] = $data['foto'];
                    $_SESSION['carrera'] = $data['carrera'];    
                    $_SESSION['dni'] = $data['dni'];
                    $_SESSION['activo'] = true;
                    $_SESSION['rol'] = 'estudiante';  // Usuario es estudiante
                    
                    $msg = array('msg' => 'Bienvenido, ' . $data['nombre'], 'icono' => 'success', 'redireccion' => "HomeBibl/",);
                } else {
                    $msg = array('msg' => 'Usuario o contraseña incorrecta', 'icono' => 'warning');
                }
            }
        }
        
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    
    
    
    public function registrar()
    {
        $usuario = strClean($_POST['usuario']);
        $nombre = strClean($_POST['nombre']);
        $clave = strClean($_POST['clave']);
        $confirmar = strClean($_POST['confirmar']);
        $id = strClean($_POST['id']);
        $hash = hash("SHA256", $clave);

        if (empty($usuario) || empty($nombre)) {
            $msg = array('msg' => 'Todo los campos son requeridos', 'icono' => 'warning');
        }else{
            if ($id == "") {
                if (!empty($clave) && !empty($confirmar)) {
                    if ($clave != $confirmar) {
                        $msg = array('msg' => 'La contraseña es requerido', 'icono' => 'warning');
                    } else {
                        $data = $this->model->registrarUsuario($usuario, $nombre, $hash);
                        if ($data == "ok") {
                            $msg = array('msg' => 'Usuario registrado', 'icono' => 'success');
                        } else if ($data == "existe") {
                            $msg = array('msg' => 'El usuario ya existe', 'icono' => 'warning');
                        } else {
                            $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                        }
                    }
                }
            }else{
                $data = $this->model->modificarUsuario($usuario, $nombre, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Usuario modificado', 'icono' => 'success');
                }else {
                    $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrarB()
    {
        if ($_POST) {
            $dni = strClean($_POST['dni']);
            $nombre =strClean($_POST['nombre']);
            $apellido = strClean($_POST['apellido']);
            $telefono = strClean($_POST['telefono']);
            $fecha_nacimiento = strClean($_POST['fecha_nacimiento']);
            $correo = strClean($_POST['correo']);
            $carrera = strClean($_POST['carrera']);
            $clave = strClean($_POST['rclave']);
            $confirmar_clave = strClean($_POST['confirmar_clave']);
    
            if ($clave !== $confirmar_clave) {
                $msg = array('msg' => 'Las contraseñas no coinciden.', 'icono' => 'warning');
            } else {
                $hash = hash("SHA256", $clave);
                
                $data = $this->model->registrarUsuarioB($dni, $nombre, $apellido, $telefono, $fecha_nacimiento, $correo, $carrera, $hash);
                if ($data == "ok") {
                    $msg = array('msg' => 'Usuario registrado correctamente', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'El DNI ya está registrado', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    


    public function editar(int $id)
    {
        $data = $this->model->editarUser($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar(int $id)
    {
        $data = $this->model->accionUser(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Usuario dado de baja', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar(int $id)
    {
        $data = $this->model->accionUser(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Usuario restaurado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al restaurar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function permisos($id)
    {
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "roles");
        if (!$perm && $id_user != 1) {
            echo '<div class="card">
                    <div class="card-body text-center">
                        <span class="badge badge-danger">No tienes permisos</span>
                    </div>
                </div>';
            exit;
        }
        $data = $this->model->getPermisos();
        $asignados = $this->model->getDetallePermisos($id);
        $datos = array();
        foreach ($asignados as $asignado) {
            $datos[$asignado['id_permiso']] = true;
        }
        echo '<div class="row">
        <input type="hidden" name="id_usuario" value="' . $id . '">';
        foreach ($data as $row) {
            echo '<div class="d-inline mx-3 text-center">
                    <hr>
                    <label for="" class="font-weight-bold text-capitalize">' . $row['nombre'] . '</label>
                        <div class="center">
                            <input type="checkbox" name="permisos[]" value="' . $row['id'] . '" ';
            if (isset($datos[$row['id']])) {
                echo "checked";
            }
            echo '>
                            <span class="span">On</span>
                            <span class="span">Off</span>
                        </div>
                </div>';
        }
        echo '</div>
        <button class="btn btn-primary mt-3 btn-block" type="button" onclick="registrarPermisos(event);">Actualizar</button>';
        die();
    }
    public function registrarPermisos()
    {
        $id_user = strClean($_POST['id_usuario']);
        $permisos = $_POST['permisos'];
        $this->model->deletePermisos($id_user);
        if ($permisos != "") {
            foreach ($permisos as $permiso) {
                $this->model->actualizarPermisos($id_user, $permiso);
            }
        }
        echo json_encode("ok");
        die();
    }
    public function cambiarPas()
    {
        if ($_POST) {
            $id = $_SESSION['id_usuario'];
            $clave = strClean($_POST['clave_actual']);
            $user = $this->model->editarUser($id);
            if (hash("SHA256", $clave) == $user['clave']) {
                $hash = hash("SHA256", strClean($_POST['clave_nueva']));
                $data = $this->model->actualizarPass($hash, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Contraseña modificado', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar', 'icono' => 'warning');
                }
            } else {
                $msg = array('msg' => 'Contraseña actual incorrecta', 'icono' => 'warning');
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
    }


    public function salir()
    {
        session_destroy();
        header("location: ".base_url);
        exit();
    }
}