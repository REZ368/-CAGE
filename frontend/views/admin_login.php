<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-gray-900 to-green-900 flex items-center justify-center h-screen">
    <form class="bg-white p-8 rounded shadow-md w-full max-w-sm" method="POST" action="../../backend/controller/authController.php">
        <h2 class="text-2xl font-bold mb-6 text-center">Admin Login</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="mb-4 text-red-500 text-sm text-center">
                Invalid username or password.
            </div>
        <?php endif; ?>
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="username">Username</label>
            <input class="w-full border px-3 py-2 rounded" type="text" id="username" name="username" required>
        </div>
        <div class="mb-6">
            <label class="block mb-1 font-semibold" for="password">Password</label>
            <input class="w-full border px-3 py-2 rounded" type="password" id="password" name="password" required>
        </div>
        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition" type="submit">Login</button>
    </form>
</body>
</html> 