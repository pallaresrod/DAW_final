<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class CategoriasModel extends \Com\Daw2\Core\BaseModel {

    /**
     * selecciona de las tablas categoria y familia toda la informacion
     * @return array devuelve toda la info de las familias
     */
    function getAll(): array {
        return $this->pdo->query("SELECT * FROM categoria c LEFT JOIN familia f ON c.idFamilia = f.idFamilia ORDER BY c.nombreCategoria")->fetchAll();
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
     * inserta una nueva categoria a la base de datos
     * @param array $data los datos de la categoria
     * @return int devuelve 1 si se hace correctamente, 0 si no
     */
    function insertCategoria(array $data): int {
        $query = "INSERT INTO categoria (nombreCategoria, descripcion, idFamilia) VALUES(:nombreFamilia, :descripcion, :idFamilia)";
        $stmt = $this->pdo->prepare($query);
        $vars = [
            'nombreFamilia' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'idFamilia' => $data['idFamilia']
        ];
        if ($stmt->execute($vars)) {
            return 1;
        } else {
            return 0;
        }
    }
   
}
 ?>