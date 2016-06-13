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
  if(isset($_GET['login'])){
    $name = $_GET['name'];
    $sql = 'SELECT name FROM User WHERE name = :name;';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name', $name);
    $stmt->execute();
    $task = $stmt->fetch(PDO::FETCH_ASSOC);
    if($task['name'] == ""){
      echo "<script type='text/javascript'>";
      echo "alert('ユーザーIDが存在しません。');";
      echo "</script>";
    }else{
      $name = $task['name'];
      header("Location: http://localhost/Board/board.php?name=".$name."&login='LOGIN'");
    }
  }
 ?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
  <title>ログインページ</title>
    <style type="text/css">
      .main {
        margin-top: 30%;
        text-align: center;
      }
      body {
    background-color: #90EE90;
    color: #7CFC00;
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
  <div class ="main">
<<<<<<< HEAD
    <form action="http://localhost/Board/board.php" method="get" onsubmit="return check(this)">
      <input type="text" size="21" name="name" value="" placeholder="ユーザー名">
      <input type="submit"style="width:10%;" name="login" value="Login"><br  />
      <input type="text" size="21" name="passwd" value="" placeholder="パスワード">
      <input type="submit" style="width:10%;" name="new" value="新規作成">
=======
    <form action="http://localhost/Board/index.php" method="get" onsubmit="return check(this)">
      <input type="text" name="name" value="" placeholder="ユーザー名">
      <input type="submit" name="login" value="Login">
>>>>>>> 28adfd29bf62ede99ad0c0ae8339dbdf346d7077
    </form>
  </div>
</body>
</html>
