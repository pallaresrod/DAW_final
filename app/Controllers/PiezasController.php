<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class PiezasController extends \Com\Daw2\Core\BaseController {

    /**
     * muestra un listado con todas las categorias
     */
    function mostrarTodas() {
        $modelocat = new \Com\Daw2\Models\CategoriasModel();
        $modelofami = new \Com\Daw2\Models\FamiliasModel();

        $modelo = new \Com\Daw2\Models\PiezasModel();

        $data = [];
        $data['titulo'] = 'Piezas';
        $data['categorias'] = $modelocat->getAll();
        $data['familias'] = $modelofami->getAll();
        $data['piezas'] = $modelo->getAll();

        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
        }

        $this->view->showViews(array('templates/header.view.php', 'piezas.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * muestra un listado dependiendo del filtro de familia y categoria seleccionadas
     */
    function mostrarFiltros() {

        if (empty($_POST['idFamilia']) && empty($_POST["idCategoria"])) {
            header('location: /piezas');
        } else {

            $modelocat = new \Com\Daw2\Models\CategoriasModel();
            $modelofami = new \Com\Daw2\Models\FamiliasModel();

            $modelo = new \Com\Daw2\Models\PiezasModel();

            $data = [];
            $data['titulo'] = 'Piezas';
            $data['categorias'] = $modelocat->getAll();
            $data['familias'] = $modelofami->getAll();
            $data['piezas'] = $modelo->getFiltros($_POST);
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            if (isset($_SESSION['mensaje'])) {
                $data['mensaje'] = $_SESSION['mensaje'];
                unset($_SESSION['mensaje']);
            }

            $this->view->showViews(array('templates/header.view.php', 'piezas.view.php', 'templates/footer.view.php'), $data);
        }
    }

    /**
     * muestra info de una pieza
     * @param int $idPieza la pieza que se quiere ver
     */
    function mostrarPieza(int $idPieza) {
        $modelocat = new \Com\Daw2\Models\CategoriasModel();
        $modeloFam = new \Com\Daw2\Models\FamiliasModel();

        $modelo = new \Com\Daw2\Models\PiezasModel();

        $categoria = $modelocat->getAll();
        $familias = $modeloFam->getAll();
        $piezas = $modelo->loadById($idPieza);

        //al compartir vista con edit necesitamos una manera de que si esta viendo la pieza no la pueda editar
        $readOnly = true;

        $data = array(
            'titulo' => 'Información de pieza',
            'input' => $piezas,
            'readonly' => $readOnly,
            'familias' => $familias,
            'categorias' => $categoria
        );

        $this->view->showViews(array('templates/header.view.php', 'editViewPieza.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * muestra el formulario de editar una pieza
     * @param int $idPieza la pieza que se quiere editar
     */
    function mostrarEdit(int $idPieza) {
        $modelocat = new \Com\Daw2\Models\CategoriasModel();

        $modelo = new \Com\Daw2\Models\PiezasModel();

        $categorias = $modelocat->getAll();
        $piezas = $modelo->loadById($idPieza);

        //al compartir vista con edit necesitamos una manera de que si esta viendo la pieza no la pueda editar
        $readOnly = false;

        $data = array(
            'titulo' => 'Información de pieza',
            'input' => $piezas,
            'readonly' => $readOnly,
            'categorias' => $categorias
        );

        $this->view->showViews(array('templates/header.view.php', 'editViewPieza.view.php', 'templates/footer.view.php'), $data);
    }

    function procesarEdit(int $idPieza) {
        $errores = $this->checkEditForm($_POST, $idPieza);

        //si no hay errores se actualiza el valor en la base de datos
        if (count($errores) == 0) {
            $model = new \Com\Daw2\Models\PiezasModel();
            $update = $model->updatePieza($idPieza, $_POST);

            //si la operación no se realizó con exito se crea un error desconocido que saldrá por pantalla
            if ($update > 0) {
                header('location: /piezas');
                die;
            } else {
                $errores['desconocido'] = 'Error desconocido. No se ha editado la pieza.';
            }
        }

        $modelocat = new \Com\Daw2\Models\CategoriasModel();
        $categorias = $modelocat->getAll();

        $readOnly = false;

        $data = array(
            'titulo' => 'Editar pieza',
            'input' => filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS),
            'errores' => $errores,
            'readonly' => $readOnly,
            'categorias' => $categorias
        );

        $this->view->showViews(array('templates/header.view.php', 'editViewPieza.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * muestra el formulario para añadir una pieza
     */
    function mostrarAdd() {
        $modelocat = new \Com\Daw2\Models\CategoriasModel();
        $categorias = $modelocat->getAll();

        $data = array(
            'titulo' => 'Añadir pieza',
            'categorias' => $categorias
        );

        $this->view->showViews(array('templates/header.view.php', 'addPieza.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * procesa la petición de añadir una pieza
     */
    function procesarAdd() {
        //comprueba errores
        $errores = $this->checkAddForm($_POST);

        //si no hay errores se inserta el valor en la base de datos
        if (count($errores) == 0) {
            $model = new \Com\Daw2\Models\PiezasModel();
            $insert = $model->insertPieza($_POST);

            //si la operación no se realizó con exito se crea un error desconocido que saldrá por pantalla
            if ($insert > 0) {
                header('location: /piezas');
                die;
            } else {
                $errores['desconocido'] = 'Error desconocido. No se ha insertado la pieza.';
            }
        }

        $modelocat = new \Com\Daw2\Models\CategoriasModel();
        $categorias = $modelocat->getAll();

        $data = array(
            'titulo' => 'Añadir pieza',
            'input' => filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS),
            'categorias' => $categorias,
            'errores' => $errores
        );

        $this->view->showViews(array('templates/header.view.php', 'addPieza.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * procesa la petición de borrar una pieza
     * @param int $idPieza la pieza que se quiere borrar
     */
    function processDelete(int $idPieza) {
        $model = new \Com\Daw2\Models\PiezasModel();

        //primero nos aseguramos de que la pieza no se este usando en ningún proyecto
        $modeloEvento = new \Com\Daw2\Models\EventosModel();

        if (is_null($modeloEvento->buscarPieza($idPieza))) {
            if (!$model->delete($idPieza)) {
                $mensaje = [];
                $mensaje['class'] = 'danger';
                $mensaje['texto'] = 'No se ha podido borrar la pieza.';
            } else {
                $mensaje = [];
                $mensaje['class'] = 'success';
                $mensaje['texto'] = 'Pieza eliminada con éxito.';
            }
        } else {
            $mensaje = [];
            $mensaje['class'] = 'danger';
            $mensaje['texto'] = 'No se ha podido borrar la pieza, pues se está usando o se previene usar en eventos. '
                    . 'Asegurese de que una pieza no este asociada a ningún evento antes de borrarla.';
        }

        $_SESSION['mensaje'] = $mensaje;
        header('location: /piezas');
    }

    /**
     * comprueba que el formulario de añadir pieza este correcto
     * @param type $data los datos del formulario
     * @return array los errores encontrados
     */
    private function checkAddForm($data): array {
        $errores = $this->checkForm($data);

        $model = new \Com\Daw2\Models\PiezasModel();

        $piezaNombre = $model->loadByNombreOficial($data['nombreOficial']);
        if (!is_null($piezaNombre)) {
            $errores['nombreOficial'] = 'El nombre seleccionado ya está en uso';
        }

        $piezaCodigo = $model->loadByCodigoPieza($data['codigoPieza']);
        if (!is_null($piezaCodigo)) {
            $errores['codigoPieza'] = 'El nombre seleccionado ya está en uso';
        }

        return $errores;
    }

    /**
     * comprueba que el formulario de edicion este correcto
     * @param array $data los datos del formulario
     * @param int $idPieza la pieza que se quiere editar
     * @return array los errores encontrados
     */
    private function checkEditForm(array $data, int $idPieza): array {
        $errores = $this->checkForm($data);

        $model = new \Com\Daw2\Models\PiezasModel();

        $piezaNombre = $model->loadByNombreOficialNotId($data['nombreOficial'], $idPieza);
        if (!is_null($piezaNombre)) {
            $errores['nombreOficial'] = 'El nombre seleccionado ya está en uso';
        }

        $piezaCodigo = $model->loadByCodigoPiezaNotId($data['codigoPieza'], $idPieza);
        if (!is_null($piezaCodigo)) {
            $errores['codigoPieza'] = 'El nombre seleccionado ya está en uso';
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

        if (empty($data['codigoPieza'])) {
            $errores['codigoPieza'] = 'Inserte el código de la pieza';
        } else if (!preg_match('/^[a-zA-ZÀ-ÿ\u00f1\u00d10-9 ]{1,255}$/', $data['codigoPieza'])) {
            $errores['codigoPieza'] = 'El código debe ser menor a 255 caracteres y solo puede contener letras, números y espacios';
        }

        if (empty($data['nombreOficial'])) {
            $errores['nombreOficial'] = 'Inserte un nombre';
        } else if (!preg_match('/^[a-zA-ZÀ-ÿ\u00f1\u00d1 ]{1,255}$/', $data['nombreOficial'])) {
            $errores['nombreOficial'] = 'El nombre debe ser menor a 255 caracteres y solo puede contener letras y espacios';
        }

        if (empty($data['codigoMarca'])) {
            $errores['codigoMarca'] = 'Inserte el código de marca';
        } else if (!preg_match('/^[a-zA-Z0-9.]{1,20}$/', $data['codigoMarca'])) {
            $errores['codigoMarca'] = 'El nombre debe ser menor a 20 caracteres y solo puede contener letras, números y .';
        }

        if (empty($data['precio'])) {
            $errores['precio'] = 'Inserte el precio';
        } else if (!filter_var($data['precio'], FILTER_VALIDATE_FLOAT)) {
            $errores['precio'] = 'Valor incorrecto';
        }

        if (empty($data['stock'])) {
            $errores['stock'] = 'Inserte el stock';
        } else if (!filter_var($data['stock'], FILTER_VALIDATE_INT)) {
            $errores['stock'] = 'Valor incorrecto';
        }

        if (!empty($data['peso'])) {
            if (!filter_var($data['peso'], FILTER_VALIDATE_FLOAT)) {
                $errores['peso'] = 'Valor incorrecto.';
            }
        }

        if (!empty($data['longitud'])) {
            if (!filter_var($data['longitud'], FILTER_VALIDATE_FLOAT)) {
                $errores['longitud'] = 'Valor incorrecto.';
            }
        }

        if (!empty($data['observaciones'])) {
            if (!preg_match('/^[a-zA-ZÀ-ÿ\u00f1\u00d10-9,. ]{4,255}$/', $data['observaciones'])) {
                $errores['observaciones'] = 'El texto de observaciones debe estar entre 4 y 255 caracteres y solo puede contener letras, números y espacios';
            }
        }

        if (empty($data['idCategoria'])) {
            $errores['idCategoria'] = 'Por favor, seleccione una categoría';
        } else {
            $catmodel = new \Com\Daw2\Models\CategoriasModel();
            //comprueba que la categoría existe en la bbdd
            if (!filter_var($data['idCategoria'], FILTER_VALIDATE_INT) || is_null($catmodel->loadById((int) $data['idCategoria']))) {
                $errores['idCategoria'] = 'Valor incorrecto';
            }
        }

        return $errores;
    }

}

?>