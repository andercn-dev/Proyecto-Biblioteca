<?php
class EstudiantesModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getEstudiantes()
    {
        $sql = "SELECT * FROM estudiante";
        $res = $this->selectAll($sql);
        return $res;
    }
    public function insertarEstudiante($dni, $clave, $nombre, $apellido, $telefono, $fecha_nacimiento, $correo, $carrera)
    {
        $verificar = "SELECT * FROM estudiante WHERE dni = '$dni'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $query = "INSERT INTO estudiante(dni, clave, nombre, apellido, telefono, fecha_nacimiento, correo, carrera) VALUES (?,?,?,?,?,?,?,?)";
            $datos = array($dni, $clave, $nombre, $apellido, $telefono, $fecha_nacimiento,$correo, $carrera);
            $data = $this->save($query, $datos);
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            $res = "existe";
        }
        return $res;
    }
    public function editEstudiante($id)
    {
        $sql = "SELECT * FROM estudiante WHERE id = $id";
        $res = $this->select($sql);
        return $res;
    }
    public function actualizarEstudiante($dni, $nombre, $apellido, $telefono, $fecha_nacimiento,$correo, $carrera, $id)
    {
        $query = "UPDATE estudiante SET dni = ?, nombre = ?, apellido = ?, telefono = ?, fecha_nacimiento = ?, correo = ?, carrera = ?  WHERE id = ?";
        $datos = array($dni, $nombre, $apellido, $telefono, $fecha_nacimiento, $correo, $carrera, $id);
        $data = $this->save($query, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function actualizarPass($clave, $id)
    {
        $sql = "UPDATE estudiante SET clave = ? WHERE id = ?";
        $datos = array($clave, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function estadoEstudiante($estado, $id)
    {
        $query = "UPDATE estudiante SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $data = $this->save($query, $datos);
        return $data;
    }
    public function buscarEstudiante($valor)
    {
        $sql = "SELECT id, dni, CONCAT(nombre, ' ', apellido) AS text FROM estudiante 
                WHERE (dni LIKE '%" . $valor . "%' OR nombre LIKE '%" . $valor . "%' OR apellido LIKE '%" . $valor . "%') AND estado = 1 
                LIMIT 10";
        $data = $this->selectAll($sql);
        return $data;
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
