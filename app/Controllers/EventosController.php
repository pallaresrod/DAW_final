<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

class EventosController extends \Com\Daw2\Core\BaseController {

    /**
     * muestra un listado con todos los eventos
     */
    function mostrarTodos() {
        $modelo = new \Com\Daw2\Models\EventosModel();

        $data = [];
        $data['titulo'] = 'Eventos';
        $data['eventos'] = $modelo->getAll();

        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
        }

        $this->view->showViews(array('templates/header.view.php', 'eventos.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * muestra el formulario para añadir un nuevo evento
     */
    function mostrarAdd() {
        $clientesModel = new \Com\Daw2\Models\ClientesModel();
        $clientes = $clientesModel->getAll();

        $data = array(
            'titulo' => 'Añadir evento',
            'clientes' => $clientes
        );

        $this->view->showViews(array('templates/header.view.php', 'addEvento.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * procesa la petición de añadir un nuevo evento
     */
    function procesarAdd() {
        //comprueba errores
        $errores = $this->checkForm($_POST);

        //si no hay errores se inserta el valor en la base de datos
        if (count($errores) == 0) {
            $model = new \Com\Daw2\Models\EventosModel();
            $insert = $model->insertEvento($_POST);

            //si la operación no se realizó con exito se crea un error desconocido que saldrá por pantalla
            if ($insert > 0) {
                header('location: /eventos');
                die;
            } else {
                $errores['desconocido'] = 'Error desconocido. No se ha insertado el evento.';
            }
        }

        $clientesModel = new \Com\Daw2\Models\ClientesModel();
        $clientes = $clientesModel->getAll();

        $data = array(
            'titulo' => 'Añadir evento',
            'input' => filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS),
            'clientes' => $clientes,
            'errores' => $errores
        );

        $this->view->showViews(array('templates/header.view.php', 'addEvento.view.php', 'templates/footer.view.php'), $data);
    }

    function mostrarEvento(int $id){
        
    }

    /**
     * procesa la petiión de borrar un evento
     * @param int $id el evento que se quiere borrar
     */
    function procesarDelete(int $id) {
        $model = new \Com\Daw2\Models\EventosModel();

        $errores = $this->checkDelete($id);

        if (count($errores) == 0) {
            if (!$model->delete($id)) {
                $mensaje = [];
                $mensaje['class'] = 'danger';
                $mensaje['texto'] = 'No se ha podido borrar el evento.';
            } else {
                $mensaje = [];
                $mensaje['class'] = 'success';
                $mensaje['texto'] = 'Evento eliminado con éxito.';
            }
        }else{
            $mensaje = [];
            $mensaje['class'] = 'danger';
            $mensaje['texto'] = $errores['mensaje'];
        }

        $_SESSION['mensaje'] = $mensaje;
        header('location: /eventos');
    }
    
    /**
     * comprueba que un evento no esté en proceso si se quiere borrar
     * @param int $idEvento el evento que se quiere borrar
     * @return array los errores encontrados
     */
    private function checkDelete(int $idEvento) : array{

        $modal = new \Com\Daw2\Models\EventosModel();
        $evento = $modal->loadById($idEvento);

        $fechaActual = new \DateTime();

        $errores = [];

        //si hay fechas reales lo comprobamos por ellas, pues son más específicas
        if (isset($evento['fechaInicioReal']) && isset($evento['fechaFinalReal'])) {

            $fechaInicioReal = new \DateTime($evento['fechaInicioReal']);
            $fechaFinalReal = new \DateTime($evento['fechaFinalReal']);

            if ($fechaFinalReal > $fechaActual && $fechaInicioReal < $fechaActual) {
                $errores['mensaje'] = 'El evento está en proceso. No se puede borrar.';
            }
        } else {

            $fechaInicioEstimada = new \DateTime($evento['fechaInicioEstimada']);
            $fechaFinalEstimada = new \DateTime($evento['fechaFinalEstimada']);

            if ($fechaFinalEstimada > $fechaActual && $fechaInicioEstimada < $fechaActual) {
                $errores['mensaje'] = 'Se ha estimado que el evento está en proceso. No se puede borrar.';
            }
        }

        return $errores;
    }

    /**
     * comprueba que el formulario no tenga errores
     * @param array $data los datos del formulario
     * @return array los errores encontrados
     */
    private function checkForm(array $data): array {
        $errores = [];

        if (empty($data['nombreEvento'])) {
            $errores['nombreEvento'] = 'Inserte un nombre';
        } else if (!preg_match('/^[a-zA-ZÀ-ÿ\u00f1\u00d10-9 ]{1,255}$/', $data['nombreEvento'])) {
            $errores['nombreEvento'] = 'El nombre debe ser menor a 255 caracteres y solo puede contener letras, números y espacios';
        }

        if (empty($data['lugarEvento'])) {
            $errores['lugarEvento'] = 'Inserte un lugar';
        } else if (!preg_match('/^[a-zA-ZÀ-ÿ\u00f1\u00d10-9\.\,\- ]{1,255}$/', $data['nombreEvento'])) {
            $errores['lugarEvento'] = 'El lugar debe ser menor a 255 caracteres. Solo puede contener letras, números, puntos, comas, guiones y espacios.';
        }

        if (empty($data['fechaInicioEstimada'])) {
            $errores['fechaInicioEstimada'] = 'Inserte una fecha de inicio estimada';
        } else if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['fechaInicioEstimada'])) {
            $errores['fechaInicioEstimada'] = 'El formato no es correcto.';
        } else {
            $fechaInicio = new \DateTime($data['fechaInicioEstimada']);
            $fechaActual = new \DateTime();
            if ($fechaInicio < $fechaActual) {
                $errores['fechaInicioEstimada'] = 'La fecha de inicio no puede ser anterior al día actual.';
            }
        }

        if (empty($data['fechaFinalEstimada'])) {
            $errores['fechaFinalEstimada'] = 'Inserte una fecha final estimada';
        } else if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['fechaFinalEstimada'])) {
            $errores['fechaFinalEstimada'] = 'El formato no es correcto.';
        } else {
            $fechaFinal = new \DateTime($data['fechaFinalEstimada']);
            if (isset($fechaInicio) && $fechaFinal < $fechaInicio) {
                $errores['fechaFinalEstimada'] = 'La fecha final no puede ser anterior a la fecha de inicio.';
            }
        }

        if (empty($data['idCliente'])) {
            $errores['idCliente'] = 'Por favor, seleccione un cliente';
        } else {
            $clientModel = new \Com\Daw2\Models\ClientesModel();
            //comprueba que la familia existe en la bbdd
            if (!filter_var($data['idCliente'], FILTER_VALIDATE_INT) || is_null($clientModel->loadById((int) $data['idCliente']))) {
                $errores['idCliente'] = 'Valor incorrecto';
            }
        }

        if (!empty($data['observaciones'])) {
            $observaciones = trim($data['observaciones']);
            if (!preg_match('/^[a-zA-ZÀ-ÿ\u00f1\u00d10-9 ]{1,255}$/', $data['observaciones'])) {
                $errores['observaciones'] = 'El campo observaciones debe ser menor a 255 caracteres y solo puede contener letras, números y espacios';
            }
        }

        return $errores;
    }

}

?>