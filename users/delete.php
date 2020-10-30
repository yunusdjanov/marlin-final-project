<?php
require_once "../init.php";
$user = new User;
if ($user->isLoggedIn() && $user->hasPermissons('admin')){
    if (isset($_GET['id'])){
        $id = $_GET['id'];
        Database::getInstance()->delete('users', ['id', '=', $id]);
        Session::flash('danger', 'Профиль удален');
        Redirect::to('index.php');
    }
}else{
    $user->logout();
    Redirect::to('../index.php');
}

