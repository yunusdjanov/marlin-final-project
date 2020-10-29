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
            <li class="nav-item">
                <a class="nav-link" href="#">Управление пользователями</a>
            </li>
        </ul>

        <ul class="navbar-nav">
            <li class="nav-item">
            <li class="nav-item">
                <a href="../profile.php" class="nav-link">Профиль</a>
            </li>
            <a href="../logout.php" class="nav-link">Выйти</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Данные пользователя</h1>
            <table class="table">
                <thead>
                <th>ID</th>
                <th>Имя</th>
                <th>Дата регистрации</th>
                <th>Статус</th>
                </thead>

                <tbody>
                <tr>
                    <?php
                    if (isset($_GET['id'])){
                        $id = $_GET['id'];
                        $users = Database::getInstance()->get('users', ['id', '=', $id]);
                        foreach ($users->results() as $item) :
                            $uid = $item->id;
                            $name = $item->username;
                            $date = $item->register_time;
                            $status = $item->status;


                    ?>
                    <td><?php echo $uid; ?></td>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $date; ?></td>
                    <td><?php echo $status; ?></td>
                </tr>
                </tbody>
                <?php
                endforeach;
                    }
                ?>
            </table>


        </div>
    </div>
</div>
</body>
</html>