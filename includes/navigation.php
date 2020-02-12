<?php
include_once "includes/db.php";
include_once "admin/functions.php";
//session_start();
?>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/projects/lili/cms">CMS Front</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <?php
                /* Setting the categories from the DB */
                $query = "SELECT * FROM categories";
                $select_all_categories_query = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_all_categories_query)){
                    $cat_title = $row['cat_title'];
                    $cat_id = $row['cat_id'];

                    echo "<li><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";
                }


                /* Admin will be visible only for logged in users */
                /* If a user is logged in he doesnt see the registration and contact forms */
                if(isset($_SESSION['user_role'])){
                ?>
                <li>
                    <a href="admin">Admin</a>
                </li>
                <li>
                    <a href="includes/logout.php">Logout</a>
                </li>

                <?php }
                if(!isset($_SESSION['user_role'])){ ?>
                <li>
                    <a href="login">Login</a>
                </li>
                <li>
                    <a href="registration">Registration</a>
                </li>
                <li>
                    <a href="contact">Contact</a>
                </li>

                <?php };

                /* Registration functionality */
                /* "Edit Post" will appear in navigation only if user_role is set */
                if(isset($_SESSION['user_role'])){
                    if(isset($_GET['p_id'])){
                        $the_post_id = $_GET['p_id'];
                        echo "<li><a href='admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";
                    }
                }
                ?>

            </ul>

            <?php
            /* If user is not logged in can't see the top right username and dropdown */
            if(isset($_SESSION['user_role'])) {
                ?>
            <ul class="nav navbar-right top-nav">
                <!-- Dropdown top-right -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                        <?php
                        if(isset($_SESSION['username'])){
                            echo "Logged in as " .$_SESSION['username'];
                        };
                        ?>
                        <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="admin/profile.php"><i class="fa fa-fw fa-user"></i>Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="includes/logout.php"><i class="fa fa-fw fa-power-off"></i>Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <?php
            }
            ?>

        </div>
        <!-- /.navbar-collapse -->

    </div>
    <!-- /.container -->
</nav>