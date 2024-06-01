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

    /**
     * muestra la info sobre un evento
     * @param int $id el evento que se esta viendo
     */
    function mostrarEvento(int $id) {
        $modelo = new \Com\Daw2\Models\EventosModel();
        $modeloCli = new \Com\Daw2\Models\ClientesModel();

        $evento = $modelo->loadById($id);
        $clientes = $modeloCli->getAll();

        $piezas = $modelo->piezasEvento($id);

        //al compartir vista con edit necesitamos una manera de que si esta viendo la categoría no la pueda editar
        $readOnly = true;

        $data = array(
            'titulo' => 'Información de evento',
            'input' => $evento,
            'readonly' => $readOnly,
            'clientes' => $clientes,
            'piezas' => $piezas
        );

        $this->view->showViews(array('templates/header.view.php', 'editViewEvento.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * procesa la petición para dar un evento como terminado
     * @param int $id el evento que se quiere terminar
     */
    function terminarEvento(int $id) {

        $modelo = new \Com\Daw2\Models\EventosModel();
        $modeloPiezas = new \Com\Daw2\Models\PiezasModel();

        $piezas = $modelo->piezasEvento($id);

        $errores = $this->checkDelete($id);

        if (count($errores) == 0) {
            foreach ($piezas as $p) {
                $stockNuevo = $p['cantidad'] + $p['stockActual'];
                $modeloPiezas->updateStock($p['idPieza'], $stockNuevo);
                $modelo->removePiezasEvento($id, $p['idPieza']);
            }

            $terminar = $modelo->terminarEvento($id);

            $mensaje = [];
            if ($terminar) {
                $mensaje['class'] = 'success';
                $mensaje['texto'] = 'El evento se ha dado por terminado.';
            } else {
                $mensaje['class'] = 'danger';
                $mensaje['texto'] = 'Error desconocido. No se ha dado el evento por terminado.';
            }
        } else {
            $mensaje = [];
            $mensaje['class'] = 'danger';
            $mensaje['texto'] = $errores['mensaje'];
        }

        $_SESSION['mensaje'] = $mensaje;
        header('location: /eventos');
    }

    /**
     * muestra el formulario para editar un evento
     * @param int $id el evento que se quiere editar
     */
    function mostrarEdit(int $id) {
        $modelo = new \Com\Daw2\Models\EventosModel();
        $modeloCli = new \Com\Daw2\Models\ClientesModel();

        $evento = $modelo->loadById($id);

        if ($evento['terminado'] == 1) {
            $mensaje = [];
            $mensaje['class'] = 'danger';
            $mensaje['texto'] = 'El evento ya terminó. No se puede editar';
            $_SESSION['mensaje'] = $mensaje;
            header('location: /eventos');
        } else {
            $clientes = $modeloCli->getAll();
            $eventoId = $evento['idEvento'];

            //al compartir vista con edit necesitamos una manera de que si esta viendo la categoría no la pueda editar
            $readOnly = false;

            $data = array(
                'titulo' => 'Editar evento',
                'input' => $evento,
                'idEvento' => $eventoId,
                'readonly' => $readOnly,
                'clientes' => $clientes
            );

            $this->view->showViews(array('templates/header.view.php', 'editViewEvento.view.php', 'templates/footer.view.php'), $data);
        }
    }

    /**
     * procesa la petición de editar un evento
     * @param int $id
     */
    function procesarEdit(int $id) {
        $errores = $this->checkEditForm($_POST);
        $model = new \Com\Daw2\Models\EventosModel();
        
        //si no hay errores se actualiza el valor en la base de datos
        if (count($errores) == 0) {
            $update = $model->updateEvento($id, $_POST);

            //si la operación no se realizó con exito se crea un error desconocido que saldrá por pantalla
            if ($update > 0) {
                header('location: /eventos');
            } else {
                $errores['desconocido'] = 'Error desconocido. No se ha editado el evento.';
            }
        }
        $modeloCli = new \Com\Daw2\Models\ClientesModel();

        $readOnly = false;
        $evento = $model->loadById($id);
        $clientes = $modeloCli->getAll();
        $eventoId = $evento['idEvento'];

        $data = array(
            'titulo' => 'Editar evento',
            'input' => filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS),
            'idEvento' => $eventoId,
            'errores' => $errores,
            'readonly' => $readOnly,
            'clientes' => $clientes
        );

        $this->view->showViews(array('templates/header.view.php', 'editViewEvento.view.php', 'templates/footer.view.php'), $data);
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
        } else {
            $mensaje = [];
            $mensaje['class'] = 'danger';
            $mensaje['texto'] = $errores['mensaje'];
        }

        $_SESSION['mensaje'] = $mensaje;
        header('location: /eventos');
    }

    /**
     * muestra la patalla para añadir piezas a un evento
     * @param int $idEvento el evento al que se quieren añadir las piezas
     */
    function mostrarAñadirPiezas(int $idEvento) {
        $piezasModel = new \Com\Daw2\Models\PiezasModel();
        $piezas = $piezasModel->getAll();

        $eventoModel = new \Com\Daw2\Models\EventosModel();
        $evento = $eventoModel->loadById($idEvento);

        if ($evento['terminado'] == 1) {
            $mensaje = [];
            $mensaje['class'] = 'danger';
            $mensaje['texto'] = 'El evento ya terminó. No se puede añadir piezas';
            $_SESSION['mensaje'] = $mensaje;
            header('location: /eventos');
        } else {
            $data = array(
                'titulo' => 'Piezas para el evento',
                'evento' => $evento,
                'piezas' => $piezas
            );

            $this->view->showViews(array('templates/header.view.php', 'addPiezasEvento.view.php', 'templates/footer.view.php'), $data);
        }
    }

    /**
     * procesa la petición de añadir piezas a un evento
     * @param int $idEvento el evento al que se añaden las piezas
     */
    function procesarAñadirPiezas(int $idEvento) {
        $errores = $this->checkPiezas($_POST);

        $model = new \Com\Daw2\Models\EventosModel();
        $piezasModel = new \Com\Daw2\Models\PiezasModel();

        $piezas = $piezasModel->getAll();

        //si no hay errores se actualiza el valor en la base de datos
        if (count($errores) == 0) {

            foreach ($piezas as $p) {
                if (!empty($_POST['cantidad' . $p['idPieza']])) {

                    $add = $model->addPiezasEvento($_POST, $p['idPieza'], $idEvento);

                    $nuevoStock = isset($p['stockActual']) ? $p['stockActual'] - $_POST['cantidad' . $p['idPieza']] : $p['stock'] - $_POST['cantidad' . $p['idPieza']];
                    $piezasModel->updateStock($p['idPieza'], $nuevoStock);
                }
            }

            //si la operación no se realizó con exito se crea un error desconocido que saldrá por pantalla
            if ($add > 0) {
                header('location: /eventos');
            } else {
                $errores['desconocido'] = 'Error desconocido. No se ha realizado la operación.';
            }
        }

        $evento = $model->loadById($idEvento);

        $data = array(
            'titulo' => 'Piezas para el evento',
            'input' => $_POST,
            'errores' => $errores,
            'evento' => $evento,
            'piezas' => $piezas
        );

        $this->view->showViews(array('templates/header.view.php', 'addPiezasEvento.view.php', 'templates/footer.view.php'), $data);
    }

    /**
     * comprueba que los datos insertados para añadir las piezas a un evento sean correctos
     * @param array $data los datos que se comprueban
     * @return array los errores encontrados
     */
    private function checkPiezas(array $data): array {

        $errores = [];

        $piezasModel = new \Com\Daw2\Models\PiezasModel();
        $piezas = $piezasModel->getAll();

        foreach ($piezas as $p) {
            if (!empty($data['cantidad' . $p['idPieza']])) {
                if (!filter_var($data['cantidad' . $p['idPieza']], FILTER_VALIDATE_FLOAT)) {
                    $errores['cantidad' . $p['idPieza']] = 'Valor incorrecto';
                } else {
                    if (isset($p['stockActuak'])) {
                        if ($data['cantidad' . $p['idPieza']] > $p['stockActuak']) {
                            $errores['cantidad' . $p['idPieza']] = 'La cantidad de stock introducida no está disponible';
                        }
                    } else if ($data['cantidad' . $p['idPieza']] > $p['stock']) {
                        $errores['cantidad' . $p['idPieza']] = 'La cantidad de stock introducida no está disponible';
                    }
                }
            }
            if (!empty($data['observaciones' . $p['idPieza']])) {
                if (!preg_match('/^[a-zA-ZÀ-ÿ\u00f1\u00d10-9,. ]{1,255}$/', $data['observaciones' . $p['idPieza']])) {
                    $errores['observaciones' . $p['idPieza']] = 'El texto de observaciones debe ser menor a 255 caracteres y solo puede contener letras, números y espacios';
                }
            }
        }

        return $errores;
    }

    /**
     * comprueba que un evento no esté en proceso si se quiere borrar
     * @param int $idEvento el evento que se quiere borrar
     * @return array los errores encontrados
     */
    private function checkDelete(int $idEvento): array {

        $modal = new \Com\Daw2\Models\EventosModel();
        $evento = $modal->loadById($idEvento);

        $fechaActual = new \DateTime();

        $errores = [];

        //si hay fechas reales lo comprobamos por ellas, pues son más específicas
        if (isset($evento['fechaInicioReal']) && isset($evento['fechaFinalReal'])) {

            $fechaInicioReal = new \DateTime($evento['fechaInicioReal']);
            $fechaFinalReal = new \DateTime($evento['fechaFinalReal']);

            if ($fechaFinalReal > $fechaActual && $fechaInicioReal < $fechaActual) {
                $errores['mensaje'] = 'No se puede realizar la acción. El evento está en proceso.';
            }
        } else {

            $fechaInicioEstimada = new \DateTime($evento['fechaInicioEstimada']);
            $fechaFinalEstimada = new \DateTime($evento['fechaFinalEstimada']);

            if ($fechaFinalEstimada > $fechaActual && $fechaInicioEstimada < $fechaActual) {
                $errores['mensaje'] = 'No se puede realizar la acción. Se ha estimado que el evento está en proceso.';
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

    /**
     * comprueba que el formulario de editar un evento sea correcto
     * @param type $data los datos del formulario
     * @return array los errores encontrados
     */
    private function checkEditForm($data): array {
        $errores = $this->checkForm($data);

        if (!empty($data['fechaInicioReal'])) {
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['fechaInicioReal'])) {
                $errores['fechaInicioReal'] = 'El formato no es correcto.';
            } else {
                $fechaInicio = new \DateTime($data['fechaInicioReal']);
                $fechaActual = new \DateTime();
                if ($fechaInicio < $fechaActual) {
                    $errores['fechaInicioReal'] = 'La fecha de inicio no puede ser anterior al día actual.';
                }
            }
        }

        if (!empty($data['fechaFinalReal'])) {
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['fechaFinalReal'])) {
                $errores['fechaFinalReal'] = 'El formato no es correcto.';
            } else {
                $fechaFinal = new \DateTime($data['fechaFinalReal']);
                if (isset($fechaInicio) && $fechaFinal < $fechaInicio) {
                    $errores['fechaFinalReal'] = 'La fecha final no puede ser anterior a la fecha de inicio.';
                }
            }
        }
        return $errores;
    }

}

?>