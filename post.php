<?php
include "includes/header.php";
include "includes/navigation.php";
?>

<?php

// LIKE button functionality
if (isset($_POST['liked'])){
  //1 FETCHING THE RIGHT POST
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    $query = "SELECT * FROM posts WHERE post_id = $post_id";
    $post_result = mysqli_query($connection, $query);
    $post = mysqli_fetch_array($post_result);
    $likes = $post['likes'];

    //2 UPDATE POSTS WITH LIKES
    mysqli_query($connection, "UPDATE posts SET likes=$likes+1 WHERE post_id = $post_id");

    //3 CREATE LIKES FOR POST
    mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)");
    exit();
}


// UNLIKE button functionality
if (isset($_POST['unliked'])){
    //1 FETCHING THE RIGHT POST
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    $query = "SELECT * FROM posts WHERE post_id = $post_id";
    $post_result = mysqli_query($connection, $query);
    $post = mysqli_fetch_array($post_result);
    $likes = $post['likes'];

    //2 CREATE UNLIKES FOR POST
    mysqli_query($connection, "UPDATE posts SET likes=$likes-1 WHERE post_id = $post_id");

    //3 DELETING LIKES FROM THE EXACT USER
    mysqli_query($connection, "DELETE FROM likes WHERE user_id = $user_id AND post_id = $post_id");

    exit();
}


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

                /* Counting views on every specific post */
                $view_query = "UPDATE posts SET post_view_counts = post_view_counts + 1 WHERE post_id = $the_post_id";
                $send_query = mysqli_query($connection, $view_query);

            /* Setting the posts information from the DB */
            $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
            $select_all_posts_query = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($select_all_posts_query)) {
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
                <!--Blog Post Author-->by <a href="index.php"><?php echo $post_author ?></a>
            </p>
            <!--Blog Post Date--><p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
            <hr>
            <img class="img-responsive" src="../images/<?php echo $post_image; ?>" alt="">
            <hr>
            <!--Blog Post Content--><p><?php echo $post_content ?></p>
            <hr>

<!--<div class="row">-->
<!-- Like button and Facebook Share button IFRAME -->

    <p><a class="<?php echo userLikedThisPost($the_post_id) ? 'unlike' : 'like'?>" href=""><span class="glyphicon glyphicon-thumbs-up"></span><?php echo userLikedThisPost($the_post_id) ? ' Unlike' : ' Like'?></a></p>
    <p>Likes: <?php echo getPostLikes($the_post_id); ?></p>
    <?php
    //Extracting the current URL
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    echo '<iframe src="https://www.facebook.com/plugins/share_button.php?href=' . $actual_link . '&layout=button&size=small&width=59&height=20&appId" width="59" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>';
     ?>



<!--                --><?php //getPostLikes($the_post_id); ?>


<!--</div>-->
        <br/>
            <hr>

            <?php
            }

            /* If it's not open specific post post_view_counts doesn't work */
            } else {
                header("Location: index.php");
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
            if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {

                $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES ($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'waiting for approvale', now())";

                $create_comment_query = mysqli_query($connection, $query);

                if (!$create_comment_query) {
                    die("QUERY FAILED" . mysqli_error($connection));
                }
//                one way for counting post comments
//                $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $the_post_id ";
//                $update_comment_count = mysqli_query($connection, $query);
            }
            }
            ?>

            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form action="" method="post" role="form">

                    <div class="form-group">
                        <label for="comment_author">Author</label>
                        <input type="text" class="form-control" name="comment_author">
                    </div>

                    <div class="form-group">
                        <label for="comment_email">Email</label>
                        <input type="email" class="form-control" name="comment_email">
                    </div>


                    <div class="form-group">
                        <label for="comment_content">Comment</label>
                        <textarea class="form-control" rows="3" name="comment_content"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                </form>
            </div>

            <hr>

            <!-- Posted Comments -->
            <?php
            $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} AND comment_status = 'Approved' ORDER BY comment_id DESC "; //desc give the first comments on top
            $select_comment_query = mysqli_query($connection, $query);

            if (!$select_comment_query) {
                die("QUERY FAILED" . mysqli_error($connection));
            }

            while ($row = mysqli_fetch_assoc($select_comment_query)) {
                $comment_date = $row ['comment_date'];
                $comment_content = $row ['comment_content'];
                $comment_author = $row ['comment_author'];
                ?>

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>

                <?php
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
<footer>
    <div class="row">
        <div class="col-lg-12">
            <p>Copyright &copy; Lilyah Website 2019</p>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</footer>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="../js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>


    </div>



<?php $user_id = $_SESSION['user_id']; ?>

<script>

$(document).ready(function(){

    // LIKE button functionality
    $('.like').click(function(){
        var post_id = <?php echo $the_post_id ?>;
            var user_id = <?php echo $user_id ?>;
    // console.log("IT WORKS MADA FAKAAAA");
        $.ajax({
            url: "../post.php?p_id=<?php echo $the_post_id ?>",
            type: 'post',
            data: {
                'liked': 1,
                'post_id': post_id,
                'user_id': user_id
            }
        });
    });



    // UNLIKE button functionality
    $('.unlike').click(function(){
        var post_id = <?php echo $the_post_id ?>;
        var user_id = <?php echo $user_id ?>;
        // console.log("IT WORKS MADA FAKAAAA");
        $.ajax({
            url: "../post.php?p_id=<?php echo $the_post_id ?>",
            type: 'post',
            data: {
                'unliked': 1,
                'post_id': post_id,
                'user_id': user_id
            }
        });
    });

});

</script>