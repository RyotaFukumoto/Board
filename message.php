<?php
  try{
    $dsn = 'mysql:dbname=BoardDB;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $name  = $_COOKIE['name'];
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
