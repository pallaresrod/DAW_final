<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $titulo ?></h1>
    </div>

    <!-- DataTale -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">Últimas conexiones del usuario: <?php echo $nombre ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">                    
                    <thead>
                        <tr>
                            <th>Día</th>
                            <th>Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($actividad as $a) {
                            $datetime = new DateTime($a['log']);
                            $dia = $datetime->format('d-m-Y');
                            $hora = $datetime->format('H:i:s');
                            ?>
                            <tr>
                                <td><?php echo $dia; ?></td>
                                <td><?php echo $hora; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        Total de registros: <?php echo count($actividad); ?>
                    </tfoot>
                </table>
                <div class="col-12 text-right">
                    <a href="/usuarios" class="btn btn-secondary ml-3">Salir</a>                            
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->