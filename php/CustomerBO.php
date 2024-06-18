<?php

require_once 'connect.php';

class CustomerBO {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addCustomer($c_name, $c_city, $mobile_number, $c_gender, $imag) {
        if(isset($imag['error']) && $imag['error'] == 0){
            $imagContent = addslashes(file_get_contents($imag['tmp_name']));
            $imagName = $imag['name'];  // Original file name
            $imagType = $imag['type'];  // MIME type

            $query = $this->conn->query("INSERT INTO m_customer (c_name, c_city, mobile_number, c_gender, imag, imag_name, imag_type) VALUES ('$c_name', '$c_city', '$mobile_number', '$c_gender', '$imagContent', '$imagName', '$imagType')");
            if ($query) {
                return $query;
            } else {
                die($this->conn->error);
            }
        } else {
            die("Error in file upload: " . $imag['error']);
        }
    }

    public function updateCustomer($id, $c_name, $c_city, $mobile_number, $c_gender) {
        $query = $this->conn->query("UPDATE m_customer SET c_name = '$c_name', c_city = '$c_city', mobile_number = '$mobile_number', c_gender = '$c_gender' WHERE customer_id = $id") or die($this->conn->error);
        return $query;
    }

    public function getCustomerById($id) {
        $result = $this->conn->query("SELECT * FROM m_customer WHERE customer_id = $id") or die($this->conn->error);
        return $result->fetch_assoc();
    }

    public function deleteCustomer($id) {
        $control = $this->conn->query("SELECT * FROM m_order WHERE customer_id = $id") or die($this->conn->error);
        $c_data = $control->fetch_assoc();
        if (empty($c_data)) {
            $result = $this->conn->query("DELETE FROM m_customer WHERE customer_id = $id") or die($this->conn->error);
            return $result;
        }
        return false;
    }

    public function getAllCustomers() {
        $result = $this->conn->query("SELECT * FROM m_customer") or die($this->conn->error);
        $customers = array();
        while ($data = $result->fetch_assoc()) {
            $customers[] = $data;
        }
        return $customers;
    }
}

?>
