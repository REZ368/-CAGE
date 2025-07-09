<?php
// backend/model/mainModel.php
require_once __DIR__ . '/../config/db.php';

class MainModel {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getPosts($type = null, $status = null) {
        $sql = "SELECT * FROM posts WHERE 1=1";
        $params = [];
        if ($type) {
            $sql .= " AND type = :type";
            $params[':type'] = $type;
        }
        if ($status) {
            $sql .= " AND status = :status";
            $params[':status'] = $status;
        }
        $sql .= " ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getClickStats($post_id) {
        $stmt = $this->pdo->prepare("SELECT action, count FROM click_stats WHERE post_id = :post_id");
        $stmt->execute([':post_id' => $post_id]);
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    public function authenticate($username, $password) {
        $stmt = $this->pdo->prepare("SELECT password FROM admin_users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $hash = $stmt->fetchColumn();
        if ($hash && password_verify($password, $hash)) {
            return true;
        }
        return false;
    }

    public function createPost($type, $title, $description, $link, $file_path, $status) {
        $stmt = $this->pdo->prepare("INSERT INTO posts (type, title, description, link, file_path, status) VALUES (:type, :title, :description, :link, :file_path, :status)");
        $stmt->execute([
            ':type' => $type,
            ':title' => $title,
            ':description' => $description,
            ':link' => $link,
            ':file_path' => $file_path,
            ':status' => $status
        ]);
        $post_id = $this->pdo->lastInsertId();
        // Initialize click stats
        if ($type === 'website') {
            $this->pdo->prepare("INSERT INTO click_stats (post_id, action, count) VALUES (?, 'open', 0)")->execute([$post_id]);
        } elseif ($type === 'mobile') {
            $this->pdo->prepare("INSERT INTO click_stats (post_id, action, count) VALUES (?, 'download', 0)")->execute([$post_id]);
        }
        return $post_id;
    }

    public function getAllPostsWithStats() {
        $sql = "SELECT p.*, 
            (SELECT count FROM click_stats WHERE post_id = p.id AND action = 'open') AS open_count,
            (SELECT count FROM click_stats WHERE post_id = p.id AND action = 'download') AS download_count
            FROM posts p ORDER BY p.created_at DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function incrementClick($post_id, $action) {
        $stmt = $this->pdo->prepare("UPDATE click_stats SET count = count + 1 WHERE post_id = :post_id AND action = :action");
        $stmt->execute([':post_id' => $post_id, ':action' => $action]);
    }

    public function getPostById($post_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE id = :id");
        $stmt->execute([':id' => $post_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deletePost($post_id) {
        // Delete click stats first due to FK constraint
        $this->pdo->prepare('DELETE FROM click_stats WHERE post_id = ?')->execute([$post_id]);
        $this->pdo->prepare('DELETE FROM posts WHERE id = ?')->execute([$post_id]);
    }

    public function updatePost($post_id, $title, $description, $link, $file_path, $status) {
        $post = $this->getPostById($post_id);
        if ($post['type'] === 'website') {
            $sql = 'UPDATE posts SET title = :title, description = :description, link = :link, status = :status WHERE id = :id';
            $params = [
                ':title' => $title,
                ':description' => $description,
                ':link' => $link,
                ':status' => $status,
                ':id' => $post_id
            ];
        } else {
            $sql = 'UPDATE posts SET title = :title, description = :description, link = :link, file_path = NULL, status = :status WHERE id = :id';
            $params = [
                ':title' => $title,
                ':description' => $description,
                ':link' => $link,
                ':status' => $status,
                ':id' => $post_id
            ];
        }
        $this->pdo->prepare($sql)->execute($params);
    }
} 