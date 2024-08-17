<?php
class LibrosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getLibros()
    {
        $sql = "SELECT * FROM libro";
        $res = $this->selectAll($sql);
        return $res;
    }
    public function insertarLibros($especialidad, $orden_pagina, $n_especialidad, $tema_titulo, $codigo_titulo_autor, $n_unico, $titulo, 
        $autor, $resumen, $cantidad, $precio_unidad, $valor_total, $estado_fisico, $fecha_ingreso, $estante_ubicacion, $nivel_estante, $imgNombre
    ) {
        if (empty($resumen)) {$resumen = "Sin Información";}
        $verificar = "SELECT * FROM libro WHERE titulo = '$titulo'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $query = "INSERT INTO libro(especialidad, orden_pagina, n_especialidad, tema_titulo, codigo_titulo_autor, n_unico, titulo, autor, resumen, cantidad, precio_unidad, valor_total, estado_fisico, fecha_ingreso, estante_ubicacion, nivel_estante, imagen) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $datos = array($especialidad, $orden_pagina, $n_especialidad, $tema_titulo, $codigo_titulo_autor, $n_unico, $titulo, $autor, 
            $resumen, $cantidad, $precio_unidad, $valor_total, $estado_fisico, $fecha_ingreso, $estante_ubicacion, $nivel_estante, $imgNombre
            );
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
    
    public function editLibros($id)
    {
        $sql = "SELECT * FROM libro WHERE id = $id";
        $res = $this->select($sql);
        return $res;
    }
    public function actualizarLibros($especialidad, $orden_pagina, $n_especialidad, $tema_titulo, $codigo_titulo_autor, $n_unico, $titulo, 
        $autor,  $resumen, $cantidad, $precio_unidad, $valor_total, $estado_fisico, $fecha_ingreso, $estante_ubicacion, $nivel_estante, $imgNombre, $id
    ) {
        $query = "UPDATE libro SET especialidad =?, orden_pagina =?, n_especialidad =?, tema_titulo =?, codigo_titulo_autor =?, n_unico =?, titulo =?, autor =?, resumen =?, cantidad =?, precio_unidad =?, valor_total =?, estado_fisico =?, fecha_ingreso =?, estante_ubicacion =?, nivel_estante =?, imagen =? WHERE id =?";
        $datos = array($especialidad, $orden_pagina, $n_especialidad, $tema_titulo, $codigo_titulo_autor, $n_unico, $titulo, $autor, 
        $resumen, $cantidad, $precio_unidad, $valor_total, $estado_fisico, $fecha_ingreso, $estante_ubicacion, $nivel_estante, $imgNombre, $id
        );
        $data = $this->save($query, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    
    public function estadoLibros($estado, $id)
    {
        $query = "UPDATE libro SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $data = $this->save($query, $datos);
        return $data;
    }
    public function buscarLibro($valor)
    {
        $sql = "SELECT id, titulo AS text FROM libro WHERE titulo LIKE '%" . $valor . "%' AND estado = 1 LIMIT 10";
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
