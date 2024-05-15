<?php 

require "connect.php";
session_start();
$user_id = $_SESSION['user']['id'];

if(isset($_POST['name']) and isset($_POST['description'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $random = rand(1, 999999999999999999);

    $filename = $_FILES["file_upload"]["name"];
    $image = $_FILES["image"]["name"];

    $full_file = "$random-$filename";
    $full_image = "$random-$image";

    $tempname_file = $_FILES["file_upload"]["tmp_name"];
    $tempname_image = $_FILES["image"]["tmp_name"];

    $folder_file = "./file/" . $full_file;
    $folder_image = "./image/" . $full_image;

    if (move_uploaded_file($tempname_image, $folder_image)) {
        $sql = "INSERT INTO files (name, description, image, file, user_id, status) VALUES ('$name', '$description', '$full_image', '$full_file', '$user_id', 'Ожидание')";
        $result = mysqli_query($connect, $sql);
        if($result) { 
            echo "<script>alert('успешно отправленна на рассмотрение'); location.href='profile.php';</script>"; 
        } else { 
            echo "<script>alert('ошибка!')</script>"; 
        }    
    }
}

$exam_user = "SELECT * FROM `users` WHERE `id` = '$user_id'";
$result = mysqli_query($connect, $exam_user); 
$response = $result->fetch_all(MYSQLI_ASSOC);

if($_SESSION['user']['login']) {} else {
    header('Location: '. 'index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сайт</title>
</head>
<body>
    <?php include ("components/Header/header.php"); ?>
        <div style="position: absolute; bottom: 50px; left: 250px">
            <a href="status.php" class="btn">Ваши товары</a>
            <?php if($_SESSION['user']['role'] == 'admin') { ?>
                <a href="/admin/index.php" class="btn">Проверить товары</a>
            <?php }?>
            <a href="logout.php" class="btn">Выйти</a>
        </div>
    <form action="" method="POST" enctype="multipart/form-data">
        <h2>Добавления товара</h2>
        <input name="name" type="text" placeholder="Название">
        <textarea style="padding: 10px;" name="description" id="" cols="30" rows="10" placeholder="Описание"></textarea>
        <label for="">Картинка</label>
        <input name="image" type="file">
        <button>Подать на рассмотрение</button>
    </form>
</body>
</html>