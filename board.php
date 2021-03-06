<?php
if(isset($_COOKIE['name'])){
  $name  = $_COOKIE['name'];
}else{
  if(isset($_GET['login'])){
    $cName = $_GET['name'];
    setcookie('name',$cName);
    header("Location: ../Board/board.php");
  }else{
    header("Location: ../Board/index.php");
  }
}
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

  if(isset($_GET['login'])){
    $cName = $_GET['name'];
    setcookie('name',$cName);
    header("Location: ../Board/board.php");
  }else if(isset($_GET['add'])){
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
?>
<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Refresh" content="30">
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
    background-color:rgba(255,255,255,0.6);
    margin-bottom: 10px;
    font-size: 16px;
    padding: 2px;
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
  </script>
  <title>簡易掲示板</title>
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.css" rel="stylesheet">
</head>
<body onload="document.form1.text.focus();">
  <div class="container">
  <div style="text-align:right">
    <a href="../Board/index.php" class="btn btn-default"　onclick="delCookie()">ログアウト</a>
  </div>
  <?php
  // echo $name."さん";
  echo '<span class="label label-default">'.$name.'さん</span>'
  ?>
  <?php
  echo '<form name="form1" action="" method="GET" onsubmit="return check(this)" class="form-inline">';
  echo  '<input type="text" name="text" class="form-control">';
  echo  '<input type="hidden" name="name" value='.$name.' >';
  // echo  '　<input type="submit" name="add" value="add" >';
  echo '<button type="submit" class="btn btn-default" name="add">送信</button>';
  echo '</form>';
  ?>
  <hr>
  <?php
        try{
          $dsn = 'mysql:dbname=BoardDB;host=localhost;charset=utf8';
          $user = 'root';
          $password = '';
          $dbh = new PDO($dsn, $user, $password);
          $dbh->query('SET NAMES utf8');
          $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }catch(PDOException $e){
          die('エラー');
        }
        $sql = 'SELECT * FROM Board ORDER BY id DESC;';
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        while($task = $stmt->fetch(PDO::FETCH_ASSOC)){
          echo "<div class='media message' style='word-wrap: break-word;'>";
          echo "<form method='get' action=''>".$task['name']."  ";
          echo $task['time'];
          echo '<input type="hidden" name="name" value='.$name.' >';
          echo "　<button type='submit' name='delete' style='float: right;' class='btn btn-default btn-xs' value='".$task['id']."'><i class='fa fa-trash-o' aria-hidden='true'></i></button>";
          echo "<br>".$task['text'];
          echo "</form>";
          echo "</div>";
        }
      ?>
    </div>
</body>
</html>
