<?php
/*
*  登録内容変更ページ
*/
require_once '../../include/const/const.php';
require_once '../../include/model/function.php';
$err_msg = array(); //エラーメッセージ
$success_msg = array();
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
//リクエストメソッドを取得
if (get_request_method() === 'POST') {
    //ポストされたデータを取得
    $tmp_user_name = get_post_data('user_name');
    $tmp_user_id = get_post_data('user_id');
    $tmp_psword = get_post_data('new_psword');
    $psword_confirm = get_post_data('new_psword_confirm');
    $posted_psword = get_post_data('psword');
    // データベース接続
    $link = get_db_connect();
    // 既存のパスワード・画像パス取得
    if (($result = get_psword_and_img($link, $user_num)) !== '') {
        $current_psword = $result[0]['password'];
        $current_image_file = $result[0]['image'];
    } else {
        $err_msg[] = '既存データ取得失敗';
    }
    //現在のパスワードが正しいか確認
    if ($current_psword === $posted_psword) {
        //空白の欄があったら既存の変数を代入・そうでなければ通常のエラーチェック
        if (trim($tmp_user_id) === '') {
            //既存のuser_idを代入
            $tmp_user_id = $_SESSION['user_id'];
        } else {
            if (($result = check_user_id($tmp_user_id, 'ユーザーID')) !== '') {
                $err_msg[] = $result;
            }
        }
        if (trim($tmp_user_name) === '') {
            //既存のuser_nameを代入
            $tmp_user_name = $_SESSION['user_name'];
        } else {
            if (($result = check_user_name($tmp_user_name, 'ユーザー名')) !== '') {
                $err_msg[] = $result;
            }
        }
        if (trim($tmp_psword) === '') {
            //既存のパスワードを代入
            $tmp_psword = $current_psword;
        } else {
            if ($tmp_psword === $psword_confirm) {
                if (($result = check_psword($tmp_psword, 'パスワード')) !== '') {
                    $err_msg[] = $result;
                }
            } else {
                $err_msg[] = '新しいパスワードと確認用パスワードが一致しません。';
            }
        }
        //画像ファイル追加
        //もし一時的なファイル名の$_FILES['new_img']がPOSTでアップロードされていたら
        if (is_uploaded_file($_FILES['new_img']['tmp_name'])) {
            //画像の一時ファイル名取得
            $tmp_img_name = $_FILES['new_img']['tmp_name'];
            //uploaded_imagesフォルダがなければ、フォルダ作成
            create_new_folder();
            //日付と擬似乱数を組み合わせて、画像の新しいファイル名を生成
            $new_img_name = date("YmdHis");
            $new_img_name .= mt_rand();
            switch (exif_imagetype ($_FILES['new_img']['tmp_name'])) {
                case IMAGETYPE_JPEG :
                    $new_img_name .= '.jpg';
                    break;
                case IMAGETYPE_PNG :
                    $new_img_name .= '.png';
                    break;
                default :
                    $err_msg[] = '画像ファイルはjpg、もしくはpngファイルのものを選んでください。';
                    break;
            }
            //続きの処理はデータをSQLへインサートした後で
        } else {
            //新しいアイコンをアップロードしないなら、現在の画像ファイルをDBに登録
            $new_img_name = $current_image_file;
        }
    } else {
        $err_msg[] = 'パスワードが違います。';
    }
    if (count($err_msg) === 0) {
        if (update_my_data($link, $tmp_user_id, $tmp_user_name, $tmp_psword, $new_img_name, $user_num) === TRUE) {
            //アイコンを変更していたら、新しい画像データをフォルダに格納
            if (is_uploaded_file($_FILES['new_img']['tmp_name'])) {
                if (move_uploaded_file ($tmp_img_name, './images/' . $new_img_name) === TRUE) {
                    //古いアイコンデータを削除
                    if($current_image_file !== 'grape.png') {
                        delete_old_img($current_image_file);
                    }
                } else {
                    $err_msg[] = 'アイコン画像のアップロードに失敗しました。既存のアイコンに設定します。';
                    //アイコンを元に戻す
                    update_pre_img($link, $current_image_file, $user_num);
                }
            }
            //セッション変数に投稿データを保存して完了
            $success_msg[] = '登録内容を変更しました';
            //セッション変数保存
            $user_id = $tmp_user_id;
            $user_name = $tmp_user_name;
            $_SESSION['user_id'] = $tmp_user_id;
            $_SESSION['user_name'] = $tmp_user_name;
        } else {
            $err_msg[] = '登録内容をアップデートできませんでした。';
        }
    }
}
include_once '../../include/view/change-profile.php';
?>
