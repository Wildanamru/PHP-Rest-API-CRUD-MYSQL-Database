<?php

namespace app\Controller;

include "app/Traits/ApiResponseFormatter.php";
include "app/Models/Product.php";

use app\Models\Product;
use app\Traits\ApiResponseFormatter;

class ProductController
{
    // PAKAI TRAIT YANG SUDAH DIBUAT
    use ApiResponseFormatter;

    public function index()
    {
        // DEFINISIKAN OBJECT MODEL PRODUCT YANG SUDAH DIBUAT
        $productModel = new Product();

        // PANGGIL FUNGSI GET ALL PRODUCT
        $response = $productModel->findAll();

        // RETURN $response DENGAN MELAKUKAN FORMATTING TERLEBIH DAHULU MENGGUNAKAN TRAIT YANG SUDAH DIPANGGIL
        return $this->apiResponse(200, "success", $response);
    }

    public function getById($id)
    {
        $productModel = new Product();
        $response = $productModel->findById($id);

        return $this->apiResponse(200, "success", $response);
    }

    public function insert()
    {
        // TANGKAP INPUT JSON
        $jsonInput = file_get_contents('php://input');
        $inputData = json_decode($jsonInput, true);
    
        // VALIDASI APAKAH INPUT VALID
        if (json_last_error()) {
            return $this->apiResponse(400, "error invalid input", null);
        }
    
        // LANJUT JIKA TIDAK ERROR
        $productModel = new Product();
        $response = $productModel->create([
            "product_name" => $inputData['product_name'],
            "category_id" => $inputData['category_id'] ?? null
        ]);
    
        return $this->apiResponse(200, "success", $response);
    }
    
    public function update($id)
    {
        // TANGKAP INPUT JSON
        $jsonInput = file_get_contents('php://input');
        $inputData = json_decode($jsonInput, true);
    
        // VALIDASI APAKAH INPUT VALID
        if (json_last_error()) {
            return $this->apiResponse(400, "error invalid input", null);
        }
    
        // LANJUT JIKA TIDAK ERROR
        $productModel = new Product();
        $response = $productModel->update([
            "product_name" => $inputData['product_name'],
            "category_id" => $inputData['category_id'] ?? null
        ], $id);
    
        return $this->apiResponse(200, "success", $response);
    }

    public function delete($id)
    {
        $productModel = new Product();
        $response = $productModel->destroy($id);

        return $this->apiResponse(200, "success", $response);
    }

    public function indexWithCategory()
    {
        $productModel = new Product();
        $response = $productModel->findAllWithCategory();
        return $this->apiResponse(200, "success", $response);
    }

    public function insertWithCategory()
    {
        // TANGKAP INPUT JSON
        $jsonInput = file_get_contents('php://input');
        $inputData = json_decode($jsonInput, true);

        // VALIDASI APAKAH INPUT VALID
        if (json_last_error()) {
            return $this->apiResponse(400, "error invalid input", null);
        }

        // LANJUT JIKA TIDAK ERROR
        $productModel = new Product();

        // Tambahkan kategori_id ke array data yang akan dimasukkan
        $category_id = $inputData['category_id'] ?? null;

        $response = $productModel->create([
            "product_name" => $inputData['product_name'],
            "category_id" => $category_id
        ]);

        return $this->apiResponse(200, "success", $response);
    }

    // Menampilkan semua kategori
    public function indexCategories()
    {
        $productModel = new Product();
        $response = $productModel->findAllCategories();
        return $this->apiResponse(200, "success", $response);
    }

    // Menampilkan kategori berdasarkan ID
    public function getCategoryById($id)
    {
        $productModel = new Product();
        $response = $productModel->findCategoryById($id);
        return $this->apiResponse(200, "success", $response);
    }

    // Menambah kategori baru
    public function insertCategory()
    {
        // TANGKAP INPUT JSON
        $jsonInput = file_get_contents('php://input');
        $inputData = json_decode($jsonInput, true);

        // VALIDASI APAKAH INPUT VALID
        if (json_last_error()) {
            return $this->apiResponse(400, "error invalid input", null);
        }

        // LANJUT JIKA TIDAK ERROR
        $productModel = new Product();
        $response = $productModel->createCategory(["category_name" => $inputData['category_name']]);

        return $this->apiResponse(200, "success", $response);
    }

    // Mengupdate kategori berdasarkan ID
    public function updateCategory($id)
    {
        // TANGKAP INPUT JSON
        $jsonInput = file_get_contents('php://input');
        $inputData = json_decode($jsonInput, true);

        // VALIDASI APAKAH INPUT VALID
        if (json_last_error()) {
            return $this->apiResponse(400, "error invalid input", null);
        }

        // LANJUT JIKA TIDAK ERROR
        $productModel = new Product();
        $response = $productModel->updateCategory(["category_name" => $inputData['category_name']], $id);

        return $this->apiResponse(200, "success", $response);
    }

    // Menghapus kategori berdasarkan ID
    public function deleteCategory($id)
    {
        $productModel = new Product();
        $response = $productModel->destroyCategory($id);

        return $this->apiResponse(200, "success", $response);
    }
}
