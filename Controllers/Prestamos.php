<?php
class Prestamos extends Controller
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
            $perm = $this->model->verificarPermisos($id_user, "Prestamos");
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

    // public function listar()
    // {
    //     $data = $this->model->getPrestamos();
    //     for ($i = 0; $i < count($data); $i++) {
    //         if ($data[$i]['estado'] == 1) {
    //             $data[$i]['estado'] = '<span class="badge badge-secondary">Prestado</span>';
    //             $data[$i]['acciones'] = '<div>
    //             <button class="btn btn-primary" type="button" onclick="btnEntregar(' . $data[$i]['id'] . ');"><i class="fa fa-hourglass-start"></i></button>
    //             <div/>';
    //         } else {
    //             $data[$i]['estado'] = '<span class="badge badge-primary">Devuelto</span>';
    //             $data[$i]['acciones'] = '<div>
    //             <div/>';
    //         }
    //     }
    //     echo json_encode($data, JSON_UNESCAPED_UNICODE);
    //     die();
    // }

    public function listar()
    {
        $data = $this->model->getPrestamos();
        $currentDate = new DateTime();

        for ($i = 0; $i < count($data); $i++) {
            $fechaDevolucion = new DateTime($data[$i]['fecha_devolucion']);

            // Calcular días de retraso
            if ($currentDate > $fechaDevolucion && $data[$i]['estado'] == 1) {
                $interval = $currentDate->diff($fechaDevolucion);
                $diasRetraso = $interval->days;

                // Solo mostrar si hay al menos 1 día de retraso
                if ($diasRetraso >= 1) {
                    $data[$i]['observacion'] = $diasRetraso . " días de retraso";
                } else {
                    $data[$i]['observacion'] = "";
                }
            } else {
                $data[$i]['observacion'] = "";
            }

            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-secondary">Prestado</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEntregar(' . $data[$i]['id'] . ');"><i class="fa fa-hourglass-start"></i></button>
                <div/>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-primary">Devuelto</span>';
                $data[$i]['acciones'] = '<div>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function registrar()
    {
        $libro = strClean($_POST['libro']);
        $estudiante = strClean($_POST['estudiante']);
        $cantidad = strClean($_POST['cantidad']);
        $fecha_prestamo = strClean($_POST['fecha_prestamo']);
        $fecha_devolucion = strClean($_POST['fecha_devolucion']);
        $observacion = strClean($_POST['observacion']);
        if (empty($libro) || empty($estudiante) || empty($cantidad) || empty($fecha_prestamo) || empty($fecha_devolucion)) {
            $msg = array('msg' => 'Todo los campos son requeridos', 'icono' => 'warning');
        } else {
            $verificar_cant = $this->model->getCantLibro($libro);
            if ($verificar_cant['cantidad'] >= $cantidad) {
                $data = $this->model->insertarPrestamo($estudiante, $libro, $cantidad, $fecha_prestamo, $fecha_devolucion, $observacion);
                if ($data > 0) {
                    $msg = array('msg' => 'Libro Prestado', 'icono' => 'success', 'id' => $data);
                } else if ($data == "existe") {
                    $msg = array('msg' => 'El libro ya esta prestado', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al prestar', 'icono' => 'error');
                }
            } else {
                $msg = array('msg' => 'Stock no disponible', 'icono' => 'warning');
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function entregar($id)
    {
        $datos = $this->model->actualizarPrestamo(0, $id);
        if ($datos == "ok") {
            $msg = array('msg' => 'Libro recibido', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al recibir el libro', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function rprestamos()
    {
        $prestamos = $this->model->getPrestamos();
        require_once 'Libraries/pdf/fpdf.php';
        $pdf = new FPDF('P', 'mm', 'letter');
        $pdf->AddPage();
        $pdf->SetMargins(10, 10, 10);

        $pageWidth = $pdf->GetPageWidth() - 20;

        $pdf->Image("Assets/img/pdf_excel/Emcabezado.png", 10, 2, $pageWidth);

        $pdf->SetFont('Arial', 'BU', 26);
        $pdf->Ln(25);
        $pdf->Cell(0, 10, "Reporte de Prestamos", 0, 1, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 5, utf8_decode("ID"), 1, 0, 'C');
        $pdf->Cell(50, 5, utf8_decode("Nombre Completo"), 1, 0, 'C');
        $pdf->Cell(60, 5, utf8_decode("Título"), 1, 0, 'C');
        $pdf->Cell(28, 5, utf8_decode("F. Préstamo"), 1, 0, 'C');
        $pdf->Cell(28, 5, utf8_decode("F. Devolución"), 1, 0, 'C');
        $pdf->Cell(20, 5, utf8_decode("Cantidad"), 1, 1, 'C');

        foreach ($prestamos as $prestamo) {
            $pdf->Cell(10, 5, $prestamo['id'], 1, 0, 'C');
            $pdf->Cell(50, 5, utf8_decode($prestamo['nombre_completo']), 1, 0, 'L');
            $pdf->Cell(60, 5, utf8_decode($prestamo['titulo']), 1, 0, 'L');
            $pdf->Cell(28, 5, $prestamo['fecha_prestamo'], 1, 0, 'C');
            $pdf->Cell(28, 5, $prestamo['fecha_devolucion'], 1, 0, 'C');
            $pdf->Cell(20, 5, $prestamo['cantidad'], 1, 1, 'C');
        }

        $pdf->Output("Reporte de Préstamos.pdf", "I");
    }


    public function Excelprestamos()
    {
        $prestamos = $this->model->getPrestamos();
    
        header("Content-Type: application/vnd.ms-excel;charset=utf-8");
        header("Content-Disposition: attachment; filename=Reporte_Prestamos.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
    
        echo "\xEF\xBB\xBF";
    
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        
        // Fila de título del reporte
        echo "<tr style='background-color: #f2f2f2; font-weight: bold; font-size: 28pt; text-align: center; height: 50px;'>";
        echo "<td colspan='6'>Reporte de Préstamos</td>";
        echo "</tr>";
        
        // Cabeceras de columnas
        echo "<tr style='background-color: #f2f2f2; font-weight: bold;'>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>ID</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Nombre Completo</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Título</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Fecha Préstamo</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Fecha Devolución</th>";
        echo "<th style='height: 30px; background-color: #228B22; color: white; font-size: 16pt;'>Cantidad</th>";
        echo "</tr>";
    
        foreach ($prestamos as $prestamo) {
            echo "<tr>";
            echo "<td>" . $prestamo['id'] . "</td>";
            echo "<td>" . $prestamo['nombre_completo'] . "</td>";
            echo "<td>" . $prestamo['titulo'] . "</td>";
            echo "<td>" . $prestamo['fecha_prestamo'] . "</td>";
            echo "<td>" . $prestamo['fecha_devolucion'] . "</td>";
            echo "<td>" . $prestamo['cantidad'] . "</td>";
            echo "</tr>";
        }
    
        echo "</table>";
    }
    
}
