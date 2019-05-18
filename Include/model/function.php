<?php

/**
 *
 * ------------------------common------------------------
 *
**/

/**
* 特殊文字をHTMLエンティティに変換する
*/
function entity_str($str) {
    return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}

/**
* 特殊文字をHTMLエンティティに変換する(2次元配列の値)
*/
function entity_assoc_array($assoc_array) {

    foreach ($assoc_array as $key => $value) {

        foreach ($value as $keys => $values) {
            // 特殊文字をHTMLエンティティに変換
            $assoc_array[$key][$keys] = entity_str($values);
        }

    }

    return $assoc_array;

}

/**
* DBハンドルを取得
*/
function get_db_connect() {

    // コネクション取得
    if (!$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME)) {
        die('error: ' . mysqli_connect_error());
    }

    // 文字コードセット
    mysqli_set_charset($link, DB_CHARACTER_SET);

    return $link;
}

/**
* DBとのコネクション切断
*/
function close_db_connect($link) {
    // 接続を閉じる
    mysqli_close($link);
}

/**
* クエリを実行しその結果を配列で取得する
*
*/
function get_as_array($link, $sql) {

    // 返却用配列
    $data = array();

    // クエリを実行する
    if ($result = mysqli_query($link, $sql)) {

        if (mysqli_num_rows($result) > 0) {

            // １件ずつ取り出す
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }

        }

        // 結果セットを開放
        mysqli_free_result($result);

    }

    return $data;

}

/**
* insertを実行する
*
* @param obj $link DBハンドル
*/
function insert_db($link, $data) {
    //ユーザー名・パスワード・時間をインサートするSQL
    $sql = 'INSERT INTO EC_user_table(user_name, password, created_at, updated_at) VALUES(\'' . implode('\',\'', $data) . '\')';

    // クエリを実行する
    if (mysqli_query($link, $sql) === TRUE) {
       return TRUE;
    } else {
       return FALSE;
    }
}

/**
* リクエストメソッドを取得
*/
function get_request_method() {
   return $_SERVER['REQUEST_METHOD'];
}

/**
* POSTデータを取得
*/
function get_post_data($key) {
   $str = '';
   if (isset($_POST[$key]) === TRUE) {
       $str = $_POST[$key];
   }
   // 特殊文字をHTMLエンティティに変換
   return entity_str($str);
}

/**
* オートコミットオフ
*/
function turn_off_autocommit($link) {

    return mysqli_autocommit($link, false);

}

/**
 *
 * ------------------------signup------------------------
 *
**/

/**
* ユーザーIDのチェック
*/

function check_user_id($str, $label) {
    $msg = '';
    $link = get_db_connect();
    //ユーザー名被りがないかチェック
    $result = search_the_same_id($link, $str);
    if(trim($str) === '') {
        $msg = $label . 'を入力してください。';
    } else if (preg_match("/^[a-zA-Z0-9]+$/", $str) !== 1) {
        $msg = $label . 'は半角英数字で入力してください。';
    } else if (mb_strlen($str) > 20 || mb_strlen($str) < 6) {
        $msg = $label . 'は6文字以上20文字以内で入力してください。';
    } else if (count($result) !== 0) {
        $msg = 'このユーザーIDは既に使われています。';
    }
    // データベース切断
    close_db_connect($link);
    return $msg;
}

/**
* ユーザー名被りがないかチェック
*/
function search_the_same_id($link, $str) {
    $sql = 'SELECT user_id FROM chat_user_table WHERE user_id = "' . $str . '"';

    return get_as_array($link, $sql);
}


/**
* パスワードのチェック
*/

function check_psword($str, $label) {
    $msg = '';
    if (trim($str) === '') {
        $msg = $label . 'を入力してください。';
    } else if (preg_match("/^[a-zA-Z0-9]+$/", $str) !== 1) {
        $msg = $label . 'は半角英数字で入力してください。';
    } else if (mb_strlen($str) > 20 || mb_strlen($str) < 6) {
        $msg = $label . 'は6文字以上20文字以内で入力してください。';
    }
    return $msg;
}


/**
* ユーザー名チェック
*/

function check_user_name($str, $label) {
    $msg = '';
    if(trim($str) === '') {
        $msg = $label . 'を入力してください。';
    } else if (mb_strlen($str) > 20) {
        $msg = $label . 'は20文字以内で入力してください。';
    }
    return $msg;
}

/**
 *
 * ------------------------finish------------------------
 *
**/

