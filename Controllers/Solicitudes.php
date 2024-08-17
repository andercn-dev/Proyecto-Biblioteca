<?php
class Solicitudes extends Controller
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
            $perm = $this->model->verificarPermisos($id_user, "Solicitudes");
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
        $data = $this->model->getSolicitudes();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-secondary">En Proceso</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnAceptarSolc(' . $data[$i]['id'] . ');"><i class="fa fa-check-square-o"></i></button>
                <div/>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Aceptado</span>';
                $data[$i]['acciones'] = '<div>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function aceptar($id)
    {
        $datos = $this->model->aceptarPrestamo(0, $id);
        if ($datos == "ok") {
            $msg = array('msg' => 'Libro Prestado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al Prestar el libro', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function rsolicitudes()
    {
        $solicitudes = $this->model->getSolicitudes();
        require_once 'Libraries/pdf/fpdf.php';
        $pdf = new FPDF('P', 'mm', 'letter');
        $pdf->AddPage();
        $pdf->SetMargins(10, 10, 10);

        $pageWidth = $pdf->GetPageWidth() - 20;

        $pdf->Image("Assets/img/pdf_excel/Emcabezado.png", 10, 2, $pageWidth);

        $pdf->SetFont('Arial', 'BU', 26);
        $pdf->Ln(25);
        $pdf->Cell(0, 10, "Reporte de Solicitudes", 0, 1, 'C');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 5, utf8_decode("ID"), 1, 0, 'C');
        $pdf->Cell(50, 5, utf8_decode("Nombre Completo"), 1, 0, 'C');
        $pdf->Cell(60, 5, utf8_decode("Título"), 1, 0, 'C');
        $pdf->Cell(28, 5, utf8_decode("F. Préstamo"), 1, 0, 'C');
        $pdf->Cell(28, 5, utf8_decode("F. Devolución"), 1, 0, 'C');
        $pdf->Cell(20, 5, utf8_decode("Cantidad"), 1, 1, 'C');

        foreach ($solicitudes as $solicitud) {
            $pdf->Cell(10, 5, $solicitud['id'], 1, 0, 'C');
            $pdf->Cell(50, 5, utf8_decode($solicitud['nombre_completo']), 1, 0, 'L');
            $pdf->Cell(60, 5, utf8_decode($solicitud['titulo']), 1, 0, 'L');
            $pdf->Cell(28, 5, $solicitud['fecha_prestamo'], 1, 0, 'C');
            $pdf->Cell(28, 5, $solicitud['fecha_devolucion'], 1, 0, 'C');
            $pdf->Cell(20, 5, $solicitud['cantidad'], 1, 1, 'C');
        }

        $pdf->Output("Reporte de Solicitudes.pdf", "I");
    }


    public function Excelsolicitudes()
    {
        $solicitudes = $this->model->getSolicitudes();
    
        header("Content-Type: application/vnd.ms-excel;charset=utf-8");
        header("Content-Disposition: attachment; filename=Reporte_Solicitudes.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
    
        echo "\xEF\xBB\xBF";
    
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        
        // Fila de título del reporte
        echo "<tr style='background-color: #f2f2f2; font-weight: bold; font-size: 28pt; text-align: center; height: 50px;'>";
        echo "<td colspan='6'>Reporte de Solicitudes</td>";
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
    
        foreach ($solicitudes as $solicitud) {
            echo "<tr>";
            echo "<td>" . $solicitud['id'] . "</td>";
            echo "<td>" . $solicitud['nombre_completo'] . "</td>";
            echo "<td>" . $solicitud['titulo'] . "</td>";
            echo "<td>" . $solicitud['fecha_prestamo'] . "</td>";
            echo "<td>" . $solicitud['fecha_devolucion'] . "</td>";
            echo "<td>" . $solicitud['cantidad'] . "</td>";
            echo "</tr>";
        }
    
        echo "</table>";
    }
    
}
