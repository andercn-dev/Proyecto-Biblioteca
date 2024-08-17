let tblUsuarios, tblEst, tblLibros, tblPrestar;
document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("#modalPass").addEventListener("click", function () {
        document.querySelector('#frmCambiarPass').reset();
        $('#cambiarClave').modal('show');
    });
    const language = {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }

    }

    const buttons = [{
        //Botón para Excel
        // extend: 'excel',
        // footer: true,
        // title: 'Archivo',
        // filename: 'Export_File',
        text: '<button class="btn btn-success"><i class="fa fa-file-excel-o"></i></button>',
        action: function (e, dt, node, config) {
            const tableId = dt.table().node().id;
            let url;
            let title;

            if (tableId === 'tblLibros') {
                url = base_url + 'Libros/Excellibros';
                title = 'Reporte de Libros';
            } else if (tableId === 'tblPrestar') {
                url = base_url + 'Prestamos/Excelprestamos';
                title = 'Reporte de Prestamos';
            } else if (tableId === 'tblSolicitud') {
                url = base_url + 'Solicitudes/Excelsolicitudes';
                title = 'Reporte de Solicitudes';
            }

            Swal.fire({
                title: '¿Deseas descargar el reporte?',
                text: `Se descargará el ${title}.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Sí, descargar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open(url, '_blank');
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'info',
                        title: 'Descarga cancelada',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }

    },

    //Botón para PDF
    {
        // extend: 'pdf',
        // footer: true,
        // title: 'Archivo PDF',
        // filename: 'reporte',
        text: '<button class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></button>',
        action: function (e, dt, node, config) {
            const tableId = dt.table().node().id;
            if (tableId === 'tblLibros') {
                config.title = 'Reporte de Libros';
                window.open(base_url + 'Libros/rlibros', '_blank');

            } else if (tableId === 'tblPrestar') {
                config.title = 'Reporte de Prestamos';
                window.open(base_url + 'Prestamos/rprestamos', '_blank');

            } else if (tableId === 'tblSolicitud') {
                config.title = 'Reporte de Solicitudes';
                window.open(base_url + 'Solicitudes/rsolicitudes', '_blank');

            }
        }
    },

    //Botón para print
    {
        extend: 'print',
        footer: true,
        title: 'Reportes',
        filename: 'Export_File_print',
        text: '<button class="btn btn-info"><i class="fa fa-print"></i></button>'
    }
    ]

    tblUsuarios = $('#tblUsuarios').DataTable({
        ajax: {
            url: base_url + "Usuarios/listar",
            dataSrc: ''
        },
        columns: [
            { 'data': 'id' },
            { 'data': 'usuario' },
            { 'data': 'nombre' },
            { 'data': 'estado' },
            { 'data': 'acciones' }
        ],
        responsive: true,
        bDestroy: true,
        iDisplayLength: 10,
        order: [
            [0, "desc"]
        ],
        language

    });
    //Fin de la tabla usuarios
    tblEst = $('#tblEst').DataTable({
        ajax: {
            url: base_url + "Estudiantes/listar",
            dataSrc: ''
        },
        columns: [{ 'data': 'id' },
        { 'data': 'dni' },
        { 'data': 'nombre' },
        { 'data': 'apellido' },
        { 'data': 'telefono' },
        { 'data': 'fecha_nacimiento' },
        { 'data': 'correo' },
        { 'data': 'carrera' },
        { 'data': 'estado' },
        { 'data': 'acciones' }
        ],
        language

    });
    //Fin de la tabla Estudiantes

    tblLibros = $('#tblLibros').DataTable({
        ajax: {
            url: base_url + "Libros/listar",
            dataSrc: ''
        },
        columns: [
            { 'data': 'id' },
            { 'data': 'especialidad' },
            { 'data': 'orden_pagina' },
            { 'data': 'n_especialidad' },
            { 'data': 'tema_titulo' },
            { 'data': 'codigo_titulo_autor' },
            { 'data': 'n_unico' },
            { 'data': 'imagen' },
            { 'data': 'titulo' },
            { 'data': 'autor' },
            {
                'data': 'resumen',
                'render': function (data, type, row, meta) {
                    // Verifica si data es null o undefined
                    if (data == null) { return ''; }
                    // Truncar a 50 caracteres
                    return data.length > 50 ? data.substr(0, 50) + '...' : data;
                }
            },
            { 'data': 'cantidad' },
            { 'data': 'precio_unidad' },
            { 'data': 'valor_total' },
            { 'data': 'estado_fisico' },
            { 'data': 'fecha_ingreso' },
            { 'data': 'estante_ubicacion' },
            { 'data': 'nivel_estante' },
            { 'data': 'estado' },
            { 'data': 'acciones' }
        ],
        language,
        dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons

    });

    tblSolicitud = $('#tblSolicitud').DataTable({
        ajax: {
            url: base_url + "Solicitudes/listar",
            dataSrc: ''
        },
        columns: [{
            'data': 'id'
        },
        {
            'data': 'titulo'
        },
        {
            'data': 'nombre_completo'
        },
        {
            'data': 'fecha_prestamo'
        },
        {
            'data': 'fecha_devolucion'
        },
        {
            'data': 'cantidad'
        },
        {
            'data': 'estado'
        },
        {
            'data': 'acciones'
        }
        ],
        language,
        dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons,
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ]
    });

    //fin Libros
    tblPrestar = $('#tblPrestar').DataTable({
        ajax: {
            url: base_url + "Prestamos/listar",
            dataSrc: ''
        },
        columns: [{
            'data': 'id'
        },
        {
            'data': 'titulo'
        },
        {
            'data': 'nombre_completo'
        },
        {
            'data': 'fecha_prestamo'
        },

        {
            'data': 'fecha_devolucion'
        },
        {
            'data': 'cantidad'
        },
        {
            'data': 'observacion'
        },
        {
            'data': 'estado'
        },
        {
            'data': 'acciones'
        }
        ],
        language,
        dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons,
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ]
    });
    $('.estudiante').select2({
        placeholder: 'Buscar Estudiante',
        minimumInputLength: 2,
        ajax: {
            url: base_url + 'Estudiantes/buscarEstudiante',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    est: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
    $('.libro').select2({
        placeholder: 'Buscar Libro',
        minimumInputLength: 2,
        ajax: {
            url: base_url + 'Libros/buscarLibro',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    lb: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
    // Notificacion de Retraso
    // if (document.getElementById('nombre_estudiante')) {
    //     const http = new XMLHttpRequest();
    //     const url = base_url + 'Configuracion/verificar';
    //     http.open("GET", url);
    //     http.send();
    //     http.onreadystatechange = function () {
    //         if (this.readyState == 4 && this.status == 200) {
    //             const res = JSON.parse(this.responseText);
    //             let html = '';
    //             res.forEach(row => {
    //                 html += `
    //                 <a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-user-o fa-stack-1x fa-inverse"></i></span></span>
    //                     <div>
    //                         <p class="app-notification__message" id="nombre_estudiante">${row.nombre_completo}</p>
    //                         <p class="app-notification__meta" id="fecha_entrega">${row.fecha_devolucion}</p>
    //                         <p class="app-notification__message" id="nombre_estudiante">${row.dias_retraso} días de retraso</p>

    //                     </div>
    //                 </a>
    //                 `;
    //             });
    //             document.getElementById('nombre_estudiante').innerHTML = html;
    //         }
    //     }
    // }
    if (document.getElementById('nombre_estudiante')) {
        const http = new XMLHttpRequest();
        const url = base_url + 'Configuracion/verificar';
        http.open("GET", url);
        http.send();
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                let html = '';
                let hasNotifications = res.length > 0;

                res.forEach(row => {
                    html += `
                    <a class="app-notification__item" href="javascript:;"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-user-o fa-stack-1x fa-inverse"></i></span></span>
                        <div>
                            <p class="app-notification__message" id="nombre_estudiante">${row.nombre_completo}</p>
                            <p class="app-notification__meta" id="fecha_entrega">${row.fecha_devolucion}</p>
                            <p class="app-notification__message" id="nombre_estudiante">${row.dias_retraso} días de retraso</p>
                        </div>
                    </a>
                    `;
                });
                document.getElementById('nombre_estudiante').innerHTML = html;

                // Cambiar el ícono si hay notificaciones
                const bellIcon = document.querySelector('.app-nav__item i');
                if (hasNotifications) {
                    bellIcon.classList.remove('fa-bell-o');
                    bellIcon.classList.add('fa-bell', 'text-danger');
                } else {
                    bellIcon.classList.remove('fa-bell', 'text-danger');
                    bellIcon.classList.add('fa-bell-o');
                }
            }
        }
    }

})



function frmUsuario() {
    document.getElementById("title").textContent = "Nuevo Usuario";
    document.getElementById("btnAccion").textContent = "Registrar";
    document.getElementById("claves").classList.remove("d-none");
    document.getElementById("frmUsuario").reset();
    document.getElementById("id").value = "";
    $("#nuevo_usuario").modal("show");
}

function registrarUser(e) {
    e.preventDefault();
    const usuario = document.getElementById("usuario");
    const nombre = document.getElementById("nombre");
    const clave = document.getElementById("clave");
    const confirmar = document.getElementById("confirmar");
    if (usuario.value == "" || nombre.value == "") {
        alertas('Todo los campos son requeridos', 'warning');
    } else {
        const url = base_url + "Usuarios/registrar";
        const frm = document.getElementById("frmUsuario");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                $("#nuevo_usuario").modal("hide");
                frm.reset();
                tblUsuarios.ajax.reload();
                alertas(res.msg, res.icono);
            }
        }
    }
}

