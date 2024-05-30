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
            <h6 class="m-0 font-weight-bold text-success">Evento</h6>
        </div>
        <div class="card-body">
            <div>
                <div>
                    <form class="user" method="post">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="nombreEvento">Nombre del evento:</label>
                                <input type="text" class="form-control " id="nombreEvento" name="nombreEvento"  <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>
                                       value="<?php echo isset($input['nombreEvento']) ? $input['nombreEvento'] : ''; ?>" placeholder="Nombre del evento">
                                <p class="text-danger"><?php echo isset($errores['nombreEvento']) ? $errores['nombreEvento'] : ''; ?></p>
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="lugarEvento">Lugar del evento:</label>
                                <input type="text" class="form-control " id="lugarEvento" name="lugarEvento"  <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>
                                       value="<?php echo isset($input['lugarEvento']) ? $input['lugarEvento'] : ''; ?>" placeholder="Lugar del evento">
                                <p class="text-danger"><?php echo isset($errores['lugarEvento']) ? $errores['lugarEvento'] : ''; ?></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <?php
                            $incioEst = new \DateTime($input['fechaInicioEstimada']);
                            $fechaInicioEstimada = $incioEst->format('Y-m-d');
                            $finalEst = new \DateTime($input['fechaFinalEstimada']);
                            $fechaFinalEstimada = $finalEst->format('Y-m-d');

                            if (isset($input['fechaInicioReal'])) {
                                $inicioRe = new \DateTime($input['fechaInicioReal']);
                                $fechaInicioReal = $inicioRe->format('Y-m-d');
                            }
                            if (isset($input['fechaFinalReal'])) {
                                $finalRe = new \DateTime($input['fechaFinalReal']);
                                $fechaFinalReal = $finalRe->format('Y-m-d');
                            }
                            ?>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="fechaInicioEstimada">Fecha de inicio estimada:</label>
                                <input type="date" class="form-control " id="fechaInicioEstimada" name="fechaInicioEstimada"  <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>
                                       value="<?php echo isset($input['fechaInicioEstimada']) ? $fechaInicioEstimada : ''; ?>" >
                                <p class="text-danger"><?php echo isset($errores['fechaInicioEstimada']) ? $errores['fechaInicioEstimada'] : ''; ?></p>

                                <label for="fechaFinalEstimada">Fecha final estimada:</label>
                                <input type="date" class="form-control " id="fechaFinalEstimada" name="fechaFinalEstimada"  <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>
                                       value="<?php echo isset($input['fechaFinalEstimada']) ? $fechaFinalEstimada : ''; ?>">
                                <p class="text-danger"><?php echo isset($errores['fechaFinalEstimada']) ? $errores['fechaFinalEstimada'] : ''; ?></p>
                            </div>

                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="fechaInicioReal">Fecha de inicio real:</label>
                                <input type="date" class="form-control " id="fechaInicioReal" name="fechaInicioReal"  <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>
                                       value="<?php echo isset($input['fechaInicioReal']) ? $fechaInicioReal : ''; ?>" >
                                <p class="text-danger"><?php echo isset($errores['fechaInicioReal']) ? $errores['fechaInicioReal'] : ''; ?></p>

                                <label for="fechaFinalReal">Fecha final real:</label>
                                <input type="date" class="form-control " id="fechaFinalReal" name="fechaFinalReal"  <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>
                                       value="<?php echo isset($input['fechaFinalReal']) ? $fechaFinalReal : ''; ?>">
                                <p class="text-danger"><?php echo isset($errores['fechaFinalReal']) ? $errores['fechaFinalReal'] : ''; ?></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="observaciones">Observaciones:</label>
                                <textarea class="form-control" id="observaciones" name="observaciones"  <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>>
                                    <?php echo isset($input['observaciones']) ? trim($input['observaciones']) : ''; ?>
                                </textarea>
                                <p class="text-danger"><?php echo isset($errores['observaciones']) ? $errores['observaciones'] : ''; ?></p>
                            </div>
                            <div class="col-sm-6">
                                <label for="idCliente">Cliente:</label>
                                <select class="form-control select2" name="idCliente"  <?php echo (isset($readonly) && $readonly) ? 'disabled' : ''; ?>>
                                    <option value="">Cliente</option>
                                    <?php
                                    foreach ($clientes as $c) {
                                        ?>
                                        <option value="<?php echo $c['idCliente'] ?>" <?php echo (isset($input['idCliente']) && $input['idCliente'] == $c['idCliente']) ? 'selected' : ''; ?>>
                                            <?php echo ucfirst($c['nombreFiscalCliente']) ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <p class="text-danger"><?php echo isset($errores['idCliente']) ? $errores['idCliente'] : ''; ?></p>
                            </div>
                        </div>
                        <?php
                        if ($readonly) {
                            ?>
                            <hr>
                            <h6 class="m-0 font-weight-bold text-success mb-2">Piezas para el evento</h6>
                            <div>
                                <?php
                                if (count($piezas) > 0) {
                                    ?>
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">                    
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Cantidad</th>
                                                <th>Observaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($piezas as $p) {
                                                ?>
                                                <tr>
                                                    <td><a href="/pieza/view/<?php echo $p['idPieza']; ?>" target="_blank"><?php echo $p['nombreOficial']; ?></a></td>
                                                    <td><?php echo $p['cantidad']; ?></td> 
                                                    <td><?php echo $p['observaciones']; ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            Total de registros: <?php echo count($piezas); ?>
                                        </tfoot>
                                    </table>
                                    <div id="pagination" class="mt-3 text-center">
                                        <!-- Los controles de paginación son generados por JavaScript si es necesario-->
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <p class="text-danger">Este evento no tiene piezas asociadas.</p>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="form-group row">
                            <div class="col-sm-12 mb-4 mb-sm-0 align-content-sm-end text-right p-3">
                                <?php
                                if (!$readonly) {
                                    ?>
                                    <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                                    <?php
                                }
                                ?>
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