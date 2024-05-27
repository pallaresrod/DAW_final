<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $titulo ?></h1>
        <?php
        if (strpos($_SESSION['permisos'], 'w') !== false) {
            ?>
            <a href="/categoria/add" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Añadir categoría</a>
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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">Filtrar por familia</h6>
        </div>
        <div class="card-body">
            <form class="user" method="post">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <select class="form-control select2" name="idFamilia">
                            <option value="">Todas</option>
                            <?php
                            foreach ($familias as $f) {
                                ?>
                                <option value="<?php echo $f['idFamilia'] ?>" <?php echo (isset($input['idFamilia']) && $input['idFamilia'] == $f['idFamilia']) ? 'selected' : ''; ?>>
                                    <?php echo ucfirst($f['nombreFamilia']) ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0 align-content-start text-right"> 
                        <a href="/categorias" class="btn btn-secondary ml-3">Restablecer</a> 
                        <input type="submit" value="Filtrar" name="enviar" class="btn btn-primary"/>                     
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTale -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">Categorías</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php
                if (count($categorias) > 0) {
                    ?>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">                    
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Familia</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($categorias as $c) {
                                ?>
                                <tr>
                                    <td><?php echo $c['nombreCategoria']; ?></td>
                                    <td><?php echo $c['descripcion']; ?></td>  
                                    <td><a href="/familia/view/<?php echo $c['idFamilia']; ?>" target="_blank"><?php echo $c['nombreFamilia']; ?></a></td>
                                    <td>                              
                                        <a class="btn btn-success ml-1 mt-1 mb-1" href="/categoria/view/<?php echo $c['idCategoria']; ?>"><i class="fas fa-eye text-white"></i></a>
                                        <?php
                                        if (strpos($_SESSION['permisos'], 'w') !== false) {
                                            ?>
                                            <a class="btn btn-dark ml-1 mt-1 mb-1" href="/categoria/edit/<?php echo $c['idCategoria']; ?>"><i class="fas fa-edit text-white"></i></a>
                                            <a class="btn btn-danger ml-1 mt-1 mb-1" href="/categoria/delete/<?php echo $c['idCategoria']; ?>"><i class="fas fa-trash text-white"></i></a>
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
                            Total de registros: <?php echo count($categorias); ?>
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