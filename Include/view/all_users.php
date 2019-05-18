<!DOCTYPE HTML>
<html lang="ja">
<head>
    <title>CHATROOM</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./chatroom-pc.css">
</head>
<body>
    <header>
        <div class="header-box">
            <a href="./index.php" class="logo">CHATROOM</a>
            <a href="./logout.php" class="menu menu-btn">ログアウト</a>
            <p class="menu login_user_name">ユーザー名：<a href="mypage.php"><?php echo $user_name;?></a></p>
        </div>
    </header>
    <main>
        <div class="login-container container">
            <h1>ユーザ情報一覧</h1>
<?php foreach ($err_msg as $value) { ?>
<p class="err-msg"><?php echo $value; ?></p>
<?php } ?>
                <table class="user_data_table">
                    <tr>
                        <th>ユーザID</th>
                        <th>登録日</th>
                    </tr>
<?php foreach ($user_data as $value) { ?>
                    <tr>
                        <td class="name_width"><?php echo $value['user_name']; ?></td>
                        <td ><?php echo $value['created_at']; ?></td>
                    </tr>
<?php } ?>
            </table>
            <a class="return" href="./index.php">戻る</a>
        </div>
    </main>
    <footer>
        <p>test application</p>
    </footer>
</body>
</html>
