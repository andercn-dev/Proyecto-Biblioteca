function buscarLibro(event, item = null, page = 1) {
    event.preventDefault();

    const getElementValue = (id) => {
        const element = document.getElementById(id);
        return element ? element.value.trim() : '';
    };

    const valor = getElementValue("searchInput");
    const especialidad =  getElementValue("Aespecialidad");
    const autor = item || getElementValue("autor");
    const anio = getElementValue("anio");

    if (!valor && !especialidad && !anio && !autor) {
        Swal.fire({
            title: 'Error',
            text: 'Ingresar Datos para realizar una búsqueda',
            icon: 'warning',
            showConfirmButton: false,
            timer: 1500 
        });
        return;
    }

    const header = document.querySelector('form.resultado h2');
    if (header) {
        header.textContent = "Resultado de Búsqueda";
    }

    const data = new FormData();
    data.append("valor", valor);
    data.append("especialidad", especialidad);
    data.append("anio", anio);
    data.append("autor", autor);
    data.append("page", page);
    data.append("limit", 10);

    const http = new XMLHttpRequest();
    http.open("POST", base_url + "HomeBibl/buscarLibroB", true);
    http.send(data);

    http.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                try {
                    const res = JSON.parse(this.responseText);
                    mostrarResultadosBusqueda(res);
                    mostrarTotalLibros(res.num_libros);
                    generarPaginacion(res.num_libros, page, 10);
                } catch (error) {
                    console.error("Error al analizar la respuesta JSON:", error);
                }
            } else {
                console.error("Error al obtener datos:", this.statusText);
            }
        }
    };
}


function mostrarTotalLibros(total) {
    const numTotalLibros = document.getElementById("numTotalLibros");
    if (numTotalLibros) {
        numTotalLibros.innerHTML = `Total de libros encontrados: ${total}`;
    }
}

function mostrarResultadosBusqueda(data) {
    const resultadoBusqueda = document.getElementById("resultadoBusqueda");
    const resultadoContainer = document.querySelector(".resultado");

    resultadoBusqueda.innerHTML = "";

    if (!data.html || data.html.trim() === "") {
        resultadoBusqueda.innerHTML = "<p>No se encontraron libros.</p>";
        resultadoContainer.style.display = "block";
    } else {
        resultadoBusqueda.innerHTML = data.html;
        resultadoContainer.style.display = "block";
    }
}

function generarPaginacion(total, currentPage, limit) {
    const totalPages = Math.ceil(total / limit);
    const paginationContainer = document.getElementById("pagination");

    paginationContainer.innerHTML = "";

    // Botón de página anterior
    const prevPageItem = document.createElement("button");
    prevPageItem.innerHTML = '<i class="fa-solid fa-chevron-left"></i>'; 
    prevPageItem.classList.add("page-item");
    if (currentPage === 1) {
        prevPageItem.classList.add("disabled");
    } else {
        prevPageItem.addEventListener("click", (event) => buscarLibro(event, null, currentPage - 1));
    }
    paginationContainer.appendChild(prevPageItem);

    // Botones de páginas
    const maxVisiblePages = 3; 
    if (totalPages <= maxVisiblePages) {
        for (let i = 1; i <= totalPages; i++) {
            const pageItem = createPageButton(i, currentPage);
            paginationContainer.appendChild(pageItem);
        }
    } else {
        const startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
        const endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

        if (startPage > 1) {
            paginationContainer.appendChild(createPageButton(1, currentPage));
            if (startPage > 2) {
                paginationContainer.appendChild(createEllipsis());
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            paginationContainer.appendChild(createPageButton(i, currentPage));
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                paginationContainer.appendChild(createEllipsis());
            }
            paginationContainer.appendChild(createPageButton(totalPages, currentPage));
        }
    }

    // Botón de página siguiente
    const nextPageItem = document.createElement("button");
    nextPageItem.innerHTML = '<i class="fa-solid fa-chevron-right"></i>';
    nextPageItem.classList.add("page-item");
    if (currentPage === totalPages) {
        nextPageItem.classList.add("disabled");
    } else {
        nextPageItem.addEventListener("click", (event) => buscarLibro(event, null, currentPage + 1));
    }
    paginationContainer.appendChild(nextPageItem);
}

