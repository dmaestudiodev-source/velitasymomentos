<?php

/**
 * Handles category-related actions
 */
class CategoryController
{
    /**
     * Display list of all categories
     */
    public function index()
    {
        require_once __DIR__ . '/../models/Category.php';
        $model = new Category();
        $categories = $model->getAll();

        require_once __DIR__ . '/../views/categories/index.php';
    }

    /**
     * Show the create form
     */
    public function create()
    {
        require_once __DIR__ . '/../views/categories/create.php';
    }

    /**
     * Save new category
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';

            require_once __DIR__ . '/../models/Category.php';
            $model = new Category();
            $model->create(['name' => $name]);

            header('Location: index.php?controller=category&action=index');
            exit;
        }
    }

    /**
     * Show the edit form
     */
    public function edit()
    {
        if (isset($_GET['id'])) {
            require_once __DIR__ . '/../models/Category.php';
            $model = new Category();
            $category = $model->getById($_GET['id']);

            require_once __DIR__ . '/../views/categories/edit.php';
        }
    }

    /**
     * Update category
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $name = $_POST['name'] ?? '';

            require_once __DIR__ . '/../models/Category.php';
            $model = new Category();
            $model->update($id, ['name' => $name]);

            header('Location: index.php?controller=category&action=index');
            exit;
        }
    }
}
