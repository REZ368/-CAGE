<?php
session_start();
require_once __DIR__ . '/../model/mainModel.php';

$model = new MainModel($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if ($model->authenticate($username, $password)) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: ../../frontend/views/admin_dashboard.php');
        exit();
    } else {
        header('Location: ../../frontend/views/admin_login.php?error=1');
        exit();
    }
} elseif (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: ../../frontend/views/admin_login.php');
    exit();
} else {
    header('Location: ../../frontend/views/admin_login.php');
    exit();
} 