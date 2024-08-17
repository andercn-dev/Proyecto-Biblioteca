<div class="frmbusqueda">
        <form class="busqueda" id="frmBusqueda" onsubmit="buscarLibro(event);">
            <h2 style="text-align: justify; margin-bottom:15px;">Busqueda Avanzada</h2>
            <input type="text" id="searchInput" name="searchInput" placeholder="Buscar...">
            <button type="submit" id="submitSearch">Buscar</button>

            <div id="contbavanzado">
                <div class="opgrupo">
                    <label for="Aespecialidad">Especialidad:</label>
                    <select id="Aespecialidad" name="especialidad">
                        <option value="" disabled selected>Seleccione una especialidad</option>
                        <option value="Cultura General">Cultura General</option>
                        <option value="Enfermeria Tecnica">Enfermeria Tecnica</option>
                        <option value="Industrias Alimentarias">Industrias Alimentarias</option>
                        <option value="Computacion e Informatica">Computación e Informática</option>
                    </select>
                </div>
                <div class="opgrupo">
                    <label for="anio">Año:</label>
                    <input type="text" id="anio" name="anio">
                </div>
                <div class="opgrupo">
                    <label for="autor">Autor:</label>
                    <input type="text" id="autor" name="autor">
                </div>
            </div>
        </form>

        <form class="resultado">
            <h2>Resultado de Búsqueda</h2>
            <p id="numTotalLibros" class="total-libros"></p><br>
            <div id="pagination" class="pagination-container"></div>
            <div id="resultadoBusqueda"></div>
        </form>
    </div>