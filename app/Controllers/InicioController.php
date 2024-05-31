<?php

namespace Com\Daw2\Controllers;

class InicioController extends \Com\Daw2\Core\BaseController {

    public function index() {
        
        $modeloPiezas = new \Com\Daw2\Models\PiezasModel();
        $modeloEventos = new \Com\Daw2\Models\EventosModel();
        $modeloClientes = new \Com\Daw2\Models\ClientesModel();
        
        $modelo = new \Com\Daw2\Models\UsuariosModel();
        $usuario = $modelo->loadById($_SESSION['usuario']['idUsuario']);
        
        $data = array(
            'titulo' => 'Página de inicio',
            'eventos' => $modeloEventos->getEventosNoTerminados(),
            'piezasEnUso' => $modeloPiezas->getPiezasEnUso(),
            'piezasDisponibles' => $modeloPiezas->getPiezasDisponibles(),
            'clientes' => $modeloClientes->getAll(),
            'actividad' => $modelo->getActivity($_SESSION['usuario']['idUsuario'])
        );
        
        $this->view->showViews(array('templates/header.view.php', 'inicio.view.php', 'templates/footer.view.php'), $data);
    }

}

?>