function btnEditarUser(id) {
    document.getElementById("title").textContent = "Actualizar usuario";
    document.getElementById("btnAccion").textContent = "Modificar";
    const url = base_url + "Usuarios/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById("id").value = res.id;
            document.getElementById("usuario").value = res.usuario;
            document.getElementById("nombre").value = res.nombre;
            document.getElementById("claves").classList.add("d-none");
            $("#nuevo_usuario").modal("show");
        }
    }
}

function btnEliminarUser(id) {
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        text: "El usuario no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Usuarios/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblUsuarios.ajax.reload();
                    alertas(res.msg, res.icono);
                }
            }

        }
    })
}
function btnReingresarUser(id) {
    Swal.fire({
        title: 'Esta seguro de reingresar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Usuarios/reingresar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblUsuarios.ajax.reload();
                    alertas(res.msg, res.icono);
                }
            }

        }
    })
}
//Fin Usuarios

function frmEstudiante() {
    document.getElementById("title").textContent = "Nuevo Estudiante";
    document.getElementById("btnAccion").textContent = "Registrar";
    document.getElementById("frmEstudiante").reset();
    document.getElementById("dni").value = "";
    $("#nuevoEstudiante").modal("show");
}

function registrarEstudiante(e) {
    e.preventDefault();
    const dni = document.getElementById("dni");
    const nombre = document.getElementById("nombre");
    const telefono = document.getElementById("telefono");
    const fecha_nacimiento = document.getElementById("fecha_nacimiento");
    const apellido = document.getElementById("apellido");
    const correo = document.getElementById("correo");
    const carrera = document.getElementById("carrera");
    if (dni.value == "" || nombre.value == "" || apellido.value == "" || telefono.value == "" || fecha_nacimiento.value == "" || correo.value == "" || carrera.value == "") {
        alertas('Todo los campos son requeridos', 'warning');
    } else {
        const url = base_url + "Estudiantes/registrar";
        const frm = document.getElementById("frmEstudiante");

        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                $("#nuevoEstudiante").modal("hide");
                frm.reset();
                tblEst.ajax.reload();
                alertas(res.msg, res.icono);
            }
        }
    }
}

