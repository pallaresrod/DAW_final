<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $titulo ?></h1>
    </div>

    <?php
    if (isset($errores['desconocido'])) {
        ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-gradient-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-m font-weight-bold text-gray-100 text-uppercase mb-1">
                                Error</div>
                            <div class="mb-0 font-weight-bold text-gray-100"><?php echo $errores['desconocido'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-circle fa-2x text-gray-100"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

    <div class="card shadow mb-4">

        <div class="card-body">
            <div >
                <div>
                    <form class="user" method="post">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control " id="nombre" name="nombre"
                                       value="<?php echo isset($input['nombre']) ? $input['nombre'] : ''; ?>" placeholder="Nombre completo"
                                       <?php echo isset($readonly) ? 'readonly' : ''; ?>>
                                <p class="text-danger"><?php echo isset($errores['nombre']) ? $errores['nombre'] : ''; ?></p>
                            </div>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" id="email" name="email"
                                       value="<?php echo isset($input['email']) ? $input['email'] : ''; ?>" placeholder="Email"
                                       <?php echo isset($readonly) ? 'readonly' : ''; ?>>
                                <p class="text-danger"><?php echo isset($errores['email']) ? $errores['email'] : ''; ?></p>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control" id="login" name="login"
                                       value="<?php echo isset($input['login']) ? $input['login'] : ''; ?>" placeholder="Usuario"
                                       <?php echo isset($readonly) ? 'readonly' : ''; ?>>
                                <p class="text-danger"><?php echo isset($errores['login']) ? $errores['login'] : ''; ?></p>
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control" name="idRol" <?php echo isset($readonly) ? 'readonly' : ''; ?>>
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
                            </div>
                        </div>
                        <?php if (!$readonly) { ?>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control" id="pass1" name="pass1" 
                                           placeholder="Contraseña">
                                    <p class="text-danger"><?php echo isset($errores['pass1']) ? $errores['pass1'] : ''; ?></p>
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" id="pass2" name="pass2" 
                                           placeholder="Verifique la contraseña">
                                    <p class="text-danger"><?php echo isset($errores['pass2']) ? $errores['pass2'] : ''; ?></p>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="col-12 text-right">
                            <?php
                            if($readonly){
                            ?>                            
                            <a href="/actividad/<?php echo $input['idUsuario']; ?>" class="btn btn-primary ml-3">Ver actividad del usuario</a>  
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