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
            <h6 class="m-0 font-weight-bold text-success">Introduzca los datos del nuevo usuario</h6>
        </div>
        <div class="card-body">
            <div >
                <div>
                    <form class="user" method="post">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control " id="nombreFamilia" name="nombreFamilia" <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>
                                       value="<?php echo isset($input['nombreFamilia']) ? $input['nombreFamilia'] : ''; ?>" placeholder="Nombre de la familia">
                                <p class="text-danger"><?php echo isset($errores['nombre']) ? $errores['nombre'] : ''; ?></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="descripcion">Descripción:</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>>
                                    <?php echo isset($input['descripcion']) ? $input['descripcion'] : ''; ?>
                                </textarea>
                                <p class="text-danger"><?php echo isset($errores['descripcion']) ? trim($errores['descripcion']) : ''; ?></p>
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0 align-content-sm-end text-right p-3">
                                <?php
                                if (isset($readonly) && !$readonly) {
                                    ?>
                                    <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                                <?php } ?>
                                <a href="/familias" class="btn btn-secondary ml-3">Cancelar</a>                            
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