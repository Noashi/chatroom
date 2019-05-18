<?php
/*
*  スレッドページ
*/
require_once '../../include/const/const.php';
require_once '../../include/model/function.php';
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
// データベース接続
$link = get_db_connect();
// ユーザーデータ取得
if (($user_data = get_user_data($link)) === '') {
    $err_msg[] = 'ユーザーデータ取得失敗';
}
// データベース切断
close_db_connect($link);
// 特殊文字をHTMLエンティティに変換
$user_data = entity_assoc_array($user_data);
include_once '../../include/view/all_users.php';
?>
