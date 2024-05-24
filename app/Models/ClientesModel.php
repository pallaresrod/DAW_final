<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class ClientesModel extends \Com\Daw2\Core\BaseModel {
    
    /**
     * selecciona de las tabla cliente toda la informacion
     * @return array devuelve toda la info de los clientes
     */
    function getAll(): array {
        return $this->pdo->query("SELECT * FROM cliente ORDER BY nombreFiscalCliente")->fetchAll();
    }
    
    /**
     * busca un cliente con el nombre fiscal que se pasa como parametro
     * @param string $name el nombre que se busca
     * @return array|null la fila en forma de array si se encuentra, null si no
     */
    function loadByNombreFiscal(string $name): ?array {
        $query = "SELECT * FROM cliente WHERE nombreFiscalCliente = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$name]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }
    
    /**
     * busca un cliente con la denominacion pasada como parametro
     * @param string $denom la denominacion que se busca
     * @return array|null la fila en forma de array si se encuentra, null si no
     */
    function loadByDenominacion(string $denom): ?array {
        $query = "SELECT * FROM cliente WHERE denominacion = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$denom]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }
    
    /**
     *  busca un cliente con el cif pasado como parametro
     * @param string $cif el cif que se busca
     * @return array|null la fila en forma de array si se encuentra, null si no
     */
    function loadByCif(string $cif): ?array {
        $query = "SELECT * FROM cliente WHERE cifCliente = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$cif]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }
    
    /**
     * introduce un cliente en la base de datos
     * @param array $data los datos del cliente
     * @return int devuelve 1 si se realiza con éxito, 0 si no
     */
    function insertCliente(array $data): int {
        $query = "INSERT INTO cliente (nombreFiscalCliente, denominacion, cifCliente, direccion, email) "
                . "VALUES (:nombreFiscalCliente, :denominacion, :cifCliente, :direccion, :email)";
        $stmt = $this->pdo->prepare($query);
        $vars = [
            'nombreFiscalCliente' => $data['nombreFiscalCliente'],
            'denominacion' => trim($data['denominacion']),
            'cifCliente' => $data['cifCliente'],
            'direccion' => $data['direccion'],
            'email' => $data['email']
        ];
        if ($stmt->execute($vars)) {
            return 1;
        } else {
            return 0;
        }
    }
    
    /**
     * borra un cliente de la base de datos
     * @param int $id el cliente que se quiere borrar
     * @return bool true si se borra correctamente, false si no
     */
    function delete(int $id): bool {
        $query = "DELETE FROM cliente WHERE idCliente = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
    
    /**
     * carga un cliente por el id
     * @param int $idCliente  el id que se busca
     * @return array|null la fila en moda array si la encuentra, null si no
     */
    function loadById(int $idCliente): ?array {
        $query = "SELECT * FROM cliente WHERE idCliente = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$idCliente]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }
}
?>