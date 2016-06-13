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
    $sql = 'DELETE FROM Board WHERE id = :num';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':num',$num,PDO::PARAM_INT);
    $stmt->execute();
    header( "Location: ../Board/board.php?");
  }
?>
<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Refresh" content="5">
  <style type="text/css">
  .right{text-align: right;}
  .message{
    background-color:#E0F2F7;
    margin-bottom: 10px;
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
<body>
  <div class="right">
    <a href="../Board/index.php" onclick="delCookie()">ログアウト</a>
  </div>
  <?php
  echo $name."さん";
  ?>
  <?php
  echo '<form action="" method="GET" onsubmit="return check(this)">';
  echo  '<input type="text" name="text">';
  echo  '<input type="hidden" name="name" value='.$name.' >';
  echo  '　<input type="submit" name="add" value="add">';
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
          echo "<div class='container message'>";
          echo "<form method='get' action=''>".$task['name']."  ";
          echo $task['time'];
          echo '<input type="hidden" name="name" value='.$name.' >';
          echo "　<button type='submit' name='delete' value='".$task['id']."'><i class='fa fa-trash-o' aria-hidden='true'></i></button>";
          echo "<br>".$task['text'];
          echo "</form></div>";
        }
      ?>
</body>
</html>
