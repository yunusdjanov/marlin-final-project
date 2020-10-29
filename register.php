<?php
require_once "init.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="text-center">
<form class="form-signin" method="post">
    <img class="mb-4" src="images/apple-touch-icon.png" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>









    <?php
    if (Input::exists()) {
        if (Token::check(Input::get('token'))){
            $validate = new Validate();

            $validation = $validate->check($_POST , [
                'username' => [
                    'required' => true,
                    'min' => 2,
                    'max' => 15,
                    'unique' => 'users'
                ],

                'email' => [
                    'required' => true,
                    'email' => true,
                    'unique' => 'users'
                ],

                'password' => [
                    'required' => true,
                    'min' => 3
                ],

                'password_again' => [
                    'required' => true,
                    'matches' => 'password'
                ]
            ]);

            if ($validation->passed()) {

                $user = new User;

                $user->create([
                    'username' => Input::get('username'),
                    'password' => password_hash(Input::get('password') , PASSWORD_DEFAULT),
                    'email' => Input::get('email')
                ]);

                Session::flash('success' , 'Успешный успех');

                echo "<div class='alert alert-success'>".   Session::flash('success') ."</div>" ;

            } else {
                foreach ($validation->errors() as $error) {
                    echo  '<div class="alert alert-danger"><ul><li>' . $error . '</li></ul></div>' ;
                }
            }
        }
    }

    ?>








    <div class="form-group">
        <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?php echo Input::get('email'); ?>">
    </div>
    <div class="form-group">
        <input type="text" name="username" class="form-control" id="email" placeholder="Ваше имя" value="<?php echo Input::get('username'); ?>">
    </div>
    <div class="form-group">
        <input type="password" name="password" class="form-control" id="password" placeholder="Пароль">
    </div>

    <div class="form-group">
        <input type="password" name="password_again" class="form-control" id="password" placeholder="Повторите пароль">
    </div>

    <div class="checkbox mb-3">
        <label>
            <input type="checkbox"> Согласен со всеми правилами
        </label>
    </div>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Зарегистрироваться</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2017-2020</p>
</form>
</body>
</html>
