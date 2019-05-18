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
        <div class="index-container">
            <div class="post-comment">
<?php foreach ($err_msg as $value) { ?>
<p class="err-msg"><?php echo $value; ?></p>
<?php } ?>
<?php foreach ($success_msg as $value) { ?>
<p class="success-msg"><?php echo $value; ?></p>
<?php } ?>
                <form class="comment-form" action="./index.php" method="post">
                    <input class="comment-text" type="text" name="new_comment" placeholder="自由につぶやこう！">
                    <button class="comment-button" name="comment">送信</button>
                    <input type="hidden" name="sql_kind" value="new_comment">
                </form>
                <div class="float-clear"></div>
            </div>
<?php foreach ($log_data as $value) {
if ($value['user_num'] === $user_num) { ?>
            <div class="log log-me">
                <div class="icon icon-me">
                    <img class="icon-image" alt="アイコン" width="50" height="50" src="./images/<?php echo $value['image'];?>">
                </div>
                <div class="comment comment-me">
                    <div class="balloon1-left">
                        <p class="user-name"><?php echo $value['user_name'];?><span class="time"><?php echo $value['created_at'];?></span></p>
                        <p class="say"><?php echo $value['comment'];?></p>
                        <form method="post" action="./index.php">
                            <button class="delete-button" name="delete" onclick="return confirm('発言を取り消します。よろしいですか？')">削除</button>
                            <input type="hidden" name="sql_kind" value="delete">
                            <input type="hidden" name="post_num" value="<?php echo $value['post_num'];?>">
                        </form>
                    </div>
                </div>
                <div class="float-clear"></div>
            </div>
<?php } else { ?>
            <div class="log log-others">
                <div class="icon icon-others">
                    <img class="icon-image" alt="アイコン" width="50" height="50" src="./images/<?php echo check_log_img($value['image']);?>">
                </div>
                <div class="comment comment-others">
                    <div class="balloon1-right">
                        <p class="user-name"><?php echo check_log_name($value['user_name']);?><span class="time"><?php echo $value['created_at'];?></span></p>
                        <p class="say"><?php echo $value['comment'];?></p>
                    </div>
                </div>
                <div class="float-clear"></div>
            </div>
<?php } ?>
<?php } ?>
        </div>
    </main>
    <footer>
      <p id="copyright">
          <small>test application</small>
      </p>
    </footer>
</body>
</html>
