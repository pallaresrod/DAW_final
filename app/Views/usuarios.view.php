<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $titulo ?></h1>
        <a href="/usuarios/add" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Añadir usuario</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">Basic Card Example</h6>
        </div>
        <div class="card-body">
            The styling for this basic card example is created by using default Bootstrap
            utility classes. By using utility classes, the style of the card component can be
            easily modified with no need for any custom CSS!
        </div>
    </div>

    <!-- DataTale -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">Uusarios</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php
                if (count($usuarios) > 0) {
                    ?>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">                    
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>                          
                                <th>Rol</th>
                                <th>Última conexión</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($usuarios as $u) {
                                ?>
                                <tr>
                                    <td><?php echo $u['nombre']; ?></td>
                                    <td><a href="mailto: <?php echo $u['email']; ?>"><?php echo $u['email']; ?></a></td>
                                    <td><?php echo $u['nombreRol']; ?></td>                            
                                    <td><?php echo $u['nombre_idioma']; ?></td>   
                                    <td><?php echo $u['last_log']; ?></td>     
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            Total de registros: <?php echo count($usuarios); ?>
                        </tfoot>
                    </table>
                    <?php
                } else {
                    ?>
                    <p class="text-danger">No existen registros que cumplan los requisitos.</p>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->