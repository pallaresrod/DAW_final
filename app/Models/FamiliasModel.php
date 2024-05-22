<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class FamiliasModel extends \Com\Daw2\Core\BaseModel {

    /**
     * selecciona de la tabla familia todas las familias
     * @return array devuelve toda la info de las familias
     */
    function getAll(): array {
        return $this->pdo->query("SELECT * FROM familia ORDER BY nombreFamilia")->fetchAll();
    }
    
    /**
     * busca una familia que tenga el nombre pasado como parametro
     * @param string $name el nombre que se busca
     * @return array|null devuelve la fila de info en modo array si la encuentra, null si no
     */
    function loadByName(string $name): ?array {
        $query = "SELECT * FROM familia WHERE nombreFamilia = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$name]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }
    
    /**
     * busca una familia con el id pasado como parametro
     * @param int $idFamilia el id que se busca
     * @return array|null devuelve la fila de info en forma de array si la encuentra, null si no
     */
    function loadById(int $idFamilia): ?array {
        $query = "SELECT * FROM familia WHERE idFamilia = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$idFamilia]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }
    
    /**
     * inserta una familia en la base de datos
     * @param array $data los datos de la familia
     * @return int devuelve 1 si la operación se realizo sin problema, 0 si no
     */
    function insertFamilia(array $data): int {
        $query = "INSERT INTO familia (nombreFamilia, descripcion) VALUES(:nombreFamilia, :descripcion)";
        $stmt = $this->pdo->prepare($query);
        $vars = [
            'nombreFamilia' => $data['nombreFamilia'],
            'descripcion' => trim($data['descripcion'])
        ];
        if ($stmt->execute($vars)) {
            return 1;
        } else {
            return 0;
        }
    }
    
    /**
     * borrar una familia
     * @param int $id la familia ha borrar
     * @return bool true si la borra sin problema, false si no
     */
    function delete(int $id): bool {
        $query = "DELETE FROM familia WHERE idFamilia = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
    
    /**
     * busca una familia con el nombre pasado como parametro y que no coincida con el id
     * @param string $nombre el nombre que se busca
     * @param int $id el id que no debe coincidir
     * @return array|null devuelve la fila en modo array si la encuentra, null si no
     */
    function loadByNameNotId(string $nombre, int $id): ?array {
        $query = "SELECT * FROM familia WHERE nombreFamilia = ? AND idFamilia != ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$nombre, $id]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }
    
    /**
     * actualiza los datos de una familia
     * @param int $idFamilia la familia que se actualiza
     * @param array $data los datos
     * @return bool devuelve true si la operación se realizó con éxito, false si no
     */
    function updateFamilia(int $idFamilia, array $data): bool {
        $query = "UPDATE familia SET nombreFamilia=:nombre, descripcion=:descripcion WHERE idFamilia=:idFamilia";
        $stmt = $this->pdo->prepare($query);
        $vars = [
            'nombre' => $data['nombreFamilia'],
            'descripcion' => trim($data['descripcion']),
            'idFamilia' => $idFamilia
        ];
        return $stmt->execute($vars);
    }
    
}
?>