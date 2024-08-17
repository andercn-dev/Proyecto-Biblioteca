function mostrarAlerta(titulo, texto, icono) {
    Swal.fire({
        title: titulo,
        text: texto,
        icon: icono,
        showConfirmButton: false,
        timer: 1500
    });
}



let selectedBooks = [];
// Función para mostrar los detalles del libro en el modal
function mostrarDetalleL(titulo, autor, especialidad, cantidad, imagen, id, codigo, fecha, resumen) {
    document.getElementById('detalleTitulo').textContent = titulo;
    document.getElementById('detalleAutor').textContent = autor;
    document.getElementById('detalleEspecialidad').textContent = especialidad;
    document.getElementById('detalleDisponibles').textContent = cantidad;
    document.getElementById('detalleImagen').src = imagen;
    document.getElementById('detalleCodigo').textContent = codigo;
    document.getElementById('detalleFecha').textContent = fecha;
    document.getElementById('detalleResumen').textContent = resumen;

    // Mostrar el modal
    document.getElementById('detalleLibroModal').style.display = 'block';
    document.getElementById('detalleLibroBackdrop').style.display = 'block';

    const añadirLibroBtn = document.querySelector('#detalleLibroModal .add-book-btn');
    const disponiblesNumero = parseInt(cantidad, 10);

    if (disponiblesNumero === 0) {
        añadirLibroBtn.disabled = true;
        añadirLibroBtn.style.backgroundColor = '#c6c6c6';
        añadirLibroBtn.style.borderColor = 'gray';
    } else {
        añadirLibroBtn.disabled = false;
        añadirLibroBtn.style.backgroundColor = ''; 
        añadirLibroBtn.style.borderColor = '';
    }

    selectedBooks = selectedBooks.filter(libro => libro.id !== id);
    selectedBooks.push({ titulo, imagen, cantidad: disponiblesNumero, id });
}



// Función para cerrar el modal
function cerrarModal() {
    document.getElementById('detalleLibroModal').style.display = 'none';
    document.getElementById('detalleLibroBackdrop').style.display = 'none';
}
document.getElementById('closeDetalleLibroBtn').addEventListener('click', cerrarModal);
document.getElementById('detalleLibroBackdrop').addEventListener('click', cerrarModal);


document.getElementById('agregarLibroBtn').addEventListener('click', agregarLibro);


// Función para agregar un libro a la lista
function agregarLibro() {
    const libroActual = selectedBooks[selectedBooks.length - 1];

    const listItems = document.querySelectorAll('#floatingBookList li');
    const libroYaEnLista = Array.from(listItems).some(item => item.textContent.includes(libroActual.titulo));

    if (libroYaEnLista) {
        mostrarAlerta('Información', 'Este libro ya está en la lista.', 'info');
        return;
    }
    if (libroActual.cantidad === 0) {
        mostrarAlerta('Advertencia', 'El libro aún no está disponible.', 'warning');
        return;
    }

    const emptyMessage = document.getElementById('emptyMessage');
    if (emptyMessage) {
        emptyMessage.style.display = 'none';
    }

    const listItem = document.createElement('li');
    listItem.innerHTML = `
        <img src="${libroActual.imagen}" alt="Imagen del libro" style="width: 40px; height: auto;">
        ${libroActual.titulo}
        <button class="remove-btn" onclick="eliminarLibro(this)" style="color: red; font-size: 16px;">&#10006;</button>
    `;
    listItem.dataset.id = libroActual.id;
    listItem.dataset.cantidad = libroActual.cantidad;

    const list = document.getElementById('floatingBookList');
    list.appendChild(listItem);

    const libroIndex = selectedBooks.findIndex(libro => libro.id === libroActual.id);
    if (libroIndex > -1) {
        selectedBooks[libroIndex].cantidad = libroActual.cantidad;
    } else {
        selectedBooks.push(libroActual);
    }

    document.getElementById('confirmButton').disabled = false;
    cerrarModal();
    mostrarAlerta('Libro añadido', 'El libro ha sido añadido a la lista.', 'success');
}


