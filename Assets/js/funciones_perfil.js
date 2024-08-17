function mostrarAlerta(titulo, texto, icono) {
    Swal.fire({
        title: titulo,
        text: texto,
        icon: icono,
        showConfirmButton: false,
        timer: 1500
    });
}

function imagenprevp(e) {
    var input = document.getElementById('imagenp');
    var filePath = input.value;
    var extension = /(\.png|\.jpeg|\.jpg)$/i;
    if (!extension.exec(filePath)) {
        alertas('Seleccione un archivo valido', 'warning');
        deleteImg();
        return false;   
    } else {
        const url = e.target.files[0];
        const urlTmp = URL.createObjectURL(url);
        document.getElementById("img-preview").src = urlTmp;
        document.getElementById("icon-cerrar").innerHTML = `
            <button class="btn btn-danger" onclick="deleteImg()"><i class="fa fa-times-circle"></i></button>
        `;
    }
}

function deleteImg() {
    document.getElementById('imagenp').value = '';
    document.getElementById('img-preview').src = '';
    document.getElementById('icon-cerrar').innerHTML = '';
}

document.addEventListener("DOMContentLoaded", function() {
    const id = document.getElementById("id").value;
    if (id) {
        cargarDatosPerfil(id);
    }
});

function cargarDatosPerfil(id) {
    const url = base_url + "HomeBibl/editarPerfil/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();

    http.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            try {
                const res = JSON.parse(this.responseText);
                document.getElementById("id").value = res.id;
                document.getElementById("dni").value = res.dni;
                document.getElementById("nombre").value = res.nombre;
                document.getElementById("apellido").value = res.apellido;
                document.getElementById("telefono").value = res.telefono;
                document.getElementById("fecha_nacimiento").value = res.fecha_nacimiento;
                document.getElementById("correo").value = res.correo;
                document.getElementById("carrera").value = res.carrera;

                const profileImg = document.getElementById('img-preview');
                if (res.foto && res.foto !== 'user.png') {
                    profileImg.src = base_url + 'Assets/img/Foto_user/' + res.foto;
                } else {
                    profileImg.src = base_url + 'Assets/img/Foto_user/user.png';
                }

            } catch (e) {
                console.error('Error al parsear JSON:', e);
                mostrarAlerta('Error en la respuesta del servidor. Verifica que el servidor esté enviando JSON.', 'error');
            }
        } else if (this.readyState === 4) {
            mostrarAlerta('Error en la solicitud: ' + this.status, 'error');
        }
    };
}


function actualizarPerfil(e) {
    e.preventDefault();

    const nombre = document.getElementById("nombre").value;
    const apellido = document.getElementById("apellido").value;
    const telefono = document.getElementById("telefono").value;
    const correo = document.getElementById("correo").value;
    const carrera = document.getElementById("carrera").value;
    const id = document.getElementById("id").value;

    if (nombre === "" || apellido === "" || telefono === "" || correo === "" || carrera === "" || id === "") {
        mostrarAlerta('Todos los campos son requeridos', 'warning');
    } else {
        const url = base_url + "HomeBibl/actualizarPerfil";
        const frm = document.getElementById("perfil-form");

        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));

        http.onreadystatechange = function () {
            if (this.readyState === 4) {
                if (this.status === 200) {
                    try {
                        // console.log(this.responseText);
                        const res = JSON.parse(this.responseText);
                        Swal.fire({
                            title: res.msg,
                            icon: res.icono,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            if (res.icono === 'success') {
                                const imagenInput = document.getElementById('imagenp');
                                const imgPreview = document.getElementById('img-preview');
                                
                                if (imagenInput.files && imagenInput.files[0]) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        imgPreview.src = e.target.result;
                                    };
                                    reader.readAsDataURL(imagenInput.files[0]);
                                } else if (res.newImage && res.newImage !== 'user.png') {
                                    imgPreview.src = base_url + 'Assets/img/Foto_user/' + res.newImage;
                                }
                                // Ocultar el elemento con el ID `icon-cerrar`
                                document.getElementById('icon-cerrar').style.display = 'none';
                            }
                        });
                    } catch (e) {
                        console.error('Error al parsear JSON:', e);
                        mostrarAlerta('Error en la respuesta del servidor. Verifica que el servidor esté enviando JSON.', 'error');
                    }
                } else {
                    mostrarAlerta('Error en la solicitud: ' + this.status, 'error');
                }
            }
        };
    }
}