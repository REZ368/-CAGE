<?php
require_once __DIR__ . '/../model/mainModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $post_id = $_POST['post_id'] ?? $_GET['post_id'] ?? null;
    $action = $_POST['action'] ?? $_GET['action'] ?? null;
    if ($post_id && ($action === 'open' || $action === 'download')) {
        $model = new MainModel($pdo);
        $model->incrementClick($post_id, $action);
        $post = $model->getPostById($post_id);
        if ($action === 'open' && !empty($post['link'])) {
            header('Location: ' . $post['link']);
            exit();
        } elseif ($action === 'download') {
            // For mobile, use 'link' column
            if (!empty($post['link'])) {
                header('Location: ' . $post['link']);
                exit();
            }
        }
    }
}
header('Location: ../../frontend/views/main.php');
exit(); 