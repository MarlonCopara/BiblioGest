<?php
class CategoriaModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getCategorias()
    {
        $sql = "SELECT * FROM categoria";
        $res = $this->selectAll($sql);
        return $res;
    }
    public function insertarCategoria($categoria)
    {
        $verificar = "SELECT * FROM categoria WHERE categoria = '$categoria'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $query = "INSERT INTO categoria(categoria) VALUES (?)";
            $datos = array($categoria);
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
    public function editCategoria($id)
    {
        $sql = "SELECT * FROM categoria WHERE id = $id";
        $res = $this->select($sql);
        return $res;
    }
    public function actualizarCategoria($categoria, $id)
    {
        $query = "UPDATE categoria SET categoria = ? WHERE id = ?";
        $datos = array($categoria, $id);
        $data = $this->save($query, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function estadoCategoria($estado, $id)
    {
        $query = "UPDATE categoria SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $data = $this->save($query, $datos);
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
    public function buscarCategoria($valor)
    {
        $sql = "SELECT id, categoria AS text FROM categoria WHERE categoria LIKE '%" . $valor . "%'  AND estado = 1 LIMIT 10";
        $data = $this->selectAll($sql);
        return $data;
    }
}
