<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class EventosModel extends \Com\Daw2\Core\BaseModel {

    /**
     * selecciona de las tabla eventos toda la informacion
     * @return array devuelve toda la info de los eventos
     */
    function getAll(): array {

        return $this->pdo->query("SELECT e.idEvento, e.nombreEvento, e.fechaInicioEstimada, e.fechaFinalEstimada, e.fechaFinalReal, e.lugarEvento, e.terminado, e.observaciones, "
                        . "c.idCliente, c.nombreFiscalCliente FROM evento e JOIN cliente c ON e.idCliente = c.idCliente ORDER BY e.terminado ASC, e.fechaInicioEstimada DESC")->fetchAll();
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
            'fechaInicioReal' => empty($data['fechaInicioReal']) ? null : $data['fechaInicioReal'],
            'fechaFinalReal' => empty($data['fechaFinalReal']) ? null : $data['fechaFinalReal'],
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
    function loadById(int $id): ?array {
        $query = "SELECT * FROM evento WHERE idEvento = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }

    /**
     * borra un evento
     * @param int $id el evento que se quiere borrar
     * @return bool true si se borra sin probelma, false si no
     */
    function delete(int $id): bool {
        $query = "DELETE FROM evento WHERE idEvento = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    /**
     * actualizar un evento para terminarlo
     * @param int $id el evento que se termina
     * @return bool true si se actualiza sin problema, false si no
     */
    function terminarEvento(int $id): bool {
        $query = "UPDATE evento SET terminado = 1 WHERE idEvento = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    /**
     * añade un registro de las piezas necesarias para un evento
     * @param array $data datos sobre el registro
     * @param int $idPieza la pieza que se mete
     * @param int $idEvento el evento en el que se usa
     * @return bool true si la operación se realiza con éxito, false si no
     */
    function addPiezasEvento(array $data, int $idPieza, int $idEvento): bool {
        $query = "INSERT INTO piezas_evento (idPieza, idEvento, cantidad, observaciones) VALUES (:idPieza, :idEvento, :cantidad, :observaciones)";
        $stmt = $this->pdo->prepare($query);
        $vars = [
            'idPieza' => $idPieza,
            'idEvento' => $idEvento,
            'cantidad' => $data['cantidad' . $idPieza],
            'observaciones' => trim($data['observaciones' . $idPieza])
        ];
        return $stmt->execute($vars);
    }

    /**
     * busca las piezas que están siedno utilizadas en un evento
     * @param int $idEvento el evento
     * @return array|null la info de las piezas is las encuentra, si no null
     */
    function piezasEvento(int $idEvento): ?array {
        $query = "SELECT pe.*, p.nombreOficial, p.stockActual FROM piezas_evento pe JOIN pieza p ON pe.idPieza=p.idPieza WHERE pe.idEvento = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$idEvento]);

        return $stmt->fetchAll();
    }

    /**
     * borra una peza de un evento
     * @param int $idEvento el evento de donde se borra
     * @param int $idPiezas la pieza que se borra
     * @return bool true si se realiza sin problemas, false si no
     */
    function removePiezasEvento(int $idEvento, int $idPieza): bool {
        $query = "DELETE FROM piezas_evento WHERE idPieza = ? AND idEvento = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$idPieza, $idEvento]);
        return $stmt->rowCount() > 0;
    }

    /**
     * busca eventos en los que se encuentre al cliente pasado como parámetro
     * @param int $id el cliente que se busca
     * @return array|null la info encontrada si la hay, null si no
     */
    function buscarCliente(int $id): ?array {
        $query = "SELECT * FROM evento WHERE idCliente= ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);

        return $stmt->fetchAll();
    }
    
    /**
     * busca eventos con la pieza pasada como parámetro
     * @param int $id la pieza que se busca
     * @return array|null la info encontrada si la hay, null si no
     */
    function buscarPieza(int $id): ?array{
        $query = "SELECT * FROM piezas_evento WHERE idPieza= ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);

        return $stmt->fetchAll();
    }

}

?>