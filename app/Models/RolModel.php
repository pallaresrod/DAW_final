<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class RolModel extends \Com\Daw2\Core\BaseModel {

    /*
     * devuelve info sobre los roles
     */
    function getAll(): array {
        return $this->pdo->query("SELECT * FROM rol")->fetchAll();
    }
    
    /**
     * devuelve el rol que coincida con el id que se pasa como parametro
     * @param int $id el id del rol que se quiere encontrar
     * @return array|null si se encuentra un rol se devuelve la fila con la info del rol en forma de array
     * si no hay rol con ese id se devuelve null
     */
    function loadRol(int $id): ?array {
        $stmt = $this->pdo->prepare('SELECT * FROM rol WHERE idRol=?');
        $stmt->execute([$id]);
        if($row = $stmt->fetch()){
            return $row;
        }
        else {
            return null;
        }
    }

}
