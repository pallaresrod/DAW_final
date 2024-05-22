<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class CategoriasController extends \Com\Daw2\Core\BaseController {

    /**
     * muestra un listado con todas las categorias
     */
    function mostrarTodas() {
        $modelo = new \Com\Daw2\Models\CategoriasModel();

        $data = [];
        $data['titulo'] = 'Categorias';
        $data['categorias'] = $modelo->getAll();

        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
        }

        $this->view->showViews(array('templates/header.view.php', 'categorias.view.php', 'templates/footer.view.php'), $data);
    }
    
    /**
     * muestra el formulario para añadir una categoria
     */
    function mostrarAdd() {
        $modelFamilia = new \Com\Daw2\Models\FamiliasModel();
        $familias = $modelFamilia->getAll();
        
        $data = array(
            'titulo' => 'Añadir categoria',
            'familias' => $familias
        );

        $this->view->showViews(array('templates/header.view.php', 'addCategoria.view.php', 'templates/footer.view.php'), $data);
    }
    
    /**
     * procesa la petición de añadir una nueva categoria
     */
    function procesarAdd(){
        //comprueba errores
        $errores = $this->checkAddForm($_POST);

        //si no hay errores se inserta el valor en la base de datos
        if (count($errores) == 0) {
            $model = new \Com\Daw2\Models\CategoriasModel();
            $insert = $model->insertCategoria($_POST);

            //si la operación no se realizó con exito se crea un error desconocido que saldrá por pantalla
            if ($insert > 0) {
                header('location: /categorias');
                die;
            } else {
                $errores['desconocido'] = 'Error desconocido. No se ha insertado la familia.';
            }
        }

        $modelFamilia = new \Com\Daw2\Models\FamiliasModel();
        $familias = $modelFamilia->getAll();

        $data = array(
            'titulo' => 'Añadir categoria',
            'input' => filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS),
            'familias' => $familias,
            'errores' => $errores
        );

        $this->view->showViews(array('templates/header.view.php', 'addCategoria.view.php', 'templates/footer.view.php'), $data);
    }
    
    /**
     * comprueba que el formulario de añadir categoria este bien
     * @param array $data datos del formulario
     * @return array los errores
     */
    function checkAddForm(array $data) : array {
        $errores = $this->checkForm($data);
        
        $model = new \Com\Daw2\Models\CategoriasModel();
        $categoria = $model->loadByName($data['nombre']);
        if (!is_null($categoria)) {
            $errores['nombre'] = 'El nombre seleccionado ya está en uso';
        }
        
        return $errores;
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
        
        if (empty($data['idFamilia'])) {
            $errores['idFamilia'] = 'Por favor, seleccione un rol';
        } else {
            $famModel = new \Com\Daw2\Models\FamiliasModel();
            //comprueba que la familia existe en la bbdd
            if (!filter_var($data['idFamilia'], FILTER_VALIDATE_INT) || is_null($famModel->loadById((int) $data['idFamilia']))) {
                $errores['idFamilia'] = 'Valor incorrecto';
            }
        }

        return $errores;
    }
}

?>