function btnEditarEst(id) {
    document.getElementById("title").textContent = "Actualizar estudiante";
    document.getElementById("btnAccion").textContent = "Modificar";
    const url = base_url + "Estudiantes/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById("id").value = res.id;
            document.getElementById("dni").value = res.dni;
            document.getElementById("nombre").value = res.nombre;
            document.getElementById("apellido").value = res.apellido;
            document.getElementById("telefono").value = res.telefono;
            document.getElementById("fecha_nacimiento").value = res.fecha_nacimiento;
            document.getElementById("correo").value = res.correo;
            document.getElementById("carrera").value = res.carrera;
            $("#nuevoEstudiante").modal("show");
        }
    }
}

function btnEliminarEst(id) {
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        text: "El estudiante no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Estudiantes/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblEst.ajax.reload();
                    alertas(res.msg, res.icono);
                }
            }

        }
    })
}

function btnActualizarPass(id) {
    Swal.fire({
        title: 'Esta seguro de cambiar la Contraseña?',
        text: "La contraseña se modificara con el N° de DNI",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Estudiantes/cambiarPas";
            const http = new XMLHttpRequest();
            http.open("POST", url, true);
            http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            http.send("id=" + id);
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    tblEst.ajax.reload();
                }
            }
        }
    })
}


function btnReingresarEst(id) {
    Swal.fire({
        title: 'Esta seguro de reingresar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Estudiantes/reingresar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblEst.ajax.reload();
                    alertas(res.msg, res.icono);
                }
            }

        }
    })
}
//Fin Estudiante
function frmLibros() {
    document.getElementById("title").textContent = "Nuevo Libro";
    document.getElementById("btnAccion").textContent = "Registrar";
    document.getElementById("frmLibro").reset();
    document.getElementById("id").value = "";
    $("#nuevoLibro").modal("show");
    deleteImg();
}


