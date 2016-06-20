<?php
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
  if(isset($_GET['new'])){
    $name = $_GET['name'];
    $password = $_GET['passwd'];
    $sql = 'INSERT INTO User (name , password) VALUES(:name, :password);';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':password',$password);
    $result = $stmt->execute();
    if($result){
      echo "<script type='text/javascript'>";
      echo "alert('ユーザーの追加に成功しました。');";
      echo "location.href = '../Board/index.php';";
      echo "</script>";
    }else{
      echo "<script type='text/javascript'>";
      echo "alert('ユーザーIDが使用中です。');";
      echo "location.href = '../Board/index.php';";
      echo "</script>";

    }
  }else if(isset($_GET['login'])){
    $name = $_GET['name'];
    $password = $_GET['passwd'];
    $sql = 'SELECT name FROM User WHERE name = :name AND password = :password;';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':password',$password);
    $stmt->execute();
    $task = $stmt->fetch(PDO::FETCH_ASSOC);
    if($task['name'] == ""){
      echo "<script type='text/javascript'>";
      echo "alert('ユーザーIDが存在しないか、パスワードが違います。');";
      echo "location.href = '../Board/index.php';";
      echo "</script>";
    }else{
      $name = $task['name'];
      // header("Location: http://localhost/Board/board.php?name=".$name."&login='LOGIN'");
      header("Location: ../Board/board.php?name=".$name."&login='LOGIN'");
    }
  }
 ?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="../tmp/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="../tmp/js/bootstrap.min.js"></script>
  <title>ログインページ</title>
    <style type="text/css">
      body {
        background: url(main.jpg) no-repeat center center fixed;
        -webkit-background-size:cover;
        -moz-background-size:cover;
        -o-background-size:cover;
        background-size:cover;
      }
      .aaa{
        width: 60%;
        margin: auto;
        margin-top: 18%;
      }
      @media screen and (max-width:650px){
        .aaa{
          width: 90%;
          margin-top: 40%;
        }
      }

    </style>
    <script type="text/javascript">
      function change(str){
        while(str.substr(0,1) == ' ' || str.substr(0,1) == '　'){
          str = str.substr(1);
        }
        return str;
      }
      function check(frm){
        var text = change(frm.elements['name'].value);
        if(text==""){
          alert("ユーザー名を入力してください。");
          return false;
        }else{
          frm.elements['name'].value = text;
          return true;
        }
      }
    </script>
</head>
<body>
  <div class="container" >

    <div class="text-center aaa">

    <form action="../Board/index.php" method="get" onsubmit="return check(this)" >
      <div  class="form-group">
        <input type="text"  name="name" value="" placeholder="ユーザー名" class="form-control"><br>
        <input type="text"  name="passwd" value="" placeholder="パスワード" class="form-control"><br>
        <div class="btn-group btn-group-justified" role="group">
          <div class="btn-group" role="group">
            <button type="submit"  name="login" class="btn btn-default" >login</button>
          </div>
          <div class="btn-group" role="group">
            <button type="submit"  name="new" class="btn btn-default" >新規作成</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
</body>
</html>
