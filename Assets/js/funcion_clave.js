function modificarContraseña(e) {
    e.preventDefault();
    
    const clv_actual = document.querySelector("#clv_actual").value;
    const clv_nueva = document.querySelector("#clv_nueva").value;
    const clv_confirmar = document.querySelector("#clv_confirmar").value;
    
    if (clv_actual == "" || clv_nueva == "" || clv_confirmar == "") {
        mostrarAlerta('Todos los campos son requeridos', 'warning');
    } else if (clv_nueva != clv_confirmar) {
        mostrarAlerta('Las contraseñas no coinciden', 'warning');
    } else {
        const formClavest = document.querySelector("#frmCambiarContraseña");
        const http = new XMLHttpRequest();
        const url = base_url + "HomeBibl/cambiarContraseña";
        http.open("POST", url);
        http.send(new FormData(formClavest));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                Swal.fire({
                    title: res.msg,
                    icon: res.icono,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    if (res.icono === 'success') {
                        window.location = base_url + res.redireccion;
                    }
                });
            }
        }
    }
}
