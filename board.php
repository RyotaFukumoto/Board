<?php
  $name  = $_GET['name'];
  try{
    $dsn = 'mysql:dbname=BoardDB;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db = NULL;
  }catch(PDOException $e){
    die('エラー');
  }
  if(isset($_GET['add'])){
    $text = $_GET['text'];
    $time = date("Y-m-d H:i:s");
    echo $time;
    $text = htmlspecialchars($text, ENT_QUOTES);
    $sql = 'INSERT INTO Board (name , time, text) VALUES(:name, :time, :text)';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':text', $text, PDO::PARAM_STR);
    $stmt->bindValue(':time', $time);
    $stmt->execute();
    $dbh = null;
  }
?>
<!DOCTYPE HTML>
<html>
<head>
  <style type="text/css">
  .right{text-align: right;}
  </style>
  <title>簡易掲示板</title>
</head>
<body>
  <div class="right">
    <a href="http://localhost/Board/index.php" >ログアウト</a>
  </div>
  <?php
  echo $name."さん。";
  ?>
  <?php
  echo '<form action="" method="GET">';
  echo  '<input type="text" name="text">';
  echo  '<input type="hidden" name="name" value='.$name.' >';
  echo  '<input type="submit" name="add" value="add">';
  echo '</form>';
  ?>
  <hr>
</body>
</html>
