<!--
Este archivo contiene el final del cuerpo de las páginas así como el final
del html de todas las páginas, donde se encuentran links a .js necesarios para
el funcionamiento de la app
-->
<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Litoria Produccións <?php echo date('Y'); ?></span>
        </div>
        <div class="copyright text-center my-auto p-1">
            <span> Iconos diseñados por <a href="https://www.flaticon.es/autores/kmg-design" title="kmg design" target="_blank"> kmg design </a> 
                from <a href="https://www.flaticon.es/" title="Flaticon" target="_blank">www.flaticon.es</a></span>
        </div>
        <div class="copyright text-center my-auto">
            <span> Aplicación construida con <a href="https://startbootstrap.com/theme/sb-admin-2" title="framework sb-admin-2" target="_blank"> SB Admin 2</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Cuadro de dialogo que sale al darle al cerrar sesión -->
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Preparado para irse</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Seleciona "Cerrar sesión" si está preparado para cerrar la sesión actual.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-danger" href="/session/borrar">Cerrar sesión</a>
            </div>
        </div>
    </div>
</div>

<script>
// JavaScript para la paginación
document.addEventListener('DOMContentLoaded', function() {
    const filasPorPagina = 10; // Número de filas a mostrar por página
    const tabla = document.querySelector('#dataTable tbody'); // Selecciona el cuerpo de la tabla
    const filas = Array.from(tabla.rows); // Convierte las filas de la tabla en un array
    const totalFilas = filas.length; // Cuenta total de filas
    const numeroDePaginas = Math.ceil(totalFilas / filasPorPagina); // Calcula el número de páginas
    const paginacion = document.getElementById('pagination'); // Selecciona el contenedor de paginación

    // Función para mostrar la página seleccionada
    function mostrarPagina(pagina) {
        const inicio = (pagina - 1) * filasPorPagina; // Calcula la fila inicial
        const fin = inicio + filasPorPagina; // Calcula la fila final

        // Muestra u oculta las filas según la página seleccionada
        filas.forEach((fila, indice) => {
            fila.style.display = (indice >= inicio && indice < fin) ? '' : 'none';
        });
    }

    // Función para crear los controles de paginación
    function crearControlesDePaginacion() {
        for (let i = 1; i <= numeroDePaginas; i++) {
            const boton = document.createElement('button'); // Crea un botón
            boton.innerText = i; // Establece el número de la página como texto del botón
            boton.classList.add('btn', 'btn-success', 'mx-1'); // Agrega clases al botón
            boton.addEventListener('click', () => mostrarPagina(i)); // Agrega evento click al botón
            paginacion.appendChild(boton); // Añade el botón al contenedor de paginación
        }
    }

    // Si hay más de una página, crea los controles de paginación
    if (numeroDePaginas > 1) {
        crearControlesDePaginacion();
    }

    // Muestra la primera página inicialmente
    mostrarPagina(1);
});
</script>

<!-- Bootstrap core JavaScript-->
<script src="assets/jquery/jquery.min.js"></script>
<script src="assets/js/bootstrap/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="assets/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="assets/js/sb-admin-2.min.js"></script>
    
</body>

</html>