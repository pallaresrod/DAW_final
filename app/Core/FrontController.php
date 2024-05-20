<?php

namespace Com\Daw2\Core;

use Steampixel\Route;

class FrontController {

    static function main() {

        if (!isset($_SESSION["usuario"])) {
            Route::add('/login',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UsuarioController();
                        $controlador->mostrarLogin();
                    }
                    , 'get');

            Route::pathNotFound(
                    function () {
                        header("location: /login");
                    }
            );

            Route::add('/login',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UsuarioController();
                        $controlador->procesarLogin();
                    }
                    , 'post');
        } else {

            //ruta hacia la página de inicio
            Route::add('/',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\InicioController();
                        $controlador->index();
                    }
                    , 'get');

            //ruta hacia la págia de usuarios
            Route::add('/usuarios',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UsuarioController();
                        $controlador->mostrarTodos();
                    }
                    , 'get');

            //cerrar sesión
            Route::add('/session/borrar',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UsuarioController();
                        $controlador->procesarLogOut();
                    }
                    , 'get');

            //ver info de un usuario
            Route::add('/usuario/view/([0-9]+)',
                    function ($id) {
                        $controlador = new \Com\Daw2\Controllers\UsuarioController();
                        $controlador->mostrarUsuario((int) $id);
                    }
                    , 'get');

            //ver actividad de un usuario
            Route::add('/actividad/([0-9]+)',
                    function ($id) {
                        $controlador = new \Com\Daw2\Controllers\UsuarioController();
                        $controlador->mostrarActividadUser((int) $id);
                    }
                    , 'get');

            //solo pueden los que tienen permiso de edición
            if (strpos($_SESSION['permisos'], 'w') !== false) {

                //editar un usuario
                Route::add('/usuario/edit/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UsuarioController();
                            $controlador->mostrarEdit((int) $id);
                        }
                        , 'get');

                Route::add('/usuario/edit/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UsuarioController();
                            $controlador->procesarEdit((int) $id);
                        }
                        , 'post');

                //añadir usuarios
                Route::add('/usuarios/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\UsuarioController();
                            $controlador->mostrarAdd();
                        }
                        , 'get');

                Route::add('/usuarios/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\UsuarioController();
                            $controlador->processAdd();
                        }
                        , 'post');
            }

            //no se encuentra la ruta. Error 404
            Route::pathNotFound(
                    function () {
                        $controller = new \Com\Daw2\Controllers\ErroresController();
                        $controller->error404();
                    }
            );

            //el metodo HTTP no esta permitido. Error 405
            Route::methodNotAllowed(
                    function () {
                        $controller = new \Com\Daw2\Controllers\ErroresController();
                        $controller->error405();
                    }
            );
        }

        Route::run();
    }

}

?>