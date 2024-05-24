<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class ClientesController extends \Com\Daw2\Core\BaseController {

    /**
     * muestra un listado con todos los clientes
     */
    function mostrarTodos() {
        $modelo = new \Com\Daw2\Models\ClientesModel();

        $data = [];
        $data['titulo'] = 'Clientes';
        $data['clientes'] = $modelo->getAll();

        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
        }

        $this->view->showViews(array('templates/header.view.php', 'clientes.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * muestra el formulario para añadir un cliente
     */
    function mostrarAdd() {

        $data = array(
            'titulo' => 'Añadir cliente'
        );

        $this->view->showViews(array('templates/header.view.php', 'addCliente.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * procesa la petición de añadir una nueva categoria
     */
    function procesarAdd() {
        //comprueba errores
        $errores = $this->checkAddForm($_POST);

        //si no hay errores se inserta el valor en la base de datos
        if (count($errores) == 0) {
            $model = new \Com\Daw2\Models\ClientesModel();
            $insert = $model->insertCliente($_POST);

            //si la operación no se realizó con exito se crea un error desconocido que saldrá por pantalla
            if ($insert > 0) {
                header('location: /clientes');
                die;
            } else {
                $errores['desconocido'] = 'Error desconocido. No se ha insertado el cliente.';
            }
        }


        $data = array(
            'titulo' => 'Añadir cliente',
            'input' => filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS),
            'errores' => $errores
        );

        $this->view->showViews(array('templates/header.view.php', 'addCliente.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * procesa la petición de borrar un cliente
     * @param int $idCliente el cliente que se quiere borrar
     */
    function processDelete(int $idCliente) {
        $model = new \Com\Daw2\Models\ClientesModel();

        if (!$model->delete($idCliente)) {
            $mensaje = [];
            $mensaje['class'] = 'danger';
            $mensaje['texto'] = 'No se ha podido borrar la categoría.';
        } else {
            $mensaje = [];
            $mensaje['class'] = 'success';
            $mensaje['texto'] = 'Categoría eliminada con éxito.';
        }

        $_SESSION['mensaje'] = $mensaje;
        header('location: /clientes');
    }
    
    function mostrarCliente(int $idCliente) {
        $modelo = new \Com\Daw2\Models\ClientesModel();

        $cliente = $modelo->loadById($idCliente);

        //al compartir vista con edit necesitamos una manera de que si esta viendo el cliente no lo pueda editar
        $readOnly = true;

        $data = array(
            'titulo' => 'Información de cliente',
            'input' => $cliente,
            'readonly' => $readOnly
        );

        $this->view->showViews(array('templates/header.view.php', 'editViewCliente.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * Comprueba que el formulario esta bien
     * @param array $data los datos del formulario
     * @return array los errores encontrados
     */
    private function checkForm(array $data): array {

        $errores = [];

        if (empty($data['nombreFiscalCliente'])) {
            $errores['nombreFiscalCliente'] = 'Inserte el nombre fiscal';
        } else if (!preg_match('/^[a-zA-ZÀ-ÿ\u00f1\u00d1\.\,\- ]{1,255}$/', $data['nombreFiscalCliente'])) {
            $errores['nombreFiscalCliente'] = 'El nombre debe ser menor a 255 caracteres y solo puede contener letras, espacios, puntos, comas y guiones';
        }

        if (empty($data['email'])) {
            $errores['email'] = 'Inserte un email';
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = 'Inserte un email válido';
        }

        if (empty($data['denominacion'])) {
            $errores['denominacion'] = 'Inserte una descripción';
        } else if (!preg_match('/^[a-zA-ZÀ-ÿ\u00f1\u00d1\.\,\-\(\) ]{1,255}$/', $data['denominacion'])) {
            $errores['denominacion'] = 'La descripción debe estar entre 4 y 255 caracteres y solo puede contener letras, espacios, puntos, comas, guiones y parénteis';
        }

        if (empty($data['cifCliente'])) {
            $errores['cifCliente'] = 'Inserte el CIF';
        } else if (!preg_match('/^[a-zA-Z0-9]{1,10}$/', $data['cifCliente'])) {
            $errores['cifCliente'] = 'El CIF no es correcto. Este solo puede contener letras y números';
        }

        if (empty($data['direccion'])) {
            $errores['direccion'] = 'Inserte la dirección';
        } else if (!preg_match('/^[a-zA-ZÀ-ÿ\u00f1\u00d10-9\.\,\- ]{1,255}$/', $data['direccion'])) {
            $errores['direccion'] = 'La dirección debe ser menor a 255 caracteres. Solo puede contener letras, números, puntos, comas, guiones y espacios.';
        }

        return $errores;
    }

    /**
     * comprueba que el formulario e añadir cliente este correcto
     * @param array $data los datos del formulario
     * @return array los errores encontrados
     */
    private function checkAddForm(array $data): array {

        $errores = $this->checkForm($data);

        $model = new \Com\Daw2\Models\ClientesModel();

        $nombre = $model->loadByNombreFiscal($data['nombreFiscalCliente']);
        if (!is_null($nombre)) {
            $errores['nombreFiscalCliente'] = 'El nombre introducido ya está en uso';
        }

        $denom = $model->loadByDenominacion($data['denominacion']);
        if (!is_null($denom)) {
            $errores['denominacion'] = 'La denominacion introducida ya está en uso';
        }

        $cif = $model->loadByCif($data['cifCliente']);
        if (!is_null($cif)) {
            $errores['denominacion'] = 'El cif introducido ya está en uso';
        }

        return $errores;
    }

}

?>