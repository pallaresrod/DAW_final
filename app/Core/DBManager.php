<?php

declare(strict_types=1);

namespace Com\Daw2\Core;

use \PDO;

class DBManager {

    // Contenedor de la instancia de la Clase
    private static $instance;
    private $db;

    //Previene creacion de objetos via new
    private function __construct() {}

    // Única forma para obtener el objeto singleton
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection($emulatePrepares = false) {
        // Verifica si la conexión ya está establecida
        if (is_null($this->db)) {
            // Obtiene los detalles de conexión desde las variables de entorno
            $host = $_ENV['db.host'];
            $db = $_ENV['db.schema'];
            $user = $_ENV['db.user'];
            $pass = $_ENV['db.pass'];
            $charset = $_ENV['db.charset'];
            // El valor de emulated se toma de las variables de entorno y se convierte a un booleano
            $emulated = (bool)$_ENV['db.emulated'];

            // Construye el DSN para la conexión PDO
            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            // Define las opciones de configuración para la conexión PDO
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => $emulated,
            ];
            try {
                // Intenta establecer la conexión a la base de datos utilizando PDO
                $this->db = new PDO($dsn, $user, $pass, $options);
            } catch(\PDOException $e){
                // Captura y relanza cualquier excepción de PDO como una excepción de PDO personalizada
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
        
        // Devuelve la conexión establecida o existente
        return $this->db;
    }

}
?>