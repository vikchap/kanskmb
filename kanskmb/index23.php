<?php
session_start();

$host = 'localhost';        
$db_user = 'root'; 
$db_password = ''; 
$db_name = 'reviews_db';

// Функция для безопасного вывода
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$loggedIn = isset($_SESSION['username']);
$username = $loggedIn ? $_SESSION['username'] : '';
$avatar = $loggedIn ? ($_SESSION['avatar'] ?? 'uploads/avatars/default.png') : '';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $loggedIn) {
    // Берём имя пользователя из сессии, а не из формы
    $name = $username;
    $email = trim($_POST["email"] ?? '');
    $rating = $_POST["rating"] ?? '';
    $comments = trim($_POST["comments"] ?? '');

    // Валидация
    if (empty($rating) || empty($comments)) {
        $message = "<p style='color:red;'>Пожалуйста, заполните все обязательные поля.</p>";
    } else {
        $conn = new mysqli($host, $db_user, $db_password, $db_name);
        if ($conn->connect_error) {
            die("Ошибка подключения: " . $conn->connect_error);
        }
        $stmt = $conn->prepare("INSERT INTO reviews (name, email, rating, comments) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            die("Ошибка подготовки запроса: " . $conn->error);
        }
        $stmt->bind_param("ssis", $name, $email, $rating, $comments);
        if ($stmt->execute()) {
            $message = "<p style='color:green;'>Ваш отзыв успешно отправлен. Спасибо!</p>";
        } else {
            $message = "<p style='color:red;'>Ошибка при отправке отзыва: " . h($stmt->error) . "</p>";
        }
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="index23.css">
    <link rel="stylesheet" href="https://indestructibletype.com/fonts/Jost.css" type="text/css" charset="utf-8" />
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Контактная информация</title>
    <style>
        /* Ваша стилизация кнопок входа/регистрации */
        #auth-buttons {
            display: flex;
            flex-direction: row;
            gap: 16px; 
            margin: 7px 0 20px 0; 
            justify-content: flex-start; 
            align-items: center;
        }
        .auth-btn {
            background-color: #FF4D4D;
            color: #fff;
            text-decoration: none;
            padding: 8px 24px;
            border-radius: 6px;
            font-weight: bold;
            font-family: inherit;
            margin-right: 20px;
            transition: background 0.2s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border: none;
            font-size: 16px;
            display: inline-block;

        }
        .auth-btn:hover {
            background-color: #B5FAA0;
            color: #333;
        }
        /* Сообщения */
        #message {
            margin-top: 10px;
            font-weight: bold;
        }
        /* Форма отзыва */
        form.feedback-form label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        form.feedback-form input[type="email"],
        form.feedback-form select,
        form.feedback-form textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: inherit;
            font-size: 14px;
        }
        form.feedback-form textarea {
            resize: vertical;
            min-height: 100px;
        }
        form.feedback-form button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #FF4D4D;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        form.feedback-form button:hover {
            background-color: #90d57a;
        }
        .leave_a_review {
            margin-left: -15px; 
        }

       #top4 img {
        display: block; 
        margin-left: 50px;
        margin-bottom: 10px; 
        }

        #auth-buttons {
            display: flex;
            margin-top: -35px;
            margin-left: 60px;
            gap: 20px;
            justify-content: flex-start;
        }

        .user-avatar{
            width: 60px;
            height: 60px;
            margin-right: 10px;
        }
    </style>
</head>
<body> 
    <div id="cap" class="clearfix">
        <header>
            <div id="top1"><a href="index.php"><img src="logo.png" width="110" height="100"></a></div>
            <div id="vvv"><p>Канская <br>межрайонная<br> больница</p></div>
            <div id="top2"><p>663604, Красноярский край,<br>г. Канск, ул. 40 лет Октября д 15</p></div>
            <div id="top3"><a href="tel:8(39161) 4-29-31">8(39161) 4-29-31</a><br><span>Контакт-центр</span><br><a href="index23.php">Оставить отзыв о больнице</a></div>
            <div id="top4">
                <img src="versdlslab.png" alt="Логотип" />
                <div id="auth-buttons">
    <?php if ($loggedIn): ?>
        <img src="<?= htmlspecialchars($avatar) ?>" alt="Аватарка пользователя" class="user-avatar" />
        <span><?= htmlspecialchars($username) ?></span>
        <a href="logout.php" class="auth-btn">Выйти</a>
    <?php else: ?>
        <a href="log.php" class="auth-btn">Вход</a>
        <a href="reg.php" class="auth-btn">Регистрация</a>
    <?php endif; ?>
