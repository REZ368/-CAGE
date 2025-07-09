<?php
require_once '../../backend/model/mainModel.php';
$model = new MainModel($pdo);
$website_posts = [
    'new' => $model->getPosts('website', 'new'),
    'current' => $model->getPosts('website', 'current'),
    'old' => $model->getPosts('website', 'old'),
];
$mobile_posts = [
    'new' => $model->getPosts('mobile', 'new'),
    'current' => $model->getPosts('mobile', 'current'),
    'old' => $model->getPosts('mobile', 'old'),
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud-Cage Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gradient-to-r from-gray-900 to-green-900 min-h-screen flex flex-col">
    <!-- Mobile Menu Button -->
    <div class="md:hidden fixed top-4 right-4 z-50">
        <button id="mobile-menu-btn" class="bg-gray-900 text-white p-2 rounded">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden fixed inset-0 bg-gradient-to-r from-gray-900 to-green-900 z-40 transform translate-x-full transition-transform duration-300">
        <div class="flex flex-col justify-center items-center h-full">
            <button id="close-menu" class="absolute top-4 right-4 text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <nav class="text-center">
                <a href="#home" class="block text-white text-xl py-4 hover:text-gray-300 transition">HOME</a>
                <a href="#website" class="block text-white text-xl py-4 hover:text-gray-300 transition">WEBSITE</a>
                <a href="#mobile" class="block text-white text-xl py-4 hover:text-gray-300 transition">MOBILE</a>
                <a href="#contact" class="block text-white text-xl py-4 hover:text-gray-300 transition">CONTACT</a>
                <a href="#footer" class="block text-white text-xl py-4 hover:text-gray-300 transition">FOOTER</a>
            </nav>
        </div>
    </div>

    <header id="home" class="bg-gradient-to-l from-gray-900 to-blue-900 text-white py-6 mb-8">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="flex justify-center text-left text-3xl font-bold mt-1">☁️CAGE : Create Application Git Engine</h1>
        </div>
    </header>
    <main class="flex-1 max-w-4xl mx-auto px-4">
        <p class="flex justify-center text-white text-center"> An open and free-to-use platform (not for commercial use) designed to run and manage showcasing Website Projects and Mobile Applications PWA projects — Version 2 of my portfolio.</p><br>
        <section id="website" class="mb-10">
            <h2 class="flex justify-center text-2xl text-white font-bold mb-4">Website Apps</h2>
            <?php foreach (['new', 'current', 'old'] as $status): ?>
                <?php if (count($website_posts[$status])): ?>
                    <h3 class="text-xl text-white font-bold mt-6 mb-2 capitalize"><?php echo $status; ?> Posts</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <?php foreach ($website_posts[$status] as $post): ?>
                            <div class="bg-gray-900 p-5 rounded shadow-lg hover:shadow-none hover:[box-shadow:0_0_20px_white] hover:-translate-y-2 transform transition-all duration-300">
                                <h4 class="text-lg text-white font-bold mb-1"><?php echo htmlspecialchars($post['title']); ?></h4>
                                <p class="mb-2 text-gray-400"><?php echo htmlspecialchars($post['description']); ?></p>
                                
                                <form method="POST" action="../../backend/controller/clickTracker.php">
                                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                    <input type="hidden" name="action" value="open">
                                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-900 transition" type="submit">OPEN</button>
                                </form>

                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </section>
        <section id="mobile" class="mb-10">
            <h2 class="flex justify-center text-2xl text-white font-bold mb-4">Mobile Apps (PWA)</h2>
            <?php foreach (['new', 'current', 'old'] as $status): ?>
                <?php if (count($mobile_posts[$status])): ?>
                    <h3 class="text-xl text-white font-bold mt-6 mb-2 capitalize"><?php echo $status; ?> Posts</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <?php foreach ($mobile_posts[$status] as $post): ?>
                            <div class="bg-gray-900 p-5 rounded shadow-lg hover:shadow-none hover:[box-shadow:0_0_20px_white] hover:-translate-y-2 transform transition-all duration-300">
                                <h4 class="text-lg text-white font-bold mb-1"><?php echo htmlspecialchars($post['title']); ?></h4>
                                <p class="mb-2 text-gray-400"><?php echo htmlspecialchars($post['description']); ?></p>

                                <form method="POST" action="../../backend/controller/clickTracker.php">
                                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                    <input type="hidden" name="action" value="download">
                                    <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-900 transition" target="_blank">DOWNLOAD</button>
                                </form>    

                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </section>



        <section id="contact" class="mb-10">
  <div class="text-center">
    <h2 class="text-2xl text-white font-semibold mb-8">Contact & Support</h2>
  </div>

  <!-- Flex container: vertical on small, horizontal on large -->
  <div class="flex flex-col lg:flex-row items-start justify-center gap-8">

    <!-- Contact Form -->
    <form id="contact-form" action="https://formspree.io/f/xyzjnbqd" method="POST"
          class="bg-gray-900 p-6 rounded shadow max-w-lg w-full mx-auto">
      <h3 class="text-xl text-white font-semibold mb-4 text-center lg:text-left">Contact Me</h3>
      <div class="mb-4">
        <label class="block text-white mb-1 font-semibold">Your Email</label>
        <input class="w-full text-white border-gray-900 bg-gray-800 px-3 py-2 rounded" type="email" name="email" required>
      </div>
      <div class="mb-4">
        <label class="block text-white mb-1 font-semibold">Message</label>
        <textarea class="w-full text-white border-gray-900 bg-gray-800 px-3 py-2 rounded" name="message" required></textarea>
      </div>
      <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition w-full" type="submit">
        Send
      </button>
      <div id="form-msg"></div>
    </form>

    <!-- GCash QR Support -->
    <div class="bg-gray-900 p-6 rounded shadow max-w-xs w-full mx-auto flex flex-col items-center">
      <h3 class="text-xl text-white font-semibold mb-4">Support via GCash</h3>
      <img src="image.png" alt="NOT YET SUPPORTED" class="w-48 h-48 mb-2">
      <p class="text-gray-400 text-center">Scan to donate via GCash</p>
    </div>

  </div>
</section>



    </main>
    <footer id="footer" class="bg-gray-900 text-white py-6 mt-10">
        <div class="max-w-4xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-2 md:mb-0">
                &copy; <?php echo date('Y'); ?> cloud - cage
            </div>


            <div class="flex space-x-6 text-white items-center">
  <a href="https://github.com/REZ368" target="_blank" class="transform transition-transform hover:-translate-y-1">
    <i data-lucide="github" class="w-6 h-6"></i>
  </a>

  <a href="https://drive.google.com/file/d/1I2zyGKdKq7HXBnXXhA8H9QhcXYbaaHYK/view?usp=sharing" target="_blank" class="transform transition-transform hover:-translate-y-1">
    <i data-lucide="file-text" class="w-6 h-6"></i>
  </a>

  <a href="https://my-portfolio-renz.netlify.app/" target="_blank" class="transform transition-transform hover:-translate-y-1">
    <i data-lucide="monitor" class="w-6 h-6"></i>
  </a>
</div>


        </div>
    </footer>
    <script src="main.js"></script>
</body>
</html> 