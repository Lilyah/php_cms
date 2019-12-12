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
    $post_date = mysqli_real_escape_string(date('d-m-y'));

    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) VALUES ({$post_category_id},'{$post_title}','{$post_author}', now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";

    $create_post_query = mysqli_query($connection, $query);

    confirmQuery($create_post_query);

    $the_post_id = mysqli_insert_id($connection); //takes the last created id from the DB
    echo "<p class='bg-success'>Post Created. <a href='../post.php?p_id={$the_post_id}++'>View Post</a>";
    echo " or <a href='posts.php?source=add_post'>Add Another Post</a></p>";

   // header("Location: posts.php"); // when submited to open View all posts

}

?>





<form action="" method="post" enctype="multipart/form-data">

     <div class="form-group">
        <label for="title">Post Title</label>
         <input type="text" class="form-control" name="title">
     </div>

    <!--<div class="form-group">
        <label for="post_category">Post Category</label>
        <input type="text" class="form-control" name="post_category_id">
    </div> -->


    <!-- Dropdown menu for selecting categories -->
    <div class="form-group">
        <label for="post_category">Post Category</label>
        <br>
        <select name="post_category" id="">
            <?php
            $query = "SELECT * FROM categories";
            $select_categories_id = mysqli_query($connection, $query);

            confirmQuery($select_categories_id);

            /*Setting the categories and categories id for the table from the DB */
            while ($row = mysqli_fetch_assoc($select_categories_id)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                echo "<option value='{$cat_id}'>$cat_title</option>";
            }
            ?>
        </select>
    </div>



    <div class="form-group" id="author">
        <label for="author">Post Author</label>
        <br>
<?php


$query = "SELECT * FROM users ";
$select_all_users_query = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($select_all_users_query);
$user_role = $row ['user_role'];

//$user_role = $_SESSION['user_role'];

    if($user_role == 'subscriber'){
        /* the author of the post to be only the loged in user */
        //echo $_SESSION['username'];
?>
        <input class="no-border" name="author" value="<?php echo $_SESSION['username']; ?>" readonly>
<?php

        //echo $_SESSION['user_role'];
    }

    if ($user_role == 'admin'){
    /* if the loged in user is admin he can publish posts from any user from the db */
    ?>
        <select name="author" id="">
            <?php
            $query = "SELECT username FROM users ORDER BY username ASC";
            $select_user = mysqli_query($connection, $query);

            confirmQuery($select_user);

            /* Setting the user names for the dropdown in add_post */
            while ($row = mysqli_fetch_assoc($select_user)) {
                $username = $row['username'];

                echo "<option value='{$username}'>$username</option>";
            }
            ?>
        </select>
        <?php
        }
        ?>





        <!-- 2. if we want the author of the post to be input field -->
<!--        <input type="text" class="form-control" name="author">-->

<!-- 3. if we want the author to be drop down menu to choose -->


    <!-- Dropdown menu for selecting witch user to be the Author of the post -->
<!--    <div class="form-group">-->
<!--        <label for="users">Post Author</label>-->
<!--        <br>-->
<!--        <select name="author" id="">-->
<!--            --><?php
//            $query = "SELECT * FROM users ORDER BY username ASC";
//            $select_users = mysqli_query($connection, $query);
//
//            confirmQuery($select_users);
//
//            /* Setting the users and categories id for the table from the DB */
//            while ($row = mysqli_fetch_assoc($select_users)) {
//                $user_id = $row['user_id'];
//                $username = $row['username'];
//
//                echo "<option value='{$user_id}'>$username</option>";
//            }
//            ?>
<!--        </select>-->
    </div>


    <div class="form-group">
        <label for="status">Status</label>
        <br>
        <select name="post_status" id="">
            <option selected='draft'>draft</option> <!-- to be default option -->
            <option value='published'>published</option>
        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <!-- id=body is from scripts.js for the editor -->
        <textarea class="form-control" name="post_content" id="body" cols="30" rows="10"></textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
    </div>
</form>