/**
* 新規ユーザー登録
*/
function insert_new_user_data($link, $data) {
    $result = '';
    $sql = 'INSERT INTO chat_user_table(user_id, user_name, password, image, created_at) VALUES(\'' . implode('\',\'', $data) . '\')';

    if (($result = mysqli_query($link, $sql)) === TRUE) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 *
 * ------------------------login------------------------
 *
**/

/**
* （ログイン）メールアドレスとパスワードからuser_idを取得する
*/
function get_user_id($link, $user_id, $psword) {
    //データを取得するSQL
    $sql = 'SELECT user_num, user_id, user_name FROM chat_user_table WHERE user_id =\'' . $user_id . '\' AND password =\'' . $psword . '\'';

    //登録データを配列で取得
    return get_as_array($link, $sql);

}
/**
 *
 * ------------------------index------------------------
 *
**/

/**
* （トップ）ログデータを取得
*/
function get_log_data($link) {
        //データを取得するSQL
    $sql = 'SELECT L.post_num, L.user_num, U.user_name, L.comment, L.created_at, U.image FROM chat_log_table AS L LEFT JOIN chat_user_table AS U ON L.user_num = U.user_num';

    //登録データを配列で取得
    return get_as_array($link, $sql);

}

/**
* （トップ）投稿内容をログへインサート
*/
function insert_comment($link, $data) {
    //データを取得するSQL
    $sql = 'INSERT INTO chat_log_table(user_num, comment, created_at) VALUES(\'' . implode('\',\'', $data) . '\')';

    if (mysqli_query($link, $sql) === TRUE) {
        return TRUE;
    } else {
        return FALSE;
    }

}

/**
* （トップ）投稿を削除
*/
function delete_comment($link, $delete_post_num) {
    //データを削除するSQL
    $sql = 'DELETE FROM chat_log_table WHERE post_num = ' . $delete_post_num;

    if (mysqli_query($link, $sql) === TRUE) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
* （トップ）名前があるか確認
*/
function check_log_name($str) {
    if ($str === '') {
        return '退会したユーザー';
    } else {
        return $str;
    }
}

/**
* （トップ）画像データがあるか確認
*/
function check_log_img($str) {
    if ($str === '') {
        return 'icon-delete.png';
    } else {
        return $str;
    }
}

/**
 *
 * ------------------------mypage------------------------
 *
**/

/**
* 自分のユーザーデータを取得
*/
function get_my_data($link, $user_num) {
        //データを取得するSQL
    $sql = 'SELECT * FROM chat_user_table WHERE user_num = ' . $user_num;

    //登録データを配列で取得
    return get_as_array($link, $sql);

}

/**
 *
 * ------------------------all_users------------------------
 *
**/

/**
* ゆーざーデータを取得
*/
function get_user_data($link) {
        //データを取得するSQL
    $sql = 'SELECT user_name, image, created_at FROM chat_user_table';

    //登録データを配列で取得
    return get_as_array($link, $sql);

}

/**
 *
 * ------------------------change_profile------------------------
 *
**/

/**
* パスワードを取得
*/
function get_psword_and_img($link, $user_num) {

   $sql = 'SELECT password, image FROM chat_user_table WHERE user_num = ' . $user_num;

   //登録データを配列で取得
    return get_as_array($link, $sql);
}

/**
* 登録情報を更新
*/
function update_my_data($link, $tmp_user_id, $tmp_user_name, $tmp_psword, $new_img_name, $user_num) {

    $sql = 'UPDATE chat_user_table SET user_id = "' . $tmp_user_id . '", user_name = "' . $tmp_user_name . '", password = "' . $tmp_psword . '", image = "' . $new_img_name . '" WHERE user_num = ' . $user_num;

    if (mysqli_query($link, $sql) === TRUE) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
* 画像を格納するフォルダがなければ作成
*/
function create_new_folder() {

    if (! file_exists ('./images')) {
        mkdir ('./images');
    }

}

/**
* 画像アップロードに失敗したら元のアイコンに戻す
*/
function update_pre_img($link, $current_image_file, $user_num) {

    $sql = 'UPDATE chat_user_table SET image = ' . $current_image_file . ' WHERE user_num = ' . $user_num;

    if (mysqli_query($link, $sql) === TRUE) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
* 画像アップロードに成功したら元のアイコンをサーバーから削除
*/

function delete_old_img($current_image_file) {

    $str = 'images/' .$current_image_file;
    if (unlink($str) === TRUE) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 *
 * ------------------------delete-data------------------------
 *
**/

/**
* アカウント削除
*/

function delete_account($link, $user_num) {

   $sql = 'DELETE FROM chat_user_table WHERE user_num = ' . $user_num;

    if (mysqli_query($link, $sql) === TRUE) {
        return TRUE;
    } else {
        return FALSE;
    }
}
