<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo base_url; ?>Assets/img/LOGO-MAC.png">
    <title>Biblioteca MAC</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />


    <link rel="stylesheet" href="<?php echo base_url; ?>Assets/css/nav.css">
    <link rel="stylesheet" href="<?php echo base_url; ?>Assets/css/footer.css">
    <link rel="stylesheet" href="<?php echo base_url; ?>Assets/css/p_homeb.css">
    <link rel="stylesheet" href="<?php echo base_url; ?>Assets/css/clave_camb.css">

    <script src="<?php echo base_url; ?>Assets/js/jquery-3.6.0.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

</head>

<body>

    <!--Fondo Oscuro que se activa al ingresar menu responsive-->
    <div class="menu-black"></div>

    <header class="header-user">
        <div class="login-logo">
            <img src="<?php echo base_url; ?>Assets/img/LOGO-MAC.png" alt="">
            <div class="login-title">
                <h3>Instituto de Educación Superior Tecnológico Público</h3>
                <h2>Manuel Arévalo Cáceres</h2>
            </div>
        </div>

        <!---IMAGEN PERFIL DEL USUARIO-->
        <div class="login-user">
            <div class="nom_usuario">
                <h4><?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?></h4>
            </div>
            <div class="login_img">
                <input type="hidden" id="idfoto" name="idfoto" value="<?php echo isset($_SESSION['id_estudiante']) ? $_SESSION['id_estudiante'] : ''; ?>">
                <img id="img-perfil" src="" alt="Foto de perfil">
            </div>
        </div>
        <!---FIN IMAGEN PERFIL-->
    </header>
    <nav>
        <div>
            <i class="fa-solid fa-bars" id="btn_menu"></i>
            <div>
                <ul class="menu">
                    <img src="<?php echo base_url; ?>Assets/img/LOGO-MAC.png" alt="">
                    <li>
                        <div>
                            <a href="<?php echo base_url; ?>HomeBibl"><i class="fa-solid fa-home"></i></a>
                        </div>
                    </li>

                    <li>
                        <div>
                            <a href="<?php echo base_url; ?>HomeBibl/libsolicitados"><i class="fa-solid fa-book-bookmark"></i>Libros Solicitados</a>
                        </div>
                    </li>

                    <li>
                        <div>
                            <a href="<?php echo base_url; ?>HomeBibl/perfil"><i class="fa-solid fa-user"></i>Mi Perfil</a>
                        </div>
                    </li>
                </ul>

                <ul class="menu">
                    <li>
                        <div>
                            <a href="#"><i class="fa-solid fa-user" id="icon_estudiante"></i>Estudiante</a>
                            <i class="fa-solid fa-angle-right" id="icon_right"></i>
                        </div>

                        <ul class="menu-second">
                            <li><i class="fa-solid fa-lock"></i><a href="<?php echo base_url; ?>HomeBibl/clavecamb">Cambiar Contraseña</a></li>
                        </ul>
                    </li>
                    <li>
                        <div>
                            <a href="<?php echo base_url; ?>Usuarios/salir">
                                <i class="fa-solid fa-power-off" id="icon_cerrar"></i>
                            </a>
                        </div>

                    </li>
                </ul>

            </div>
        </div>
    </nav>

    </div>

    <div></div>