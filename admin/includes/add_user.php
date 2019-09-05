<?php

if(isset($_POST['create_post'])){

    $post_title = mysqli_real_escape_string($connection, $_POST['title']);
    $post_author = mysqli_real_escape_string($connection, $_POST['author']);
    $post_category_id = mysqli_real_escape_string($connection, $_POST['post_category']);
    $post_status = mysqli_real_escape_string($connection,$_POST['post_status']);

    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name']; //for temp on the srv

    $post_tags = mysqli_real_escape_string($connection, $_POST['post_tags']);
    $post_content = mysqli_real_escape_string($connection, $_POST['post_content']);
    $post_date = date('d-m-y');

    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) VALUES ({$post_category_id},'{$post_title}','{$post_author}', now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";

    $create_post_query = mysqli_query($connection, $query);

    confirmQuery($create_post_query);

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
            <option selected="selected" value="subscriber">Subscriber</option> <!-- Subscriber to be default option -->
            <option value="admin">Admin</option>
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