<?php
if(isset($_GET['login'])){
  $cName = $_GET['name'];
  setcookie('name',$cName);
  header("Location: ../Board/board.php");
}else{
  if(isset($_COOKIE['name'])){
    $name  = $_COOKIE['name'];
  }else{
    header("Location: ../Board/index.php");
  }
}
if(isset($_GET['add']) || isset($_GET['delete'])){
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
    $text = htmlspecialchars($text, ENT_QUOTES);
    $sql = 'INSERT INTO Board (name , time, text) VALUES(:name, :time, :text)';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':text', $text, PDO::PARAM_STR);
    $stmt->bindValue(':time', $time);
    $stmt->execute();
    $dbh = null;
    header("Location: ../Board/board.php");
  }else if(isset($_GET['delete'])){
    $num =$_GET['delete'];
    $cName = $_GET['name'];
    $sql = 'DELETE FROM Board WHERE id = :num AND name = :name';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':num',$num,PDO::PARAM_INT);
    $stmt->bindValue(':name',$cName);
    $stmt->execute();
    header( "Location: ../Board/board.php?");
  }
}
?>
<!DOCTYPE HTML>
<html>
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="../tmp/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../tmp/js/bootstrap.min.js"></script>
    <style type="text/css">
    body {
      background: url(main.jpg) no-repeat center center fixed;
      -webkit-background-size:cover;
      -moz-background-size:cover;
      -o-background-size:cover;
      background-size:cover;
    }
    .message{
      background-color:rgba(255,255,255,0.65);
      margin-bottom: 10px;
      font-size: 16px;
      padding: 5px;
      border-radius: 4px;
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
        var text = change(frm.elements['text'].value);
        if(text==""){
          alert("テキストを入力してください。");
          return false;
        }else{
          frm.elements['text'].value = text;
          return true;
        }
      }
      function delCookie(){
         var date = new Date();
         date.setTime(0);
         document.cookie = "name=;expires="+date.toGMTString();
      }
      $('#logout').on('click',function(){
        $.cookie(name,null);
      });
      $(document).ready(function(){
        $('#message').load('message.php');
        var timer_id = setInterval(function(){
          $('#message').load('message.php');
        },1000);
      });
    </script>
    <title>簡易掲示板</title>
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.css" rel="stylesheet">
  </head>
  <body onload="document.form1.text.focus();">
    <div class="container">
      <div style="text-align:right">
        <a href="../Board/index.php" class="btn btn-default btn-xs"　id="logout" onclick="delCookie()">ログアウト</a>
      </div>
      <?php
        echo '<span class="label label-default">'.$name.'さん</span>';
        echo '<form name="form1" action="" method="GET" onsubmit="return check(this)" class="form-inline">';
          echo '<div class="row">';
            echo '<div class="col-xs-9 col-md-8">';
              echo '<input type="text" name="text" class="form-control" style="width:100%">';
            echo '</div>';
            echo '<input type="hidden" name="name" value='.$name.' >';
            echo '<div class="col-xs-2 col-md-2">';
              echo '<button type="submit" class="btn btn-default" name="add">送信</button>';
            echo '</div>';
          echo '</div>';
        echo '</form>';
      ?>
      <hr>
      <div id="message"></div><!--DB情報表示-->
    </div><!--container end-->
  </body>
</html>
