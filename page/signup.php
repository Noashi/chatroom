<?php
/*
*  新規登録ページ
*/
require_once '../../include/const/const.php';
require_once '../../include/model/function.php';
$err_msg = array(); //エラーメッセージ
// セッション開始
session_start();
//リクエストメソッドを取得
if (get_request_method() === 'POST') {
    //ポストされたデータを取得
    $tmp_user_name = get_post_data('user_name');
    $tmp_user_id = get_post_data('user_id');
    $tmp_psword = get_post_data('psword');
    $psword_confirm = get_post_data('psword_confirm');
    //確認用パスワードが一致しているか
    if ($tmp_psword === $psword_confirm) {
        //エラーメッセージ
        if (($result = check_user_name($tmp_user_name, 'お名前')) !== '') {
            $err_msg[] = $result;
        }
        if (($result = check_user_id($tmp_user_id, 'ユーザーID')) !== '') {
            $err_msg[] = $result;
        }
        if (($result = check_psword($tmp_psword, 'パスワード')) !== '') {
            $err_msg[] = $result;
        }
    } else {
        $err_msg[] = '確認用パスワードが一致しません。';
    }
    //問題がなければ、セッション変数に投稿データを保存
    if (count($err_msg) === 0) {
        $_SESSION['tmp_user_name'] = $tmp_user_name;
        $_SESSION['tmp_user_id'] = $tmp_user_id;
        $_SESSION['tmp_psword'] = $tmp_psword;
        //確認ページに遷移
        header('Location: confirm.php');
        exit;
    }
}
include_once '../../include/view/signup.php';
?>
