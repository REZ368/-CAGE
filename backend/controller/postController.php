<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: ../../frontend/views/admin_login.php');
    exit();
}
require_once __DIR__ . '/../model/mainModel.php';
$model = new MainModel($pdo);

// Handle DELETE first
if (isset($_GET['action']) && $_GET['action'] === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'] ?? null;
    if ($post_id) {
        $model->deletePost($post_id);
    }
    header('Location: ../../frontend/views/admin_dashboard.php');
    exit();
}

// Handle UPDATE next
if (isset($_GET['action']) && $_GET['action'] === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'] ?? null;
    $type = $_POST['type'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? 'new';
    $link = null;
    if ($type === 'website') {
        $link = $_POST['link'] ?? '';
        $model->updatePost($post_id, $title, $description, $link, null, $status);
    } elseif ($type === 'mobile') {
        $link = $_POST['link'] ?? '';
        $model->updatePost($post_id, $title, $description, $link, null, $status);
    }
    header('Location: ../../frontend/views/admin_dashboard.php');
    exit();
}

// Handle CREATE (default POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? 'new';
    $link = null;
    $file_path = null;

    if ($type === 'website') {
        $link = $_POST['link'] ?? '';
        $model->createPost($type, $title, $description, $link, null, $status);
    } elseif ($type === 'mobile') {
        $link = $_POST['link'] ?? '';
        $model->createPost($type, $title, $description, $link, null, $status);
    }
    header('Location: ../../frontend/views/admin_dashboard.php');
    exit();
} else {
    header('Location: ../../frontend/views/admin_dashboard.php');
    exit();
} 