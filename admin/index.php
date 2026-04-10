<?php
session_start();

// Проверка прав администратора
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;

if (!$isAdmin) {
    header('Location: ../index.php');
    exit;
}

$host = 'localhost';
$dbname = 'users';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Ошибка БД: " . $e->getMessage());
}

// Файл с маршрутами
$routesFile = '../routes.json';
$routes = file_exists($routesFile) ? json_decode(file_get_contents($routesFile), true) : [];

$message = '';
$messageType = '';

// ========== ДОБАВЛЕНИЕ МАРШРУТА ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_route'])) {
    $newId = count($routes) + 1;
    
    $newRoute = [
        'id' => $newId,
        'title' => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'duration' => $_POST['duration'] ?? '',
        'type' => $_POST['type'] ?? '',
        'category' => $_POST['category'] ?? '',
        'budget' => $_POST['budget'] ?? '',
        'kids' => isset($_POST['kids']) ? true : false,
        'pets' => isset($_POST['pets']) ? true : false,
        'coords' => $_POST['coords'] ?? '',
        'image' => $_POST['image'] ?? 'img/routes/default.jpg'
    ];
    
    $routes[] = $newRoute;
    file_put_contents($routesFile, json_encode($routes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
    $message = "✅ Маршрут '{$_POST['title']}' добавлен!";
    $messageType = 'success';
    
    // Перезагружаем маршруты
    $routes = json_decode(file_get_contents($routesFile), true);
}

// ========== РЕДАКТИРОВАНИЕ МАРШРУТА ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_route'])) {
    $editId = intval($_POST['route_id']);
    
    foreach ($routes as $key => $route) {
        if ($route['id'] === $editId) {
            $routes[$key] = [
                'id' => $editId,
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'duration' => $_POST['duration'] ?? '',
                'type' => $_POST['type'] ?? '',
                'category' => $_POST['category'] ?? '',
                'budget' => $_POST['budget'] ?? '',
                'kids' => isset($_POST['kids']) ? true : false,
                'pets' => isset($_POST['pets']) ? true : false,
                'coords' => $_POST['coords'] ?? '',
                'image' => $_POST['image'] ?? 'img/routes/default.jpg'
            ];
            break;
        }
    }
    
    file_put_contents($routesFile, json_encode($routes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
    $message = "✅ Маршрут обновлен!";
    $messageType = 'success';
    $routes = json_decode(file_get_contents($routesFile), true);
}

// ========== УДАЛЕНИЕ МАРШРУТА ==========
if (isset($_GET['delete_route'])) {
    $deleteId = intval($_GET['delete_route']);
    
    $routes = array_filter($routes, function($route) use ($deleteId) {
        return $route['id'] !== $deleteId;
    });
    
    // Переиндексация ID
    $routes = array_values($routes);
    foreach ($routes as $key => $route) {
        $routes[$key]['id'] = $key + 1;
    }
    
    file_put_contents($routesFile, json_encode($routes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
    $message = "🗑️ Маршрут удален!";
    $messageType = 'success';
    $routes = json_decode(file_get_contents($routesFile), true);
}

// ========== ОБНОВЛЕНИЕ СТАТУСА БРОНИРОВАНИЯ ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $bookingId = intval($_POST['booking_id']);
    $newStatus = $_POST['status'];
    
    $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
    $stmt->execute([$newStatus, $bookingId]);
    
    $message = "✅ Статус бронирования обновлен!";
    $messageType = 'success';
}

// Получаем данные для отображения
$bookings = $pdo->query("SELECT b.*, u.username FROM bookings b LEFT JOIN users u ON b.user_id = u.id ORDER BY b.created_at DESC")->fetchAll();
$users = $pdo->query("SELECT id, username, email, phone, created_at, is_admin FROM users ORDER BY id DESC")->fetchAll();

// Маршрут для редактирования
$editRoute = null;
if (isset($_GET['edit_route'])) {
    $editId = intval($_GET['edit_route']);
    foreach ($routes as $route) {
        if ($route['id'] === $editId) {
            $editRoute = $route;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель | Маршруты Удмуртии</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #0a0a0a; font-family: Arial, sans-serif; color: #fff; }
        .header { background: #000; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #FF00A0; flex-wrap: wrap; gap: 15px; }
        .header h1 { color: #FF00A0; font-size: 24px; }
        .container { max-width: 1400px; margin: 0 auto; padding: 20px; }
        .message { padding: 12px; border-radius: 10px; margin-bottom: 20px; text-align: center; }
        .message.success { background: rgba(0,255,0,0.1); color: #00ff00; border: 1px solid #00ff00; }
        .message.error { background: rgba(255,0,0,0.1); color: #ff4444; border: 1px solid #ff4444; }
        
        .tabs { display: flex; gap: 10px; margin-bottom: 30px; border-bottom: 1px solid #333; flex-wrap: wrap; }
        .tab-btn { background: transparent; border: none; padding: 12px 25px; color: #888; cursor: pointer; font-size: 16px; transition: 0.3s; }
        .tab-btn.active { color: #FF00A0; border-bottom: 3px solid #FF00A0; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .card { background: #111; border-radius: 20px; padding: 25px; margin-bottom: 30px; border: 1px solid #333; }
        .card h3 { color: #FF00A0; margin-bottom: 20px; font-size: 20px; }
        
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #ccc; font-size: 13px; }
        input, select, textarea { width: 100%; padding: 10px; background: #1a1a1a; border: 1px solid #333; border-radius: 8px; color: white; font-size: 14px; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #FF00A0; }
        .checkbox-group { display: flex; gap: 20px; align-items: center; }
        .checkbox-group label { display: flex; align-items: center; gap: 8px; cursor: pointer; }
        .checkbox-group input { width: auto; }
        
        button { background: #FF00A0; color: white; border: none; padding: 10px 25px; border-radius: 30px; cursor: pointer; font-size: 14px; transition: 0.3s; }
        button:hover { background: #cc0080; transform: translateY(-2px); }
        
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #333; }
        th { background: #1a1a1a; color: #FF00A0; }
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; }
        .status-new { background: #FF00A0; }
        .status-confirmed { background: #00aa00; }
        .status-cancelled { background: #ff4444; }
        
        .route-list { display: flex; flex-direction: column; gap: 15px; }
        .route-item { background: #1a1a1a; border-radius: 15px; padding: 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
        .route-info h4 { color: #FF00A0; margin-bottom: 5px; }
        .route-info p { color: #888; font-size: 12px; margin-top: 5px; }
        .route-actions { display: flex; gap: 10px; }
        .edit-btn { background: #00BFFF; padding: 6px 15px; border-radius: 20px; text-decoration: none; color: white; font-size: 12px; }
        .delete-btn { background: #ff4444; padding: 6px 15px; border-radius: 20px; text-decoration: none; color: white; font-size: 12px; }
        .back-link { display: inline-block; margin-top: 20px; color: #FF00A0; text-decoration: none; }
        
        @media (max-width: 768px) {
            .container { padding: 15px; }
            th, td { font-size: 12px; padding: 8px; }
            .route-item { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-crown"></i> Админ-панель | Маршруты Удмуртии</h1>
        <div>
            <span style="margin-right: 15px;">👑 <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="../index.php" style="background: #FF00A0; color: white; padding: 8px 20px; border-radius: 30px; text-decoration: none;">← На сайт</a>
        </div>
    </div>

    <div class="container">
        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="tabs">
            <button class="tab-btn active" onclick="showTab('routes')"><i class="fas fa-route"></i> Маршруты</button>
            <button class="tab-btn" onclick="showTab('add')"><i class="fas fa-plus"></i> Добавить маршрут</button>
            <button class="tab-btn" onclick="showTab('bookings')"><i class="fas fa-calendar-check"></i> Бронирования</button>
            <button class="tab-btn" onclick="showTab('users')"><i class="fas fa-users"></i> Пользователи</button>
        </div>

        <!-- ========== ВКЛАДКА: СПИСОК МАРШРУТОВ ========== -->
        <div id="tab-routes" class="tab-content active">
            <div class="card">
                <h3><i class="fas fa-list"></i> Все маршруты</h3>
                <?php if (empty($routes)): ?>
                    <p style="text-align: center; color: #888;">Нет добавленных маршрутов</p>
                <?php else: ?>
                    <div class="route-list">
                        <?php foreach ($routes as $route): ?>
                            <div class="route-item">
                                <div class="route-info">
                                    <h4><?php echo htmlspecialchars($route['title']); ?></h4>
                                    <p>
                                        <i class="fas fa-clock"></i> <?php echo $route['duration']; ?> | 
                                        <i class="fas fa-car"></i> <?php echo $route['type']; ?> | 
                                        <i class="fas fa-coins"></i> <?php echo $route['budget']; ?>
                                    </p>
                                    <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($route['coords']); ?></p>
                                </div>
                                <div class="route-actions">
                                    <a href="?edit_route=<?php echo $route['id']; ?>" class="edit-btn" onclick="showTab('edit'); return true;"><i class="fas fa-edit"></i> Редактировать</a>
                                    <a href="?delete_route=<?php echo $route['id']; ?>" class="delete-btn" onclick="return confirm('Удалить маршрут «<?php echo addslashes($route['title']); ?>»?')"><i class="fas fa-trash"></i> Удалить</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- ========== ВКЛАДКА: ДОБАВИТЬ МАРШРУТ ========== -->
        <div id="tab-add" class="tab-content">
            <div class="card">
                <h3><i class="fas fa-plus-circle"></i> Добавить новый маршрут</h3>
                <form method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Название маршрута *</label>
                            <input type="text" name="title" required>
                        </div>
                        <div class="form-group">
                            <label>Длительность (1 день, 2 дня и т.д.) *</label>
                            <input type="text" name="duration" required>
                        </div>
                        <div class="form-group">
                            <label>Тип *</label>
                            <select name="type" required>
                                <option value="Автомобильный">Автомобильный</option>
                                <option value="Пеший">Пеший</option>
                                <option value="Автобусный">Автобусный</option>
                                <option value="Водный">Водный</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Категория *</label>
                            <select name="category" required>
                                <option value="Исторический">Исторический</option>
                                <option value="Природный">Природный</option>
                                <option value="Экологический">Экологический</option>
                                <option value="Этнографический">Этнографический</option>
                                <option value="Гастрономический">Гастрономический</option>
                                <option value="Культурный">Культурный</option>
                                <option value="Волонтёрский">Волонтёрский</option>
                                <option value="Архитектурный">Архитектурный</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Бюджет *</label>
                            <select name="budget" required>
                                <option value="Эконом">Эконом</option>
                                <option value="Средний">Средний</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Локация (город или координаты) *</label>
                            <input type="text" name="coords" required>
                        </div>
                        <div class="form-group">
                            <label>Путь к картинке</label>
                            <input type="text" name="image" placeholder="img/nazvanie.png">
                        </div>
                        <div class="form-group checkbox-group">
                            <label><input type="checkbox" name="kids" value="1"> ✅ Можно с детьми</label>
                            <label><input type="checkbox" name="pets" value="1"> 🐾 Можно с животными</label>
                        </div>
                        <div class="form-group" style="grid-column: 1/-1;">
                            <label>Описание *</label>
                            <textarea name="description" rows="4" required placeholder="Полное описание маршрута..."></textarea>
                        </div>
                    </div>
                    <button type="submit" name="add_route"><i class="fas fa-save"></i> Сохранить маршрут</button>
                </form>
            </div>
        </div>

        <!-- ========== ВКЛАДКА: РЕДАКТИРОВАТЬ МАРШРУТ ========== -->
        <?php if ($editRoute): ?>
        <div id="tab-edit" class="tab-content">
            <div class="card">
                <h3><i class="fas fa-edit"></i> Редактировать маршрут</h3>
                <form method="POST">
                    <input type="hidden" name="route_id" value="<?php echo $editRoute['id']; ?>">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Название маршрута</label>
                            <input type="text" name="title" value="<?php echo htmlspecialchars($editRoute['title']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Длительность</label>
                            <input type="text" name="duration" value="<?php echo htmlspecialchars($editRoute['duration']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Тип</label>
                            <select name="type" required>
                                <option value="Автомобильный" <?php echo $editRoute['type'] == 'Автомобильный' ? 'selected' : ''; ?>>Автомобильный</option>
                                <option value="Пеший" <?php echo $editRoute['type'] == 'Пеший' ? 'selected' : ''; ?>>Пеший</option>
                                <option value="Автобусный" <?php echo $editRoute['type'] == 'Автобусный' ? 'selected' : ''; ?>>Автобусный</option>
                                <option value="Водный" <?php echo $editRoute['type'] == 'Водный' ? 'selected' : ''; ?>>Водный</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Категория</label>
                            <select name="category" required>
                                <option value="Исторический" <?php echo $editRoute['category'] == 'Исторический' ? 'selected' : ''; ?>>Исторический</option>
                                <option value="Природный" <?php echo $editRoute['category'] == 'Природный' ? 'selected' : ''; ?>>Природный</option>
                                <option value="Экологический" <?php echo $editRoute['category'] == 'Экологический' ? 'selected' : ''; ?>>Экологический</option>
                                <option value="Этнографический" <?php echo $editRoute['category'] == 'Этнографический' ? 'selected' : ''; ?>>Этнографический</option>
                                <option value="Гастрономический" <?php echo $editRoute['category'] == 'Гастрономический' ? 'selected' : ''; ?>>Гастрономический</option>
                                <option value="Культурный" <?php echo $editRoute['category'] == 'Культурный' ? 'selected' : ''; ?>>Культурный</option>
                                <option value="Волонтёрский" <?php echo $editRoute['category'] == 'Волонтёрский' ? 'selected' : ''; ?>>Волонтёрский</option>
                                <option value="Архитектурный" <?php echo $editRoute['category'] == 'Архитектурный' ? 'selected' : ''; ?>>Архитектурный</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Бюджет</label>
                            <select name="budget" required>
                                <option value="Эконом" <?php echo $editRoute['budget'] == 'Эконом' ? 'selected' : ''; ?>>Эконом</option>
                                <option value="Средний" <?php echo $editRoute['budget'] == 'Средний' ? 'selected' : ''; ?>>Средний</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Локация</label>
                            <input type="text" name="coords" value="<?php echo htmlspecialchars($editRoute['coords']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Путь к картинке</label>
                            <input type="text" name="image" value="<?php echo htmlspecialchars($editRoute['image'] ?? ''); ?>">
                        </div>
                        <div class="form-group checkbox-group">
                            <label><input type="checkbox" name="kids" value="1" <?php echo ($editRoute['kids'] ?? false) ? 'checked' : ''; ?>> ✅ Можно с детьми</label>
                            <label><input type="checkbox" name="pets" value="1" <?php echo ($editRoute['pets'] ?? false) ? 'checked' : ''; ?>> 🐾 Можно с животными</label>
                        </div>
                        <div class="form-group" style="grid-column: 1/-1;">
                            <label>Описание</label>
                            <textarea name="description" rows="4" required><?php echo htmlspecialchars($editRoute['description']); ?></textarea>
                        </div>
                    </div>
                    <button type="submit" name="edit_route"><i class="fas fa-save"></i> Сохранить изменения</button>
                    <a href="index.php" style="margin-left: 15px; color: #888;">Отмена</a>
                </form>
            </div>
        </div>
        <?php endif; ?>

        <!-- ========== ВКЛАДКА: БРОНИРОВАНИЯ ========== -->
        <div id="tab-bookings" class="tab-content">
            <div class="card">
                <h3><i class="fas fa-calendar-alt"></i> Все бронирования</h3>
                <?php if (empty($bookings)): ?>
                    <p style="text-align: center; color: #888;">Нет бронирований</p>
                <?php else: ?>
                    <div style="overflow-x: auto;">
                        <table>
                            <thead>
                                <tr><th>ID</th><th>Пользователь</th><th>ФИО</th><th>Телефон</th><th>Маршрут</th><th>Дата</th><th>Человек</th><th>Статус</th><th>Действие</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bookings as $b): ?>
                                <tr>
                                    <td><?= $b['id'] ?></td>
                                    <td><?= htmlspecialchars($b['username'] ?? 'Гость') ?></td>
                                    <td><?= htmlspecialchars($b['full_name']) ?></td>
                                    <td><?= htmlspecialchars($b['phone']) ?></td>
                                    <td><?= htmlspecialchars($b['route_name']) ?></td>
                                    <td><?= $b['travel_date'] ?></td>
                                    <td><?= $b['passengers'] ?></td>
                                    <td><span class="status-badge status-<?= $b['status'] ?>"><?= $b['status'] ?></span></td>
                                    <td>
                                        <form method="POST" style="display: flex; gap: 5px;">
                                            <input type="hidden" name="booking_id" value="<?= $b['id'] ?>">
                                            <select name="status" style="padding: 5px; border-radius: 10px;">
                                                <option value="new" <?= $b['status'] == 'new' ? 'selected' : '' ?>>Новая</option>
                                                <option value="confirmed" <?= $b['status'] == 'confirmed' ? 'selected' : '' ?>>Подтверждена</option>
                                                <option value="cancelled" <?= $b['status'] == 'cancelled' ? 'selected' : '' ?>>Отменена</option>
                                            </select>
                                            <button type="submit" name="update_status" style="padding: 5px 12px;">Обновить</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- ========== ВКЛАДКА: ПОЛЬЗОВАТЕЛИ ========== -->
        <div id="tab-users" class="tab-content">
            <div class="card">
                <h3><i class="fas fa-users"></i> Зарегистрированные пользователи</h3>
                <?php if (empty($users)): ?>
                    <p style="text-align: center; color: #888;">Нет пользователей</p>
                <?php else: ?>
                    <div style="overflow-x: auto;">
                        <table>
                            <thead>
                                <tr><th>ID</th><th>Логин</th><th>Email</th><th>Телефон</th><th>Дата регистрации</th><th>Админ</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $u): ?>
                                <tr>
                                    <td><?= $u['id'] ?></td>
                                    <td><?= htmlspecialchars($u['username']) ?></td>
                                    <td><?= htmlspecialchars($u['email']) ?></td>
                                    <td><?= htmlspecialchars($u['phone']) ?></td>
                                    <td><?= $u['created_at'] ?></td>
                                    <td><?= $u['is_admin'] ? '✅ Да' : '❌' ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Скрыть все вкладки
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            // Показать выбранную
            const targetTab = document.getElementById('tab-' + tabName);
            if (targetTab) {
                targetTab.classList.add('active');
            }
            
            // Обновить активную кнопку
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
        }
        
        // Если есть редактирование, показываем вкладку edit
        <?php if ($editRoute): ?>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.getElementById('tab-edit').classList.add('active');
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
        });
        <?php endif; ?>
    </script>
</body>
</html>