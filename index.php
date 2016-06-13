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
    <form action="http://localhost/Board/board.php" method="get" onsubmit="return check(this)">
      <input type="text" size="21" name="name" value="" placeholder="ユーザー名">
      <input type="submit"style="width:10%;" name="login" value="Login"><br  />
      <input type="text" size="21" name="passwd" value="" placeholder="パスワード">
      <input type="submit" style="width:10%;" name="new" value="新規作成">
    </form>
  </div>
</body>
</html>
