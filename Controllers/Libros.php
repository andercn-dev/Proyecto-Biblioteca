<?php
class Libros extends Controller
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
            $perm = $this->model->verificarPermisos($id_user, "Libros");
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
        $data = $this->model->getLibros();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['imagen'] = '<img class="img-thumbnail" src="' . base_url . "Assets/img/PortadaLibros/" . $data[$i]['imagen'] . '" height="50">';
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div class="d-flex">
                <button class="btn btn-primary" type="button" onclick="btnEditarLibro(' . $data[$i]['id'] . ');"><i class="fa fa-pencil-square-o"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarLibro(' . $data[$i]['id'] . ');"><i class="fa fa-trash-o"></i></button>
                <div/>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarLibro(' . $data[$i]['id'] . ');"><i class="fa fa-reply-all"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $titulo = strClean($_POST['titulo']);
        $autor = strClean($_POST['autor']);
        $especialidad = strClean($_POST['especialidad']);
        $orden_pagina = strClean($_POST['orden_pagina']);
        $n_especialidad = strClean($_POST['n_especialidad']);
        $tema_titulo = strClean($_POST['tema_titulo']);
        $codigo_titulo_autor = strClean($_POST['codigo_titulo_autor']);
        $n_unico = strClean($_POST['n_unico']);
        $resumen = strClean($_POST['resumen']);
        $cantidad = strClean($_POST['cantidad']);
        $precio_unidad = strClean($_POST['precio_unidad']);
        $valor_total = strClean($_POST['valor_total']);
        $estado_fisico = strClean($_POST['estado_fisico']);
        $fecha_ingreso = strClean($_POST['fecha_ingreso']);
        $estante_ubicacion = strClean($_POST['estante_ubicacion']);
        $nivel_estante = strClean($_POST['nivel_estante']);
        $id = strClean($_POST['id']);
        $img = $_FILES['imagen'];
        $name = $img['name'];
        $fecha = date("YmdHis");
        $tmpName = $img['tmp_name'];
        if (empty($titulo) || empty($autor) || empty($especialidad) || empty($cantidad) || empty($fecha_ingreso)) {
            $msg = array('msg' => 'Todo los campos son requeridos', 'icono' => 'warning');
        } else {
            if (!empty($name)) {
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $formatos_permitidos = array('png', 'jpeg', 'jpg');
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                if (!in_array($extension, $formatos_permitidos)) {
                    $msg = array('msg' => 'Archivo no permitido', 'icono' => 'warning');
                } else {
                    $imgNombre = $fecha . ".jpg";
                    $destino = "Assets/img/PortadaLibros/" . $imgNombre;
                }
            } else if (!empty($_POST['foto_actual']) && empty($name)) {
                $imgNombre = $_POST['foto_actual'];
            } else {
                $imgNombre = "sinportada.png";
            }
            if ($id == "") {
                $data = $this->model->insertarLibros(
                    $especialidad,
                    $orden_pagina,
                    $n_especialidad,
                    $tema_titulo,
                    $codigo_titulo_autor,
                    $n_unico,
                    $titulo,
                    $autor,
                    $resumen,
                    $cantidad,
                    $precio_unidad,
                    $valor_total,
                    $estado_fisico,
                    $fecha_ingreso,
                    $estante_ubicacion,
                    $nivel_estante,
                    $imgNombre
                );
                if ($data == "ok") {
                    if (!empty($name)) {
                        move_uploaded_file($tmpName, $destino);
                    }
                    $msg = array('msg' => 'Libro registrado', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'El libro ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } else {
                $imgDelete = $this->model->editLibros($id);
                if ($imgDelete['imagen'] != 'sinportada.png') {
                    if (file_exists("Assets/img/PortadaLibros/" . $imgDelete['imagen'])) {
                        unlink("Assets/img/PortadaLibros/" . $imgDelete['imagen']);
                    }
                }
                $data = $this->model->actualizarLibros(
                    $especialidad,
                    $orden_pagina,
                    $n_especialidad,
                    $tema_titulo,
                    $codigo_titulo_autor,
                    $n_unico,
                    $titulo,
                    $autor,
                    $resumen,
                    $cantidad,
                    $precio_unidad,
                    $valor_total,
                    $estado_fisico,
                    $fecha_ingreso,
                    $estante_ubicacion,
                    $nivel_estante,
                    $imgNombre,
                    $id
                );
                if ($data == "modificado") {
                    if (!empty($name)) {
                        move_uploaded_file($tmpName, $destino);
                    }
                    $msg = array('msg' => 'Libro modificado', 'icono' => 'success');
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
        $data = $this->model->editLibros($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar($id)
    {
        $data = $this->model->estadoLibros(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Libro dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar($id)
    {
        $data = $this->model->estadoLibros(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Libro restaurado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al restaurar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function verificar($id_libro)
    {
        if (is_numeric($id_libro)) {
            $data = $this->model->editLibros($id_libro);
            if (!empty($data)) {
                $msg = array('cantidad' => $data['cantidad'], 'icono' => 'success');
            }
        } else {
            $msg = array('msg' => 'Error Fatal', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function buscarLibro()
    {
        if (isset($_GET['lb'])) {
            $valor = $_GET['lb'];
            $data = $this->model->buscarLibro($valor);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    public function rlibros()
    {
        $libros = $this->model->getLibros();
        require_once 'Libraries/pdf/fpdf.php';
        $pdf = new FPDF('P', 'mm', 'letter');
        $pdf->AddPage();
        $pdf->SetMargins(10, 10, 10);
    
        $pageWidth = $pdf->GetPageWidth() - 20;

        $pdf->Image("Assets/img/pdf_excel/Emcabezado.png", 10, 2, $pageWidth);
    
        $pdf->SetFont('Arial', 'BU', 26);
        $pdf->Ln(25);
        $pdf->Cell(0, 10, "Reporte de Libros", 0, 1, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 5, utf8_decode("ID"), 1, 0, 'C');
        $pdf->Cell(80, 5, utf8_decode("Título"), 1, 0, 'C');
        $pdf->Cell(55, 5, utf8_decode("Autor"), 1, 0, 'C');
        $pdf->Cell(20, 5, utf8_decode("Cantidad"), 1, 0, 'C');
        $pdf->Cell(30, 5, utf8_decode("Fecha Ingreso"), 1, 1, 'C');
    
        foreach ($libros as $libro) {
            $titulo = !empty($libro['titulo']) ? utf8_decode($libro['titulo']) : '';
            $autor = !empty($libro['autor']) ? utf8_decode($libro['autor']) : '';
            $cantidad = !empty($libro['cantidad']) ? $libro['cantidad'] : '0';
            $fechaIngreso = !empty($libro['fecha_ingreso']) ? $libro['fecha_ingreso'] : 'N/A';
    
            $pdf->Cell(10, 5, $libro['id'], 1, 0, 'C');
            $pdf->Cell(80, 5, $titulo, 1, 0, 'L');
            $pdf->Cell(55, 5, $autor, 1, 0, 'L');
            $pdf->Cell(20, 5, $cantidad, 1, 0, 'C');
            $pdf->Cell(30, 5, $fechaIngreso, 1, 1, 'C');
        }
    
        $pdf->Output("Reporte de Libros.pdf", "I");
    }
    


    public function Excellibros()
    {
        $libros = $this->model->getLibros();
    
        header("Content-Type: application/vnd.ms-excel;charset=utf-8");
        header("Content-Disposition: attachment; filename=Reporte_Libros.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "\xEF\xBB\xBF";
    
        echo "<table border='1' style='border-collapse: collapse;'>";

        // echo "<tr>";
        // echo "<td colspan='19' style='text-align: center; height: 100px;'>";
        // echo "<img src='Assets/img/pdf_excel/Emcabezado.png' style='width:100%; height:auto;'/>";
        // echo "</td>";
        // echo "</tr>";

        // Fila de título del reporte
        echo "<tr style='background-color: #f2f2f2; font-weight: bold; font-size: 28pt; text-align: center; height: 50px;'>";
        echo "<td colspan='19'>Reporte de Libros</td>"; 
        echo "</tr>";

        // Cabeceras de columnas
        echo "<tr style='background-color: #f2f2f2; font-weight: bold;';>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt; '>ID</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Especialidad</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Orden Página</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>N Especialidad</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Tema Título</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Código Título Autor</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>N Único</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Imagen</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Título</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Autor</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Resumen</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Cantidad</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Precio Unidad</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Valor Total</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Estado Físico</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Fecha Ingreso</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Estante Ubicación</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Nivel Estante</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Estado</th>";
        echo "</tr>";
    
        foreach ($libros as $libro) {
            echo "<tr>";
            echo "<td>" . $libro['id'] . "</td>";
            echo "<td>" . $libro['especialidad'] . "</td>";
            echo "<td>" . $libro['orden_pagina'] . "</td>";
            echo "<td>" . $libro['n_especialidad'] . "</td>";
            echo "<td>" . $libro['tema_titulo'] . "</td>";
            echo "<td>" . $libro['codigo_titulo_autor'] . "</td>";
            echo "<td>" . $libro['n_unico'] . "</td>";
            echo "<td>" . $libro['imagen'] . "</td>"; 
            echo "<td>" . $libro['titulo'] . "</td>";
            echo "<td>" . $libro['autor'] . "</td>";
            echo "<td>" . $libro['resumen'] . "</td>";
            echo "<td>" . $libro['cantidad'] . "</td>";
            echo "<td>" . $libro['precio_unidad'] . "</td>";
            echo "<td>" . $libro['valor_total'] . "</td>";
            echo "<td>" . $libro['estado_fisico'] . "</td>";
            echo "<td>" . $libro['fecha_ingreso'] . "</td>";
            echo "<td>" . $libro['estante_ubicacion'] . "</td>";
            echo "<td>" . $libro['nivel_estante'] . "</td>";
            echo "<td>" . $libro['estado'] . "</td>";
            echo "</tr>";
        }
    
        echo "</table>";
    }
    
}