function registrarLibro(e) {
    e.preventDefault();
    const especialidad = document.getElementById("especialidad");
    const orden_pagina = document.getElementById("orden_pagina");
    const n_especialidad = document.getElementById("n_especialidad");
    const tema_titulo = document.getElementById("tema_titulo");
    const codigo_titulo_autor = document.getElementById("codigo_titulo_autor");
    const n_unico = document.getElementById("n_unico");
    const titulo = document.getElementById("titulo");
    const autor = document.getElementById("autor");
    const resumen = document.getElementById("resumen");
    const cantidad = document.getElementById("cantidad");
    const precio_unidad = document.getElementById("precio_unidad");
    const valor_total = document.getElementById("valor_total");
    const estado_fisico = document.getElementById("estado_fisico");
    const fecha_ingreso = document.getElementById("fecha_ingreso");
    const estante_ubicacion = document.getElementById("estante_ubicacion");
    const nivel_estante = document.getElementById("nivel_estante");
    if (titulo.value == '' || autor.value == '' || especialidad.value == '' || cantidad.value == '' || fecha_ingreso.value == '') {
        alertas('Todo los campos son requeridos', 'warning');
    } else {
        const url = base_url + "Libros/registrar";
        const frm = document.getElementById("frmLibro");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // console.log(this.responseText);
                const res = JSON.parse(this.responseText);
                $("#nuevoLibro").modal("hide");
                tblLibros.ajax.reload();
                frm.reset();
                alertas(res.msg, res.icono);
            }
        }
    }
}

function btnEditarLibro(id) {
    document.getElementById("title").textContent = "Actualizar Libro";
    document.getElementById("btnAccion").textContent = "Modificar";
    const url = base_url + "Libros/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById("id").value = res.id;
            document.getElementById("especialidad").value = res.especialidad;
            document.getElementById("orden_pagina").value = res.orden_pagina;
            document.getElementById("n_especialidad").value = res.n_especialidad;
            document.getElementById("tema_titulo").value = res.tema_titulo;
            document.getElementById("codigo_titulo_autor").value = res.codigo_titulo_autor;
            document.getElementById("n_unico").value = res.n_unico;
            document.getElementById("titulo").value = res.titulo;
            document.getElementById("autor").value = res.autor;
            document.getElementById("resumen").value = res.resumen;
            document.getElementById("cantidad").value = res.cantidad;
            document.getElementById("precio_unidad").value = res.precio_unidad;
            document.getElementById("valor_total").value = res.valor_total;
            document.getElementById("estado_fisico").value = res.estado_fisico;
            document.getElementById("fecha_ingreso").value = res.fecha_ingreso;
            document.getElementById("estante_ubicacion").value = res.estante_ubicacion;
            document.getElementById("nivel_estante").value = res.nivel_estante;
            document.getElementById("img-preview").src = base_url + 'Assets/img/PortadaLibros/' + res.imagen;
            document.getElementById("icon-cerrar").innerHTML = `
            <button class="btn btn-danger" onclick="deleteImg()">
            <i class="fa fa-times-circle"></i></button>`;
            document.getElementById("icon-image").classList.add("d-none");
            document.getElementById("foto_actual").value = res.imagen;
            $("#nuevoLibro").modal("show");
        }
    }
}

function btnEliminarLibro(id) {
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        text: "El libro no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Libros/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblLibros.ajax.reload();
                    alertas(res.msg, res.icono);
                }
            }

        }
    })
}

function btnReingresarLibro(id) {
    Swal.fire({
        title: 'Esta seguro de reingresar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Libros/reingresar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblLibros.ajax.reload();
                    alertas(res.msg, res.icono);
                }
            }

        }
    })
}
function preview(e) {
    var input = document.getElementById('imagen');
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
        document.getElementById("icon-image").classList.add("d-none");
        document.getElementById("icon-cerrar").innerHTML = `
        <button class="btn btn-danger" onclick="deleteImg()"><i class="fa fa-times-circle"></i></button>
        `;
    }

}
function deleteImg() {
    document.getElementById("icon-cerrar").innerHTML = '';
    document.getElementById("icon-image").classList.remove("d-none");
    document.getElementById("img-preview").src = '';
    document.getElementById("imagen").value = '';
    document.getElementById("foto_actual").value = '';
}

