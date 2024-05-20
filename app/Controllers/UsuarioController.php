<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class UsuarioController extends \Com\Daw2\Core\BaseController {

    private const ROL_EDICION = 1;
    private const ROL_LECTURA = 2;

    /**
     * muestra el formulario de inicio de sesión
     */
    function mostrarLogin() {
        $this->view->show("login.view.php");
    }

    /**
     * procesa el formulario de inicio de sesión
     */
    function procesarLogin() {
        $modelo = new \Com\Daw2\Models\UsuariosModel();
        $login = $_POST["login"];
        $pass = $_POST["pass"];

        $usuario = $modelo->loadByLogin($login);
        $errores = $this->checkLogin($_POST);

        if (count($errores) == 0) {
            if (!is_null($usuario)) {
                if (password_verify($pass, $usuario["pass"])) {

                    //al hacer esto borramos del array de ususario la pass, de esta manera cuando usuario se guarde en una variable de sesión no se guarde la contraseña
                    unset($usuario["pass"]);

                    $_SESSION["usuario"] = $usuario;
                    $_SESSION["permisos"] = $this->getPermisos($usuario["idRol"]);

                    $modelo->updateLogin($usuario["idUsuario"]);

                    header("location: /");
                } else {
                    $errores["pass"] = "Datos de acceso incorrectos";
                }
            } else {
                $errores["pass"] = "Datos de acceso incorrectos";
            }
        }

        $data = [];
        $data["inputLogin"] = $_POST["login"];
        $data["errores"] = $errores;
        $this->view->show("login.view.php", $data);
    }

    /**
     * comprueba que los datos del formulario login estén completos
     * @param array $data los datos ha comprobar
     * @return array los errores que se encuentran
     */
    function checkLogin(array $data): array {
        $errores = [];
        if (empty($data["login"])) {
            $errores["login"] = "Introduzca un nombre de usuario";
        }
        if (empty($data["pass"])) {
            $errores["pass"] = "Introduzca una contraseña";
        }
        return $errores;
    }

    /**
     * dependiendo del rol que tengas te da unos permisos u otros,
     * hay dos roles, de edicion o de lectura, por ello los permisos que puedes tener son rw (lectura y edición) o solo r (lectura)
     * @param int $idRol el rol del usuario
     * @return string los permisos que tiene el ususario
     */
    private function getPermisos(int $idRol): string {
        $permisos = '';

        switch ($idRol) {

            case self::ROL_EDICION:
                $permisos = 'rw';

                break;

            case self::ROL_LECTURA:
                $permisos = 'r';

                break;
        }

        return $permisos;
    }

    /**
     * procesa la petición de cerrar sesión
     */
    function procesarLogOut() {
        session_destroy();
        header("location: /");
    }

    /**
     * muestra un listado con todos los ususarios
     */
    function mostrarTodos() {
        $modelo = new \Com\Daw2\Models\UsuariosModel();

        $data = array(
            'titulo' => 'Usuarios',
            'usuarios' => $modelo->getAll()
        );

        $this->view->showViews(array('templates/header.view.php', 'usuarios.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * muestra el formulario para añadir un usuario
     */
    function mostrarAdd() {
        $rolModel = new \Com\Daw2\Models\RolModel();

        $data = array(
            'titulo' => 'Añadir usuario',
            'roles' => $rolModel->getAll()
        );

        $this->view->showViews(array('templates/header.view.php', 'addUsuario.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * procesa el formulario de añadir un usuario una vez enviado
     * @return void no se devuelve nada
     */
    function processAdd(): void {

        //comprueba errores
        $errores = $this->checkAddForm($_POST);

        //si no hay errores se inserta el valor en la base de datos
        if (count($errores) == 0) {
            $model = new \Com\Daw2\Models\UsuariosModel();
            $insert = $model->insertUsuarioSistema($_POST);
            //si la operación no se realizó con exito se crea un error desconocido que saldrá por pantalla
            if ($insert > 0) {
                header('location: /usuarios');
                die;
            } else {
                $errores['desconocido'] = 'Error desconocido. No se ha insertado el usuario.';
            }
        }

        $rolModel = new \Com\Daw2\Models\RolModel();

        $data = array(
            'titulo' => 'Añadir usuario',
            'roles' => $rolModel->getAll(),
            'input' => filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS),
            'errores' => $errores
        );

        $this->view->showViews(array('templates/header.view.php', 'addUsuario.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * comprueba que el formulario de añadir un usuario este bien
     * @param array $data la información ha comprobar
     * @return array los errores encontrados
     */
    private function checkAddForm(array $data): array {
        $errores = $this->checkForm($data);
        array_merge($errores, $this->checkPassForm($data));

        return $errores;
    }

    /*
     * función que comprueba que los datos del formularios sean correctos 
     * @param array $data los datos introducidos
     * @return array los errores encontrados
     */

    private function checkForm(array $data): array {
        $errores = [];

        //comprueba el nombre
        if (empty($data['nombre'])) {
            $errores['nombre'] = 'Inserte un nombre';
        } else if (!preg_match('/^[a-zA-Z ]{1,255}$/', $data['nombre'])) {
            $errores['nombre'] = 'El nombre debe ser menor a 255 caracteres y solo puede contener letras y espacios';
        }

        //email
        if (empty($data['email'])) {
            $errores['email'] = 'Inserte un email';
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = 'Inserte un email válido';
        } else {
            $model = new \Com\Daw2\Models\UsuariosModel();
            $usuario = $model->loadByEmail($data['email']);
            if (!is_null($usuario)) {
                $errores['email'] = 'El email seleccionado ya está en uso';
            }
        }

        //login
        if (empty($data['login'])) {
            $errores['login'] = 'Inserte un nombre de usuario';
        } else if (!preg_match('/^[a-zA-Z0-9_]{4,255}$/', $data['login'])) {
            $errores['login'] = 'El nombre de usuario debe estar entre 4 y 255 caracteres y solo puede contener letras, números y _';
        } else {
            $model = new \Com\Daw2\Models\UsuariosModel();
            $usuario = $model->loadByLogin($data['login']);
            if (!is_null($usuario)) {
                $errores['login'] = 'El nombre de usuario seleccionado ya está en uso';
            }
        }

        //rol
        if (empty($data['idRol'])) {
            $errores['idRol'] = 'Por favor, seleccione un rol';
        } else {
            $rolModel = new \Com\Daw2\Models\RolModel();
            //comprueba que el rol existe en la bbdd
            if (!filter_var($data['idRol'], FILTER_VALIDATE_INT) || is_null($rolModel->loadRol((int) $data['idRol']))) {
                $errores['idRol'] = 'Valor incorrecto';
            }
        }

        return $errores;
    }

    /**
     * comprueba que las contraseñas metidas en un formulario sean correctas
     * @param array $data los datos ha comprobar
     * @return array los errores encontrados
     */
    private function checkPassForm(array $data): array {
        $errores = [];

        if (empty($data['pass1'])) {
            $errores['pass1'] = 'Introduzca una contraseña';
        } else if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $data['pass1'])) {
            $errores['pass1'] = 'El password debe contener una mayúscula, una minúscula y un número y tener una longitud de al menos 8 caracteres';
        } else if (empty($data['pass2'])) {
            $errores['pass2'] = 'Verifique la contraseña';
        } else if ($data['pass1'] != $data['pass2']) {
            $errores['pass2'] = 'Las contraseñas no coinciden';
        }

        return $errores;
    }

    /**
     * muestra la actividad de un usuario
     * @param type $idUsuario el usuario del que se muestra la actividad
     */
    function mostrarActividadUser(int $idUsuario) {
        $modelo = new \Com\Daw2\Models\UsuariosModel();
        $usuario = $modelo->loadById($idUsuario);

        $data = array(
            'titulo' => 'Actividad del usuario',
            'nombre' => $usuario['nombre'],
            'actividad' => $modelo->getActivity($idUsuario)
        );

        //un ususario puede ver su propia actividad, pero solo un admin puede ver la actividad del resto
        if ($_SESSION['usuario']['idUsuario'] === $idUsuario) {
            $this->view->showViews(array('templates/header.view.php', 'userActivityLog.view.php', 'templates/footer.view.php'), $data);
        } else if (strpos($_SESSION['permisos'], 'w') !== false) {
            $this->view->showViews(array('templates/header.view.php', 'userActivityLog.view.php', 'templates/footer.view.php'), $data);
        } else {
            $error = new \Com\Daw2\Controllers\ErroresController();
            $error->error404();
        }
    }

    /**
     * muestra la informacion de un usuario 
     * @param int $idUsuario el usuario del que se muestra la info
     */
    function mostrarUsuario(int $idUsuario) {
        $modelo = new \Com\Daw2\Models\UsuariosModel();
        $rolModel = new \Com\Daw2\Models\RolModel();
        $usuario = $modelo->loadById($idUsuario);

        //al compartir vista con edit necesitamos una manera de que si esta viendo el usuario no lo pueda editar
        $readOnly = true;

        $data = array(
            'titulo' => 'Información de usuario',
            'roles' => $rolModel->getAll(),
            'input' => $usuario,
            'readonly' => $readOnly
        );

        $this->view->showViews(array('templates/header.view.php', 'editViewUsuario.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * muestra el formulario para editar el rol de otros usuarios
     * @param int $idUsuario el ususario que se quiere editar
     */
    function mostrarEdit(int $idUsuario) {
        $modelo = new \Com\Daw2\Models\UsuariosModel();
        $rolModel = new \Com\Daw2\Models\RolModel();
        $usuario = $modelo->loadById($idUsuario);

        //al compartir vista con edit necesitamos una manera de que si esta viendo el usuario no lo pueda editar
        $readOnly = false;

        $data = array(
            'titulo' => 'Editar usuario',
            'roles' => $rolModel->getAll(),
            'input' => $usuario,
            'readonly' => $readOnly
        );

        $this->view->showViews(array('templates/header.view.php', 'editViewUsuario.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * procesa la edición de un ususario
     * @param int $idUsuario el usuario que se ha editado
     */
    function procesarEdit(int $idUsuario) {

        $errores = [];
        //comprueba errores
        if (empty($_POST['idRol'])) {
            $errores['idRol'] = 'Por favor, seleccione un rol';
        } else {
            $rolModel = new \Com\Daw2\Models\RolModel();
            //comprueba que el rol existe en la bbdd
            if (!filter_var($_POST['idRol'], FILTER_VALIDATE_INT) || is_null($rolModel->loadRol((int) $_POST['idRol']))) {
                $errores['idRol'] = 'Valor incorrecto';
            }
        }

        //si no hay errores se inserta el valor en la base de datos
        if (count($errores) == 0) {
            //solo se pueden editar perfiles que no sean del usuario que intenta editarlos
            if ($_SESSION['usuario']['idUsuario'] !== $idUsuario) {
                $model = new \Com\Daw2\Models\UsuariosModel();
                $update = $model->updateidRol($idUsuario, (int) $_POST['idRol']);

                //si la operación no se realizó con exito se crea un error desconocido que saldrá por pantalla
                if ($update > 0) {
                    header('location: /usuarios');
                    die;
                } else {
                    $errores['desconocido'] = 'Error desconocido. No se ha editado el usuario.';
                }
            } else {
                $errores['desconocido'] = 'No puede cambiarse el rol a si mismo.';
            }
        }

        $rolModel = new \Com\Daw2\Models\RolModel();
        $readOnly = false;

        $data = array(
            'titulo' => 'Editar usuario',
            'roles' => $rolModel->getAll(),
            'input' => filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS),
            'errores' => $errores,
            'readonly' => $readOnly
        );

        $this->view->showViews(array('templates/header.view.php', 'editViewUsuario.view.php', 'templates/footer.view.php'), $data);
    }

}
