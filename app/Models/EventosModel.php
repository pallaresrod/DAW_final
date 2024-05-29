<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class EventosModel extends \Com\Daw2\Core\BaseModel {
    
    /**
     * selecciona de las tabla eventos toda la informacion
     * @return array devuelve toda la info de los eventos
     */
    function getAll(): array {
        
        return $this->pdo->query("SELECT e.idEvento, e.nombreEvento, e.fechaInicioEstimada, e.fechaFinalEstimada, e.fechaFinalReal, e.lugarEvento, e.observaciones, "
                . "c.idCliente, c.nombreFiscalCliente FROM evento e JOIN cliente c ON e.idCliente = c.idCliente ORDER BY fechaInicioEstimada DESC")->fetchAll();
    }
    
    /**
     * añade un evento a la base de datps
     * @param array $data los datos del evento
     * @return int 1 si se añade sin problema, 0 si no
     */
    function insertEvento(array $data): int {
        $query = "INSERT INTO evento (nombreEvento, fechaInicioEstimada, fechaFinalEstimada, lugarEvento, observaciones, idCliente) "
                . "VALUES (:nombreEvento, :fechaInicioEstimada, :fechaFinalEstimada, :lugarEvento, :observaciones, :idCliente)";
        $stmt = $this->pdo->prepare($query);
        $vars = [
            'nombreEvento' => $data['nombreEvento'],
            'fechaInicioEstimada' => $data['fechaInicioEstimada'],
            'fechaFinalEstimada' => $data['fechaFinalEstimada'],
            'lugarEvento' => $data['lugarEvento'],
            'observaciones' => trim($data['observaciones']),
            'idCliente' => $data['idCliente']
        ];
        if ($stmt->execute($vars)) {
            return 1;
        } else {
            return 0;
        }
    }
    
    /**
     * actualiza los datos de un evento
     * @param int $idEvento el evento que se actualiza
     * @param array $data los datos del evento
     * @return bool true si se actualiza, false si no
     */
    function updateEvento(int $idEvento, array $data): bool {
        $query = "UPDATE evento SET nombreEvento=:nombreEvento, fechaInicioEstimada=:fechaInicioEstimada, "
                . "fechaFinalEstimada=:fechaFinalEstimada, fechaInicioReal=:fechaInicioReal, fechaFinalReal=:fechaFinalReal, "
                . "lugarEvento=:lugarEvento, observaciones=:observaciones, idCliente=:idCliente WHERE idEvento=:idEvento";
        $stmt = $this->pdo->prepare($query);
        $vars = [
            'nombreEvento' => $data['nombreEvento'],
            'fechaInicioEstimada' => $data['fechaInicioEstimada'],
            'fechaFinalEstimada' => $data['fechaFinalEstimada'],
            'fechaInicioReal' => empty($data['fechaInicioReal'])? null : $data['fechaInicioReal'],
            'fechaFinalReal' => empty($data['fechaFinalReal'])? null : $data['fechaFinalReal'],
            'lugarEvento' => $data['lugarEvento'],
            'observaciones' => trim($data['observaciones']),
            'idCliente' => $data['idCliente'],
            'idEvento' => $idEvento
        ];
        return $stmt->execute($vars);
    }
    
    /**
     * busca un evento en especifico
     * @param int $id el evento que se busca
     * @return array|null devuelve la fila en modo array si la encuentra, null si no
     */
    function loadById(int $id): ?array{
        $query = "SELECT * FROM evento WHERE idEvento = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }
    
    function delete(int $id): bool {
        $query = "DELETE FROM evento WHERE idEvento = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
    
}
?>