function frmPrestar() {
    document.getElementById("frmPrestar").reset();
    $("#prestar").modal("show");
}
function btnEntregar(id) {
    Swal.fire({
        title: 'Recibir de libro?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Prestamos/entregar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblPrestar.ajax.reload();
                    alertas(res.msg, res.icono);
                }
            }

        }
    })
}
function registroPrestamos(e) {
    e.preventDefault();
    const libro = document.getElementById("libro").value;
    const estudiante = document.getElementById("estudiante").value;
    const cantidad = document.getElementById("cantidad").value;
    const fecha_prestamo = document.getElementById("fecha_prestamo").value;
    const fecha_devolucion = document.getElementById("fecha_devolucion").value;
    if (libro == '' || estudiante == '' || cantidad == '' || fecha_prestamo == '' || fecha_devolucion == '') {
        alertas('Todo los campos son requeridos', 'warning');
    } else {
        const frm = document.getElementById("frmPrestar");
        const url = base_url + "Prestamos/registrar";
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                tblPrestar.ajax.reload();
                $("#prestar").modal("hide");
                alertas(res.msg, res.icono);
                if (res.icono == 'success') {
                    setTimeout(() => {
                        // window.open(base_url + 'Prestamos/ticked/' + res.id, '_blank');
                    }, 3000);
                }

            }
        }
    }
}

function btnAceptarSolc(id) {
    Swal.fire({
        title: 'Aceptar Solicitud?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Solicitudes/aceptar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        try {
                            const res = JSON.parse(this.responseText);
                            tblSolicitud.ajax.reload();
                            alertas(res.msg, res.icono);
                        } catch (e) {
                            console.error('Error al analizar JSON:', e);
                            console.error('Respuesta del servidor:', this.responseText);
                        }
                    } else {
                        console.error('Error de red:', this.statusText);
                    }
                }
            }
        }
    })
}

function btnRolesUser(id) {
    const http = new XMLHttpRequest();
    const url = base_url + "Usuarios/permisos/" + id;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("frmPermisos").innerHTML = this.responseText;
            $("#permisos").modal("show");
        }
    }
}

function registrarPermisos(e) {
    e.preventDefault();
    const http = new XMLHttpRequest();
    const frm = document.getElementById("frmPermisos");
    const url = base_url + "Usuarios/registrarPermisos";
    http.open("POST", url);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            $("#permisos").modal("hide");
            if (res == 'ok') {
                alertas('Permisos Asignado', 'success');
            } else {
                alertas('Error al asignar los permisos', 'error');
            }
        }
    }
}

function modificarClave(e) {
    e.preventDefault();
    var formClave = document.querySelector("#frmCambiarPass");
    formClave.onsubmit = function (e) {
        e.preventDefault();
        const clave_actual = document.querySelector("#clave_actual").value;
        const nueva_clave = document.querySelector("#clave_nueva").value;
        const confirmar_clave = document.querySelector("#clave_confirmar").value;
        if (clave_actual == "" || nueva_clave == "" || confirmar_clave == "") {
            alertas('Todo los campos son requeridos', 'warning');
        } else if (nueva_clave != confirmar_clave) {
            alertas('Las contraseñas no coinciden', 'warning');
        } else {
            const http = new XMLHttpRequest();
            const frm = document.getElementById("frmPermisos");
            const url = base_url + "Usuarios/cambiarPas";
            http.open("POST", url);
            http.send(new FormData(formClave));
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    $('#cambiarClave').modal("hide");
                    alertas(res.msg, res.icono);
                }
            }
        }

    }
}

if (document.getElementById("reportePrestamo")) {
    const url = base_url + "Configuracion/grafico";
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const data = JSON.parse(this.responseText);
            let nombre = [];
            let cantidad = [];
            for (let i = 0; i < data.length; i++) {
                nombre.push(data[i]['titulo']);
                cantidad.push(data[i]['total_prestamos']);
            }
            var ctx = document.getElementById("reportePrestamo");
            var myPieChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: nombre,
                    datasets: [{
                        label: 'Libros',
                        data: cantidad,
                        backgroundColor: ['#dc143c'],
                    }],
                },
            });

        }
    }
}


function alertas(msg, icono) {
    Swal.fire({
        position: 'center',
        icon: icono,
        title: msg,
        showConfirmButton: false,
        timer: 1500
    })
}

function verificarLibro(e) {
    const libro = document.getElementById('libro').value;
    const cant = document.getElementById('cantidad').value;
    const http = new XMLHttpRequest();
    const url = base_url + 'Libros/verificar/' + libro;
    http.open("GET", url);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            if (res.icono == 'success') {
                document.getElementById('msg_error').innerHTML = `<span class="badge badge-primary">Disponible: ${res.cantidad}</span>`;
            } else {
                alertas(res.msg, res.icono);
                return false;
            }
        }
    }
}