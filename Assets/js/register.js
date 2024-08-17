function frmRegister(e) {
    e.preventDefault();
    
    const dni = document.getElementById("dni");
    const nombre = document.getElementById("nombre");
    const apellido = document.getElementById("apellido");
    const correo = document.getElementById("correo");
    const carrera = document.getElementById("carrera");
    const clave = document.getElementById("rclave");
    const confirmarClave = document.getElementById("confirmar_clave");

    // Validar campos
    if (dni.value === "") {
        dni.classList.add("is-invalid");
        dni.focus();
    } else if (nombre.value === "") {
        nombre.classList.add("is-invalid");
        nombre.focus();
    } else if (apellido.value === "") {
        apellido.classList.add("is-invalid");
        apellido.focus();
    } else if (correo.value === "") {
        correo.classList.add("is-invalid");
        correo.focus();
    } else if (carrera.value === "") {
        carrera.classList.add("is-invalid");
        carrera.focus();
    } else if (clave.value === "" || confirmarClave.value === "") {
        if (clave.value === "") {
            clave.classList.add("is-invalid");
        }
        if (confirmarClave.value === "") {
            confirmarClave.classList.add("is-invalid");
        }
        clave.focus();
    } else if (clave.value !== confirmarClave.value) {
        document.getElementById("registerAlert").classList.remove("d-none");
        document.getElementById("registerAlert").innerHTML = 'Las contraseñas no coinciden.';
    } else {
        
        const url = base_url + "Usuarios/registrarB";
        const frm = document.getElementById("frmRegister");

        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                const res = JSON.parse(this.responseText);
                
                Swal.fire({
                    title: res.msg,
                    icon: res.icono,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    const registerModal = document.getElementById('registerModal');
                    const registerBackdrop = document.getElementById('registerBackdrop');
                    const loginModal = document.getElementById('myModal');
                    const loginBackdrop = document.getElementById('modalBackdrop');
                    
                    if (registerModal && registerBackdrop) {
                        registerModal.style.display = 'none';
                        registerBackdrop.style.display = 'none';
                    }
                    
                    if (res.icono === 'success') {
                        if (loginModal && loginBackdrop) {
                            loginModal.style.display = 'block';
                            loginBackdrop.style.display = 'block';
                        }

                        window.location = base_url + "index";
                    }
                });
            }
        }
    }
}
