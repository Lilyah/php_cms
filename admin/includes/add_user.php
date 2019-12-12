<?php

if(isset($_POST['create_user'])){

    //$user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
    $user_firstname = mysqli_real_escape_string($connection, $_POST['user_firstname']);
    $user_lastname = mysqli_real_escape_string($connection, $_POST['user_lastname']);
    $user_role = mysqli_real_escape_string($connection, $_POST['user_role']);
    $username = mysqli_real_escape_string($connection,$_POST['username']);
    $user_email = mysqli_real_escape_string($connection,$_POST['user_email']);
    $user_password = mysqli_real_escape_string($connection,$_POST['user_password']);

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10)); //crypt the password


//    $post_image = $_FILES['image']['name'];
//    $post_image_temp = $_FILES['image']['tmp_name']; //for temp on the srv
//    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "INSERT INTO users(username, user_password, user_firstname, user_lastname, user_email, user_role) VALUES ('{$username}','{$user_password}','{$user_firstname}','{$user_lastname}','{$user_email}','{$user_role}')";

    $create_user_query = mysqli_query($connection, $query);

    confirmQuery($create_user_query);

    header("Location: users.php"); // when submited to open View all users
}

?>





<form action="" method="post" enctype="multipart/form-data">


    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <label for="user_role">User Role</label>
        <br>
        <select name="user_role" id="">
            <option selected="selected" value="subscriber">subscriber</option> <!-- Subscriber to be default option -->
            <option value="admin">admin</option>
        </select>
    </div>




<!--    <div class="form-group">-->
<!--        <label for="post_tags">Post Tags</label>-->
<!--        <input type="text" class="form-control" name="post_tags">-->
<!--    </div>-->

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="user_pasword">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_user" value="Add User">
    </div>
</form>