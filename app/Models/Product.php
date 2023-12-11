<?php

namespace app\Models;

include "app/Config/DatabaseConfig.php";

use app\Config\DatabaseConfig;
use mysqli;

class Product extends DatabaseConfig
{
    public $conn;

    public function __construct()
    {
        // CONNECT KE DATABASE MYSQL
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database_name, $this->port);
        // CHECK KONEKSI
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // PROSES MENAMPILKAN SEMUA DATA
    public function findAll()
    {
        $sql = "SELECT * FROM products";
        $result = $this->conn->query($sql);
        $this->conn->close();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    // PROSES MENAMPILKAN DENGAN ID
    public function findById($id)
    {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $this->conn->close();
        $data = [];
        while ($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return $data;
    }

    // PROSES INSERT DATA
    // PROSES INSERT DATA
public function create($data)
{
    $productName = $data['product_name'];
    $category_id = $data['category_id'] ?? null; // Mendapatkan category_id dari data atau null jika tidak ada

    $query = "INSERT INTO products (product_name, category_id) VALUES (?, ?)";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("si", $productName, $category_id); // Menggunakan "si" karena product_name adalah string, dan category_id adalah integer
    $stmt->execute();
    $this->conn->close();
}


    // PROSES UPDATE DATA DENGAN ID
    public function update($data, $id)
{
    $productName = $data['product_name'];
    $category_id = $data['category_id'] ?? null;

    $query = "UPDATE products SET product_name = ?, category_id = ? WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("sii", $productName, $category_id, $id);
    $stmt->execute();
    $this->conn->close();
}

    // PROSES DELETE DATA DENGAN ID
    public function destroy($id)
    {
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        // huruf "i" berarti parameter pertama untuk integer
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $this->conn->close();
    }

    public function findAllWithCategory()
    {
        $sql = "SELECT products.product_name, products.category_id,  categories.category_name 
                FROM products 
                LEFT JOIN categories ON products.category_id = categories.id";
        $result = $this->conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function findAllCategories()
    {
        $sql = "SELECT * FROM categories";
        $result = $this->conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    // PROSES MENAMPILKAN CATEGORY DENGAN ID
    public function findCategoryById($id)
    {
        $sql = "SELECT * FROM categories WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    // PROSES INSERT DATA CATEGORY
    public function createCategory($data)
    {
        $categoryName = $data['category_name'];
        $query = "INSERT INTO categories (category_name) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $categoryName);
        $stmt->execute();
        $this->conn->close();
    }

    // PROSES UPDATE DATA CATEGORY DENGAN ID
    public function updateCategory($data, $id)
    {
        $categoryName = $data['category_name'];

        $query = "UPDATE categories SET category_name = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $categoryName, $id);
        $stmt->execute();
        $this->conn->close();
    }

    // PROSES DELETE DATA CATEGORY DENGAN ID
    public function destroyCategory($id)
    {
        $query = "DELETE FROM categories WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $this->conn->close();
    }

}