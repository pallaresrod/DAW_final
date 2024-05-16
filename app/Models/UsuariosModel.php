<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

class UsuariosModel extends \Com\Daw2\Core\BaseModel {

    //devuelve información sobre los usuarios
    function getAll(): array {
        return $this->pdo->query("SELECT us.nombre, us.email, us.last_log, r.nombreRol "
                . "FROM usuario us LEFT JOIN rol r ON r.idRol = us.idRol ORDER BY us.nombre")->fetchAll();
    }
    
    //devuelve un usuario con el mismo email que el pasado por párametro
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
    
    //devuelve un usuario con el mismo login que el pasado por párametro
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
    
    function insertUsuarioSistema(array $data): int {
        $query = "INSERT INTO usuario (login, pass, nombre, email, idRol) VALUES(:login, :pass, :email, :idRol)";
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

    function updateLogin(int $id) {
        $query = "UPDATE usuario_sistema SET last_date= now() WHERE id_usuario= ?";
        $stmt = $this->pdo->prepare($query);
        
        $stmt->execute([$id]);
    }
}
