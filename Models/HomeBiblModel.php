<?php
class HomeBiblModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function recLibros()
    {
        $sql = "SELECT * FROM libro ORDER BY fecha_ingreso DESC LIMIT 10";
        $res = $this->selectAll($sql);
        return $res;
    }

    public function recDatosListas() {
        $especialidades = $this->selectAll("SELECT DISTINCT especialidad FROM libro");
        $autores = $this->selectAll("SELECT DISTINCT autor FROM libro ORDER BY autor ASC");
        $anios = $this->selectAll("SELECT DISTINCT YEAR(fecha_ingreso) as anio FROM libro ORDER BY anio DESC");
        $archivos = $this->selectAll("SELECT DISTINCT tema_titulo FROM libro");
    
        return [
            'especialidades' => $especialidades,
            'autores' => $autores,
            'anios' => $anios,
            'archivos' => $archivos
        ];
    }
    
    public function buscarLibroB($valor, $especialidad, $anio, $autor, $limit, $offset)
    {
        $sql = "SELECT id, especialidad, titulo, autor, imagen, cantidad, codigo_titulo_autor, fecha_ingreso, resumen
            FROM libro 
            WHERE estado = 1";

        if (!empty($valor)) {
            $sql .= " AND titulo LIKE '%" . $valor . "%'";
        }
        if (!empty($especialidad)) {
            $sql .= " AND especialidad LIKE '%" . $especialidad . "%'";
        }
        if (!empty($anio)) {
            $sql .= " AND YEAR(fecha_ingreso) = " . intval($anio);
        }
        if (!empty($autor)) {
            $sql .= " AND autor LIKE '%" . $autor . "%'";
        }

        $sql .= " LIMIT $limit OFFSET $offset";

        $data = $this->selectAll($sql);
        return $data;
    }

    public function countLibros($valor, $especialidad, $anio, $autor)
    {
        $sql = "SELECT COUNT(*) as total FROM libro WHERE estado = 1";

        if (!empty($valor)) {
            $sql .= " AND titulo LIKE '%" . $valor . "%'";
        }
        if (!empty($especialidad)) {
            $sql .= " AND especialidad LIKE '%" . $especialidad . "%'";
        }
        if (!empty($anio)) {
            $sql .= " AND YEAR(fecha_ingreso) = " . intval($anio);
        }
        if (!empty($autor)) {
            $sql .= " AND autor LIKE '%" . $autor . "%'";
        }

        $result = $this->select($sql);
        return $result['total'];
    }

    public function getlistsolicitados($id_estudiante)
    {
        $sql = "SELECT e.id, CONCAT(e.nombre, ' ', e.apellido) AS nombre_completo, 
                    l.id AS libro_id, l.titulo AS libro_titulo, 
                    p.id AS prestamo_id, p.id_estudiante, p.id_libro, 
                    p.fecha_prestamo, p.fecha_devolucion, p.cantidad, 
                    p.observacion, p.estado 
                FROM estudiante e 
                INNER JOIN prestamo p ON p.id_estudiante = e.id
                INNER JOIN libro l ON p.id_libro = l.id 
                WHERE p.id_estudiante = $id_estudiante";

        $res = $this->selectAll($sql);

        return $res;
    }

    public function getbCantLibro($libro)
    {
        $sql = "SELECT cantidad FROM libro WHERE id = $libro";
        $res = $this->select($sql);
        return $res;
    }

    public function insertarbPrestamo($estudiante, $libro, $cantidad, string $fecha_prestamo, string $fecha_devolucion, string $observacion)
    {
        $verificar = "SELECT * FROM solicitudes WHERE id_libro = '$libro' AND id_estudiante = $estudiante AND estado = 1";
        $existe = $this->select($verificar);
    
        if (empty($existe)) {
            $query = "INSERT INTO solicitudes (id_estudiante, id_libro, fecha_prestamo, fecha_devolucion, cantidad, observacion) VALUES (?,?,?,?,?,?)";
            $datos = array($estudiante, $libro, $fecha_prestamo, $fecha_devolucion, $cantidad, $observacion);
            $data = $this->insert($query, $datos);
    
            if ($data > 0) {
                $lib = "SELECT cantidad FROM libro WHERE id = $libro";
                $resLibro = $this->select($lib);
                $total = $resLibro['cantidad'] - $cantidad;
                $libroUpdate = "UPDATE libro SET cantidad = ? WHERE id = ?";
                $datosLibro = array($total, $libro);
                $this->save($libroUpdate, $datosLibro);
                $res = $data;
            } else {
                $res = 0;
            }
        } else {
            $res = "existe";
        }
    
        return $res;
    }


    public function editarEstd($id)
    {
        $sql = "SELECT * FROM estudiante WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }

    public function cambContraseña($clave, $id)
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


    public function actualizarPerfil($nombre, $apellido, $telefono, $correo, $carrera, $foto, $id)
    {
        $query = "UPDATE estudiante SET nombre = ?, apellido = ?, telefono = ?, correo = ?, carrera = ? ";
        $datos = array($nombre, $apellido, $telefono, $correo, $carrera);
    
        if ($foto !== "user.png") {
            $query .= ", foto = ? ";
            $datos[] = $foto;
        }
    
        $query .= "WHERE id = ?";
        $datos[] = $id;
    
        $data = $this->save($query, $datos);
    
        return $data == 1 ? "modificado" : "error";
    }
    
    public function getImagenActual($id)
    {
        $sql = "SELECT foto FROM estudiante WHERE id = $id";
        $res = $this->select($sql);
        return $res;
    }
    



}
