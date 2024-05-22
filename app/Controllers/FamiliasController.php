<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class FamiliasController extends \Com\Daw2\Core\BaseController {

    /**
     * muestra un listado con todas las familias
     */
    function mostrarTodas() {
        $modelo = new \Com\Daw2\Models\FamiliasModel();

        $data = [];
        $data['titulo'] = 'Familias';
        $data['familias'] = $modelo->getAll();

        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
        }

        $this->view->showViews(array('templates/header.view.php', 'familias.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * muestra el formulario para añadir una familia
     */
    function mostrarAdd() {
        $data = array(
            'titulo' => 'Añadir familia'
        );

        $this->view->showViews(array('templates/header.view.php', 'addFamilia.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * procesa la solicitud de añadir una nueva familia
     */
    function procesarAdd() {
        //comprueba errores
        $errores = $this->checkAddForm($_POST);

        //si no hay errores se inserta el valor en la base de datos
        if (count($errores) == 0) {
            $model = new \Com\Daw2\Models\FamiliasModel();
            $insert = $model->insertFamilia($_POST);

            //si la operación no se realizó con exito se crea un error desconocido que saldrá por pantalla
            if ($insert > 0) {
                header('location: /familias');
                die;
            } else {
                $errores['desconocido'] = 'Error desconocido. No se ha insertado la familia.';
            }
        }

        $rolModel = new \Com\Daw2\Models\RolModel();

        $data = array(
            'titulo' => 'Añadir familia',
            'input' => filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS),
            'errores' => $errores
        );

        $this->view->showViews(array('templates/header.view.php', 'addFamilia.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * comprueba que el formulario este bien
     * @param array $data datos del formulario
     * @return array errores encontrados
     */
    function checkForm(array $data): array {
        $errores = [];

        if (empty($data['nombre'])) {
            $errores['nombre'] = 'Inserte un nombre';
        } else if (!preg_match('/^[a-zA-Z ]{1,255}$/', $data['nombre'])) {
            $errores['nombre'] = 'El nombre debe ser menor a 255 caracteres y solo puede contener letras y espacios';
        }

        if (empty($data['descripcion'])) {
            $errores['descripcion'] = 'Inserte una descripción';
        } else if (!preg_match('/^[a-zA-Z0-9 ]{4,255}$/', $data['descripcion'])) {
            $errores['descripcion'] = 'La descripción debe estar entre 4 y 255 caracteres y solo puede contener letras, números y espacios';
        }

        return $errores;
    }

    function checkAddForm(array $data): array {
        $errores = $this->checkForm($data);
        
        $model = new \Com\Daw2\Models\FamiliasModel();
        $familia = $model->loadByName($data['nombre']);
        if (!is_null($familia)) {
            $errores['nombre'] = 'El nombre seleccionado ya está en uso';
        }
        
        return $errores;
    }

    /**
     * procesa la petición de borrar una familia
     * @param int $idFamilia la familia que se quiere borrar
     */
    function processDelete(int $idFamilia) {
        $model = new \Com\Daw2\Models\FamiliasModel();

        if (!$model->delete($idFamilia)) {
            $mensaje = [];
            $mensaje['class'] = 'danger';
            $mensaje['texto'] = 'No se ha podido borrar la familia.';
        } else {
            $mensaje = [];
            $mensaje['class'] = 'success';
            $mensaje['texto'] = 'Familia eliminada con éxito.';
        }


        $_SESSION['mensaje'] = $mensaje;
        header('location: /familias');
    }

    function mostrarFamilia(int $idFamilia) {
        $modelo = new \Com\Daw2\Models\FamiliasModel();

        $familia = $modelo->loadById($idFamilia);

        //al compartir vista con edit necesitamos una manera de que si esta viendo la familia no lo pueda editar
        $readOnly = true;

        $data = array(
            'titulo' => 'Información de familia',
            'input' => $familia,
            'readonly' => $readOnly
        );

        $this->view->showViews(array('templates/header.view.php', 'editViewFamilia.view.php', 'templates/footer.view.php'), $data);
    }

    function mostrarEdit(int $idFamilia) {
        $modelo = new \Com\Daw2\Models\FamiliasModel();

        $familia = $modelo->loadById($idFamilia);

        //al compartir vista con edit necesitamos una manera de que si esta viendo la familia no lo pueda editar
        $readOnly = false;

        $data = array(
            'titulo' => 'Editar familia',
            'input' => $familia,
            'readonly' => $readOnly
        );

        $this->view->showViews(array('templates/header.view.php', 'editViewFamilia.view.php', 'templates/footer.view.php'), $data);
    }

    function procesarEdit(int $idFamilia) {
        $errores = $this->checkEditFrom($_POST, $idFamilia);

        //si no hay errores se actualiza el valor en la base de datos
        if (count($errores) == 0) {
            $model = new \Com\Daw2\Models\FamiliasModel();
            $update = $model->updateFamilia($idFamilia, $_POST);

            //si la operación no se realizó con exito se crea un error desconocido que saldrá por pantalla
            if ($update > 0) {
                header('location: /familias');
                die;
            } else {
                $errores['desconocido'] = 'Error desconocido. No se ha editado el usuario.';
            }
        }

        $readOnly = false;

        $data = array(
            'titulo' => 'Editar familia',
            'input' => filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS),
            'errores' => $errores,
            'readonly' => $readOnly
        );

        $this->view->showViews(array('templates/header.view.php', 'editViewFamilia.view.php', 'templates/footer.view.php'), $data);
    }
    
    function checkEditFrom(array $data, int $idFamilia){
        $errores = $this->checkForm($data);
        
        $model = new \Com\Daw2\Models\FamiliasModel();
        $familia = $model->loadByNameNotId($data['nombre'], $idFamilia);
        if (!is_null($familia)) {
            $errores['nombre'] = 'El nombre seleccionado ya está en uso';
        }
        return $errores;
    }

}

?>