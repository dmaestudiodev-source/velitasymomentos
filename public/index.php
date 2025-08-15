<?php
session_start();

/**
 * ============================================================
 * Load all controllers
 * ============================================================
 */
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/AdminUserController.php';
require_once __DIR__ . '/../controllers/ClientController.php';
require_once __DIR__ . '/../controllers/ProductController.php';
require_once __DIR__ . '/../controllers/CategoryController.php';
require_once __DIR__ . '/../controllers/CartController.php';

/**
 * ============================================================
 * Instantiate all controllers
 * ============================================================
 */
$userController = new UserController();
$adminUserController = new AdminUserController();
$clientController = new ClientController();
$productController = new ProductController();
$categoryController = new CategoryController();
$cartController = new CartController();

/**
 * ============================================================
 * Determine current action
 * ============================================================
 */
$action = $_GET['action'] ?? 'home';

// Compatibility with legacy ?controller=...&action=...
if (isset($_GET['controller'])) {
    if ($_GET['controller'] === 'product') {
        if ($_GET['action'] === 'index') $action = 'products';
        if ($_GET['action'] === 'create') $action = 'product_create';
        if ($_GET['action'] === 'store') $action = 'product_store';
        if ($_GET['action'] === 'edit') $action = 'product_edit';
        if ($_GET['action'] === 'update') $action = 'product_update';
        if ($_GET['action'] === 'delete') $action = 'product_delete';
    }
    if ($_GET['controller'] === 'category') {
        if ($_GET['action'] === 'index') $action = 'categories';
        if ($_GET['action'] === 'create') $action = 'category_create';
        if ($_GET['action'] === 'store') $action = 'category_store';
        if ($_GET['action'] === 'edit') $action = 'category_edit';
        if ($_GET['action'] === 'update') $action = 'category_update';
        if ($_GET['action'] === 'delete') $action = 'category_delete';
    }
    if ($_GET['controller'] === 'cart') {
        if ($_GET['action'] === 'index') $action = 'cart';
        if ($_GET['action'] === 'add') $action = 'add_to_cart';
        if ($_GET['action'] === 'confirm') $action = 'confirm_order';
    }
}

/**
 * ============================================================
 * Main router with switch-case
 * ============================================================
 */
switch ($action) {
    // ===========================
    // Home page
    // ===========================
    case 'home':
        $productController->homeProducts(); // <<< MODIFICADO: ahora usa el controlador
        break;

    // ===========================
    // Products CRUD
    // ===========================
    case 'products':
        $productController->index();
        break;
    case 'product_create':
        $productController->create();
        break;
    case 'product_store':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productController->store();
        }
        break;
    case 'product_edit':
        $productController->edit();
        break;
    case 'product_update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productController->update();
        }
        break;
    case 'product_delete':
        $productController->delete();
        break;

    // ===========================
    // Categories CRUD
    // ===========================
    case 'categories':
        $categoryController->index();
        break;
    case 'category_create':
        $categoryController->create();
        break;
    case 'category_store':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryController->store();
        }
        break;
    case 'category_edit':
        $categoryController->edit();
        break;
    case 'category_update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryController->update();
        }
        break;


    // ===========================
    // User authentication
    // ===========================
    case 'register':
        $userController->showRegisterForm();
        break;
    case 'register_user':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->register();
        } else {
            header('Location: index.php?action=register');
            exit;
        }
        break;
    case 'login':
        $userController->showLoginForm();
        break;
    case 'login_user':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->login();
        } else {
            header('Location: index.php?action=login');
            exit;
        }
        break;
    case 'logout':
        $userController->logout();
        break;

    // ===========================
    // Client dashboard and orders
    // ===========================
    case 'client_dashboard':
        $clientController->dashboard();
        break;
    case 'my_orders':
        $clientController->orders();
        break;

    // ===========================
    // Admin dashboard and user management
    // ===========================
    case 'admin_dashboard':
        $adminUserController->dashboard();
        break;
    case 'admin_users':
        $adminUserController->index();
        break;
    case 'admin_user_create':
        $adminUserController->create();
        break;
    case 'admin_user_store':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminUserController->store();
        }
        break;
    case 'admin_user_edit':
        $adminUserController->edit();
        break;
    case 'admin_user_update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminUserController->update();
        }
        break;
    case 'admin_user_delete':
        $adminUserController->delete();
        break;

    // ===========================
    // Password recovery
    // ===========================
    case 'forgot_password':
        $userController->showForgotPasswordForm();
        break;
    case 'forgot_password_process':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->forgotPassword();
        } else {
            header('Location: index.php?action=forgot_password');
            exit;
        }
        break;
    case 'reset_password':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $userController->showResetPasswordForm();
        }
        break;
    case 'reset_password_process':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->resetPassword();
        } else {
            header('Location: index.php?action=forgot_password');
            exit;
        }
        break;

    // ===========================
    // Cart actions
    // ===========================
    case 'cart':
        $cartController->index();
        break;
    case 'add_to_cart':
        $cartController->add();
        break;
    case 'remove_from_cart':
        $cartController->remove();
        break;
    case 'update_cart':
        $cartController->update();
        break;
    case 'place_order':
        $cartController->placeOrder();
        break;
    case 'my_orders':
        $clientController->orders();
        break;
    case 'admin_orders':
        $adminUserController->orders();
        break;

    // ===========================
    // Default fallback
    // ===========================
    default:
        echo "<div style='text-align:center; margin-top:50px;'>
                <h2>Unrecognized action: <code>$action</code></h2>
                <a href='index.php' style='color: green;'>Back to home</a>
              </div>";
        break;

    // ===========================
    // contact
    // ===========================
    case 'contact':
        require __DIR__ . '/../views/contact.php';
        break;
    case 'contact_send':
        require __DIR__ . '/../controllers/ContactController.php';
        break;


    // ===========================
    // Download excel
    // ===========================
    case 'export_orders_excel':
        $adminUserController->exportOrdersExcel();
        break;
}
