<?php
session_start();

$host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'reviews_db';

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// Проверяем, вошёл ли пользователь
$loggedIn = isset($_SESSION['username']);
$username = $loggedIn ? $_SESSION['username'] : '';
$avatar = $loggedIn ? ($_SESSION['avatar'] ?? 'uploads/avatars/default.png') : '';

$showModal = false;
if ($loggedIn && isset($_GET['logged_in']) && $_GET['logged_in'] == '1') {
    $showModal = true;
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($login) || empty($password)) {
        $errors[] = "Все поля обязательны для заполнения.";
    }

    if (empty($errors)) {
        $conn = new mysqli($host, $db_user, $db_password, $db_name);
        if ($conn->connect_error) {
            $errors[] = "Ошибка подключения к базе данных: " . h($conn->connect_error);
        } else {
            $stmt = $conn->prepare("SELECT id, username, password, avatar FROM users WHERE username = ?");
            if ($stmt === false) {
                $errors[] = "Ошибка подготовки запроса: " . h($conn->error);
            } else {
                $stmt->bind_param("s", $login);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 0) {
                    $errors[] = "Пользователь с таким логином не найден.";
                } else {
                    $user = $result->fetch_assoc();
                    if (password_verify($password, $user['password'])) {
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['avatar'] = $user['avatar'] ?: 'uploads/avatars/default.png';
                        header("Location: log.php?logged_in=1");
                        exit;
                    } else {
                        $errors[] = "Неверный пароль.";
                    }
                }
                $stmt->close();
            }
            $conn->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <title>Вход в систему</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f9f9f9;
        }

        #page-wrapper {
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }

        #content {
            flex: 1 0 auto;
            padding: 20px;
            max-width: 500px; 
            width: 90%;
            margin: 40px auto;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            text-align: center;
        }

        form.login-form label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            text-align: left;
        }

        form.login-form input[type="text"],
        form.login-form input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        form.login-form button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #FF4D4D;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        form.login-form button:hover {
            background-color: #90d57a;
        }

        .error {
            color: #d8000c;
            background-color: #ffbaba;
            padding: 10px;
            border-radius: 4px;
            margin-top: 15px;
            text-align: left;
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
        <h2>Вход в систему</h2>

        <?php
        if (!empty($errors)) {
            echo '<div class="error"><ul>';
            foreach ($errors as $error) {
                echo '<li>' . h($error) . '</li>';
            }
            echo '</ul></div>';
        }
        ?>

        <?php if (!$showModal): ?>
        <form class="login-form" action="log.php" method="post" novalidate>
            <label for="login">Логин</label>
            <input type="text" id="login" name="login" placeholder="Введите логин" required />

            <label for="password">Пароль</label>
            <input type="password" id="password" name="password" placeholder="Введите пароль" required />

            <button type="submit">Войти</button>
        </form>
        <?php endif; ?>
    </div>

    <footer>
        <div id="foot1">
            <div id="f1"><p>8(39161) 4-29-31<br>Контакт-центр</p></div>
            <div id="f2"><p>663604, Российская Федерация,<br> Красноярский край, г. Канск,<br>ул 40 лет Октября, д. 15</p></div>
        </div>
        <div id="foot2"><p>© 2020 – 2022 Канская межрайонная больница</p></div>
    </footer>
</div>

<!-- Модальное окно -->
<div id="welcomeModal">
    <div>
        <span id="closeModal">&times;</span>
        <h2>Добро пожаловать, <span id="modalUsername"></span>!</h2>
        <img id="modalAvatar" src="" alt="Аватарка" style="max-width:150px; max-height:150px; border-radius:50%; margin-top:10px;">
        <a href="index.php" class="main-page-btn">Перейти на главную</a>
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
