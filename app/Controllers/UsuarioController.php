<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class UsuarioController extends \Com\Daw2\Core\BaseController {

    function mostrarTodos() {
        $modelo = new \Com\Daw2\Models\UsuariosModel();
        
        $data = array(
            'titulo' => 'Usuarios',
            'usuarios' => $modelo->getAll()
        );

        /* para cuando haya que mostrar errores
        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
        }
        */

        $this->view->showViews(array('templates/header.view.php', 'usuarios.view.php', 'templates/footer.view.php'), $data);
    }
    
    function mostrarAdd() {
        $rolModel = new \Com\Daw2\Models\RolModel();
        
        $data = array(
            'titulo' => 'Añadir usuario',
            'roles' => $rolModel->getAll()
        );

        $this->view->showViews(array('templates/header.view.php', 'editAddUsuario.view.php', 'templates/footer.view.php'), $data);
    }
    
    function processAdd(): void {
        
        $errores = $this->checkAddForm($_POST);
        
        if (count($errores) == 0) {
            $model = new \Com\Daw2\Models\UsuariosModel();
            $insert = $model->insertUsuarioSistema($_POST);
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

        $this->view->showViews(array('templates/header.view.php', 'editAddUsuario.view.php', 'templates/footer.view.php'), $data);
    }

    private function checkAddForm(array $data): array {
        $errores = [];
        
        //comprueba el nombre
        if (empty($data['nombre'])) {
            $errores['nombre'] = 'Inserte un nombre';
        } else if (!preg_match('/^[a-zA-Z ]+{1,255}$/', $data['nombre'])) {
            $errores['nombre'] = 'El nombre debe ser menor a 255 caracteres y solo puede contener letras y espacios';
        }
        
        //email
        if(empty($data['email'])){
            $errores['email'] = 'Inserte un email';
        }else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = 'Inserte un email válido';
        } else {
            $model = new \Com\Daw2\Models\UsuariosModel();
            $usuario = $model->loadByEmail($data['email']);
            if (!is_null($usuario)) {
                $errores['email'] = 'El email seleccionado ya está en uso';
            }
        }
        
        //comprueba el login
        if (empty($data['login'])) {
            $errores['login'] = 'Inserte un nombre de usuario';
        } else if (!preg_match('/^[a-zA-Z0-9_]+{4,255}$/', $data['nombre'])) {
            $errores['nombre'] = 'El nombre de usuario debe estar entre 4 y 255 caracteres y solo puede contener letras, números y _';
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
        
        //contraseña
        if(empty($data['pass1'])){
            $errores['pass1'] = 'Introduzca una contraseña';
        }else if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $data['pass1'])) {
            $errores['pass1'] = 'El password debe contener una mayúscula, una minúscula y un número y tener una longitud de al menos 8 caracteres';
        }else if(empty ($data['pass2'])){
            $errores['pass2'] = 'Verifique la contraseña';
        } else if ($data['pass1'] != $data['pass2']) {
            $errores['pass2'] = 'Las contraseñas no coinciden';
        }
        
        return $errores;
    }
}


