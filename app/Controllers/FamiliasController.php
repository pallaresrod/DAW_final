<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class FamiliasController extends \Com\Daw2\Core\BaseController {
    
    /**
     * muestra un listado con todos los ususarios
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
    
    function procesarAdd(){
        //comprueba errores
        $errores = $this->checkForm($_POST);

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
    
    function checkForm(array $data): array{
        $errores = [];
        
        if (empty($data['nombre'])) {
            $errores['nombre'] = 'Inserte un nombre';
        } else if (!preg_match('/^[a-zA-Z ]{1,255}$/', $data['nombre'])) {
            $errores['nombre'] = 'El nombre debe ser menor a 255 caracteres y solo puede contener letras y espacios';
        }
        
        if (empty($data['descripcion'])) {
            $errores['descripcion'] = 'Inserte una descripcion';
        } else if (!preg_match('/^[a-zA-Z0-9 ]{4,255}$/', $data['descripcion'])) {
            $errores['descripcion'] = 'La descripción debe estar entre 4 y 255 caracteres y solo puede contener letras, números y espacios';
        }
        
        return $errores;
    }
}
?>