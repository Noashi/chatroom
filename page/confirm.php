<?php
/*
*  新規登録確認ページ
*/
require_once '../include/const/const.php';
require_once '../include/model/function.php';
// セッション開始
session_start();
//セッション変数が存在しているか確認
if((isset($_SESSION['tmp_user_name']) === TRUE) || (isset($_SESSION['tmp_user_id']) === TRUE) || (isset($_SESSION['tmp_psword']) === TRUE)) {
    $tmp_user_name = $_SESSION['tmp_user_name'];
    $tmp_user_id = $_SESSION['tmp_user_id'];
    $tmp_psword = $_SESSION['tmp_psword'];
} else {
    //セッション変数が存在していなければトップページへ
    header('Location: ./top.php');
    exit;
}
include_once '../../include/view/confirm.php';
?>
