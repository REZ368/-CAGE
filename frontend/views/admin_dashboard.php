<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php');
    exit();
}
require_once '../../backend/model/mainModel.php';
$model = new MainModel($pdo);
$posts = $model->getAllPostsWithStats();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-gray-900 to-green-900 min-h-screen">
    <div class="max-w-4xl mx-auto py-10">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl text-white font-bold">Admin Dashboard</h1>
            <a href="../../backend/controller/authController.php?action=logout" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-xl font-semibold mb-4">Create Website App Post</h2>
                <form method="POST" action="../../backend/controller/postController.php" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="website">
                    <div class="mb-3">
                        <label class="block mb-1 font-semibold">Title</label>
                        <input class="w-full border px-3 py-2 rounded" type="text" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="block mb-1 font-semibold">Description</label>
                        <textarea class="w-full border px-3 py-2 rounded" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="block mb-1 font-semibold">Link</label>
                        <input class="w-full border px-3 py-2 rounded" type="url" name="link" required>
                    </div>
                    <div class="mb-3">
                        <label class="block mb-1 font-semibold">Status</label>
                        <select class="w-full border px-3 py-2 rounded" name="status" required>
                            <option value="new">New</option>
                            <option value="current">Current</option>
                            <option value="old">Old</option>
                        </select>
                    </div>
                    <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition" type="submit">Create Website Post</button>
                </form>
            </div>
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-xl font-semibold mb-4">Create Mobile App Post</h2>
                <form method="POST" action="../../backend/controller/postController.php" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="mobile">
                    <div class="mb-3">
                        <label class="block mb-1 font-semibold">Title</label>
                        <input class="w-full border px-3 py-2 rounded" type="text" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="block mb-1 font-semibold">Description</label>
                        <textarea class="w-full border px-3 py-2 rounded" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="block mb-1 font-semibold">Link (Google Drive, etc.)</label>
                        <input class="w-full border px-3 py-2 rounded" type="url" name="link" required>
                    </div>
                    <div class="mb-3">
                        <label class="block mb-1 font-semibold">Status</label>
                        <select class="w-full border px-3 py-2 rounded" name="status" required>
                            <option value="new">New</option>
                            <option value="current">Current</option>
                            <option value="old">Old</option>
                        </select>
                    </div>
                    <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition" type="submit">Create Mobile Post</button>
                </form>
            </div>
        </div>
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-semibold mb-4">All Posts & Stats</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Type</th>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">OPEN</th>
                            <th class="px-4 py-2">DOWNLOAD</th>
                            <th class="px-4 py-2">Created</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post): ?>
                        <tr id="post-row-<?php echo $post['id']; ?>">
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($post['type']); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($post['title']); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($post['status']); ?></td>
                            <td class="border px-4 py-2 text-center"><?php echo $post['open_count'] ?? 0; ?></td>
                            <td class="border px-4 py-2 text-center"><?php echo $post['download_count'] ?? 0; ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($post['created_at']); ?></td>
                            <td class="border px-4 py-2 text-center">
                                <form method="POST" action="../../backend/controller/postController.php?action=delete" style="display:inline;">
                                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-xs">DELETE</button>
                                </form>
                                <button onclick="showUpdateForm(<?php echo $post['id']; ?>)" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 text-xs ml-2">UPDATE</button>
                            </td>
                        </tr>
                        <tr id="update-form-row-<?php echo $post['id']; ?>" style="display:none;">
                            <td colspan="7">
                                <form method="POST" action="../../backend/controller/postController.php?action=update" enctype="multipart/form-data" class="bg-gray-100 p-4 rounded">
                                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                    <input type="hidden" name="type" value="<?php echo $post['type']; ?>">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block mb-1 font-semibold">Title</label>
                                            <input class="w-full border px-3 py-2 rounded" type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                                        </div>
                                        <div>
                                            <label class="block mb-1 font-semibold">Status</label>
                                            <select class="w-full border px-3 py-2 rounded" name="status" required>
                                                <option value="new" <?php if($post['status']==='new') echo 'selected'; ?>>New</option>
                                                <option value="current" <?php if($post['status']==='current') echo 'selected'; ?>>Current</option>
                                                <option value="old" <?php if($post['status']==='old') echo 'selected'; ?>>Old</option>
                                            </select>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block mb-1 font-semibold">Description</label>
                                            <textarea class="w-full border px-3 py-2 rounded" name="description" required><?php echo htmlspecialchars($post['description']); ?></textarea>
                                        </div>
                                        <?php if ($post['type'] === 'website'): ?>
                                        <div class="md:col-span-2">
                                            <label class="block mb-1 font-semibold">Link</label>
                                            <input class="w-full border px-3 py-2 rounded" type="url" name="link" value="<?php echo htmlspecialchars($post['link']); ?>" required>
                                        </div>
                                        <?php else: ?>
                                        <div class="md:col-span-2">
                                            <label class="block mb-1 font-semibold">Link (Google Drive, etc.)</label>
                                            <input class="w-full border px-3 py-2 rounded" type="url" name="link" value="<?php echo htmlspecialchars($post['link']); ?>" required>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mt-4 text-right">
                                        <button type="button" onclick="hideUpdateForm(<?php echo $post['id']; ?>)" class="bg-gray-400 text-white px-3 py-1 rounded mr-2">Cancel</button>
                                        <button type="submit" class="bg-yellow-600 text-white px-3 py-1 rounded">Save</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
    function showUpdateForm(id) {
        document.getElementById('update-form-row-' + id).style.display = '';
    }
    function hideUpdateForm(id) {
        document.getElementById('update-form-row-' + id).style.display = 'none';
    }
    </script>
</body>
</html> 