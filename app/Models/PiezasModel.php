<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class PiezasModel extends \Com\Daw2\Core\BaseModel {

    /**
     * selecciona de las tablas piezas, categoría y familia toda la informacion
     * @return array devuelve toda la info de las piezas
     */
    function getAll(): array {
        return $this->pdo->query("SELECT p.idPieza, p.codigoPieza, p.nombreOficial, p.precio, p.stock, p.stockActual,"
                        . " c.nombreCategoria, c.idCategoria, f.idFamilia, f.nombreFamilia FROM pieza p JOIN categoria c ON p.idCategoria = c.idCategoria"
                        . " JOIN familia f ON c.idFamilia = f.idFamilia ORDER BY p.nombreOficial")->fetchAll();
    }

    /** 
     * selecciona las piezas con el idFamilia e idCategoria que se pasan como parametros 
     * @param array $data los id de categoria y familia que se buscan
     * @return array las piezas que cumplen los requisitos
     */
    function getFiltros(array $data): array {
        $query = "SELECT p.idPieza, p.codigoPieza, p.nombreOficial, p.precio, p.stock, p.stockActual,"
                . " c.nombreCategoria, c.idCategoria, f.idFamilia, f.nombreFamilia FROM pieza p JOIN categoria c ON p.idCategoria = c.idCategoria"
                . " JOIN familia f ON c.idFamilia = f.idFamilia";

        $conditions = [];
        $vars = [];

        if (!empty($data['idCategoria'])) {
            $conditions[] = "c.idCategoria = :idCategoria";
            $vars['idCategoria'] = $data['idCategoria'];
        }

        if (!empty($data['idFamilia'])) {
            $conditions[] = "c.idFamilia = :idFamilia";
            $vars['idFamilia'] = $data['idFamilia'];
        }

        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($vars);

        return $stmt->fetchAll();
    }

    /**
     * busca una pieza por el id
     * @param int $idPieza la pieza que se busca
     * @return array|null la fila en fora de array si la encuentra, null si no
     */
    function loadById(int $idPieza): ?array {
        $query = "SELECT p.*, c.idFamilia FROM pieza p JOIN categoria c ON p.idCategoria = c.idCategoria WHERE idPieza = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$idPieza]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }
    
    /**
     * Busca una pieza con el nombre oficial pasado como parametro, que no tengal el id pasado como parametro
     * @param string $nombre el nombre que se busca
     * @param int $id el id que no debe coincidir
     * @return array|null devuelve la fila en modo array si la encuentra, null si no
     */
    function loadByNombreOficialNotId(string $nombre, int $id): ?array {
        $query = "SELECT * FROM pieza WHERE nombreOficial = ? AND idPieza != ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$nombre, $id]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }
    
    /**
     * Busca una pieza con el codigo de pieza pasado como parametro, que no tengal el id pasado como parametro
     * @param string $codigo el codigo que se busca
     * @param int $id el id que no debe coincidir
     * @return array|null devuelve la fila en modo array si la encuentra, null si no
     */
    function loadByCodigoPiezaNotId(string $codigo, int $id): ?array {
        $query = "SELECT * FROM pieza WHERE codigoPieza = ? AND idPieza != ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$codigo, $id]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }
    
    /**
     * actualiza una pieza
     * @param int $idPieza la pieza que se actualiza
     * @param array $data los datos de la pieza
     * @return bool true si se realiza sin problema, false si no
     */
    function updatePieza(int $idPieza, array $data): bool {
        $query = "UPDATE pieza SET codigoPieza= :codigoPieza, nombreOficial= :nombreOficial, codigoMarca= :codigoMarca, precio= :precio,"
                . " stock= :stock, peso= :peso, longitud= :longitud, observaciones= :observaciones, idCategoria= :idCategoria WHERE idPieza= :idPieza";
        
        $stmt = $this->pdo->prepare($query);
        $vars = [
            'codigoPieza' => $data['codigoPieza'],
            'nombreOficial' => trim($data['nombreOficial']),
            'codigoMarca' => $data['codigoMarca'],
            'precio' => $data['precio'],
            'stock' => $data['stock'],
            'peso' => $data['peso'],
            'longitud' => $data['longitud'],
            'observaciones' => trim($data['observaciones']),
            'idCategoria' => $data['idCategoria'],
            'idPieza' => $idPieza
        ];
        return $stmt->execute($vars);
    }
}

?>