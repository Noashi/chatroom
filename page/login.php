<?php
/*
*  ログインページ
*/
require_once '../../include/const/const.php';
require_once '../../include/model/function.php';
$err_msg = array(); //エラーメッセージ
// セッション開始
session_start();
//ログイン済みならトップページへ遷移
if (isset($_SESSION['user_id']) === TRUE) {
    header('Location: index.php');
    exit;
}
//リクエストメソッドを取得
if (get_request_method() === 'POST') {
    //ポストされたデータを取得
    $user_id = get_post_data('user_id');
    $psword = get_post_data('psword');
    // エラーメッセージ
    if (trim($user_id) === '') {
        $err_msg[] = 'ユーザー名を入力してください';
    }
    if (trim($psword) === '') {
        $err_msg[] = 'パスワードを入力してください';
    }
    if (count($err_msg) === 0) {
        //DB接続
        $link = get_db_connect();
        //DBからログインデータを検索
        if (($data = get_user_id($link, $user_id, $psword)) === '') {
            $err_msg[] = 'ユーザーID取得失敗';
        }
        //DB接続解除
        close_db_connect($link);
        // 登録データを取得できたか確認
        if (isset($data[0]['user_id']) === TRUE) {
            // セッション変数にuser_idを保存
            $_SESSION['user_id'] = $data[0]['user_id'];
            $_SESSION['user_name'] = $data[0]['user_name'];
            $_SESSION['user_num'] = $data[0]['user_num'];
            // ログイン済みユーザーのホームページへリダイレクト
            header('Location: index.php');
            exit;
        } else {
            // ログイン失敗
            $err_msg[] = 'ユーザーID、もしくはパスワードが違います。';
        }
    }
}
include_once '../../include/view/login.php';
?>
