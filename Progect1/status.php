<?php 
session_start();
require "connect.php";

$user_id = $_SESSION['user']['id'];

$exam_user = "SELECT * FROM `files` WHERE `user_id` = '$user_id'";
$result = mysqli_query($connect, $exam_user); 
$resp = $result->fetch_all(MYSQLI_ASSOC);

if(isset($_POST['name']) and isset($_POST['id']) and isset($_POST['description'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $random = rand(1, 999999999999999999);

    $filename = $_FILES["file_upload"]["name"];
    $full_file = "$random-$filename";
    $tempname_file = $_FILES["file_upload"]["tmp_name"];
    $folder_file = "./file/" . $full_file;

    if (move_uploaded_file($tempname_file, $folder_file)) {
        $sql = "UPDATE `files` SET `name`='$name',`description`='$description',`file`='$full_file',`status`='Ожидание' WHERE `id` = '$id'";
        $result = mysqli_query($connect, $sql);
        if($result) { 
            echo "<script>alert('успешно!'); location.href='status.php';</script>"; 
        } else { 
            echo "<script>alert('ошибка!')</script>"; 
        }    
    }
}


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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include ("components/Header/header.php"); ?>
    <div class="container">
        <?php 
        if(count($resp) == 0) {
            echo "<h1 style='color: orange; text-align: center; margin-top: 40px;'>У вас еще нету книг</h1>";
        }
            for ($i=0; $i < count($resp); $i++) {

        ?> 
        <div class="item2">
            <img src="/image/<?= $resp[$i]['image'] ?>" width="140" height="140" alt="">
            <div class="data">
                <h2><?= $resp[$i]['name'] ?></h2>
                <p style="margin-bottom: 20px; word-wrap: break-word; width: 530px;"><?= $resp[$i]['description'] ?></p>
                <h3>Статус: 
                    <?php if($resp[$i]['status'] == "Одобрено") { echo "<style> .y {color: green} </style>"; ?><span class="y"><?= $resp[$i]['status'] ?></span> <?php } ?>
                    <?php if($resp[$i]['status'] == "Ожидание") { echo "<style> .x {color: #ffa100} </style>"; ?><span class="x"><?= $resp[$i]['status'] ?></span> <?php } ?>
                    <?php if($resp[$i]['status'] == "Отказ") { echo "<style> .z {color: red} </style>"; ?><span class="z"><?= $resp[$i]['status'] ?></span> <?php } ?>
                </h3>
                <?php if($resp[$i]['comment']) { ?> <p style="margin-bottom: 20px; word-wrap: break-word; width: 530px;">Комментрий: <?= $resp[$i]['comment'] ?></p> <?php }?>
            </div>
        </div>
        <?php } ?>
    </div>

    <style>
        .data {
            position: relative;
        }
        .open {
            position: absolute;
            right: 0;
            bottom: 1px;
        }

        .modal {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: rgba(0,0,0,0.5); 
    z-index: 1050;
    opacity: 0; 
    -webkit-transition: opacity 200ms ease-in; 
    -moz-transition: opacity 200ms ease-in;
    transition: opacity 200ms ease-in;
    pointer-events: none; 
    margin: 0;
    padding: 0;
}

.modal:target {
    opacity: 1; 
	  pointer-events: auto; 
    overflow-y: auto;
}

.modal-dialog {
    position: relative;
    width: auto;
    margin: 10px;
}
@media (min-width: 576px) {
  .modal-dialog {
      max-width: 500px;
      margin: 30px auto; 
  }
}

.modal-content {
    position: relative;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
    background-color: #fff;
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    border: 1px solid rgba(0,0,0,.2);
    border-radius: .3rem;
    outline: 0;
}
@media (min-width: 768px) {
  .modal-content {
      -webkit-box-shadow: 0 5px 15px rgba(0,0,0,.5);
      box-shadow: 0 5px 15px rgba(0,0,0,.5);
  }
}

.modal-header {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: justify;
    -webkit-justify-content: space-between;
    -ms-flex-pack: justify;
    justify-content: space-between;
    padding: 15px;
    border-bottom: 1px solid #eceeef;
}
.modal-title {
    margin-top: 0;
    margin-bottom: 0;
    line-height: 1.5;
    font-size: 1.25rem;
    font-weight: 500;
}

.close {
    float: right;
    font-family: sans-serif;
    font-size: 24px;
    font-weight: 700;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    opacity: .5;
    text-decoration: none;
}

.close:focus, .close:hover {
    color: #000;
    text-decoration: none;
    cursor: pointer;
    opacity: .75;
}

.modal-body {
  position: relative;
    -webkit-box-flex: 1;
    -webkit-flex: 1 1 auto;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 15px;
    overflow: auto;
}
    </style>
</body>
</html>