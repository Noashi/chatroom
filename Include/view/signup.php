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
            <a href="./login.php" class="menu-btn">ログイン</a>
        </div>
    </header>
    <main>
        <div class="signup-container container">
            <h1>新規登録</h1>
<?php foreach ($err_msg as $value) { ?>
<p class="err-msg"><?php echo $value; ?></p>
<?php } ?>
            <form class="signup-form form" method="post" action="./signup.php">
                <label for="input_user_name">お名前</label>
                <input type="text" name="user_name" id="input_user_name" placeholder="20文字以内で入力"<?php if (isset($_POST['user_name']) === TRUE) { echo 'value="' . $_POST['user_name'] . '"'; } ?>>
                <label for="input_user_id">ユーザーID</label>
                <input type="text" name="user_id" id="input_user_id"placeholder="半角英数字で6文字～20文字まで"<?php if (isset($_POST['user_id']) === TRUE) { echo 'value="' . $_POST['user_id'] . '"'; } ?>>
                <label for="input_psword">パスワード</label>
                <input type="password" name="psword" id="input_psword"placeholder="半角英数字で6文字～20文字まで">
                <label for="input_psword_confirm">確認用パスワード</label>
                <input type="password" name="psword_confirm" id="input_psword_confirm">
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
