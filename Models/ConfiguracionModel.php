<?php
class ConfiguracionModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function selectDatos($nombre)
    {
        $sql = "SELECT COUNT(*) AS total FROM $nombre WHERE estado = 1";
        $res = $this->select($sql);
        return $res;
    }

    public function getReportes()
    {
        $sql = "SELECT l.titulo, COUNT(p.id_libro) AS total_prestamos FROM prestamo p JOIN 
                libro l ON p.id_libro = l.id WHERE l.estado = 1 GROUP BY 
                p.id_libro, l.titulo ORDER BY total_prestamos DESC";
        $res = $this->selectAll($sql);
        return $res;
    }

    public function getVerificarPrestamos($date)
    {
        $sql = "SELECT p.id, p.id_estudiante, p.fecha_prestamo, p.fecha_devolucion, p.cantidad, p.estado, 
                    e.id, CONCAT(e.nombre, ' ', e.apellido) AS nombre_completo, 
                    l.id, l.titulo, 
                    DATEDIFF('$date', p.fecha_devolucion) AS dias_retraso
                FROM prestamo p 
                INNER JOIN estudiante e ON p.id_estudiante = e.id 
                INNER JOIN libro l ON p.id_libro = l.id 
                WHERE p.fecha_devolucion < '$date' AND p.estado = 1";
        $res = $this->selectAll($sql);
        return $res;
    }
    
    public function verificarPermisos($id_user, $permiso)
    {
        $tiene = false;
        $sql = "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND CONCAT(e.nombre, ' ', e.apellido) AS nombre_completo = '$permiso'";
        $existe = $this->select($sql);
        if ($existe != null || $existe != "") {
            $tiene = true;
        }
        return $tiene;
    }
}
