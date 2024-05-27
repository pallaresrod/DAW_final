<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class EventosModel extends \Com\Daw2\Core\BaseModel {
    
    /**
     * selecciona de las tabla eventos toda la informacion
     * @return array devuelve toda la info de los eventos
     */
    function getAll(): array {
        
        return $this->pdo->query("SELECT e.idEvento, e.nombreEvento, e.fechaInicioEstimada, e.fechaFinalEstimada, e.lugarEvento, e.observaciones, "
                . "c.idCliente, c.nombreFiscalCliente FROM evento e JOIN cliente c ON e.idCliente = c.idCliente ORDER BY fechaInicioReal DESC")->fetchAll();
    }
    
}
?>