<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

session_start();

// ========== ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ ==========
$host = 'localhost';
$dbname = 'users';
$username = 'root';
$password = '';

try {
    // Сначала подключаемся без базы данных
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Создаем базу данных если её нет
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    // Подключаемся к базе данных
    $pdo->exec("USE `$dbname`");
    
    // Создаем таблицу users с колонкой is_admin
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `users` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `username` VARCHAR(50) NOT NULL,
            `email` VARCHAR(100) NOT NULL,
            `phone` VARCHAR(20) NOT NULL,
            `password` VARCHAR(255) NOT NULL,
            `is_admin` TINYINT(1) NOT NULL DEFAULT 0,
            `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `username` (`username`),
            UNIQUE KEY `email` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    // Создаем таблицу отзывов (без модерации)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `reviews` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `user_id` INT(11) NOT NULL,
            `author` VARCHAR(100) NOT NULL,
            `route_name` VARCHAR(255) NOT NULL,
            `rating` INT(1) NOT NULL DEFAULT 5,
            `travel_date` DATE NOT NULL,
            `text` TEXT NOT NULL,
            `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `user_id` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
} catch(PDOException $e) {
    echo json_encode(['error' => 'Ошибка подключения к БД: ' . $e->getMessage()]);
    exit;
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';

// ========== РЕГИСТРАЦИЯ ==========
if ($action === 'register') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $username = trim($data['username'] ?? '');
    $email = trim($data['email'] ?? '');
    $phone = trim($data['phone'] ?? '');
    $password = $data['password'] ?? '';
    
    if (empty($username) || empty($email) || empty($phone) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Заполните все поля']);
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Неверный email']);
        exit;
    }
    
    if (strlen($password) < 4) {
        echo json_encode(['success' => false, 'message' => 'Пароль должен быть не менее 4 символов']);
        exit;
    }
    
    // Проверка на существование
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Логин или email уже существует']);
        exit;
    }
    
    // Хешируем пароль
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Сохраняем пользователя
    $stmt = $pdo->prepare("INSERT INTO users (username, email, phone, password) VALUES (?, ?, ?, ?)");
    
    if ($stmt->execute([$username, $email, $phone, $hashedPassword])) {
        echo json_encode(['success' => true, 'message' => 'Регистрация успешна! Теперь войдите.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка при регистрации']);
    }
    exit;
}

// ========== ВХОД ==========
if ($action === 'login') {
    $data = json_decode(file_get_contents('php://input'), true);
    $username = trim($data['username'] ?? '');
    $password = $data['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Заполните все поля']);
        exit;
    }
    
    // Ищем пользователя по username или email
    $stmt = $pdo->prepare("SELECT id, username, email, phone, password, is_admin FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch();
    
    // Проверяем пароль
    $passwordValid = false;
    if ($user) {
        if (password_verify($password, $user['password'])) {
            $passwordValid = true;
        }
        elseif ($user['password'] === $password) {
            $passwordValid = true;
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $updateStmt->execute([$hashed, $user['id']]);
        }
    }
    
    if ($user && $passwordValid) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['phone'] = $user['phone'];
        $_SESSION['is_admin'] = $user['is_admin'];
        
        echo json_encode(['success' => true, 'user' => ['username' => $user['username']]]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Неверный логин или пароль']);
    }
    exit;
}

// ========== ПРОВЕРКА СТАТУСА ==========
if ($action === 'check') {
    if (isset($_SESSION['user_id'])) {
        echo json_encode([
            'logged_in' => true,
            'user' => [
                'username' => $_SESSION['username'],
                'email' => $_SESSION['email']
            ]
        ]);
    } else {
        echo json_encode(['logged_in' => false]);
    }
    exit;
}

// ========== ВЫХОД ==========
if ($action === 'logout') {
    session_destroy();
    echo json_encode(['success' => true]);
    exit;
}

// ========== ПОЛУЧИТЬ ОТЗЫВЫ ==========
if ($action === 'get_reviews') {
    try {
        $stmt = $pdo->prepare("SELECT id, author, route_name, rating, travel_date, text, created_at FROM reviews ORDER BY created_at DESC LIMIT 20");
        $stmt->execute();
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($reviews);
    } catch(PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

// ========== ДОБАВИТЬ ОТЗЫВ ==========
if ($action === 'add_review') {
    // Проверяем авторизацию
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Необходимо войти в аккаунт']);
        exit;
    }
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    $user_id = $_SESSION['user_id'];
    $author = trim($data['author'] ?? '');
    $route_name = trim($data['route'] ?? '');
    $rating = intval($data['rating'] ?? 5);
    $travel_date = $data['travel_date'] ?? '';
    $text = trim($data['text'] ?? '');
    
    // Валидация
    if (empty($author) || empty($route_name) || empty($travel_date) || empty($text)) {
        echo json_encode(['success' => false, 'message' => 'Заполните все поля']);
        exit;
    }
    
    if ($rating < 1 || $rating > 5) {
        $rating = 5;
    }
    
    // Проверка даты (не в будущем)
    $selectedDate = new DateTime($travel_date);
    $today = new DateTime();
    $today->setTime(0, 0, 0);
    if ($selectedDate > $today) {
        echo json_encode(['success' => false, 'message' => 'Дата поездки не может быть в будущем']);
        exit;
    }
    
    if (strlen($text) < 10) {
        echo json_encode(['success' => false, 'message' => 'Отзыв должен содержать минимум 10 символов']);
        exit;
    }
    
    // Сохраняем отзыв
    try {
        $stmt = $pdo->prepare("INSERT INTO reviews (user_id, author, route_name, rating, travel_date, text) VALUES (?, ?, ?, ?, ?, ?)");
        $result = $stmt->execute([$user_id, $author, $route_name, $rating, $travel_date, $text]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Спасибо! Ваш отзыв успешно добавлен']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Ошибка при сохранении отзыва']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Ошибка базы данных: ' . $e->getMessage()]);
    }
    exit;
}

echo json_encode(['error' => 'Неизвестное действие']);
?>