<?php
// backend/controller/controllerMain.php
require_once __DIR__ . '/../model/mainModel.php';

$model = new MainModel($pdo);

// Example usage:
// $posts = $model->getPosts('website', 'current');
// $stats = $model->getClickStats(1); 