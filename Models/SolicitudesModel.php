<?php
class SolicitudesModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getSolicitudes()
    {
        $sql = "SELECT s.id, CONCAT(e.nombre, ' ', e.apellido) AS nombre_completo, l.titulo, s.id_estudiante, 
                    s.id_libro, s.fecha_prestamo, s.fecha_devolucion, s.cantidad, s.estado FROM 
                    estudiante e INNER JOIN solicitudes s ON s.id_estudiante = e.id INNER JOIN libro l ON s.id_libro = l.id";
        $res = $this->selectAll($sql);
        return $res;
    }
    

    public function aceptarPrestamo($estado, $id)
    {
        $sql = "UPDATE solicitudes SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $res = $this->save($sql, $datos);
    
        if ($res == 1) {
            $lib = "SELECT * FROM solicitudes WHERE id = $id";
            $resSolicitud = $this->select($lib);
    
            if ($resSolicitud) {
                $query = "INSERT INTO prestamo (id_estudiante, id_libro, fecha_prestamo, fecha_devolucion, cantidad, observacion, estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $datosNuevoPrestamo = array(
                    $resSolicitud['id_estudiante'],
                    $resSolicitud['id_libro'],
                    date('Y-m-d'),
                    $resSolicitud['fecha_devolucion'],
                    $resSolicitud['cantidad'],
                    $resSolicitud['observacion'],
                    1 
                );
                $resPrestamo = $this->insert($query, $datosNuevoPrestamo);
                $res = $resPrestamo > 0 ? "ok" : "error";
            } else {
                $res = "error";
            }
        } else {
            $res = "error";
        }
    
        return $res;
    }
        
        

    public function selectDatos()
    {
        $sql = "SELECT * FROM configuracion";
        $res = $this->select($sql);
        return $res;
    }

    public function verificarPermisos($id_user, $permiso)
    {
        $tiene = false;
        $sql = "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'";
        $existe = $this->select($sql);
        if ($existe != null || $existe != "") {
            $tiene = true;
        }
        return $tiene;
    }


}
