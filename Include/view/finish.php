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
            <a href="./login.php" class="menu menu-btn">ログイン</a>
        </div>
    </header>
    <main>
        <div class="finish-container container">
<?php foreach($err_msg as $value) { ?>
<p class="msg err-msg"><?php echo $value; ?></p>
<?php } ?>
<?php if(count($success_msg) !== 0) { ?>
            <h1>登録完了</h1>
            <p class="msg success-msg"><?php echo $success_msg[0]; ?></p>
<?php } ?>
            <a class="return" href="./top.php">戻る</a>
        </div>
    </main>
    <footer>
      <p id="copyright">
          <small>test application</small>
      </p>
    </footer>
</body>
</html>
