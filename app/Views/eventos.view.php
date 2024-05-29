<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $titulo ?></h1>
        <?php
        if (strpos($_SESSION['permisos'], 'w') !== false) {
            ?>
            <a href="/evento/add" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Añadir evento</a>
                <?php
            }
            ?>
    </div>
    <?php
    if (isset($mensaje)) {
        ?>
        <div class="col-12">
            <div class="alert alert-<?php echo $mensaje['class']; ?> d-flex align-items-center">
                <p class="mb-0"><?php echo $mensaje['texto']; ?></p>
            </div>
        </div>
        <?php
    }
    ?>

    <!-- DataTale -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">Eventos</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php
                if (count($eventos) > 0) {
                    ?>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">                    
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Fecha inicio estimada</th>
                                <th>Fecha final estimada</th>
                                <th>Lugar</th>
                                <th>Cliente</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($eventos as $e) {
                                $fechaInicio = new DateTime($e['fechaInicioEstimada']);
                                $fechaFinal = new DateTime($e['fechaFinalEstimada']);
                                ?>
                                <tr>
                                    <td><?php echo $e['nombreEvento']; ?></td>
                                    <td><?php echo $fechaInicio->format('d-m-Y'); ?></td>
                                    <td><?php echo $fechaFinal->format('d-m-Y'); ?></td>
                                    <td><?php echo $e['lugarEvento']; ?></td>
                                    <td><a href="cliente/view/<?php echo $e['idCliente']; ?>" target="_blank"><?php echo $e['nombreFiscalCliente']; ?></a></td>
                                    <td>                              
                                        <a class="btn btn-success ml-1 mt-1 mb-1" href="/evento/view/<?php echo $e['idEvento']; ?>"><i class="fas fa-eye text-white"></i></a>
                                        <?php
                                        if (strpos($_SESSION['permisos'], 'w') !== false) {
                                            ?>
                                            <a class="btn btn-primary ml-1 mt-1 mb-1" href="/evento/add/piezas<?php echo $e['idEvento']; ?>"><i class="fas fa-plus text-white"></i></a>
                                            <a class="btn btn-dark ml-1 mt-1 mb-1" href="/evento/edit/<?php echo $e['idEvento']; ?>"><i class="fas fa-edit text-white"></i></a>
                                            <a class="btn btn-danger ml-1 mt-1 mb-1" href="/evento/delete/<?php echo $e['idEvento']; ?>"><i class="fas fa-trash text-white"></i></a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            Total de registros: <?php echo count($eventos); ?>
                        </tfoot>
                    </table>
                    <div id="pagination" class="mt-3 text-center">
                        <!-- Los controles de paginación son generados por JavaScript si es necesario-->
                    </div>
                    <?php
                } else {
                    ?>
                    <p class="text-danger">No existen registros.</p>
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