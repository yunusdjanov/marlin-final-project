<?php
require_once "../init.php";
$user = new User;
if (!$user->isLoggedIn()){
    $user->logout();
    Redirect::to('../index.php');
}elseif(!$user->hasPermissons('admin')){
    $user->logout();
    Redirect::to('../index.php');
}

    if (isset($_GET['id'])){
        $id = $_GET['id'];
        Database::getInstance()->delete('users', ['id', '=', $id]);
        Redirect::to('index.php');
    }else {
        $user->logout();
        Redirect::to('../index.php');
    }


?>