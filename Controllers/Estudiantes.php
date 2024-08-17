<?php
class Estudiantes extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
            exit;
        }

        parent::__construct();

        $id_user = $_SESSION['id_usuario'];
        $rol = $_SESSION['rol'];

        if ($rol === 'admin') {
            // Verificar permisos para administradores
            $perm = $this->model->verificarPermisos($id_user, "Estudiantes");
            if (!$perm && $id_user != 1) {
                $this->views->getView($this, "permisos");
                exit;
            }
        } else {
            // Si es estudiante, redirige a la página de inicio            
            header("location: " . base_url . "HomeBibl/");
            exit;
        }
    }

    public function index()
    {
        $this->views->getView($this, "index");
    }
    public function listar()
    {
        $data = $this->model->getEstudiantes();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarEst(' . $data[$i]['id'] . ');"><i class="fa fa-pencil-square-o"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarEst(' . $data[$i]['id'] . ');"><i class="fa fa-trash-o"></i></button>
                <button class="btn btn-warning" type="button" onclick="btnActualizarPass(' . $data[$i]['id'] . ');"><i class="fa fa-eye-slash"></i></button>

                <div/>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarEst(' . $data[$i]['id'] . ');"><i class="fa fa-reply-all"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $dni = strClean($_POST['dni']);
        $clave = hash("SHA256", strClean($_POST['clave']));
        $nombre = strClean($_POST['nombre']);
        $apellido = strClean($_POST['apellido']);
        $telefono = strClean($_POST['telefono']);
        $fecha_nacimiento = strClean($_POST['fecha_nacimiento']);
        $correo = strClean($_POST['correo']);
        $carrera = strClean($_POST['carrera']);
        $id = strClean($_POST['id']);
        if (empty($dni) || empty($clave) || empty($nombre) || empty($apellido) || empty($telefono) || empty($fecha_nacimiento) || empty($correo) || empty($carrera)) {
            $msg = array('msg' => 'Todo los campos son requeridos', 'icono' => 'warning');
        } else {
            if ($id == "") {
                $data = $this->model->insertarEstudiante($dni, $clave, $nombre, $apellido, $telefono, $fecha_nacimiento, $correo, $carrera);
                if ($data == "ok") {
                    $msg = array('msg' => 'Estudiante registrado', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'El estudiante ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } else {
                $data = $this->model->actualizarEstudiante($dni, $clave, $nombre, $apellido, $telefono, $fecha_nacimiento, $correo, $carrera, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Estudiante modificado', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar($id)
    {
        $data = $this->model->editEstudiante($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar($id)
    {
        $data = $this->model->estadoEstudiante(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Estudiante dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Cambio de Contraseña con DNI
    public function cambiarPas()
    {
        if ($_POST) {
            $id = strClean($_POST['id']);
            $user = $this->model->editEstudiante($id);
            if ($user) {
                $dni = $user['dni'];
                $hash = hash("SHA256", $dni);
                $data = $this->model->actualizarPass($hash, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Contraseña modificada al DNI', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar la contraseña', 'icono' => 'warning');
                }
            } else {
                $msg = array('msg' => 'Usuario no encontrado', 'icono' => 'warning');
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    public function reingresar($id)
    {
        $data = $this->model->estadoEstudiante(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Estudiante restaurado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al restaurar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function buscarEstudiante()
    {
        if (isset($_GET['est'])) {
            $valor = $_GET['est'];
            $data = $this->model->buscarEstudiante($valor);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    
    






}
