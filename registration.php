<?php  // include "includes/db.php"; ?>
<?php
include "includes/header.php";
include "admin/functions.php";

?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>



<?php

if(isset($_POST['submit'])){

    $username = mysqli_real_escape_string($connection, trim($_POST['username']));
    $email = mysqli_real_escape_string($connection, trim($_POST['email']));
    $password = mysqli_real_escape_string($connection, trim($_POST['password']));

    $error = [
            'username' => '',
            'email' => '',
            'password' => ''
    ];

    if (strlen($username) < 4){
        $error['username'] = 'Username must be longer than 4 symbols';
    }

    if ($username == ''){
        $error['username'] = 'Username cannot be empty';
    }

    if (username_exists($username)){
        $error['username'] = 'Username already exists';
    }

    if ($email == ''){
        $error['email'] = 'Email cannot be empty';
    }

    if (email_exists($email)){
        $error['email'] = 'This email already exists';
    }

    if ($password == ''){
        $error['password'] = 'Password cannot be empty';
    }

    foreach($error as $key => $value){
        if(empty($value)){
//            $username = mysqli_real_escape_string($connection, $_POST['username']);
//            $password = mysqli_real_escape_string($connection, $_POST['password']);
            unset($error[$key]);
        }
    }

    if(empty($error)){
        register_user($username, $email, $password);
        login_user($username, $password);
    }
}
?>

    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <!-- value in this input is for username to stay in the field through refresh -->
                            <input type="text" name="username" id="username" class="form-control"
                                   placeholder="Enter Desired Username"
                                   autocomplete="on"
                                   value="<?php echo isset($username) ? $username : '' ?>">
                            <p><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                             <!-- value in this input is for user email to stay in the field through refresh -->
                             <input type="email" name="email" id="email" class="form-control"
                                    placeholder="somebody@example.com"
                                    autocomplete="on"
                                    value="<?php echo isset($email) ? $email : '' ?>">
                             <p><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                         </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                             <p><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                         </div>
                        <!-- The following wouldn't work, because we used password_hash for crypt, and it's a one-way function,
                            it can't be decrypted -->
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>
        <hr>

<?php include "includes/footer.php";?>