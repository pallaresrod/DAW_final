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
    private function checkForm(array $data): array {
        $errores = [];

        if (empty($data['nombreFamilia'])) {
            $errores['nombre'] = 'Inserte un nombre';
        } else if (!preg_match('/^[a-zA-ZÀ-ÿ\u00f1\u00d1 ]{1,255}$/', $data['nombreFamilia'])) {
            $errores['nombre'] = 'El nombre debe ser menor a 255 caracteres y solo puede contener letras y espacios';
        }

        if (empty($data['descripcion'])) {
            $errores['descripcion'] = 'Inserte una descripción';
        } else if (!preg_match('/^[a-zA-Z0-9À-ÿ\u00f1\u00d1 ]{4,255}$/', $data['descripcion'])) {
            $errores['descripcion'] = 'La descripción debe estar entre 4 y 255 caracteres y solo puede contener letras, números y espacios';
        }

        return $errores;
    }

    /**
     * comprueba que el formulario para añadir una familia no tenga errores
     * @param array $data los datos del formulario
     * @return array los errores encontrados
     */
    private function checkAddForm(array $data): array {
        $errores = $this->checkForm($data);
        
        $model = new \Com\Daw2\Models\FamiliasModel();
        $familia = $model->loadByName($data['nombreFamilia']);
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

    /**
     * muestra la info de una familia
     * @param int $idFamilia la familia de la que se muestra la info
     */
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

    /**
     * muestra la pantalla de edición de una familia
     * @param int $idFamilia la familia que se muestra
     */
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

    /**
     * procesa la petición de edición de una familia
     * @param int $idFamilia la familia que se edita
     */
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
                $errores['desconocido'] = 'Error desconocido. No se ha editado la familia.';
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
    
    /**
     * comprueba que el formulario de edicion no tenga errores
     * @param array $data los datos del formulario
     * @param int $idFamilia la familia que se edita
     * @return string los errores encontrados
     */
    private function checkEditFrom(array $data, int $idFamilia){
        $errores = $this->checkForm($data);
        
        $model = new \Com\Daw2\Models\FamiliasModel();
        $familia = $model->loadByNameNotId($data['nombreFamilia'], $idFamilia);
        if (!is_null($familia)) {
            $errores['nombre'] = 'El nombre seleccionado ya está en uso';
        }
        return $errores;
    }

}

?>