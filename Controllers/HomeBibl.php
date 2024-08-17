<?php
class HomeBibl extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
            exit;
        }

        parent::__construct();

        // Verificar el rol del usuario
        if ($_SESSION['rol'] === 'admin') {
            // Si es administrador, redirigir a la página de inicio del admin
            header("location: " . base_url . "Configuracion/admin");
            exit;
        }
    }

    public function index()
    {
        $this->views->getView($this, "index");
    }

    public function libsolicitados()
    {
        $this->views->getView($this, "libsolicitados");
    }

    public function busqavanzada()
    {
        $this->views->getView($this, "busqavanzada");
    }

    public function perfil()
    {
        $this->views->getView($this, "perfil");
    }

    public function clavecamb()
    {
        $this->views->getView($this, "clavecamb");
    }



    public function buscarLibroB()
    {
        if (isset($_POST['valor']) || isset($_POST['especialidad']) || isset($_POST['anio']) || isset($_POST['autor'])) {
            $valor = $_POST['valor'] ?? '';
            $especialidad = $_POST['especialidad'] ?? '';
            $anio = $_POST['anio'] ?? '';
            $autor = $_POST['autor'] ?? '';
            $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
            $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 10;
            $offset = ($page - 1) * $limit;

            $libros = $this->model->buscarLibroB($valor, $especialidad, $anio, $autor, $limit, $offset);

            $num_libros = $this->model->countLibros($valor, $especialidad, $anio, $autor);

            $html = "";
            if (count($libros) > 0) {
                foreach ($libros as $libro) {
                    $foto_ruta = base_url . "Assets/img/PortadaLibros/" . ($libro["imagen"] ?? 'sinportada.png');
                    $html .= "<div class='book-item' data-id='{$libro['id']}' data-codigo='{$libro['codigo_titulo_autor']}' data-fecha='{$libro['fecha_ingreso']}'>";
                    $html .= "<img src='$foto_ruta' alt='Imagen del libro' class='book-img'>";
                    $html .= "<div class='book-details'>";
                    $html .= "<p><strong>Especialidad:</strong> " . ($libro["especialidad"] ?? 'No disponible') . "</p>";
                    $html .= "<p><strong>Nombre:</strong> " . ($libro["titulo"] ?? 'No disponible') . "</p>";
                    $html .= "<p><strong>Autor:</strong> " . ($libro["autor"] ?? 'No disponible') . "</p>";
                    $html .= "<p class='right'><strong>Disponibles:</strong> " . ($libro["cantidad"] ?? 'No disponible') . "</p>";
                    $html .= "<button type='button' class='btn-details' onclick='mostrarDetalleL(\"" . addslashes($libro["titulo"] ?? '') . "\", \"" . addslashes($libro["autor"] ?? '') . "\", \"" . addslashes($libro["especialidad"] ?? '') . "\", \"" . addslashes($libro["cantidad"] ?? '') . "\", \"" . addslashes($foto_ruta) . "\", \"" . $libro['id'] . "\", \"" . addslashes($libro["codigo_titulo_autor"] ?? '') . "\", \"" . addslashes($libro["fecha_ingreso"] ?? '') . "\", \"" . addslashes($libro["resumen"] ?? '') . "\")'>Ver Detalles</button>";
                    $html .= "</div>";
                    $html .= "</div>";
                }
                echo json_encode(['html' => $html, 'num_libros' => $num_libros], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(['html' => '<p class="no-results">No se encontraron resultados.</p>', 'num_libros' => 0], JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }


    public function obtenerUltimosLibros()
    {
        $libros = $this->model->recLibros();
        $num_libros = count($libros);

        $html = "<input type='hidden' id='numLibros' value='$num_libros'>";
        foreach ($libros as $libro) {
            $foto_ruta = base_url . "Assets/img/PortadaLibros/" . ($libro["imagen"] ?? 'sinportada.png');
            $html .= "<div class='book-item' data-id='{$libro['id']}' data-codigo='{$libro['codigo_titulo_autor']}' data-fecha='{$libro['fecha_ingreso']}'>";
            $html .= "<img src='$foto_ruta' alt='Imagen del libro' class='book-img'>";
            $html .= "<div class='book-details'>";
            $html .= "<p><strong>Especialidad:</strong> " . ($libro["especialidad"] ?? 'No disponible') . "</p>";
            $html .= "<p><strong>Nombre:</strong> " . ($libro["titulo"] ?? 'No disponible') . "</p>";
            $html .= "<p><strong>Autor:</strong> " . ($libro["autor"] ?? 'No disponible') . "</p>";
            $html .= "<p class='right'><strong>Disponibles:</strong> " . ($libro["cantidad"] ?? 'No disponible') . "</p>";
            $html .= "<button type='button' class='btn-details' onclick='mostrarDetalleL(\"" . addslashes($libro["titulo"] ?? '') . "\", \"" . addslashes($libro["autor"] ?? '') . "\", \"" . addslashes($libro["especialidad"] ?? '') . "\", \"" . addslashes($libro["cantidad"] ?? '') . "\", \"" . addslashes($foto_ruta) . "\", \"" . $libro['id'] . "\", \"" . addslashes($libro["codigo_titulo_autor"] ?? '') . "\", \"" . addslashes($libro["fecha_ingreso"] ?? '') . "\", \"" . addslashes($libro["resumen"] ?? '') . "\")'>Ver Detalles</button>";
            $html .= "</div>";
            $html .= "</div>";
        }

        echo json_encode(['html' => $html, 'num_libros' => $num_libros], JSON_UNESCAPED_UNICODE);
    }

    public function obtenerlistsolicitados()
    {
        $id_estudiante = $_SESSION['id_estudiante'];
        $prestamos = $this->model->getlistsolicitados($id_estudiante);

        echo json_encode($prestamos, JSON_UNESCAPED_UNICODE);
    }


    public function regprestamo()
    {
        $estudiante = strClean($_POST['idEst']);
        $fecha_prestamo = strClean($_POST['fechaPrestamo']);
        $fecha_devolucion = strClean($_POST['fechaDevolucion']);
        $libros = $_POST['libro'];
        $cantidades = $_POST['cantidad'];

        if (empty($estudiante) || empty($fecha_prestamo) || empty($fecha_devolucion) || empty($libros) || empty($cantidades)) {
            $msg = array('msg' => 'Todos los campos son requeridos', 'icono' => 'warning');
        } else {
            $prestamos = [];
            $error = false;

            for ($i = 0; $i < count($libros); $i++) {
                $libro = strClean($libros[$i]);
                $cantidad = strClean($cantidades[$i]);
                $verificar_cant = $this->model->getbCantLibro($libro);

                if ($verificar_cant['cantidad'] >= $cantidad) {
                    $prestamos[] = array(
                        'estudiante' => $estudiante,
                        'libro' => $libro,
                        'cantidad' => $cantidad,
                        'fecha_prestamo' => $fecha_prestamo,
                        'fecha_devolucion' => $fecha_devolucion,
                        'observacion' => ''
                    );
                } else {
                    $msg = array('msg' => 'Stock no disponible para este libro ', 'icono' => 'warning');
                    $error = true;
                    break;
                }
            }

            if (!$error) {
                foreach ($prestamos as $prestamo) {
                    $data = $this->model->insertarbPrestamo(
                        $prestamo['estudiante'],
                        $prestamo['libro'],
                        $prestamo['cantidad'],
                        $prestamo['fecha_prestamo'],
                        $prestamo['fecha_devolucion'],
                        $prestamo['observacion']
                    );

                    if ($data <= 0) {
                        $msg = array('msg' => 'Error al prestar el libro con ID: ' . $prestamo['libro'], 'icono' => 'error');
                        break;
                    }
                }

                if (!isset($msg)) {
                    $msg = array('msg' => 'Libro Solicitado', 'icono' => 'success', 'redireccion' => "HomeBibl/",);
                }
            }
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function cambiarContraseña()
    {
        if ($_POST) {
            $id = $_SESSION['id_estudiante'];
            $clave = strClean($_POST['clv_actual']);
            $user = $this->model->editarEstd($id);
            if (hash("SHA256", $clave) == $user['clave']) {
                $hash = hash("SHA256", strClean($_POST['clv_nueva']));
                $data = $this->model->cambContraseña($hash, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Contraseña modificado', 'icono' => 'success', 'redireccion' => "HomeBibl/",);
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


    public function editarPerfil($id)
    {
        $data = $this->model->editarEstd($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function actualizarPerfil()
    {
        $nombre = strClean($_POST['nombre']);
        $apellido = strClean($_POST['apellido']);
        $telefono = strClean($_POST['telefono']);
        $correo = strClean($_POST['correo']);
        $carrera = strClean($_POST['carrera']);
        $id = strClean($_POST['id']);
        $fecha = date("YmdHis");
        
        $name = '';
        $tmpName = '';
    
        if (isset($_FILES['imagen'])) {
            $img = $_FILES['imagen'];
            $name = $img['name'];
            $tmpName = $img['tmp_name'];
        }
    
        if (empty($nombre) || empty($apellido) || empty($telefono) || empty($correo) || empty($carrera) || empty($id)) {
            $msg = array('msg' => 'Todos los campos son requeridos', 'icono' => 'warning');
        } else {
            $imagenActual = $this->model->getImagenActual($id);
            $imgNombreActual = $imagenActual ? $imagenActual['foto'] : 'user.png';
    
            if (!empty($name)) {
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $formatos_permitidos = array('png', 'jpeg', 'jpg');
    
                if (!in_array($extension, $formatos_permitidos)) {
                    $msg = array('msg' => 'Archivo no permitido', 'icono' => 'warning');
                } else {
                    $imgNombre = $fecha . ".jpg";
                    $destino = "Assets/img/Foto_user/" . $imgNombre;
    
                    if ($imgNombreActual !== 'user.png' && $imgNombreActual !== $imgNombre) {
                        $archivoImagen = "Assets/img/Foto_user/" . $imgNombreActual;
                        if (file_exists($archivoImagen)) {
                            unlink($archivoImagen);
                        }
                    }
                }
            } else if (!empty($_POST['foto_actual']) && empty($name)) {
                $imgNombre = $_POST['foto_actual'];
            } else {
                $imgNombre = "user.png";
            }
    
            if (!empty($name)) {
                move_uploaded_file($tmpName, $destino);
            }
    
            $data = $this->model->actualizarPerfil($nombre, $apellido, $telefono, $correo, $carrera, $imgNombre, $id);
    
            if ($data == "modificado") {
                $msg = array('msg' => 'Estudiante modificado', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
            }
        }
    
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    
    
    public function obtenerDatosListas() {
        $datosListas = $this->model->recDatosListas();
        echo json_encode($datosListas, JSON_UNESCAPED_UNICODE);
    }
    
}
