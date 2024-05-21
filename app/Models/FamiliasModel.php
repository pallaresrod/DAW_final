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
     * inserta una familia en la base de datos
     * @param array $data los datos de la familia
     * @return int devuelve 1 si la operación se realizo sin problema, 0 si no
     */
    function insertFamilia(array $data): int {
        $query = "INSERT INTO familia (nombreFamilia, descripcion) VALUES(:nombreFamilia, :descripcion)";
        $stmt = $this->pdo->prepare($query);
        $vars = [
            'nombreFamilia' => $data['nombre'],
            'descripcion' => $data['descripcion']
        ];
        if ($stmt->execute($vars)) {
            return 1;
        } else {
            return 0;
        }
    }
    

}
