<?php
require_once "../init.php";
$user = new User;
if ($user->isLoggedIn() && $user->hasPermissons('admin')){
     $id = $_GET['id'];
     $role = Database::getInstance()->get('users', ['id', '=', $id]);
    foreach ($role->results() as $item) {
         $result = $item->group_id;
    }

    if ($result == 1){
        Database::getInstance()->update('users', $id, [
            'group_id' => 2
        ]);
        Redirect::to('index.php');
    }elseif($result == 2){
        Database::getInstance()->update('users', $id, [
            'group_id' => 1
        ]);
        Redirect::to('index.php');
    }

}else{
    $user->logout();
    Redirect::to('../index.php');
}