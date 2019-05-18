<?php
/*
*  新規登録完了ページ
*/
require_once '../include/const/const.php';
require_once '../include/model/function.php';
//メッセージを格納する配列
$err_msg = array();
$success_msg = array();
// セッション開始
session_start();
//セッション変数が存在しているか確認
if((isset($_SESSION['tmp_user_name']) === TRUE) && (isset($_SESSION['tmp_user_id']) === TRUE) && (isset($_SESSION['tmp_psword']) === TRUE)) {
    $tmp_user_name = $_SESSION['tmp_user_name'];
    $tmp_user_id = $_SESSION['tmp_user_id'];
    $tmp_psword = $_SESSION['tmp_psword'];
} else {
    //セッション変数が存在していなければトップページへ
    header('Location: ./top.php');
    exit;
}
//リクエストメソッドを確認
if (get_request_method() === 'POST') {
    //時間取得
    $date = date('Y-m-d H:i:s');
    //画像データ取得
    $image_file = 'grape.png';
    // データベース接続
    $link = get_db_connect();
    //新規ユーザーデータをまとめる
    $data = array(
        'user_id' => $tmp_user_id,
        'user_name' => $tmp_user_name,
        'password' => $tmp_psword,
        'icon_image' => $image_file,
        'created_at' => $date
    );
    //新規ユーザーデータをMySQLへ登録
    if (insert_new_user_data($link, $data) === TRUE) {
        $success_msg[] = '新規登録が完了しました。';
    } else {
        $err_msg[] = 'DBエラー：インサート';
    }
    //セッション変数削除
    unset($_SESSION['tmp_user_name']);
    unset($_SESSION['tmp_user_id']);
    unset($_SESSION['tmp_psword']);
} else {
    //リクエストメソッドがPOSTでなければトップページへ
    header('Location: ./top.php');
    exit;
}
include_once '../include/view/finish.php';
?>
