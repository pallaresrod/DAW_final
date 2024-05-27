<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class CategoriasModel extends \Com\Daw2\Core\BaseModel {

    /**
     * selecciona de las tablas categoria y familia toda la informacion
     * @return array devuelve toda la info de las familias
     */
    function getAll(): array {
        return $this->pdo->query("SELECT c.idCategoria, c.nombreCategoria, c.descripcion, f.nombreFamilia, f.idFamilia "
                        . "FROM categoria c LEFT JOIN familia f ON c.idFamilia = f.idFamilia ORDER BY c.nombreCategoria")->fetchAll();
    }

    /**
     * selecciona las categorias que con el idFamilia que se pasa como parametro
     * @param int $idFamilia la familia que se busca
     * @return array las categorías que cumplen los requisitos
     */
    function getFiltros(int $idFamilia): array {
        $query = "SELECT c.idCategoria, c.nombreCategoria, c.descripcion, f.nombreFamilia, f.idFamilia "
                . "FROM categoria c LEFT JOIN familia f ON c.idFamilia = f.idFamilia WHERE c.idFamilia = ? ORDER BY c.nombreCategoria";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$idFamilia]);

        return $stmt->fetchAll();
    }

    /**
     * busca una categoria con el nombre pasado como parametro
     * @param string $name el nombre que se busca
     * @return array|null la fila en modo array si la encuentra, null si no
     */
    function loadByName(string $name): ?array {
        $query = "SELECT * FROM categoria WHERE nombreCategoria = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$name]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }

    /**
     * busca una categoria con el id pasado como parametro
     * @param int $idCategoria el id que se busca
     * @return array|null devuelve la fila en modo array si se encuentra, null si no
     */
    function loadById(int $idCategoria): ?array {
        $query = "SELECT * FROM categoria WHERE idCategoria = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$idCategoria]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }

    /**
     * inserta una nueva categoria a la base de datos
     * @param array $data los datos de la categoria
     * @return int devuelve 1 si se hace correctamente, 0 si no
     */
    function insertCategoria(array $data): int {
        $query = "INSERT INTO categoria (nombreCategoria, descripcion, idFamilia) VALUES (:nombreCategoria, :descripcion, :idFamilia)";
        $stmt = $this->pdo->prepare($query);
        $vars = [
            'nombreCategoria' => $data['nombreCategoria'],
            'descripcion' => trim($data['descripcion']),
            'idFamilia' => $data['idFamilia']
        ];
        if ($stmt->execute($vars)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * busca una categoria con el nombre que se pasa como parametro pero no con el id
     * @param string $nombre el nombre que se busca
     * @param int $id el id que no debe coincidir
     * @return array|null la fila en modo array si se encuentra, null si no
     */
    function loadByNameNotId(string $nombre, int $id): ?array {
        $query = "SELECT * FROM categoria WHERE nombreCategoria = ? AND idCategoria != ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$nombre, $id]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }

    /**
     * actualiza una categoria
     * @param int $idCategoria la categoria que se actualiza
     * @param array $data los datos de la categoria
     * @return bool true si se realizó con éxito, false si no
     */
    function updateCategoria(int $idCategoria, array $data): bool {
        $query = "UPDATE categoria SET nombreCategoria=:nombre, descripcion=:descripcion, idFamilia=:idFamilia WHERE idCategoria=:idCategoria";
        $stmt = $this->pdo->prepare($query);
        $vars = [
            'nombre' => $data['nombreCategoria'],
            'descripcion' => trim($data['descripcion']),
            'idFamilia' => $data['idFamilia'],
            'idCategoria' => $idCategoria
        ];
        return $stmt->execute($vars);
    }

    /**
     * borrar una categoria
     * @param int $id la categoria ha borrar
     * @return bool true si la borra sin problema, false si no
     */
    function delete(int $id): bool {
        $query = "DELETE FROM categoria WHERE idCategoria = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
    
    /**
     * busca las categorias que pertenecen a una familia
     * @param int $id la familia que se busca
     * @return array|null las categorias si las hay, null si no
     */
    function buscarFam(int $id): ?array{
        $query = "SELECT * FROM categoria WHERE idFamilia= ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        
        return $stmt->fetchAll();
    }

}

?>