function createPageButton(pageNumber, currentPage) {
    const pageItem = document.createElement("button");
    pageItem.textContent = pageNumber;
    pageItem.classList.add("page-item");
    if (pageNumber === currentPage) {
        pageItem.classList.add("active");
    }
    pageItem.addEventListener("click", (event) => buscarLibro(event, null, pageNumber));
    return pageItem;
}

function createEllipsis() {
    const ellipsis = document.createElement("span");
    ellipsis.textContent = "...";
    ellipsis.classList.add("page-item", "ellipsis");
    return ellipsis;
}



document.addEventListener('DOMContentLoaded', function () {
    function cargarUltimosLibros() {
        const http = new XMLHttpRequest();
        http.open("GET", base_url + "HomeBibl/obtenerUltimosLibros", true);
        http.send();

        http.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    try {
                        const res = JSON.parse(this.responseText);
                        mostrarResultadosBusqueda(res);
                        mostrarTotalLibros(res.num_libros);

                        const header = document.querySelector('form.resultado h2');
                        if (header) {
                            header.textContent = "Últimos Libros Ingresados";
                        } else {
                            console.error("No se encontró el elemento <h2> en el formulario con clase 'resultado'.");
                        }
                    } catch (error) {
                        console.error("Error al analizar la respuesta JSON:", error);
                    }
                } else {
                    console.error("Error al obtener datos:", this.statusText);
                }
            }
        };
    }

    cargarUltimosLibros();


    function cargarDatos() {
        const http = new XMLHttpRequest();
        http.open("GET", base_url + "HomeBibl/obtenerDatosListas", true);
        http.send();
    
        http.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    // console.log(this.responseText);
                    try {
                        const res = JSON.parse(this.responseText);
                        actualizarLista('especialidad-list', res.especialidades.map(item => item.especialidad));
                        actualizarLista('autor-list', res.autores.map(item => item.autor), true);
                        actualizarLista('anio-list', res.anios.map(item => item.anio), true);
                        actualizarLista('archivo-list', res.archivos.map(item => item.tema_titulo));
                    } catch (error) {
                        console.error("Error al analizar la respuesta JSON:", error);
                    }
                } else {
                    console.error("Error al obtener datos:", this.status, this.statusText);
                    // console.log(this.responseText);
                }
            }
        };
    }
    
    function actualizarLista(elementId, items, limit = false) {
        const ul = document.getElementById(elementId);
        if (ul) {
            ul.innerHTML = '';
            const maxItems = limit ? 6 : items.length;
            items.slice(0, maxItems).forEach(item => {
                const li = document.createElement('li');
                li.textContent = item;
                li.style.cursor = 'pointer';
                li.addEventListener('click', function(event) {
                    buscarLibro(event, item); // Pasa el 'item' a la función buscarLibro
                });
                ul.appendChild(li);
            });
    
            if (limit && items.length > maxItems) {
                const moreLi = document.createElement('li');
                moreLi.textContent = 'Más...';
                moreLi.style.cursor = 'pointer';
                moreLi.addEventListener('click', function() {
                    ul.innerHTML = '';
                    items.forEach(item => {
                        const li = document.createElement('li');
                        li.textContent = item;
                        li.style.cursor = 'pointer';
                        li.addEventListener('click', function(event) {
                            buscarLibro(event, item); // Pasa el 'item' a la función buscarLibro
                        });
                        ul.appendChild(li);
                    });
                    moreLi.remove();
                });
                ul.appendChild(moreLi);
            }
        } else {
            console.error(`No se encontró el elemento con id: ${elementId}`);
        }
    }
    
    cargarDatos();
    

});


