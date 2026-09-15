<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdminUserController
{

    /**
     * Display admin dashboard (or could be summary)
     */
    public function dashboard()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            header('Location: index.php?action=login');
            exit;
        }

        require __DIR__ . '/../views/users/dashboard_admin.php';
    }

    /**
     * List all users
     */
    public function index()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            header('Location: index.php?action=login');
            exit;
        }

        $pdo = require __DIR__ . '/../config/database.php';
        $stmt = $pdo->query("SELECT id, email, username, roles_mask FROM users ORDER BY id DESC");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/admin/users/index.php';
    }

    /**
     * Show form to create new user
     */
    public function create()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            header('Location: index.php?action=login');
            exit;
        }

        require __DIR__ . '/../views/admin/users/create.php';
    }

    /**
     * Store new user in DB
     */
    public function store()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            header('Location: index.php?action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo = require __DIR__ . '/../config/database.php';

            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $username = $_POST['username'] ?? null;
            $roles_mask = $_POST['roles_mask'] ?? 1;
            $registered = time(); // Genera el timestamp actual de UNIX

            $stmt = $pdo->prepare("INSERT INTO users (email, password, username, roles_mask, registered) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$email, $password, $username, $roles_mask, $registered]);

            $_SESSION['create_success'] = true;
            header('Location: index.php?action=admin_users');
            exit;
        }
    }

    /**
     * Show edit form for a user
     */
    public function edit()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            header('Location: index.php?action=login');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "User ID not provided.";
            return;
        }

        $pdo = require __DIR__ . '/../config/database.php';
        $stmt = $pdo->prepare("SELECT id, email, username, roles_mask FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $editUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$editUser) {
            echo "User not found.";
            return;
        }

        require __DIR__ . '/../views/admin/users/edit.php';
    }

    /**
     * Update user data
     */
    public function update()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            header('Location: index.php?action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if (!$id) {
                echo "User ID missing.";
                return;
            }

            $pdo = require __DIR__ . '/../config/database.php';

            $email = $_POST['email'];
            $username = $_POST['username'] ?? null;
            $roles_mask = $_POST['roles_mask'] ?? 1;

            $stmt = $pdo->prepare("UPDATE users SET email = ?, username = ?, roles_mask = ? WHERE id = ?");
            $stmt->execute([$email, $username, $roles_mask, $id]);

            $_SESSION['update_success'] = true;
            header('Location: index.php?action=admin_users');
            exit;
        }
    }

    /**
     * Delete user by ID
     */
    public function delete()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            header('Location: index.php?action=login');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "User ID not provided for deletion.";
            return;
        }

        $pdo = require __DIR__ . '/../config/database.php';
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);

        $_SESSION['delete_success'] = true;
        header('Location: index.php?action=admin_users');
        exit;
    }

    /**
     * Show all orders for admin
     */
    public function orders()
    {
        // No need to call session_start, it's already in index.php

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            header('Location: index.php?action=login');
            exit;
        }

        $pdo = require __DIR__ . '/../config/database.php';

        // Fetch all orders with products and user
        $stmt = $pdo->query("
        SELECT 
            o.id AS order_id,
            o.user_id,
            u.username AS client_name,
            o.created_at AS order_date,
            p.name AS product_name,
            oi.quantity AS product_quantity,
            p.price AS unit_price,
            (oi.quantity * p.price) AS subtotal
        FROM orders o
        JOIN users u ON o.user_id = u.id
        JOIN order_items oi ON o.id = oi.order_id
        JOIN products p ON oi.product_id = p.id
        ORDER BY o.created_at DESC
    ");

        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/admin/users/orders.php';
    }


    // Download excel
    public function exportOrdersExcel()
    {
        $pdo = require __DIR__ . '/../config/database.php';
        $stmt = $pdo->query("SELECT o.id AS order_id, 
            o.user_id AS client_id, 
            u.username AS client_name,
            o.created_at AS order_date, 
            p.name AS product_name, 
            oi.quantity AS product_quantity,
            p.price AS unit_price,
            (oi.quantity * p.price) AS subtotal
        FROM orders o
        JOIN users u ON o.user_id = u.id
        JOIN order_items oi ON oi.order_id = o.id
        JOIN products p ON p.id = oi.product_id
        ORDER BY o.id DESC");

        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Headers
        $sheet->setCellValue('A1', 'Pedido');
        $sheet->setCellValue('B1', 'Cliente ID');
        $sheet->setCellValue('C1', 'Cliente');
        $sheet->setCellValue('D1', 'Fecha');
        $sheet->setCellValue('E1', 'Producto');
        $sheet->setCellValue('F1', 'Cantidad');
        $sheet->setCellValue('G1', 'Precio unitario');
        $sheet->setCellValue('H1', 'Subtotal');

        // Data rows
        $row = 2;
        foreach ($orders as $order) {
            $sheet->setCellValue("A$row", $order['order_id']);
            $sheet->setCellValue("B$row", $order['client_id']);
            $sheet->setCellValue("C$row", $order['client_name']);
            $sheet->setCellValue("D$row", $order['order_date']);
            $sheet->setCellValue("E$row", $order['product_name']);
            $sheet->setCellValue("F$row", $order['product_quantity']);
            $sheet->setCellValue("G$row", $order['unit_price']);
            $sheet->setCellValue("H$row", $order['subtotal']);
            $row++;
        }

        if (ob_get_length()) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="orders.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
