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
            <span> Iconos diseñados por <a href="https://www.flaticon.es/autores/kmg-design" title="kmg design"> kmg design </a> 
                from <a href="https://www.flaticon.es/" title="Flaticon">www.flaticon.es</a></span>
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

<!-- Cuadro de dialogo que sale al darle al botón de cerrar sesión -->
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Preparado para irse</h5>
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

<!-- Bootstrap core JavaScript-->
<script src="assets/jquery/jquery.min.js"></script>
<script src="assets/js/bootstrap/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="assets/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="assets/js/sb-admin-2.min.js"></script>
    
</body>

</html>