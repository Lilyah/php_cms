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

                /* Calculating to show 5 posts on every page (from pagination) */
                $per_page = 5;

                if(isset($_GET['page'])){

                    $page = $_GET['page'];
                } else {
                    $page = "";
                }

                if($page == "" || $page == 1){
                    $page_1 = 0;
                } else {
                    $page_1 = ($page * $per_page) - $per_page;
                }

                /* Counting the posts from the DB */
                $post_query_count = "SELECT * FROM posts";
                $find_count = mysqli_query($connection, $post_query_count);
                $count = mysqli_num_rows($find_count);

                $count = ceil($count / $per_page); //rounding

                /* Setting the posts information from the DB */
                $query = "SELECT * FROM posts WHERE post_status = 'Published' ORDER BY post_id DESC LIMIT $page_1, $per_page";
                $select_all_posts_query = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_all_posts_query)){
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_user_id'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = substr($row['post_content'], 0, 260) . "...";  //shorter text display
                    ?>

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <!--Blog Post Title; href is for opening a single post page--><a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    <!--Blog Post Author-->by <a title="View all posts from this author" href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $post_id ?>"><?php echo $post_author ?></a>
                </p>
                    <!--Blog Post Date--><p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                <hr>
                    <!--Blog Post IMG; href is for opening a single post page -->
                    <a href="post.php?p_id=<?php echo $post_id ?>">
                    <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                    </a>
                <hr>
                    <!--Blog Post Content--><p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="post/<?php echo $post_id ?>">Read More<span class="glyphicon glyphicon-chevron-right"></span></a>
<!-- without .htaccess and rewrite urls
               <a class="btn btn-primary" href="post.php?p_id=--><?php //echo $post_id ?><!--">Read More<span class="glyphicon glyphicon-chevron-right"></span></a>-->
                <hr>

                <?php
                }
                ?>


            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php
            include "includes/sidebar.php";
            ?>

        </div>
        <!-- /.row -->
        <hr>


    <ul class="pager">

        <?php
        /* Displaying the numbers of all pages/pagination below the last post
        and using css to coloring the current page */
        for($i = 1; $i <= $count; $i++) {
            if ($i == $page) {
                echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a>";
            } else {
                echo "<li><a href='index.php?page={$i}'>{$i}</a>";
            }
        }



        ?>
    </ul>

    <!-- Footer -->
<?php
include "includes/footer.php";
?>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
        <script>

            var pusher = new Pusher('9ec167a077be7bedd4ea', {
                cluster: 'eu',
                forceTLS: true
            });

            var channel = pusher.subscribe('notification');
            channel.bind('new_user', function(data) {
                toastr.success('Have fun storming the castle!', 'Miracle Max Says');
                var message = data.message;
            });
        </script>


