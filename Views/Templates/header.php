<!DOCTYPE html>
<html lang="en">

<head>
    <title>Panel Administrativo</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url; ?>Assets/img/LOGO-MAC.png" />

    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="<?php echo base_url; ?>Assets/css/main.css" rel="stylesheet" />
    <link href="<?php echo base_url; ?>Assets/css/datatables.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link href="<?php echo base_url; ?>Assets/css/select2.min.css" rel="stylesheet" />
	<link href="<?php echo base_url; ?>Assets/css/estilos.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="#"><img src="<?php echo base_url; ?>Assets/img/LOGO-MAC.png " alt="Logo Image" width="50"></a>
        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
        <!-- Navbar Right Menu-->
        <ul class="app-nav">
            <!--Notification Menu-->
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Show notifications"><i class="fa fa-bell-o fa-lg"></i></a>
                <ul class="app-notification dropdown-menu dropdown-menu-right">
                    <li class="app-notification__title">Libros no entregados.</li>
                    <div class="app-notification__content">
                        <li id="nombre_estudiante">
                            
                        </li>
                    </div>
                </ul>
            </li>
            <!-- User Menu-->
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href="#" id="modalPass"><i class="fa fa-user fa-lg"></i> Perfil</a></li>
                    <li><a class="dropdown-item" href="<?php echo base_url; ?>Usuarios/salir"><i class="fa fa-sign-out fa-lg"></i> Salir</a></li>
                </ul>
            </li>
        </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?php echo base_url; ?>Assets/img/Foto_user/user.png" alt="User Image" width="50">
            <div>
                <p class="app-sidebar__user-name"><?php echo $_SESSION['nombre'] ?></p>
                <p class="app-sidebar__user-designation"><?php echo $_SESSION['usuario']; ?></p>
            </div>
        </div>
        <ul class="app-menu">
            <li><a class="app-menu__item" href="<?php echo base_url; ?>Configuracion/admin"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Home</span></a></li>
            <li><a class="app-menu__item" href="<?php echo base_url; ?>Solicitudes"><i class="app-menu__icon fa fa-envelope-open"></i><span class="app-menu__label">Solicitudes</span></a></li>
            <li><a class="app-menu__item" href="<?php echo base_url; ?>Prestamos"><i class="app-menu__icon fa fa-hourglass-start"></i><span class="app-menu__label">Prestamos</span></a></li>
            <li><a class="app-menu__item" href="<?php echo base_url; ?>Estudiantes"><i class="app-menu__icon fa fa-graduation-cap"></i><span class="app-menu__label">Estudiantes</span></a></li>
            <li><a class="app-menu__item" href="<?php echo base_url; ?>Libros"><i class="app-menu__icon fa fa-book"></i><span class="app-menu__label">Libros</span></a></li>
            <li><a class="app-menu__item" href="<?php echo base_url; ?>Usuarios"><i class="app-menu__icon fa fa-user-o"></i><span class="app-menu__label">Usuarios</span></a></li>


        </ul>
    </aside>
    <main class="app-content">