<?php

/* Functionality for checkboxes */
if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $postValueId) {
        //echo $checkBoxValue;
        $bulk_options = $_POST['bulk_options'];

        switch($bulk_options){
            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
                $update_to_publish_status = mysqli_query($connection, $query);
                if(!$update_to_publish_status){
                    die("QUERY FAILED" . mysqli_error($connection));
                } else {
                    echo "<p class='bg-success'>Post status changed to Published.</p>";
                }
                break;

            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
                $update_to_publish_status = mysqli_query($connection, $query);
                if(!$update_to_publish_status){
                    die("QUERY FAILED" . mysqli_error($connection));
                } else {
                    echo "<p class='bg-success'>Post status changed to Published.</p>";
                }
                break;

            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
                $update_to_draft_status = mysqli_query($connection, $query);
                if(!$update_to_draft_status){
                    die("QUERY FAILED" . mysqli_error($connection));
                } else {
                    echo "<p class='bg-success'>Post status changed ot Draft.</p>";
                }
                break;

            case 'clone':
                $query = "SELECT * FROM posts WHERE post_id = {$postValueId}";
                $select_post_query = mysqli_query($connection, $query);

                while($row = mysqli_fetch_array($select_post_query)){
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_date = $row['post_date'];
                    $post_author = $row['post_author'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_content = $row['post_content'];
                }

                $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) VALUES ({$post_category_id},'{$post_title}','{$post_author}', CURRENT_TIMESTAMP(), '{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";
                $copy_query = mysqli_query($connection, $query);

                if(!$copy_query){
                    die("QUERY FAILED" . mysqli_error($connection));
                } else {
                    echo "<p class='bg-success'>Post Cloned.</p>";
                }
                break;

            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = {$postValueId}";
                $update_to_delete_status = mysqli_query($connection, $query);

                if(!$update_to_delete_status){
                    die("QUERY FAILED" . mysqli_error($connection));
                } else {
                    echo "<p class='bg-success'>Post Deleted.</p>";
                }
                break;
        }
    }

}

deletePosts();

?>

<!-- Search Field -->
<div class="well">
<form action="posts.php?source=search" method="post">
    <div class="input-group">
        <input name="search" type="text" class="form-control" placeholder="Search in posts...">
        <span class="input-group-btn">
                            <button name="submit" class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
    </div>
</form><!--search form-->
<!-- /.input-group -->
</div>




<form method='post'>
    <div style="overflow-x:auto;"> <!-- For responsive table -->
    <table class="sortable table table-striped table-bordered table-hover table-condensed">
    <div class="row" > <!-- for the bulkOptionContaner, because Bootstrap columns have a 15px padding one each side
                        while the bootstrap row has 15px of negative margin on each side -->


        <div id="bulkOptionContainer" class="col-xs-4">
        <select class="form-control" name="bulk_options" id="">
            <option selected="selected">Select an option</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="clone">Clone</option>
            <option value="delete">Delete</option>
        </select>
 </div>

    <div class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        <a class="btn btn-primary" href="posts.php?source=add_post">Add New Post</a>
    </div>

</div>

    <thead>
        <tr>
            <th><input type="checkbox" id="selectAllBoxes"></th>

            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>IMG</th>
            <th>Tags</th>
            <th>Views</th>
            <th>Comments</th>
            <th>Date</th>
            <th colspan="3">Action</th>
        </tr>


    </thead>

    <tbody>
<!-- The following code is for sotring BY ASC and DESC with PHP AND MYSQL some fields f the table -->
<!-- This code is related with admin/functions -> if(isset($_GET['sort'])) and switch($sort)-->
<!--    <tr bgcolor="#c4cace">-->
<!--        <td></td>  Checkboxes -->
<!--        <td style="width:100%">  Id sort arrows -->
<!--            <a title="Sort by Id ascending" href="posts.php?sort=id_asc"><i class="fa fa-arrow-up"></i></a>-->
<!--            <a title="Sort by Id descending" href="posts.php?sort=id_desc"><i class="fa fa-arrow-down"></i></a>-->
<!--        </td>-->
<!--        <td style="width:100%">  Author sort arrows -->
<!--            <a title="Sort by Id ascending" href="posts.php?sort=author_asc"><i class="fa fa-arrow-up"></i></a>-->
<!--            <a title="Sort by Id descending" href="posts.php?sort=author_desc"><i class="fa fa-arrow-down"></i></a>-->
<!--        </td>-->
<!--        <td></td>  Title without sort arrows-->
<!--        <td></td>  Category without sort arrows-->
<!--        <td style="width:100%">  Status sort arrows -->
<!--            <a title="Sort by Drafts" href="posts.php?sort=status_draft"><i class="fa fa-arrow-up"></i></a>-->
<!--            <a title="Sort by Published" href="posts.php?sort=status_pub"><i class="fa fa-arrow-down"></i></a>-->
<!--        </td>-->
<!--        <td></td>  IMG without sort arrows-->
<!--        <td></td>  Tags without sort arrows-->
<!--        <td style="width:100%">  Views sort arrows -->
<!--            <a title="Sort by Least views" href="posts.php?sort=views_asc"><i class="fa fa-arrow-up"></i></a>-->
<!--            <a title="Sort by Most views" href="posts.php?sort=views_desc"><i class="fa fa-arrow-down"></i></a>-->
<!--        </td>-->
<!--        <td style="width:100%">  Comments sort arrows -->
<!--            <a title="Sort by Least commented" href="posts.php?sort=comments_asc"><i class="fa fa-arrow-up"></i></a>-->
<!--            <a title="Sort by Most commented" href="posts.php?sort=comments_desc"><i class="fa fa-arrow-down"></i></a>-->
<!--        </td>-->
<!--    </tr>-->

    <?php
    /* Getting and setting the posts from the DB */
    findAllPosts();
    ?>

     </tbody>
    </div>
    </table>
</form>