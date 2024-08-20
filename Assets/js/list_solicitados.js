document.addEventListener('DOMContentLoaded', function () {
    function cargarLibrosSolicitados() {
        const http = new XMLHttpRequest();
        http.open("GET", base_url + "HomeBibl/obtenerlistsolicitados", true);
        http.send();

        http.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    try {
                        const res = JSON.parse(this.responseText);
                        mostrarLibrosSolicitados(res);
                    } catch (error) {
                        console.error("Error al analizar la respuesta JSON:", error);
                    }
                } else {
                    console.error("Error al obtener datos:", this.statusText);
                }
            }
        };
    }

    function mostrarLibrosSolicitados(libros) {
        const panel = document.getElementById("solitpanel");
        panel.innerHTML = '';
    
        if (libros.length === 0) {
            const mensaje = document.createElement('div');
            mensaje.classList.add('mensaje-no-libros');
    
            const texto = document.createElement('p');
            texto.textContent = "Aún no has solicitado libros.";
            mensaje.appendChild(texto);
    
            const icono = document.createElement('i');
            icono.classList.add('fa-solid', 'fa-book-open');
            mensaje.appendChild(icono);
    
            panel.appendChild(mensaje);
            return;
        }
    
        const leftPanel = document.createElement('div');
        leftPanel.classList.add('solitleft-panel');
    
        const librosPorFecha = {};
        libros.forEach(libro => {
            const fecha = new Date(libro.fecha_prestamo);
            const fechaTexto = fecha.toLocaleDateString('es-ES', { year: 'numeric', month: 'long', day: 'numeric' });
            if (!librosPorFecha[fechaTexto]) {
                librosPorFecha[fechaTexto] = [];
            }
            librosPorFecha[fechaTexto].push(libro);
        });
    
        const fechasOrdenadas = Object.keys(librosPorFecha).sort((a, b) => new Date(b) - new Date(a));
    
        fechasOrdenadas.forEach(fechaTexto => {
            const listGroup = document.createElement('div');
            listGroup.classList.add('list-group');
    
            const h3 = document.createElement('h3');
            h3.textContent = fechaTexto;
            listGroup.appendChild(h3);
    
            const ul = document.createElement('ul');
            librosPorFecha[fechaTexto].forEach(libro => {
                const li = document.createElement('li');
    
                const itemContainer = document.createElement('div');
                itemContainer.classList.add('item-container');
    
                const imagen = document.createElement('img');
                imagen.src = base_url + 'Assets/img/PortadaLibros/' + libro.imagen;
                imagen.alt = libro.libro_titulo;
                imagen.classList.add('libro-imagen');
                
                const textContainer = document.createElement('div');
                textContainer.classList.add('text-container');
                
                const titulo = document.createElement('h4');
                titulo.textContent = libro.libro_titulo;
                
                const autor = document.createElement('p');
                autor.textContent = `Autor: ${libro.autor}`;
                
                const especialidad = document.createElement('p');
                especialidad.textContent = `Especialidad: ${libro.especialidad}`;
                
                textContainer.appendChild(titulo);
                textContainer.appendChild(autor);
                textContainer.appendChild(especialidad);
    
                const estado = document.createElement('p');
                estado.textContent = libro.estado === 1 ? 'No devuelto' : 'Devuelto';
                estado.classList.add(libro.estado === 1 ? 'estado-no-devuelto' : 'estado-devuelto');
                estado.classList.add('estado');
    
                textContainer.appendChild(estado);
                
                itemContainer.appendChild(imagen);
                itemContainer.appendChild(textContainer);
                
                li.appendChild(itemContainer);
                ul.appendChild(li);
            });
            listGroup.appendChild(ul);
            leftPanel.appendChild(listGroup);
        });
    
        panel.appendChild(leftPanel);
    }
    
    

    cargarLibrosSolicitados();
});
