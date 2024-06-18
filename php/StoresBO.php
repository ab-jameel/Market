<?php

require_once 'connect.php';

class StoresBO {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function add_store($s_location) {
        $query = $this->conn->query("INSERT INTO m_store (s_location) VALUES ('$s_location')") or die($this->conn->error());
        return $query;
    }

    public function update_store($id, $s_location) {
        $query = $this->conn->query("UPDATE m_store SET s_location = '$s_location' WHERE store_id = $id") or die($this->conn->error());
        return $query;
    }

    public function get_store_ById($id) {
        $result = $this->conn->query("SELECT * FROM m_store WHERE store_id = $id") or die($this->conn->error);
        return $result->fetch_assoc();
    }

    public function delete_store($id) {
        $control = $this->conn->query("SELECT * FROM m_order WHERE store_id = $id") or die($this->conn->error);
        $c_data = $control->fetch_assoc();
        if (empty($c_data)) {
            $result = $this->conn->query("DELETE FROM m_store WHERE store_id = $id") or die($this->conn->error);
            return $result;
        }
        return false;
    }

    public function get_All_stores() {
        $result = $this->conn->query("SELECT * FROM m_store") or die($this->conn->error);
        $stores = array();
        while ($data = $result->fetch_assoc()) {
            $stores[] = $data;
        }
        return $stores;
    }
}

?>
