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
        <div class="confirm-container container">
            <h1>確認</h1>
            <form class="confirm-form" method="post" action="./finish.php">
                <p>お名前：</p>
                <p><?php echo $tmp_user_name; ?></p>
                <p>ユーザーID：</p>
                <p><?php echo $tmp_user_id; ?></p>
                <p>パスワード：</p>
                <p><?php echo $tmp_psword; ?></p>
                <button class="signup-btn">新規登録</button>
            </form>
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
