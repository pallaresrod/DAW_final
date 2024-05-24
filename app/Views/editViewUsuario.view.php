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
            <h6 class="m-0 font-weight-bold text-success">Usuario</h6>
        </div>
        <div class="card-body">
            <div >
                <div>
                    <form class="user" method="post">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control " id="nombre" name="nombre"
                                       value="<?php echo isset($input['nombre']) ? $input['nombre'] : ''; ?>" placeholder="Nombre completo"
                                       readonly>
                            </div>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" id="email" name="email"
                                       value="<?php echo isset($input['email']) ? $input['email'] : ''; ?>" placeholder="Email"
                                       readonly>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control" id="login" name="login"
                                       value="<?php echo isset($input['login']) ? $input['login'] : ''; ?>" placeholder="Usuario"
                                       readonly>
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control" name="idRol" <?php echo (isset($readonly) && $readonly) ? 'disabled' : ''; ?>>
                                    <option value="">Rol</option>
                                    <?php
                                    foreach ($roles as $r) {
                                        ?>
                                        <option value="<?php echo $r['idRol'] ?>" <?php echo (isset($input['idRol']) && $input['idRol'] == $r['idRol']) ? 'selected' : ''; ?>>
                                            <?php echo ucfirst($r['nombreRol']) ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <p class="text-danger"><?php echo isset($errores['idRol']) ? $errores['idRol'] : ''; ?></p>
                            </div>
                        </div>
                        <div class="col-12 text-right">
                            <?php
                            if (isset($readonly) && $readonly && (strpos($_SESSION['permisos'], 'w') !== false)) {
                                //solo se mostrará al estar en modo de ver usuario  y el usuario que quiere verlo es admin
                                ?>                            
                                <a href="/actividad/<?php echo $input['idUsuario']; ?>" class="btn btn-primary ml-3">Ver actividad del usuario</a>  
                                <?php
                            }
                            ?>
                            <?php
                            //solo se mostrará al estar en modo de edición de usuario
                            if (!$readonly) {
                                ?>                            
                                <input type="submit" value="Aceptar" name="enviar" class="btn btn-primary"/>
                                <?php
                            }
                            ?>
                            <a href="/usuarios" class="btn btn-secondary ml-3">Salir</a>                            
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