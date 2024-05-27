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
    
}
?>