<?php
class Home extends Controller
{
    public function __construct()
    {
        session_start();
        if (!empty($_SESSION['activo'])) {
            header("location: " . base_url . "Usuarios");

            // Redirección basada en el rol del usuario
            $rol = $_SESSION['rol'];
            if ($rol === 'admin') {
                header("location: " . base_url . "Configuracion/admin");
                exit;
            }
        }
        parent::__construct();
    }

    public function index()
    {
        $this->views->getView($this, "index");
    }
}
