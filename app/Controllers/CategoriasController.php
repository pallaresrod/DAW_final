<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class CategoriasController extends \Com\Daw2\Core\BaseController {

    /**
     * muestra un listado con todas las categorias
     */
    function mostrarTodas() {
        $modelo = new \Com\Daw2\Models\CategoriasModel();
        $modelofami = new \Com\Daw2\Models\FamiliasModel();

        $data = [];
        $data['titulo'] = 'Categorias';
        $data['categorias'] = $modelo->getAll();
        $data['familias'] = $modelofami->getAll();

        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
        }

        $this->view->showViews(array('templates/header.view.php', 'categorias.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * muestra un listado dependiendo del filtro de familia
     */
    function mostrarFiltros() {
        
        //echo 'hola'; die;

        if (empty($_POST['idFamilia'])) {
            header('location: /categorias');
        } else {
            $modelo = new \Com\Daw2\Models\CategoriasModel();
            $modelofami = new \Com\Daw2\Models\FamiliasModel();

            $data = [];
            $data['titulo'] = 'Categorias';
            $data['categorias'] = $modelo->getFiltros((int) $_POST['idFamilia']);
            $data['familias'] = $modelofami->getAll();

            if (isset($_SESSION['mensaje'])) {
                $data['mensaje'] = $_SESSION['mensaje'];
                unset($_SESSION['mensaje']);
            }

            $this->view->showViews(array('templates/header.view.php', 'categorias.view.php', 'templates/footer.view.php'), $data);
        }
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
    function procesarAdd() {
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
                $errores['desconocido'] = 'Error desconocido. No se ha insertado la categoría.';
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
    private function checkAddForm(array $data): array {
        $errores = $this->checkForm($data);

        $model = new \Com\Daw2\Models\CategoriasModel();
        $categoria = $model->loadByName($data['nombreCategoria']);
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
    private function checkForm(array $data): array {
        $errores = [];

        if (empty($data['nombreCategoria'])) {
            $errores['nombre'] = 'Inserte un nombre';
        } else if (!preg_match('/^[a-zA-ZÀ-ÿ\u00f1\u00d1 ]{1,255}$/', $data['nombreCategoria'])) {
            $errores['nombre'] = 'El nombre debe ser menor a 255 caracteres y solo puede contener letras y espacios';
        }

        if (empty($data['descripcion'])) {
            $errores['descripcion'] = 'Inserte una descripción';
        } else if (!preg_match('/^[a-zA-ZÀ-ÿ\u00f1\u00d10-9 ]{4,255}$/', $data['descripcion'])) {
            $errores['descripcion'] = 'La descripción debe estar entre 4 y 255 caracteres y solo puede contener letras, números y espacios';
        }

        if (empty($data['idFamilia'])) {
            $errores['idFamilia'] = 'Por favor, seleccione una familia';
        } else {
            $famModel = new \Com\Daw2\Models\FamiliasModel();
            //comprueba que la familia existe en la bbdd
            if (!filter_var($data['idFamilia'], FILTER_VALIDATE_INT) || is_null($famModel->loadById((int) $data['idFamilia']))) {
                $errores['idFamilia'] = 'Valor incorrecto';
            }
        }

        return $errores;
    }

    function mostrarCategoria(int $idCategoria) {
        $modelo = new \Com\Daw2\Models\CategoriasModel();
        $modeloFam = new \Com\Daw2\Models\FamiliasModel();

        $categoria = $modelo->loadById($idCategoria);
        $familias = $modeloFam->getAll();

        //al compartir vista con edit necesitamos una manera de que si esta viendo la categoría no la pueda editar
        $readOnly = true;

        $data = array(
            'titulo' => 'Información de categoría',
            'input' => $categoria,
            'readonly' => $readOnly,
            'familias' => $familias
        );

        $this->view->showViews(array('templates/header.view.php', 'editViewCategoria.view.php', 'templates/footer.view.php'), $data);
    }

    function mostrarEdit(int $idCategoria) {
        $modelo = new \Com\Daw2\Models\CategoriasModel();
        $modeloFam = new \Com\Daw2\Models\FamiliasModel();

        $categoria = $modelo->loadById($idCategoria);
        $familias = $modeloFam->getAll();

        //al compartir vista con edit necesitamos una manera de que si esta viendo la familia no lo pueda editar
        $readOnly = false;

        $data = array(
            'titulo' => 'Editar categoría',
            'input' => $categoria,
            'readonly' => $readOnly,
            'familias' => $familias
        );

        $this->view->showViews(array('templates/header.view.php', 'editViewCategoria.view.php', 'templates/footer.view.php'), $data);
    }

    function procesarEdit(int $idCategoria) {
        $errores = $this->checkEditForm($_POST, $idCategoria);

        //si no hay errores se actualiza el valor en la base de datos
        if (count($errores) == 0) {
            $model = new \Com\Daw2\Models\CategoriasModel();
            $update = $model->updateCategoria($idCategoria, $_POST);

            //si la operación no se realizó con exito se crea un error desconocido que saldrá por pantalla
            if ($update > 0) {
                header('location: /categorias');
                die;
            } else {
                $errores['desconocido'] = 'Error desconocido. No se ha editado la categoria.';
            }
        }
        $modeloFam = new \Com\Daw2\Models\FamiliasModel();

        $readOnly = false;
        $familias = $modeloFam->getAll();

        $data = array(
            'titulo' => 'Editar categoria',
            'input' => filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS),
            'errores' => $errores,
            'readonly' => $readOnly,
            'familias' => $familias
        );

        $this->view->showViews(array('templates/header.view.php', 'editViewCategoria.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * coprueba que el formulario de edicion este correcto
     * @param array $data los datos del formulario
     * @return array los errores encontrados
     */
    private function checkEditForm(array $data, int $idCategoria): array {
        $errores = $this->checkForm($data);

        $model = new \Com\Daw2\Models\CategoriasModel();
        $categoria = $model->loadByNameNotId($data['nombreCategoria'], $idCategoria);
        if (!is_null($categoria)) {
            $errores['nombre'] = 'El nombre seleccionado ya está en uso';
        }
        return $errores;
    }

    function processDelete(int $idCategoria) {
        $model = new \Com\Daw2\Models\CategoriasModel();

        if (!$model->delete($idCategoria)) {
            $mensaje = [];
            $mensaje['class'] = 'danger';
            $mensaje['texto'] = 'No se ha podido borrar la categoría.';
        } else {
            $mensaje = [];
            $mensaje['class'] = 'success';
            $mensaje['texto'] = 'Categoría eliminada con éxito.';
        }


        $_SESSION['mensaje'] = $mensaje;
        header('location: /categorias');
    }

}

?>