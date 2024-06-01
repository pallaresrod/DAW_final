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
            <h6 class="m-0 font-weight-bold text-success">Pieza</h6>
        </div>
        <div class="card-body">
            <div >
                <div>
                    <form class="user" method="post">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="codigoPieza">Código pieza:</label>
                                <input type="text" class="form-control " id="codigoPieza" name="codigoPieza" <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>
                                       value="<?php echo isset($input['codigoPieza']) ? $input['codigoPieza'] : ''; ?>" placeholder="Código pieza">
                                <p class="text-danger"><?php echo isset($errores['codigoPieza']) ? $errores['codigoPieza'] : ''; ?></p>
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="nombreOficial">Nombre Ofical:</label>
                                <input type="text" class="form-control " id="nombreOficial" name="nombreOficial" <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>
                                       value="<?php echo isset($input['nombreOficial']) ? $input['nombreOficial'] : ''; ?>" placeholder="Nombre oficial">
                                <p class="text-danger"><?php echo isset($errores['nombreOficial']) ? $errores['nombreOficial'] : ''; ?></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="codigoMarca">Código marca:</label>
                                <input type="text" class="form-control " id="codigoMarca" name="codigoMarca" <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>
                                       value="<?php echo isset($input['codigoMarca']) ? $input['codigoMarca'] : ''; ?>" placeholder="Código marca">
                                <p class="text-danger"><?php echo isset($errores['codigoMarca']) ? $errores['codigoMarca'] : ''; ?></p>
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="precio">Precio:</label>
                                <input type="number" step="0.001" class="form-control " id="precio" name="precio" <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>
                                       value="<?php echo isset($input['precio']) ? $input['precio'] : ''; ?>" placeholder="Precio">
                                <p class="text-danger"><?php echo isset($errores['precio']) ? $errores['precio'] : ''; ?></p>
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="stock">Stock:</label>
                                <input type="number" class="form-control " id="stock" name="stock" <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>
                                       value="<?php echo isset($input['stock']) ? $input['stock'] : ''; ?>" placeholder="Stock">
                                <p class="text-danger"><?php echo isset($errores['stock']) ? $errores['stock'] : ''; ?></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="longitud">Longitud:</label>
                                <input type="number" step="0.001" class="form-control " id="longitud" name="longitud" <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>
                                       value="<?php echo isset($input['longitud']) ? $input['longitud'] : ''; ?>" placeholder="Longitud. m">
                                <p class="text-danger"><?php echo isset($errores['longitud']) ? $errores['longitud'] : ''; ?></p>
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="peso">Peso:</label>
                                <input type="number" step="0.001" class="form-control " id="peso" name="peso" <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>
                                       value="<?php echo isset($input['peso']) ? $input['peso'] : ''; ?>" placeholder="Peso. kg">
                                <p class="text-danger"><?php echo isset($errores['peso']) ? $errores['peso'] : ''; ?></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="idCategoria">Categoría:</label>
                                <select class="form-control select2" name="idCategoria" <?php echo (isset($readonly) && $readonly) ? 'disabled' : ''; ?>>
                                    <option value="">Categoria</option>
                                    <?php
                                    foreach ($categorias as $c) {
                                        ?>
                                        <option value="<?php echo $c['idCategoria'] ?>" <?php echo (isset($input['idCategoria']) && $input['idCategoria'] == $c['idCategoria']) ? 'selected' : ''; ?>>
                                            <?php echo ucfirst($c['nombreCategoria']) ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <p class="text-danger"><?php echo isset($errores['idCategoria']) ? $errores['idCategoria'] : ''; ?></p>
                            </div>
                            <?php
                            if ($readonly) {
                                ?>
                                <div class="col-sm-6">
                                    <label for="idFamilia">Familia:</label>
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
                                <?php
                            }
                            ?>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="observaciones">Observaciones:</label>
                                <textarea class="form-control" id="observaciones" name="observaciones" <?php echo (isset($readonly) && $readonly) ? 'readonly' : ''; ?>>
                                    <?php echo isset($input['observaciones']) ? trim($input['observaciones']) : ''; ?>
                                </textarea>
                                <p class="text-danger"><?php echo isset($errores['observaciones']) ? $errores['observaciones'] : ''; ?></p>
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0 align-content-sm-end text-right p-3">      
                                <?php
                                if (!$readonly) {
                                    ?>
                                    <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                                <?php } ?>
                                <a href="/piezas" class="btn btn-secondary ml-3">Cancelar</a>                            
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