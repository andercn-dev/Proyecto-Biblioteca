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
    <link rel="stylesheet" href="<?php echo base_url; ?>Assets/css/modal.css">
    <link rel="stylesheet" href="<?php echo base_url; ?>Assets/css/footer.css">
    <link rel="stylesheet" href="<?php echo base_url; ?>Assets/css/p_estilo.css">
    <link rel="stylesheet" href="<?php echo base_url; ?>Assets/css/p_homeb.css">
    <link rel="stylesheet" href="<?php echo base_url; ?>Assets/css/slider.css">
    <link rel="stylesheet" href="<?php echo base_url; ?>Assets/css/owl.carousel.min.css">

    <script src="<?php echo base_url; ?>Assets/js/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <style>
        @media(max-width:700px) {
            .login-title {
                font-size: 14px;
                display: block;
            }

        }
    </style>
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
    </header>

    <nav>
        <div>
            <i class="fa-solid fa-bars" id="btn_menu"></i>
            <div>
                <ul class="menu">
                    <img src="<?php echo base_url; ?>Assets/img/LOGO-MAC.png" alt="">
                    <li>
                        <div>
                            <a href="<?php echo base_url; ?>index"><i class="fa-solid fa-home"></i></a>
                        </div>
                    </li>

                    <li>
                        <div>
                            <a href="https://iestp-mac.edu.pe/" target="_blank" rel="noopener"><i class="fa-solid fa-school"></i>Ir a página principal</a>
                        </div>
                    </li>

                    <li>
                        <div>
                            <a href="#" id="openModalLink"><i class="fa-solid fa-right-to-bracket"></i>Iniciar Sesión</a>
                        </div>
                    </li>
                </ul>

                <ul class="menu"></ul>
            </div>
        </div>
    </nav>

    <!-- Modal de Inicio de Sesion -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="closeModalBtn">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col image-col">
                            <img src="<?php echo base_url; ?>Assets/img/biblioteca.jpg" alt="Imagen" class="img-fluid">
                        </div>
                        <div class="col form-col">
                            <form role="form" id="frmLogin" onsubmit="frmLogin(event);">
                                <div class="greeting">
                                    <h1>¡Hola!</h1>
                                    <h5>Ingresa tus datos para <br>iniciar sesión</h5>
                                </div><br>
                                <div class="form-group">
                                    <label>Usuario</label>
                                    <input class="form-control" type="text" placeholder="Ingresa tu usuario" id="usuario" name="usuario" autofocus required>
                                </div>


                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <div>
                                        <input class="form-control" type="password" placeholder="Ingrese tu contraseña" id="clave" name="clave" required>
                                        <i class="fa fa-eye" id="togglePassword" data-target="clave"></i>
                                    </div>
                                </div>


                                <div role="alert" id="alerta"></div>
                                <a class="forgot-password"><span>¿Olvidaste tu contraseña? </span>, Acercate a Biblioteca.</a><br><br>
                                <div class="form-group btn-container">
                                    <button class="btn btn-success btn-block" type="submit">
                                        <i class="fa-solid fa-right-to-bracket"></i> Login</button>
                                </div>
                                <div class="signup">
                                    <p>¿No tienes una cuenta? <a href="#" class="signup-link" id="openRegisterModalLink"> Registrate.</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop" id="modalBackdrop"></div>


    <!-- Modal de Registro -->
    <div class="modal2" id="registerModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="closeRegisterModalBtn">&times;</button>
                </div>
                <div class="modal-body">
                    <form role="form" id="frmRegister" onsubmit="frmRegister(event);">
                        <div class="row">
                            <div class="col part-col">
                                <div class="greeting2">
                                    <h2>Registrá tu nueva cuenta en la Biblioteca MAC</h2>
                                </div><br>
                                <div class="signup2">
                                    <p>
                                        <a href="#" class="signup-link" id="openLoginModalLink"> ¿Ya estás registrado? Ingresa a tu cuenta..</a>
                                    </p>
                                </div><br>

                                <div class="form-group">
                                    <label>DNI</label>
                                    <input class="form-control" type="number" placeholder="Ingrese su DNI" id="dni" name="dni" required maxlength="8">
                                </div>

                                <div class="form-group">
                                    <label>Nombres</label>
                                    <input class="form-control" type="text" placeholder="Ingrese su nombre" id="nombre" name="nombre" required>
                                </div>

                                <div class="form-group">
                                    <label>Apellidos Completos</label>
                                    <input class="form-control" type="text" placeholder="Ingrese su apellido" id="apellido" name="apellido" required>
                                </div>

                                <div class="form-group">
                                    <label>Telefono</label>
                                    <input class="form-control" type="number" placeholder="Ingrese su telefono" id="telefono" name="telefono" required maxlength="9">
                                </div>
                            </div>

                            <div class="col form-col">
                                <div class="form-group">
                                    <label>Fecha de Nacimiento</label>
                                    <input class="form-control" type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
                                </div>

                                <div class="form-group">
                                    <label>Correo</label>
                                    <input class="form-control" type="email" placeholder="Ingrese su correo" id="correo" name="correo" required>
                                </div>

                                <div class="form-group">
                                    <label>Especialidad</label>
                                    <select id="carrera" class="form-control" name="carrera" required>
                                        <option value="" disabled selected>Selecciona una carrera</option>
                                        <option value="Computación e Informática">Computación e Informática</option>
                                        <option value="Desarrollo de Sistemas de Información">Desarrollo de Sistemas de Información</option>
                                        <option value="Enfermería Tecnica">Enfermería Tecnica</option>
                                        <option value="Industrias Alimentarias">Industrias Alimentarias</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <div>
                                        <input class="form-control" type="password" placeholder="Ingrese su contraseña" id="rclave" name="rclave" required>
                                        <i class="fa fa-eye" id="togglePassword" data-target="rclave"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Confirmar Contraseña</label>
                                    <div>
                                        <input class="form-control" type="password" placeholder="Confirme su contraseña" id="confirmar_clave" name="confirmar_clave" required>
                                        <i class="fa fa-eye" id="togglePassword" data-target="confirmar_clave"></i>
                                    </div>
                                </div>

                                <div role="alert" id="registerAlert"></div><br>
                                <div class="form-group btn-container">
                                    <button class="btn btn-success btn-block" type="submit">
                                        <i class="fa-solid fa-user-plus"></i> Registrarse</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop" id="registerModalBackdrop"></div>




    <script src="<?php echo base_url; ?>Assets/js/modal.js"></script>
    </div>

    <div>