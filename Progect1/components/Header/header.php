<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
            <a class="header__logo" href="/"><h2 style="text-align: center;margin: 20px 0px;">Сайт</h2></a>
            <hr style="margin-bottom: 30px" />
            <div style="margin-left: 70px;">
                <a class="btn auth" href="auth.php">Войти</a>
                <a class="btn auth_user" href="/profile.php"><?= $_SESSION['user']['login']; ?></a>
                <?php
                
                if(isset($_SESSION['login'])) {
                    echo "<style>.auth {display: none}; .auth_user {display: block;}</style>";
                } else {
                    echo "<style>.auth_user {display: none;}</style>";
                }
                
                ?>
            </div>
    </header>
</body>
</html>