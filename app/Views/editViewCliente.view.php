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
            <h6 class="m-0 font-weight-bold text-success">Introduzca los datos del nuevo cliente</h6>
        </div>
        <div class="card-body">
            <div >
                <div>
                    <form class="user" method="post">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control " id="nombreFiscalCliente" name="nombreFiscalCliente" <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>
                                       value="<?php echo isset($input['nombreFiscalCliente']) ? $input['nombreFiscalCliente'] : ''; ?>" placeholder="Nombre fiscal">
                                <p class="text-danger"><?php echo isset($errores['nombreFiscalCliente']) ? $errores['nombreFiscalCliente'] : ''; ?></p>
                            </div>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" id="email" name="email" <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>
                                       value="<?php echo isset($input['email']) ? $input['email'] : ''; ?>" placeholder="Email">
                                <p class="text-danger"><?php echo isset($errores['email']) ? $errores['email'] : ''; ?></p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control" id="denominacion" name="denominacion" <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>
                                       value="<?php echo isset($input['denominacion']) ? $input['denominacion'] : ''; ?>" placeholder="Denominación">
                                <p class="text-danger"><?php echo isset($errores['denominacion']) ? $errores['denominacion'] : ''; ?></p>
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control" id="cifCliente" name="cifCliente" <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>
                                       value="<?php echo isset($input['cifCliente']) ? $input['cifCliente'] : ''; ?>" placeholder="CIF cliente">
                                <p class="text-danger"><?php echo isset($errores['cifCliente']) ? $errores['cifCliente'] : ''; ?></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control" id="direccion" name="direccion" <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>
                                       value="<?php echo isset($input['direccion']) ? $input['direccion'] : ''; ?>" placeholder="Dirección">
                                <p class="text-danger"><?php echo isset($errores['direccion']) ? $errores['direccion'] : ''; ?></p>
                            </div>
                        </div>
                        <div class="col-12 text-right">                            
                            <?php
                            if (!$readonly) {
                                ?>
                                <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                                <?php
                            }
                            ?>
                            <a href="/clientes" class="btn btn-secondary ml-3">Cancelar</a>                            
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