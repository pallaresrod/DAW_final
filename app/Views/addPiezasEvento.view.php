<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $titulo ?></h1>
    </div>

    <?php
    if (isset($errores['desconocido'])) {
        ?>
        <div class="col-12">
            <div class="alert alert-danger d-flex align-items-center">
                <p class="mb-0"><?php echo $errores['desconocido']; ?></p>
            </div>
        </div>
        <?php
    }
    ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">Piezas para el evento: <?php echo $evento['nombreEvento']; ?></h6>
        </div>
        <div class="card-body">
            <div>
                <div>
                    <form class="user" method="post">
                        <div class="form-group row">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">                    
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Stock Actual</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($piezas as $p) {
                                        ?>
                                        <tr>
                                            <td><?php echo $p['codigoPieza']; ?></td>
                                            <td><?php echo $p['nombreOficial']; ?></td>
                                            <td><?php echo (is_null($p['stockActual']) || $p['stockActual'] == 0) ? $p['stock'] . ' (completo)' : $p['stockActual']; ?></td> 
                                            <td>
                                                <input type="number" class="form-control " id="cantidad<?php echo $p['idPieza']; ?>" name="cantidad<?php echo $p['idPieza']; ?>">
                                                <p class="text-danger"><?php echo isset($errores['cantidad'. $p['idPieza']]) ? $errores['cantidad'. $p['idPieza']] : ''; ?></p>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    Total de registros: <?php echo count($piezas); ?>
                                </tfoot>
                            </table>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 mb-4 mb-sm-0 align-content-sm-end text-right p-3">      
                                <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                                <a href="/eventos" class="btn btn-secondary ml-3">Cancelar</a>                            
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->