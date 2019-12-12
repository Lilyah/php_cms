<?php
include "includes/header.php";
//include "includes/db.php";

/* Navigation */
include "includes/navigation.php";
?>



    <!-- Page Content -->
    <div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php
            /* Opening single post page */
            if(isset($_GET['p_id'])){
                $the_post_id = $_GET['p_id'];
                $the_post_author = $_GET['author'];
            }

            /* Setting the posts information from the DB */
            $query = "SELECT * FROM posts WHERE post_author = '{$the_post_author}'";
            $select_all_posts_query = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($select_all_posts_query)){
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
             ?>

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <!--Blog Post Title--><a href="#"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    <!--Blog Post Author-->by <a href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $the_post_id ?>"><?php echo $post_author ?></a>
                </p>
                    <!--Blog Post Date--><p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                     <!--Blog Post Content--><p><?php echo $post_content ?></p>
                <hr>

                <?php
            }
            ?>

            <!-- Blog Comments -->

            <?php

            if(isset($_POST['create_comment'])){

                $the_post_id = $_GET['p_id'];
                $comment_author = mysqli_real_escape_string($connection, $_POST['comment_author']);
                $comment_email = mysqli_real_escape_string($connection, $_POST['comment_email']);
                $comment_content = mysqli_real_escape_string($connection, $_POST['comment_content']);

                /* For empty fields in "Leave a comment" */
                if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)){

                    $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES ($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'waiting for approvale', now())";

                    $create_comment_query = mysqli_query($connection, $query);

                    if(!$create_comment_query){
                        die("QUERY FAILED" . mysqli_error($connection));
                    }

                    $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $the_post_id ";
                    $update_comment_count = mysqli_query($connection, $query);
                } else {
                    echo "<script>alert('Fields cannot be empty.')</script>";
                }
            };
            ?>
        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php
        include "includes/sidebar.php";
        ?>

    </div>
    <!-- /.row -->
    <hr>

    <!-- Footer -->
    <?php
    include "includes/footer.php";
    ?>
    </div>
