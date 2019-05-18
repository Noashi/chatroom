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
          <a href="./mypage.php" class="mypage-menu top-menu-btn">マイページ</a> <!--携帯閲覧時のみ表示-->
          <a href="./logout.php" class="top-menu-btn">ログアウト</a>
        </div>
          <p class="menu login_user_name">ユーザー名：<a href="mypage.php"><?php echo $user_name;?></a></p> <!--PC閲覧時のみ表示-->
      </div>
    </header>
    <main>
        <div class="change-profile-container container">
            <h1>登録情報変更</h1>
<?php foreach ($err_msg as $value) { ?>
<p class="err-msg"><?php echo $value; ?></p>
<?php } ?>
<?php foreach ($success_msg as $value) { ?>
<p class="success-msg"><?php echo $value; ?></p>
<?php } ?>
            <form class="signup-form form" method="post" action="./change-profile.php" enctype="multipart/form-data">
                <label>お名前
                <input class="form-text" type="text" name="user_name" placeholder="20文字以内で入力"<?php if (isset($_POST['user_name']) === TRUE) { echo 'value="' . $_POST['user_name'] . '"'; } ?>></label>
                <label>アイコン
                <input class="icon-upload" type="file" name="new_img"></label>
                <label>ユーザーID
                <input class="form-text" type="text" name="user_id" placeholder="半角英数字で6文字～20文字まで"<?php if (isset($_POST['user_id']) === TRUE) { echo 'value="' . $_POST['user_id'] . '"'; } ?>></label>
                <label>新規パスワード
                <input class="form-text" type="password" name="new_psword" placeholder="半角英数字で6文字～20文字まで"></label>
                <label>確認用パスワード
                <input class="form-text" type="password" name="new_psword_confirm"></label>
                <label>現在のパスワード<span class="notice">※必須！</span>
                <input class="form-text" type="password" name="psword"></label>
                <button class="signup-btn">変更する</button>
            </form>
            <a class="return" href="./index.php">戻る</a>
        </div>
    </main>
    <footer>
      <p id="copyright">
          <small>test application</small>
      </p>
    </footer>
</body>
</html>
