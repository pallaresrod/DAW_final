<?php
declare(strict_types = 1);
namespace Com\Daw2\Controllers;

class ErroresController extends \Com\Daw2\Core\BaseController {

    function error404() : void{
       http_response_code(404);
       $data = ['titulo' => 'Error 404'];
       $data['texto'] = '404. La página que buscas no se ha encontrado';
       $this->view->showViews(array('templates/header.view.php', 'error.view.php', 'templates/footer.view.php') , $data);
    }
    
    function error405() : void{
       http_response_code(405);
       $data = ['titulo' => 'Error 405'];
       $data['texto'] = '405. Método no permitido';
       
       $this->view->showViews(array('templates/header.view.php', 'error.view.php', 'templates/footer.view.php') , $data);
    }
}
?>