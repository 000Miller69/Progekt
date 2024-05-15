<?php 

require "../connect.php";

$exam_user = "SELECT * FROM `files` WHERE `status` = 'Ожидание'";
$result = mysqli_query($connect, $exam_user); 
$resp = $result->fetch_all(MYSQLI_ASSOC);
session_start();
if($_SESSION['user']['login'] && $_SESSION['user']['role'] == 'admin') {} else {
    header('Location: '. '/');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сайт</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include ("../components/Header/header.php"); ?>
    <div class="container">
        <?php 
            if(count($resp) == 0) {
                echo "<h1 style='color: orange; text-align: center; margin-top: 40px;'>Постов на проверку нету</h1>";
            }
            for ($i=0; $i < count($resp); $i++) {

        ?> 
        <div class="item2">
            <img src="/image/<?= $resp[$i]['image'] ?>" width="140" height="140" alt="">
            <div class="data">
                <p>Статус: <span><?= $resp[$i]['status'] ?></span></p>
                <h2><?= $resp[$i]['name'] ?></h2>
                <p style="margin-bottom: 20px; word-wrap: break-word; width: 530px;"><?= $resp[$i]['description'] ?></p>
                <div style="display:flex;">
                    <?php 
                    
                    if(isset($_POST['yes'])) {
                        $id = $_POST['yes'];
                        $exam_user = "UPDATE `files` SET `status`='Одобрено' WHERE `id` = '$id'";
                        $result = mysqli_query($connect, $exam_user); 
                        echo "<script>alert('одобрено!'); location.href='/admin/index.php';</script>";
                    }
                    if(isset($_POST['id']) and isset($_POST['no'])) {
                        $id = $_POST['id'];
                        $no = $_POST['no'];
                        $exam_user = "UPDATE `files` SET `status`='Отказ', `comment`='$no' WHERE `id` = '$id'";
                        $result = mysqli_query($connect, $exam_user); 
                        echo "<script>alert('отклонена!'); location.href='/admin/index.php';</script>";
                    }
                    
                    
                    ?>
                    <form action="" method="POST"><input style="position: absolute; top: -1000px;" name="yes" type="text" value="<?= $resp[$i]['id'] ?>"><button>Одобрить</button></form>
                    <form action="" method="POST"><input style="position: absolute; top: -1000px;" name="id" type="text" value="<?= $resp[$i]['id'] ?>"><button>Отказать</button> <input type="text" name="no" placeholder="Комментарий для отказа"></form>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</body>
</html>