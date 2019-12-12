<?php

if(isset($_GET['p_id'])) {
    $the_post_id = $_GET['p_id'];
}

$query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
$select_all_posts_by_id = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($select_all_posts_by_id)) {
    $post_id = $row['post_id'];
    $post_author = $row['post_author'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_content = $row['post_content'];
    $post_tags = $row['post_tags'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];
}

if(isset($_POST['update_post'])){
    $post_author = mysqli_real_escape_string($connection, $_POST['author']);
    $post_title = mysqli_real_escape_string($connection, $_POST['title']);
    $post_category_id = mysqli_real_escape_string($connection, $_POST['post_category']);
    $post_status = mysqli_real_escape_string($connection, $_POST['post_status']);
    $post_image = mysqli_real_escape_string($connection, $_FILES['image']['name']);
    $post_image_temp = mysqli_real_escape_string($connection, $_FILES['image']['tmp_name']);
    $post_content = mysqli_real_escape_string($connection, $_POST['post_content']);
    $post_tags = mysqli_real_escape_string($connection, $_POST['post_tags']);

    move_uploaded_file($post_image_temp, "../images/$post_image");

    if(empty($post_image)){
        $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
        $select_image = mysqli_query($connection, $query);

        while($row = mysqli_fetch_array($select_image)){
            $post_image = $row['post_image'];
        }
    }

    $query = "UPDATE posts SET ";
    $query .= "post_title = '{$post_title}', ";
    $query .= "post_category_id = '{$post_category_id}', ";
    $query .= "post_date = now(), ";
    $query .= "post_author = '{$post_author}', ";
    $query .= "post_status = '{$post_status}', ";
    $query .= "post_tags = '{$post_tags}', ";
    $query .= "post_content = '{$post_content}', ";
    $query .= "post_image = '{$post_image}' ";
    $query .= "WHERE post_id = {$the_post_id} ";

    $update_post = mysqli_query($connection, $query);

    confirmQuery($update_post);

    echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$the_post_id}'>View Post</a>";
    echo " or <a href='posts.php'>Edit More Posts</a></p>";

    // header ("Location: posts.php");

}

?>


<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="title">Category</label>
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

    <div class="form-group">
        <label for="title">Post Author</label>
        <br>

        <?php
        $query = "SELECT * FROM users ";
        $select_all_users_query = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($select_all_users_query);
        $user_role = $row ['user_role'];

        if($user_role == 'subscriber'){
            /* the author of the post to be only the loged in user */
            ?>
            <input class="no-border" name="author" value="<?php echo $post_author ?>" readonly>
            <?php
        }

        if ($user_role == 'admin'){
            /* if the loged in user is admin he can publish posts from any user from the db */
            ?>
            <select name="author" id="">
                <?php
                echo "<option value='{$post_author}'>$post_author</option>";

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
    </div>

    <div class="form-group">
        <label for="title">Post Status</label>
        <br>
        <select name="post_status" id="">
        <option selected='<?php $post_status; ?>'><?php echo $post_status; ?></option> <!-- to be default option -->
        <?php
        if($post_status == 'published'){
            echo "<option value='draft'>draft</option>";
        } else {
            echo "<option value='published'>published</option>";
        };
        ?>
    </select>
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <br>
        <img width="100" src="../images/<?php echo $post_image;?>"><br>
        <input value="<?php echo $post_image; ?>" type="file" class="no-border" name="image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <!-- id=body is from scripts.js for the editor -->
        <textarea class="form-control" name="post_content" id="body" cols="30" rows="10"><?php echo $post_content; ?>
        </textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
    </div>
</form>
