<?php
/*
*  退会処理
*/
require_once '../../include/const/const.php';
require_once '../../include/model/function.php';
$success_msg = array();
$err_msg = array(); //エラーメッセージ
// セッション開始
session_start();
// セッション変数からログイン済みか確認
// セッション変数からユーザーデータ取得
if ((isset($_SESSION['user_id']) === TRUE) && (isset($_SESSION['user_name']) === TRUE) && (isset($_SESSION['user_num']) === TRUE)) {
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $user_num = $_SESSION['user_num'];
} else {
    // 非ログインの場合、topページへリダイレクト
    header('Location: top.php');
    exit;
}
//リクエストメソッド確認
if (get_request_method() === 'POST') {
    //「アカウント削除ボタン」が押されているか確認
    if (isset($_POST['sql_kind']) === true && $_POST['sql_kind'] === 'delete-account') {
        //データベース接続
        $link = get_db_connect();
        //アカウントを削除
        if (delete_account($link, $user_num) === TRUE) {
            $success_msg[] = 'アカウントを削除しました。またのご利用をお待ちしております。';
        } else {
            $err_msg[] = 'アカウント削除失敗';
        }
        // アカウント削除に成功したらログアウト処理
        if (count($err_msg) === 0) {
            // セッション名取得 ※デフォルトはPHPSESSID
            $session_name = session_name();
            // セッション変数を全て削除
            $_SESSION = array();
            // ユーザのCookieに保存されているセッションIDを削除
            if (isset($_COOKIE[$session_name])) {
                // sessionに関連する設定を取得
                $params = session_get_cookie_params();
                // sessionに利用しているクッキーの有効期限を過去に設定することで無効化
                setcookie($session_name, '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            // セッションIDを無効化
            session_destroy();
        }
    } else {
        $err_msg[] = 'マイページからアクセスしてください。';
    }
} else {
    $err_msg[] = 'マイページからアクセスしてください。';
}

include_once '../../include/view/delete-data.php';
?>
