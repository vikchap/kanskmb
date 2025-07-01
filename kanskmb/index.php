<?php
session_start();

$loggedIn = isset($_SESSION['username']);
$username = $loggedIn ? $_SESSION['username'] : '';
$avatar = $loggedIn ? ($_SESSION['avatar'] ?? 'uploads/avatars/default.png') : '';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://indestructibletype.com/fonts/Jost.css" type="text/css" charset="utf-8" />
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Главная</title>
    <style>
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
    <div id="cap">
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

      <div id="menu">
        <div id="m1"><p><a href="index2.html" style="color: rgb(255, 255, 255);">Сведения о медицинской <br>организации</a></p></div>
        <div id="m2"><p><a href="index3.html" style="color: rgb(255, 255, 255);">Информация для пациентов</a></p></div>
        <div id="m3"><p><a href="index4.html" style="color: rgb(255, 255, 255);">Медицинские работники</a></p></div>
        <div id="m4"><p><a href="index5.html" style="color: rgb(255, 255, 255);">Контактная информация</a></p></div>
    </div>
     
    <div id="branch">
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

    <div id="novosti">
        <div id="nov"><h2>Новости и события</h2></div>
        <div class="nov1" style="width: 300px; margin-right: 16px;"><a href="index6.php">
        
            <div class="photo">
            <img src="https://kanskmb.ru/content/img_cache/article_medium/articles/385886acda5e5fc9a69cc2d817a779a1.jpg" alt="Переход сайта на ресурс Госвеб">
            </div>
    
            <p>Переход сайта на ресурс Госвеб</p>  
            <span>15 апреля 2024 г.</span>
    
        </a></div></div>
    </div>
       
    <div id="pols">
        <div id="polsss"><h2>Полезные ссылки</h2></div>  

        <div id="polsss"> 
                    <a id="ps1" href="https://anketa.minzdrav.gov.ru/staticmojustank/2221#reviews" target="_blank">
                        <img src="ps1.png" alt="" style="width:300px;height:auto;">
                    </a>

                    <a id="ps1" href="https://aodms.mirsud24.ru/" target="_blank">
                        <img src="ps2.png" alt="" style="width:150px;height:auto;">
                    </a>

                    <a id="ps1" href="https://www.web-pacient.ru/" target="_blank">
                        <img src="ps3.png" alt="" style="width:350px;height:auto;">
                    </a>

                    <a id="ps1" href="https://nmfo-vo.edu.rosminzdrav.ru/#/login" target="_blank">
                        <img src="ps4.png" alt="" style="width:350px;height:auto;">
                    </a>
    </div>

        <div id="help">
            <div id="help1"><h2>В помощь пациенту</h2></div>  
            

            <div id="h1"><p><a href="index19.php" target="_blank">Горячая линия по обеспечению граждан техническими средствами реабилитации</a><br>
                <a href="index20.php" target="_blank">Профилактика онкологических заболеваний</a><br>
                <a href="index21.php" target="_blank">Личный кабинет пациента "Мое здоровье"</a><br>
                <a href="index22.php" target="_blank">Льготный электронный рецепт</a></p>
                </p>
            </div>
            <div id="foto">
            <img src="hospital.png" alt="" >
            </div>
        </div>

    <div id="polezss">
        <a id="pss1" href="https://kraszdrav.ru/" target="_blank">
            <img src="pss1.png" alt="" style="width:300px;height:auto;">
        </a>

        <a id="pss1" href="https://www.krasmed.ru/" target="_blank">
            <img src="pss2.png" alt="" style="width:350px;height:auto;">
        </a>

        <a id="pss1" href="https://www.rosminzdrav.ru/" target="_blank">
            <img src="pss3.png" alt="" style="width:350px;height:auto;">
        </a>

        <a id="pss1" href="http://kansk-adm.ru/" target="_blank">
            <img src="pss4.png" alt="" style="width:320px;height:auto;">
        </a>
    </div>

    <footer>
        <div id="foot1">
            <div id="f1"><p>8(39161) 4-29-31<br>Контакт-центр</p></div>
            <div id="f2"><p>663604, Российская Федерация,<br> Красноярский край, г. Канск,<br>ул 40 лет Октября, д. 15</p></div>
                </div>
        <div id="foot2"><p>© 2020 – 2022 Канская межрайонная больница</p></div>
    </footer>
</body>
</html>