</div>

            </div>
        </header>
    </div>

    <div id="menu" class="clearfix">
        <div id="m1"><p><a href="index2.html" style="color: rgb(255, 255, 255);">Сведения о медицинской <br>организации</a></p></div>
        <div id="m2"><p><a href="index3.html" style="color: rgb(255, 255, 255);">Информация для пациентов</a></p></div>
        <div id="m3"><p><a href="index4.html" style="color: rgb(255, 255, 255);">Медицинские работники</a></p></div>
        <div id="m4"><p><a href="index5.html" style="color: rgb(255, 255, 255);">Контактная информация</a></p></div>
    </div>
     
    <div id="branch" class="clearfix">
        <nav id="nav">
            <div id="br1">
                <p><a href="index7.html">Управление и администрация</a></p>
                <p><a href="index8.html">Круглосуточный и дневной стационар</a></p>
                <p><a href="index9.html">Поликлиника № 1</a></p>
                <p><a href="index10.html">Поликлиника №2</a></p>
            </div>
            <div id="br2">
                <p><a href="index11.html">Женская консультация</a></p>
                <p><a href="index12.html">Станция скорой медицинской помощи</a></p>
                <p><a href="index13.html">Родильный дом</a></p>
                <p><a href="index14.html">Филиал №1 Астафьевская УБ</a></p>
            </div>
            <div id="br3">
                <p><a href="index15.html">Филиал № 2 Браженская УБ</a></p>
                <p><a href="index16.html">Филиал № 3 Таеженская УБ</a></p>
                <p><a href="index17.html">Филиал № 4 Чечеульская УБ</a></p>
                <p><a href="index18.html">Центр амбулаторной онкологической помощи</a></p>
            </div>
        </nav>
    </div> 

    <div id="text1">
        <h2>Оставьте отзыв о больнице</h2>
    </div>

    <div id="bl1" class="clearfix">
        <div id="t1">
            <?php if ($loggedIn): ?>
                <?= $message ?>
                <form class="feedback-form" action="#" method="post">
                    <label>Ваше имя</label>
                    <input type="text" value="<?= h($username) ?>" disabled />

                    <label for="email">Email (необязательно)</label>
                    <input type="email" id="email" name="email" placeholder="Введите ваш email" />

                    <label for="rating">Оценка больницы</label>
                    <select id="rating" name="rating" required>
                      <option value="" disabled selected>Выберите оценку</option>
                      <option value="5">5 - Отлично</option>
                      <option value="4">4 - Хорошо</option>
                      <option value="3">3 - Удовлетворительно</option>
                      <option value="2">2 - Плохо</option>
                      <option value="1">1 - Очень плохо</option>
                    </select>

                    <label for="comments">Ваш отзыв</label>
                    <textarea id="comments" name="comments" placeholder="Напишите ваш отзыв здесь..." required></textarea>

                    <button type="submit">Отправить отзыв</button>
                </form>
            <?php else: ?>
                <p class="leave_a_review">Чтобы оставить отзыв, пожалуйста, <a href="log.php">войдите</a> или <a href="reg.php">зарегистрируйтесь</a>.</p>
            <?php endif; ?>
        </div>
    </div>


    <div style="clear: both;"></div>
    <footer>
        <div id="foot1" class="clearfix">
            <div id="f1"><p>8(39161) 4-29-31<br>Контакт-центр</p></div>
            <div id="f2"><p>663604, Российская Федерация,<br> Красноярский край, г. Канск,<br>ул 40 лет Октября, д. 15</p></div>
        </div>
        <div id="foot2"><p>© 2020 – 2022 Канская межрайонная больница</p></div>
    </footer>
</body>
</html>
