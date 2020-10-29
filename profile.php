<?php
require_once "init.php";

$user = new User;
if (!$user->isLoggedIn()){
    Redirect::to('index.php');
}else{
$username = $user->data()->username;
$status = $user->data()->status;
$id = $user->data()->id;



    if (Input::exists()) {
        $validate = new Validate();
        $validate->check($_POST, [
            'username' => [
                'required' => true,
                'min' => 2
            ],
            'status' => [
                'required' => true,
                'min' => 10
            ]
        ]);
        if (Token::check(Input::get('token'))) {
            if ($validate->passed()) {
                $user->update([
                    'username' => Input::get('username'),
                    'status' => Input::get('status')
                ]);
                Redirect::to('profile.php');
                Session::flash('success' , 'Профиль обновлен');
                echo "<div class='alert alert-success'>".   Session::flash('success') ."</div>" ;
            } else {
                foreach ($validate->errors() as $error) {
                    echo  '<div class="alert alert-danger"><ul><li>' . $error . '</li></ul></div>' ;
                }
            }
        }
    }


}



?>










<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">User Management</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Главная</a>
            </li>
            <?php
            if ($user->hasPermissons('admin')){
                echo '<li class="nav-item"><a class="nav-link" href="users/index.php">Управление пользователями</a></li>';
            }
            ?>
        </ul>

        <ul class="navbar-nav">
            <li class="nav-item">
            <li class="nav-item">
                <a href="profile_info.php" class="nav-link">Профиль</a>
            </li>
            <a href="logout.php" class="nav-link">Выйти</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>Профиль пользователя - <?php echo $username; ?></h1>

            <ul>
                <li><a href="changepassword.php">Изменить пароль</a></li>
            </ul>
            <form action="" class="form" method="post">
                <div class="form-group">
                    <label for="username">Имя</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?php echo $username; ?>">
                </div>
                <div class="form-group">
                    <label for="status">Статус</label>
                    <input type="text" name="status" id="status" class="form-control" value="<?php echo $status; ?>">
                </div>
                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                <div class="form-group">
                    <button class="btn btn-warning" type="submit">Обновить</button>
                </div>
            </form>


        </div>
    </div>
</div>
</body>
</html>