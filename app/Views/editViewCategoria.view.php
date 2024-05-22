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
            <h6 class="m-0 font-weight-bold text-success">Introduzca los datos de la nueva categoría</h6>
        </div>
        <div class="card-body">
            <div >
                <div>
                    <form class="user" method="post">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control " id="nombreCategoria" name="nombreCategoria" <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>
                                       value="<?php echo isset($input['nombreCategoria']) ? $input['nombreCategoria'] : ''; ?>" placeholder="Nombre de la categoría">
                                <p class="text-danger"><?php echo isset($errores['nombre']) ? $errores['nombre'] : ''; ?></p>
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control" name="idFamilia" <?php echo (isset($readonly) && $readonly) ? 'disabled' : ''; ?>>
                                    <option value="">Familia</option>
                                    <?php
                                    foreach ($familias as $f) {
                                        ?>
                                        <option value="<?php echo $f['idFamilia'] ?>" <?php echo (isset($input['idFamilia']) && $input['idFamilia'] == $f['idFamilia']) ? 'selected' : ''; ?>>
                                            <?php echo ucfirst($f['nombreFamilia']) ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <p class="text-danger"><?php echo isset($errores['idFamilia']) ? $errores['idFamilia'] : ''; ?></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="descripcion">Descripción:</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>>
                                    <?php echo isset($input['descripcion']) ? $input['descripcion'] : ''; ?>
                                </textarea>
                                <p class="text-danger"><?php echo isset($errores['descripcion']) ? $errores['descripcion'] : ''; ?></p>
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0 align-content-sm-end text-right p-3">      
                                <?php
                                if (isset($readonly) && !$readonly) {
                                    ?>
                                    <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                                <?php } ?>
                                <a href="/categorias" class="btn btn-secondary ml-3">Cancelar</a>                            
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