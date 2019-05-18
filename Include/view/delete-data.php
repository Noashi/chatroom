<!DOCTYPE HTML>
<html lang="ja">
<head>
  <title>CHATROOM</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="./chatroom-phone.css" media="(max-width: 600px)">
  <link rel="stylesheet" href="./chatroom-pc.css" media="screen and (min-width: 600px) and (max-width: 1000px)">
  <link rel="stylesheet" href="./chatroom-pc.css" media="screen and (min-width: 1000px)">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
      <div class="header-box">
          <a href="./index.php" class="logo">CHATROOM</a>
          <div class="menu">
              <a href="./signup.php" class="top-menu-btn">新規登録</a>
              <a href="./login.php" class="top-menu-btn">ログイン</a>
          </div>
    </header>
    <main>
        <div class="container">
<?php foreach ($err_msg as $value) { ?>
<p class="err-msg"><?php echo $value; ?></p>
<?php } ?>
<?php foreach ($success_msg as $value) { ?>
<p class="success-msg"><?php echo $value; ?></p>
<?php } ?>
<a class="return" href="./top.php">トップへ</a>
        </div>
    </main>
    <footer>
      <p id="copyright">
          <small>test application</small>
      </p>
    </footer>
</body>
</html>