function confirmarSeleccion() {
    // console.log("Contenido de selectedBooks:", selectedBooks);
    document.getElementById('confirmacionModal').style.display = 'block';
    document.getElementById('confirmacionBackdrop').style.display = 'block';
    
    const listaLibros = document.getElementById('confirmacionListaLibros');
    listaLibros.innerHTML = '';

    let librosUnicosMap = new Map();
    selectedBooks.forEach(libro => {
        if (libro.cantidad > 0 && !librosUnicosMap.has(libro.id)) { 
            librosUnicosMap.set(libro.id, libro);
        }
    });

    const librosUnicos = Array.from(librosUnicosMap.values());
    // console.log("Libros únicos para confirmar selección:", librosUnicos);

    const table = document.createElement('table');
    table.className = 'book-table';

    const thead = document.createElement('thead');
    thead.innerHTML = `
        <tr>
            <th>N°</th>
            <th>Libro</th>
            <th>Cantidad</th>
        </tr>
    `;
    table.appendChild(thead);

    const tbody = document.createElement('tbody');
    librosUnicos.forEach((libro, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>${libro.titulo}</td>
            <td>${libro.cantidad}</td>
        `;
        tbody.appendChild(row);
    });

    table.appendChild(tbody);
    listaLibros.appendChild(table);

}

function eliminarLibro(button) {
    const listItem = button.parentElement;
    const list = document.getElementById('floatingBookList');
    const libroId = parseInt(listItem.dataset.id);

    const libroIndex = selectedBooks.findIndex(libro => parseInt(libro.id) === libroId);

    if (libroIndex > -1) {
        selectedBooks.splice(libroIndex, 1);
    } else {
        return;
    }

    list.removeChild(listItem);

    if (selectedBooks.length === 0) {
        const emptyMessage = document.getElementById('emptyMessage');
        if (emptyMessage) {
            emptyMessage.style.display = 'list-item';
        }
        document.getElementById('confirmButton').disabled = true;
    } else {
        const emptyMessage = document.getElementById('emptyMessage');
        if (emptyMessage) {
            emptyMessage.style.display = 'none';
        }
        document.getElementById('confirmButton').disabled = false;
    }
}



// Función para cerrar el modal de confirmación
function cerrarConfirmacionModal() {
    document.getElementById('confirmacionModal').style.display = 'none';
    document.getElementById('confirmacionBackdrop').style.display = 'none';
}
document.getElementById('cancelarConfirmacionBtn').addEventListener('click', cerrarConfirmacionModal);
document.getElementById('closeConfirmacionModalBtn').addEventListener('click', cerrarConfirmacionModal);
document.getElementById('confirmacionBackdrop').addEventListener('click', cerrarConfirmacionModal);




function solicitarLibros() {
    const fechaDevolucion = document.getElementById('fechaDevolucion').value;
    const fechaPrestamo = document.getElementById('fechaPrestamo').value;
    const idEst = document.getElementById('idEst').value;
    const librosSeleccionados = [];

    document.querySelectorAll('#floatingBookList li').forEach(li => {
        const libroId = li.dataset.id;
        const cantidad = li.dataset.cantidad;
        if (libroId && cantidad) {
            librosSeleccionados.push({ id: libroId, cantidad });
        }
    });

    if (librosSeleccionados.length === 0) {
        Swal.fire({
            title: 'Advertencia',
            text: 'No hay libros seleccionados.',
            icon: 'warning',
            showConfirmButton: false,
            timer: 1500
        });
        return;
    }

    const formData = new FormData();
    formData.append('idEst', idEst);
    formData.append('fechaPrestamo', fechaPrestamo);
    formData.append('fechaDevolucion', fechaDevolucion);

    librosSeleccionados.forEach(libro => {
        formData.append('libro[]', libro.id);
        formData.append('cantidad[]', libro.cantidad);
    });

    // console.log('ID Estudiante:', idEst);
    // console.log('Fecha Préstamo:', fechaPrestamo);
    // console.log('Fecha Devolución:', fechaDevolucion);
    // console.log('Libros Seleccionados:', librosSeleccionados);

    const http = new XMLHttpRequest();
    http.open("POST", base_url + "HomeBibl/regprestamo", true);

    http.onload = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                // console.log('Respuesta del servidor:', this.responseText);
                const res = JSON.parse(this.responseText);
                document.getElementById('confirmacionModal').style.display = 'none';
                document.getElementById('confirmacionBackdrop').style.display = 'none';

                Swal.fire({
                    title: res.msg,
                    icon: res.icono,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    if (res.icono === 'success') {
                        
                        document.querySelectorAll('#floatingBookList li').forEach(li => {
                            li.remove();
                        });
                        window.location = base_url + res.redireccion;

                    }
                });

            } catch (e) {
                console.error('Error al parsear JSON:', e);
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema con la respuesta del servidor.',
                    icon: 'error',
                    showConfirmButton: true
                });
            }
        } else {
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema con la solicitud. Verifique la URL y el servidor.',
                icon: 'error',
                showConfirmButton: true
            });
        }
    };

    http.onerror = function () {
        Swal.fire({
            title: 'Error',
            text: 'Error en la solicitud.',
            icon: 'error',
            showConfirmButton: true
        });
    };

    http.send(formData);
}




// Función para cerrar el modal
function cerrarModalSolic() {
    document.getElementById('confirmacionModal').style.display = 'none';
    document.getElementById('confirmacionBackdrop').style.display = 'none';
}
document.getElementById('closeConfirmacionModalBtn').addEventListener('click', cerrarModal);
document.getElementById('cancelarConfirmacionBtn').addEventListener('click', cerrarModal);