<?php
session_start();

$host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'reviews_db';

// функция для безопасного вывода
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$showModal = false;
$username = '';
$avatar = '';

if (isset($_GET['registered']) && $_GET['registered'] == '1' && isset($_SESSION['username'])) {
    $showModal = true;
    $username = $_SESSION['username'];
    $avatar = $_SESSION['avatar'];

    // Очищаем сессию, чтобы не показывать окно при обновлении страницы
    unset($_SESSION['username'], $_SESSION['avatar']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_post = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    $errors = [];

    // Валидация
    if (mb_strlen($username_post) < 3) {
        $errors[] = "Имя пользователя должно быть не менее 3 символов.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Введите корректный email.";
    }
    if (mb_strlen($password) < 6) {
        $errors[] = "Пароль должен содержать не менее 6 символов.";
    }
    if ($password !== $password_confirm) {
        $errors[] = "Пароли не совпадают.";
    }

    // Обработка аватарки
    $avatar_path = null;
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
        $allowed_types = ['image/jpeg', 'image/png'];
        $max_size = 2 * 1024 * 1024; // 2MB

        $avatar = $_FILES['avatar'];

        if ($avatar['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "Ошибка при загрузке аватарки.";
        } elseif (!in_array(mime_content_type($avatar['tmp_name']), $allowed_types)) {
            $errors[] = "Аватарка должна быть в формате JPG или PNG.";
        } elseif ($avatar['size'] > $max_size) {
            $errors[] = "Размер аватарки не должен превышать 2MB.";
        } else {
            $ext = pathinfo($avatar['name'], PATHINFO_EXTENSION);
            $new_filename = uniqid('avatar_', true) . '.' . $ext;
            $upload_dir = __DIR__ . '/uploads/avatars/';

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $destination = $upload_dir . $new_filename;

            if (move_uploaded_file($avatar['tmp_name'], $destination)) {
                $avatar_path = 'uploads/avatars/' . $new_filename;
            } else {
                $errors[] = "Не удалось сохранить аватарку.";
            }
        }
    }

    if (empty($errors)) {
        $conn = new mysqli($host, $db_user, $db_password, $db_name);
        if ($conn->connect_error) {
            echo '<p class="error">Ошибка подключения к базе данных: ' . h($conn->connect_error) . '</p>';
            exit;
        }

        // Проверка уникальности username и email
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username_post, $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            echo '<p class="error">Пользователь с таким именем или email уже существует.</p>';
            $stmt->close();
            $conn->close();
        } else {
            $stmt->close();

            // хэширование пароля
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Подготовка запроса с полем avatar (если есть)
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, avatar) VALUES (?, ?, ?, ?)");
            if ($stmt === false) {
                echo '<p class="error">Ошибка подготовки запроса: ' . h($conn->error) . '</p>';
                $conn->close();
                exit;
            }
            $stmt->bind_param("ssss", $username_post, $email, $password_hash, $avatar_path);

            if ($stmt->execute()) {
                // Сохраняем в сессию для показа модального окна
                $_SESSION['username'] = $username_post;
                $_SESSION['avatar'] = $avatar_path ?: 'uploads/avatars/default.png';

                // Редирект для показа модального окна
                header("Location: reg.php?registered=1");
                exit;
            } else {
                echo '<p class="error">Ошибка при регистрации: ' . h($stmt->error) . '</p>';
            }
            $stmt->close();
            $conn->close();
        }
    } else {
        // Вывод ошибок
        echo '<div class="error"><ul>';
        foreach ($errors as $error) {
            echo '<li>' . h($error) . '</li>';
        }
        echo '</ul></div>';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <title>Регистрация нового пользователя</title>
    <style>
        /* Сброс отступов и высоты для html и body */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f9f9f9;
        }

        /* Контейнер всей страницы */
        #page-wrapper {
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }

        /* Основной контент занимает всё доступное пространство */
        #content {
            flex: 1 0 auto;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            margin-top: 15px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        /* Стили формы */
        form.register-form label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        form.register-form input[type="text"],
        form.register-form input[type="email"],
        form.register-form input[type="password"],
        form.register-form input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form.register-form button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #FF4D4D;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        form.register-form button:hover {
            background-color: #90d57a;
        }

        .error {
            color: #d8000c;
            background-color: #ffbaba;
            padding: 10px;
            border-radius: 4px;
            margin-top: 15px;
        }

        .message {
            color: green;
            padding: 10px;
            border-radius: 4px;
            margin-top: 15px;
        }

        /* Модальное окно */
        #welcomeModal {
            display: none;
            position: fixed;
            top:0; left:0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.6);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        #welcomeModal > div {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 320px;
            text-align: center;
            position: relative;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }
        #closeModal {
            position: absolute;
            top: 10px; right: 15px;
            cursor: pointer;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .main-page-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 20px;
            background: #90d57a;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        /* Футер */
        footer {
            flex-shrink: 0;
            background-color: #f2f2f2;
            padding: 15px 20px;
            text-align: center;
            font-size: 14px;
            color: #555;
            margin-top: 20px;
        }

        #foot1 {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        #foot1 div p {
            margin: 0;
            line-height: 1.4;
        }

    </style>
</head>
<body>

<div id="page-wrapper">
    <div id="content">

        <div id="text1">
            <h2>Регистрация нового пользователя</h2>
        </div>

        <div id="bl1">
            <div id="t1">
                <?php if (!$showModal): ?>
                <form class="register-form" action="reg.php" method="post" enctype="multipart/form-data" novalidate>
                    <label for="username">Имя пользователя</label>
                    <input type="text" id="username" name="username" placeholder="Введите имя пользователя" required />

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Введите email" required />

                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" placeholder="Введите пароль" required />

                    <label for="password_confirm">Подтвердите пароль</label>
                    <input type="password" id="password_confirm" name="password_confirm" placeholder="Подтвердите пароль" required />

                    <label for="avatar">Аватарка (jpg, png, max 2MB)</label>
                    <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png" />

                    <button type="submit">Зарегистрироваться</button>
                </form>
                <?php endif; ?>
            </div>
        </div>

    </div> <!-- конец content -->

    <footer>
        <div id="foot1">
            <div id="f1"><p>8(39161) 4-29-31<br>Контакт-центр</p></div>
            <div id="f2"><p>663604, Российская Федерация,<br> Красноярский край, г. Канск,<br>ул 40 лет Октября, д. 15</p></div>
        </div>
        <div id="foot2"><p>© 2020 – 2022 Канская межрайонная больница</p></div>
    </footer>
</div> <!-- конец page-wrapper -->

<!-- Модальное окно -->
<div id="welcomeModal">
    <div>
        <span id="closeModal">&times;</span>
        <h2>Добро пожаловать, <span id="modalUsername"></span>!</h2>
        <img id="modalAvatar" src="" alt="Аватарка" style="max-width:150px; max-height:150px; border-radius:50%; margin-top:10px;">
        <a href="log.php" class="main-page-btn">Войти в личный кабинет</a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var showModal = <?php echo json_encode($showModal); ?>;
    var username = <?php echo json_encode($username); ?>;
    var avatar = <?php echo json_encode($avatar); ?>;

    if (showModal) {
        var modal = document.getElementById('welcomeModal');
        var modalUsername = document.getElementById('modalUsername');
        var modalAvatar = document.getElementById('modalAvatar');
        var closeBtn = document.getElementById('closeModal');

        modalUsername.textContent = username;
        modalAvatar.src = avatar;

        modal.style.display = 'flex';

        closeBtn.onclick = function() {
            modal.style.display = 'none';
        };

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        };
    }
});
</script>

</body>
</html>
