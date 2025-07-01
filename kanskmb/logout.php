<?php
session_start();

// Удаляем все переменные сессии
$_SESSION = array();

// Если используется cookie для сессии, удаляем cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Уничтожаем сессию
session_destroy();

// Перенаправляем пользователя на страницу входа или главную
header("Location: index.php");
exit;
?>