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
        <div class="container">
<?php foreach ($err_msg as $value) { ?>
<p class="err-msg"><?php echo $value; ?></p>
<?php } ?>
<?php foreach ($success_msg as $value) { ?>
<p class="success-msg"><?php echo $value; ?></p>
<?php } ?>
            <h1>マイページ</h1>
<?php foreach ($my_data as $value) { ?>
            <img class="icon-image" alt="アイコン" width="100" height="100" src="./images/<?php echo $value['image'];?>">
            <button class="change-profile-button" onclick="location.href='./change-profile.php'">登録情報変更</button>
            <table class="profile">
                <tr>
                    <td>名前</td>
                    <td><?php echo $value['user_name'];?></td>
                </tr>
                <tr>
                    <td>ユーザーID</td>
                     <td><?php echo $value['user_id'];?></td>
                </tr>
            </table>
<?php } ?>
            <form action="./delete-data.php" method="post">
                <button class="delete-data" type="submit" name="delete-data" onclick="return confirm('アカウントを削除します。よろしいですか？')">アカウント削除</button>
                <input type="hidden" name="sql_kind" value="delete-account">
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
