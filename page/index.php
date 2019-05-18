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
if (get_request_method() === 'POST') {
    //新規コメント投稿の場合
    if ((isset($_POST['sql_kind']) === TRUE) && ($_POST['sql_kind'] === 'new_comment')) {
        //投稿内容を格納
        $new_comment = get_post_data('new_comment');
        //エラーメッセージ
        if (trim($new_comment) === '') {
            $err_msg[] = '投稿内容が空です。';
        }
        if (count($err_msg) === 0) {
            //時間を取得
            $date = date('Y-m-d H:i:s');
            //データをまとめる
            $data = array(
                'user_num' => $user_num,
                'comment' => $new_comment,
                'created_at' => $date
            );
            //DBのlogに挿入
            if (insert_comment($link, $data) === FALSE) {
                $err_msg[] = '投稿失敗';
            }
        }
    }
    //コメント削除の場合
    if ((isset($_POST['sql_kind']) === TRUE) && ($_POST['sql_kind'] === 'delete')) {
        //ログ番号を格納
        $delete_post_num = get_post_data('post_num');
        //DBのログを削除
        if (delete_comment($link, $delete_post_num) === TRUE) {
            $success_msg[] = '削除成功';
        } else {
            $err_msg[] = '削除失敗';
        }
    }

}
//商品一覧取得
if (($data = get_log_data($link)) === NULL) {
    $err_msg[] = 'ログ取得エラー';
}
$log_data = array_reverse($data);
// データベース切断
close_db_connect($link);
// 特殊文字をHTMLエンティティに変換
$log_data = entity_assoc_array($log_data);
// var_dump($log_data[0]);
include_once '../../include/view/index.php';
?>
