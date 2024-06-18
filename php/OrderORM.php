<?php

require_once 'connect.php';

class OrderORM {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addOrder($customer_id, $store_id, $quantity, $sales_total, $o_date, $payment_methods) {
        $query = $this->conn->query("INSERT INTO m_order (customer_id, store_id, quantity, sales_total, o_date) VALUES ('$customer_id', '$store_id', '$quantity', '$sales_total', '$o_date')") or die($this->conn->error);

        $sale_id = $this->conn->insert_id;

        foreach ($payment_methods as $p_method) {
            if (!empty($p_method)) {
                $this->conn->query("INSERT INTO order_details (sale_id, payment_method) VALUES ('$sale_id','$p_method')") or die($this->conn->error);
            }
        }

        return $query;
    }

    public function updateOrder($id, $customer_id, $store_id, $quantity, $sales_total, $o_date, $payment_methods) {
        $query = $this->conn->query("UPDATE m_order SET customer_id = '$customer_id', store_id = '$store_id', quantity = '$quantity', sales_total = '$sales_total', o_date = '$o_date' WHERE sale_id = $id") or die($this->conn->error);

        $this->conn->query("DELETE FROM order_details WHERE sale_id = $id") or die($this->conn->error);

        foreach ($payment_methods as $p_method) {
            if (!empty($p_method)) {
                $this->conn->query("INSERT INTO order_details (sale_id, payment_method) VALUES ('$id','$p_method')") or die($this->conn->error);
            }
        }

        return $query;
    }

    public function getOrderById($id) {
        $result = $this->conn->query("SELECT * FROM m_order WHERE sale_id = $id") or die($this->conn->error);
        return $result->fetch_assoc();
    }

    public function deleteOrder($id) {
        $this->conn->query("DELETE FROM order_details WHERE sale_id = $id") or die($this->conn->error);
        $result = $this->conn->query("DELETE FROM m_order WHERE sale_id = $id") or die($this->conn->error);
        return $result;
    }

    public function getAllOrders() {
        $result = $this->conn->query("SELECT * FROM m_order") or die($this->conn->error);
        $orders = array();
        while ($data = $result->fetch_assoc()) {
            $orders[] = $data;
        }
        return $orders;
    }
}

?>