<?php
declare(strict_types=1);

namespace Com\Daw2\Core;

use \PDO; 

abstract class BaseModel {
    
    //almacenará la instancia PDO
    protected $pdo;

    //obtiene una instancia de conexión PDO y la asigna a la propiedad $pdo
    function __construct() {
        $this->pdo = DBManager::getInstance()->getConnection();      
    }
}

?>