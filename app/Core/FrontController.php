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

            //cerrar sesión
            Route::add('/session/borrar',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UsuarioController();
                        $controlador->procesarLogOut();
                    }
                    , 'get');

            /* GESTIÓN DE USUSARIOS */

            Route::add('/usuarios',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\UsuarioController();
                        $controlador->mostrarTodos();
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

            //edición de perfil
            Route::add('/editarPerfil/([0-9]+)',
                    function ($id) {
                        $controlador = new \Com\Daw2\Controllers\UsuarioController();
                        $controlador->editarPefil((int) $id);
                    }
                    , 'get');

            Route::add('/editarPerfil/([0-9]+)',
                    function ($id) {
                        $controlador = new \Com\Daw2\Controllers\UsuarioController();
                        $controlador->procesarEditarPerfil((int) $id);
                    }
                    , 'post');

            /* GESTIÓN DE FAMILIAS */

            Route::add('/familias',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\FamiliasController();
                        $controlador->mostrarTodas();
                    }
                    , 'get');

            Route::add('/familia/view/([0-9]+)',
                    function ($id) {
                        $controlador = new \Com\Daw2\Controllers\FamiliasController();
                        $controlador->mostrarFamilia((int) $id);
                    }
                    , 'get');

            /* GESTIÓN DE CATEGORÍAS */

            Route::add('/categorias',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\CategoriasController();
                        $controlador->mostrarTodas();
                    }
                    , 'get');

            //ver categorias con filtros
            Route::add('/categorias',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\CategoriasController();
                        $controlador->mostrarFiltros();
                    }
                    , 'post');

            //ver categoria
            Route::add('/categoria/view/([0-9]+)',
                    function ($id) {
                        $controlador = new \Com\Daw2\Controllers\CategoriasController();
                        $controlador->mostrarCategoria((int) $id);
                    }
                    , 'get');

            /* GESTIÓN DE PIEZAS */

            Route::add('/piezas',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\PiezasController();
                        $controlador->mostrarTodas();
                    }
                    , 'get');

            Route::add('/piezas',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\PiezasController();
                        $controlador->mostrarFiltros();
                    }
                    , 'post');

            //ver pieza
            Route::add('/pieza/view/([0-9]+)',
                    function ($id) {
                        $controlador = new \Com\Daw2\Controllers\PiezasController();
                        $controlador->mostrarPieza((int) $id);
                    }
                    , 'get');

            /* GESTIÓN DE CLIENTES */

            Route::add('/clientes',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\ClientesController();
                        $controlador->mostrarTodos();
                    }
                    , 'get');

            //ver cliente
            Route::add('/cliente/view/([0-9]+)',
                    function ($id) {
                        $controlador = new \Com\Daw2\Controllers\ClientesController();
                        $controlador->mostrarCliente((int) $id);
                    }
                    , 'get');

            /* GESTIÓN DE EVENTOS */

            Route::add('/eventos',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\EventosController();
                        $controlador->mostrarTodos();
                    }
                    , 'get');

            //ver evento
            Route::add('/evento/view/([0-9]+)',
                    function ($id) {
                        $controlador = new \Com\Daw2\Controllers\EventosController();
                        $controlador->mostrarEvento((int) $id);
                    }
                    , 'get');

            //acciones que solo pueden hacer los que tienen permiso de edición
            if (strpos($_SESSION['permisos'], 'w') !== false) {

                //USUARIOS
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
                Route::add('/usuario/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\UsuarioController();
                            $controlador->mostrarAdd();
                        }
                        , 'get');

                Route::add('/usuario/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\UsuarioController();
                            $controlador->processAdd();
                        }
                        , 'post');

                //borrar usuario
                Route::add('/usuario/delete/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\UsuarioController();
                            $controlador->processDelete((int) $id);
                        }
                        , 'get');

                //FAMILIAS
                //añadir familia
                Route::add('/familia/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\FamiliasController();
                            $controlador->mostrarAdd();
                        }
                        , 'get');

                Route::add('/familia/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\FamiliasController();
                            $controlador->procesarAdd();
                        }
                        , 'post');

                //borrar familia
                Route::add('/familia/delete/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\FamiliasController();
                            $controlador->processDelete((int) $id);
                        }
                        , 'get');

                //editar familia
                Route::add('/familia/edit/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\FamiliasController();
                            $controlador->mostrarEdit((int) $id);
                        }
                        , 'get');

                Route::add('/familia/edit/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\FamiliasController();
                            $controlador->procesarEdit((int) $id);
                        }
                        , 'post');

                //CATEGORÍAS
                //añadir categoria
                Route::add('/categoria/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\CategoriasController();
                            $controlador->mostrarAdd();
                        }
                        , 'get');

                Route::add('/categoria/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\CategoriasController();
                            $controlador->procesarAdd();
                        }
                        , 'post');

                //borrar categoria
                Route::add('/categoria/delete/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\CategoriasController();
                            $controlador->processDelete((int) $id);
                        }
                        , 'get');

                //editar categoria
                Route::add('/categoria/edit/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\CategoriasController();
                            $controlador->mostrarEdit((int) $id);
                        }
                        , 'get');

                Route::add('/categoria/edit/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\CategoriasController();
                            $controlador->procesarEdit((int) $id);
                        }
                        , 'post');

                //PIEZAS
                //añadir pieza
                Route::add('/pieza/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\PiezasController();
                            $controlador->mostrarAdd();
                        }
                        , 'get');

                Route::add('/pieza/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\PiezasController();
                            $controlador->procesarAdd();
                        }
                        , 'post');

                //borrar pieza
                Route::add('/pieza/delete/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\PiezasController();
                            $controlador->processDelete((int) $id);
                        }
                        , 'get');

                //editar pieza
                Route::add('/pieza/edit/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\PiezasController();
                            $controlador->mostrarEdit((int) $id);
                        }
                        , 'get');

                Route::add('/pieza/edit/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\PiezasController();
                            $controlador->procesarEdit((int) $id);
                        }
                        , 'post');

                //CLIENTES
                //añadir cliente
                Route::add('/cliente/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\ClientesController();
                            $controlador->mostrarAdd();
                        }
                        , 'get');

                Route::add('/cliente/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\ClientesController();
                            $controlador->procesarAdd();
                        }
                        , 'post');

                //borrar cliente
                Route::add('/cliente/delete/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\ClientesController();
                            $controlador->processDelete((int) $id);
                        }
                        , 'get');

                //editar cliente
                Route::add('/cliente/edit/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\ClientesController();
                            $controlador->mostrarEdit((int) $id);
                        }
                        , 'get');

                Route::add('/cliente/edit/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\ClientesController();
                            $controlador->procesarEdit((int) $id);
                        }
                        , 'post');

                //EVENTOS
                //añadir evento
                Route::add('/evento/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\EventosController();
                            $controlador->mostrarAdd();
                        }
                        , 'get');

                Route::add('/evento/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\EventosController();
                            $controlador->procesarAdd();
                        }
                        , 'post');

                Route::add('/evento/delete/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\EventosController();
                            $controlador->procesarDelete((int) $id);
                        }
                        , 'get');

                //editar evento
                Route::add('/evento/edit/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\EventosController();
                            $controlador->mostrarEdit((int) $id);
                        }
                        , 'get');

                Route::add('/evento/edit/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\EventosController();
                            $controlador->procesarEdit((int) $id);
                        }
                        , 'post');

                Route::add('/evento/add/piezas/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\EventosController();
                            $controlador->mostrarAñadirPiezas((int) $id);
                        }
                        , 'get');

                Route::add('/evento/add/piezas/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\EventosController();
                            $controlador->procesarAñadirPiezas((int) $id);
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