<?php
/*
*  スレッドページ
*/
require_once '../include/const/const.php';
require_once '../include/model/function.php';
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
// データベース接続
$link = get_db_connect();
// ユーザーデータ取得
if (($my_data = get_my_data($link, $user_num)) === '') {
    $err_msg[] = 'ユーザーデータ取得失敗';
}
// データベース切断
close_db_connect($link);
// 特殊文字をHTMLエンティティに変換
$my_data = entity_assoc_array($my_data);
include_once '../../include/view/mypage.php';
?>
