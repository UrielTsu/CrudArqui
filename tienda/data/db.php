<?php


class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "tienda_db";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
            // Configurar para que devuelva errores y soporte tildes/eñes
            $this->conn->set_charset("utf8");
        } catch(Exception $e) {
            die("Error crítico de BD: " . $e->getMessage());
        }
        return $this->conn;
    }
}
?>