<?php


/* Functionality for checkboxes */
if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $postValueId) {
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
                <select class="form-control" name="bulk_options" id="" placeholder="some">
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

<?php
        /* SEARCH */
        if (isset($_POST['submit']) & !empty($_POST['search'])) {
        $search = $_POST['search'];
        $query = "SELECT * FROM posts WHERE 
        post_id LIKE '%$search%' OR
        post_author LIKE '%$search%' OR
        post_title LIKE '%$search%' OR
        post_status LIKE '%$search%' OR
        post_image LIKE '%$search%' OR
        post_tags LIKE '%$search%' OR
        post_tags LIKE '%$search%' OR
        post_date LIKE '%$search%'";

        $search_query = mysqli_query($connection, $query);

            if (!$search_query) {
            die("QUERY FAILED" . mysqli_error($connection));
            }

        $count = mysqli_num_rows($search_query);
            if ($count == 0) {
                // do nothing if there are no records
            } else {
             /* Displaying the results from the search */
            $search_query = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($search_query)) {
            $post_id = $row ['post_id'];
            $post_author = $row ['post_author'];
            $post_title = $row['post_title'];
            $post_category_id = $row ['post_category_id'];
            $post_status = $row ['post_status'];
            $post_image = $row ['post_image'];
            $post_tags = $row ['post_tags'];
            $post_comment_count = $row ['post_comment_count'];
            $post_date = $row ['post_date'];
            $post_view_counts = $row ['post_view_counts'];

             echo "<tr>";
                ?>
                <!-- Checkboxes -->
                <td><input type='checkbox' class='checkBoxes' id='selectAllBoxes' name='checkBoxArray[]'
                       value='<?php echo $post_id ?>'></td>
                <?php
                echo "<td>{$post_id}</td>";
                echo "<td>{$post_author}</td>";
                echo "<td>{$post_title}</td>";


            /* Displaying categories NAME by using categories id */
            $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
            $select_categories_id = mysqli_query($connection, $query);

            /* Setting the categories and categories id for the table from the DB */
            while ($row = mysqli_fetch_assoc($select_categories_id)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                echo "<td>{$cat_title}</td>";
            }

            echo "<td>{$post_status}</td>";
            echo "<td><img width='72' height='42' style='display: block; margin-left: auto; margin-right: auto' src='../images/$post_image'></td>"; // displays the img and setting the size and position
            echo "<td>{$post_tags}</td>";
            echo "<td>{$post_view_counts}</td>";

            /* Comments counter */
            $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
            $send_comment_count_query = mysqli_query($connection, $query);

            //fetching the comment for every specific post so on click to view only comments on one post
            $row = mysqli_fetch_array($send_comment_count_query);
            $comment_id = $row ['comment_id'];
            $count_comments = mysqli_num_rows($send_comment_count_query);
            echo "<td><a href='post_comments.php?id=$post_id'>$count_comments</a></td>";

            echo "<td>{$post_date}</td>";
                echo "<td><a href='../post.php?p_id={$post_id}' title='View post'><i class=\"fa fa-search\"></i></a></td>";
                echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}' title='Edit post'><i class=\"fa fa-pencil-square-o\"></i></a></td>";
                echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete the Post?') \" href='posts.php?source=delete_post&p_id={$post_id}' title='Delete post'><i class=\"fa fa-times\"></i></a></td>";
            echo "</tr>";
            }
    }
} else { header("Location: posts.php"); }
?>


        </tbody>
        </div>
    </table>
</form>