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
            <h6 class="m-0 font-weight-bold text-success">Introduzca los datos del nuevo evento</h6>
        </div>
        <div class="card-body">
            <div>
                <div>
                    <form class="user" method="post">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control " id="nombreEvento" name="nombreEvento"
                                       value="<?php echo isset($input['nombreEvento']) ? $input['nombreEvento'] : ''; ?>" placeholder="Nombre del evento">
                                <p class="text-danger"><?php echo isset($errores['nombreEvento']) ? $errores['nombreEvento'] : ''; ?></p>
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control " id="lugarEvento" name="lugarEvento"
                                       value="<?php echo isset($input['lugarEvento']) ? $input['lugarEvento'] : ''; ?>" placeholder="Lugar del evento">
                                <p class="text-danger"><?php echo isset($errores['lugarEvento']) ? $errores['lugarEvento'] : ''; ?></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="fechaInicioEstimada">Fecha de inicio estimada:</label>
                                <input type="date" class="form-control " id="fechaInicioEstimada" name="fechaInicioEstimada"
                                       value="<?php echo isset($input['fechaInicioEstimada']) ? $input['fechaInicioEstimada'] : ''; ?>" >
                                <p class="text-danger"><?php echo isset($errores['fechaInicioEstimada']) ? $errores['fechaInicioEstimada'] : ''; ?></p>
                                
                                <label for="fechaFinalEstimada">Fecha final estimada:</label>
                                <input type="date" class="form-control " id="fechaFinalEstimada" name="fechaFinalEstimada"
                                       value="<?php echo isset($input['fechaFinalEstimada']) ? $input['fechaFinalEstimada'] : ''; ?>">
                                <p class="text-danger"><?php echo isset($errores['fechaFinalEstimada']) ? $errores['fechaFinalEstimada'] : ''; ?></p>
                            </div>
                            
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="observaciones">Observaciones:</label>
                                <textarea class="form-control" id="observaciones" name="observaciones">
                                    <?php echo isset($input['observaciones']) ? $input['observaciones'] : ''; ?>
                                </textarea>
                                <p class="text-danger"><?php echo isset($errores['observaciones']) ? $errores['observaciones'] : ''; ?></p>
                            </div>
                            
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <select class="form-control select2" name="idCliente">
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
                            <div class="col-sm-6 mb-3 mb-sm-0 align-content-sm-end text-right p-3">      
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