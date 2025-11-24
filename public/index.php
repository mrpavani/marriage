<?php
session_start();

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Auth.php';

// Simple Router
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove /public prefix if present (fix for some shared hosting envs)
if (strpos($uri, '/public') === 0) {
    $uri = substr($uri, 7);
}

// Helper to load views
function view($name, $data = [])
{
    extract($data);
    require __DIR__ . "/../views/{$name}.php";
}

// Routes
if ($uri === '/' || $uri === '/index.php') {
    // Public Home
    $db = Database::getInstance()->getConnection();

    // Fetch Settings
    $stmt = $db->query("SELECT * FROM settings");
    $settings = [];
    while ($row = $stmt->fetch()) {
        $settings[$row['key']] = $row['value'];
    }

    // Fetch Photos
    $stmt = $db->query("SELECT * FROM photos ORDER BY created_at DESC");
    $photos = $stmt->fetchAll();

    view('home', ['settings' => $settings, 'photos' => $photos]);

} elseif ($uri === '/rsvp' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle RSVP Submission
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $guests = $_POST['guests'] ?? 0;
    $message = $_POST['message'] ?? '';

    if ($name && $guests) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO rsvps (name, phone, guests_count, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $phone, $guests, $message]);
    }

    header('Location: /?rsvp_success=1');
    exit;

} elseif ($uri === '/vote' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle Poll Vote
    $option = $_POST['option'] ?? null;
    if ($option) {
        $db = Database::getInstance()->getConnection();

        // Ensure table exists
        $db->exec("CREATE TABLE IF NOT EXISTS poll_votes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            option_index INTEGER NOT NULL,
            ip_address TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        // Check if MySQL or SQLite (adjust syntax if needed, assuming SQLite based on previous context or generic SQL)
        // Actually, previous code used 'INSERT OR REPLACE' which suggests SQLite, but I fixed it for MySQL.
        // Let's assume MySQL for the CREATE TABLE to be safe or use generic syntax.
        // Wait, the user environment might be MySQL.
        // Let's use a safer CREATE TABLE for MySQL/SQLite compatibility if possible or just MySQL.
        // Given the 'INSERT OR REPLACE' fix was for MySQL, I will use MySQL syntax.
        $db->exec("CREATE TABLE IF NOT EXISTS poll_votes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            option_index INT NOT NULL,
            ip_address VARCHAR(45),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB");

        $stmt = $db->prepare("INSERT INTO poll_votes (option_index, ip_address) VALUES (?, ?)");
        $stmt->execute([$option, $_SERVER['REMOTE_ADDR']]);
    }
    header('Location: /?vote_success=1');
    exit;

} elseif ($uri === '/admin/login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        if (Auth::login($username, $password)) {
            header('Location: /admin/dashboard');
            exit;
        } else {
            $error = "Invalid credentials";
            view('admin/login', ['error' => $error]);
        }
    } else {
        view('admin/login');
    }

} elseif ($uri === '/admin/logout') {
    Auth::logout();
    header('Location: /admin/login');
    exit;

} elseif ($uri === '/admin/dashboard') {
    Auth::requireLogin();

    $db = Database::getInstance()->getConnection();

    // Handle Settings Update
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_settings'])) {
        $stmt = $db->prepare("INSERT INTO settings (`key`, `value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)");
        $stmt->execute(['couple_names', $_POST['couple_names']]);
        $stmt->execute(['couple_names_color', $_POST['couple_names_color'] ?? '#000000']);
        $stmt->execute(['wedding_date', $_POST['wedding_date']]);
        $stmt->execute(['wedding_address', $_POST['wedding_address']]);
        $stmt->execute(['pix_key', $_POST['pix_key']]);
        $stmt->execute(['honeymoon_dest_1', $_POST['honeymoon_dest_1']]);
        $stmt->execute(['honeymoon_dest_2', $_POST['honeymoon_dest_2']]);
        $stmt->execute(['honeymoon_dest_3', $_POST['honeymoon_dest_3']]);
        $success = "Configurações atualizadas!";
    }

    // Handle Photo Upload
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir))
            mkdir($uploadDir, 0777, true);

        $filename = uniqid() . '_' . basename($_FILES['photo']['name']);
        $targetPath = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
            $stmt = $db->prepare("INSERT INTO photos (filename) VALUES (?)");
            $stmt->execute([$filename]);
            $success = "Foto enviada!";
        }
    }

    // Handle Photo Delete
    if (isset($_GET['delete_photo'])) {
        $id = $_GET['delete_photo'];
        $stmt = $db->prepare("SELECT filename FROM photos WHERE id = ?");
        $stmt->execute([$id]);
        $photo = $stmt->fetch();
        if ($photo) {
            $filePath = __DIR__ . '/uploads/' . $photo['filename'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $db->prepare("DELETE FROM photos WHERE id = ?")->execute([$id]);
        }
        header('Location: /admin/dashboard');
        exit;
    }

    // Fetch Data
    $stmt = $db->query("SELECT * FROM settings");
    $settings = [];
    while ($row = $stmt->fetch()) {
        $settings[$row['key']] = $row['value'];
    }

    $rsvps = $db->query("SELECT * FROM rsvps ORDER BY created_at DESC")->fetchAll();
    $photos = $db->query("SELECT * FROM photos ORDER BY created_at DESC")->fetchAll();

    // Fetch Poll Results
    try {
        $poll_results = $db->query("SELECT option_index, COUNT(*) as count FROM poll_votes GROUP BY option_index")->fetchAll(PDO::FETCH_KEY_PAIR);
    } catch (Exception $e) {
        $poll_results = []; // Table might not exist yet
    }

    view('admin/dashboard', [
        'settings' => $settings,
        'rsvps' => $rsvps,
        'photos' => $photos,
        'poll_results' => $poll_results,
        'success' => $success ?? null
    ]);

} else {
    http_response_code(404);
    echo "404 Not Found";
}
