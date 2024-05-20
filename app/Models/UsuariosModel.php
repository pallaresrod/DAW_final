<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class UsuariosModel extends \Com\Daw2\Core\BaseModel {

    /**
     * selecciona de la tabla usuario y rol los datos de todos los usuarios
     * @return array devuelve toda la info de los usuarios
     */
    function getAll(): array {
        return $this->pdo->query("SELECT us.idUsuario, us.nombre, us.email, us.last_log, r.nombreRol "
                . "FROM usuario us LEFT JOIN rol r ON r.idRol = us.idRol ORDER BY us.nombre")->fetchAll();
    }
    
    /**
     * busca un ususario con el email pasado como parametro
     * @param string $email el email que se busca
     * @return array|null si hay un usuario con ese email se pasa la fila de info en modo array
     * si el email no coincide se devuelve null
     */
    function loadByEmail(string $email): ?array {
        $query = "SELECT * FROM usuario WHERE email = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$email]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }
    
    /**
     * busca un ususario con el login pasado como parametro
     * @param string $login el login que se busca
     * @return array|null si hay un usuario con ese login se pasa la fila de info en modo array
     * si el login no coincide se devuelve null
     */
    function loadByLogin(string $login): ?array {
        $query = "SELECT * FROM usuario WHERE login = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$login]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }
    
    /**
     * busca un ususario con el id pasado como parametro
     * @param int $idUsuario el id que se busca
     * @return array|null si hay un usuario con ese id se pasa la fila de info en modo array
     * si el id no coincide se devuelve null
     */
    function loadById(int $idUsuario): ?array {
        $query = "SELECT * FROM usuario WHERE idUsuario = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$idUsuario]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }
    
    /**
     * introducee un usuario al sistema
     * @param array $data los datos necesarios para introducir el usuario
     * @return int devuelve 1 si la operación se realizo sin problema, 0 si no se puedo realizar
     */
    function insertUsuarioSistema(array $data): int {
        $query = "INSERT INTO usuario (login, pass, nombre, email, idRol) VALUES(:login, :pass, :nombre, :email, :idRol)";
        $stmt = $this->pdo->prepare($query);
        $vars = [
            'login' => $data['login'],
            'pass' => password_hash($data['pass1'], PASSWORD_DEFAULT),
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'idRol' => $data['idRol']
        ];
        if ($stmt->execute($vars)) {
            return 1;
        } else {
            return 0;
        }
    }
    
    /**
     * actualiza la última vez que un usuario se conecto y tambien lo añade al log de actividad
     * @param int $idUsuario el usuario que se actualiza
     */
    function updateLogin(int $idUsuario) {
        $query = "UPDATE usuario SET last_log= now() WHERE idUsuario= ?";
        $query2 = "INSERT INTO activityLog (idUsuario, log) VALUES (:idUsuario, now())";
        
        $stmt = $this->pdo->prepare($query);
        $stmt2 = $this->pdo->prepare($query2);
        
        $stmt2->execute([$idUsuario]);
        $stmt->execute([$idUsuario]);
    }
    
    /**
     * busca todos las veces que un usario concreto se ha conectado
     * @param int $idUsuario el ususario que se quiere buscar
     * @return type devuelve todas las veces que el usuario se conecto en modo array
     */
    function getActivity(int $idUsuario){
        $query = "SELECT * FROM activityLog WHERE idUsuario = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$idUsuario]);
        
        return $stmt->fetchAll();
    }

    //NO PROYECTO, EJERCICIOS CLASE

    function editUsuarioSistema(int $idUsuario, array $data): bool {
        $query = "UPDATE usuario_sistema SET id_rol=:id_rol, email=:email, nombre=:nombre, id_idioma=:id_idioma WHERE id_usuario=:id_usuario";
        $stmt = $this->pdo->prepare($query);
        $vars = [
            'id_rol' => $data['id_rol'],
            'email' => $data['email'],
            'nombre' => $data['nombre'],
            'id_idioma' => $data['id_idioma'],
            'id_usuario' => $idUsuario
        ];
        return $stmt->execute($vars);
    }

    function editPassword(int $idUsuario, string $pass): bool {
        $query = "UPDATE usuario_sistema SET pass=? WHERE id_usuario=?";
        $stmt = $this->pdo->prepare($query);
        $encryptedPass = password_hash($pass, PASSWORD_DEFAULT);
        return $stmt->execute([$encryptedPass, $idUsuario]);
    }

    function delete(int $id): bool {
        $query = "DELETE FROM usuario_sistema WHERE id_usuario = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    function baja(int $id, int $estado): bool {
        $query = "UPDATE usuario_sistema SET baja=? WHERE id_usuario = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$estado, $id]);
        return $stmt->rowCount() > 0;
    }

    function loadByEmailNotId(string $email, int $id): ?array {
        $query = "SELECT * FROM usuario_sistema WHERE email = ? AND id_usuario != ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$email, $id]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }

    function loadUsuarioSistema(int $id): ?array {
        $query = "SELECT * FROM usuario_sistema WHERE id_usuario = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        if ($row = $stmt->fetch()) {
            return $row;
        } else {
            return null;
        }
    }

}
