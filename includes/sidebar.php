<?php
include_once "admin/functions.php";
//session_start();

if(ifItIsMethod('post')){
    if(isset($_POST['login'])) {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            login_user($_POST['username'], $_POST['password']);
        } else {
            redirect('index');
        }
    }
}

?>



<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
        <div class="input-group">
            <input name="search" type="text" class="form-control">
            <span class="input-group-btn">
                            <button name="submit" class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
        </div>
        </form><!--search form-->
        <!-- /.input-group -->
    </div>


    <?php
    /* If a user is logged in he doesnt see the login form */
    if(!isset($_SESSION['user_role'])) {
        ?>

        <!-- Login -->
        <div class="well">
            <h4>Login</h4>
<!--            <form action="includes/login.php" method="post">-->
            <form method="post">
                <div class="form-group">
                    <input name="username" type="text" class="form-control" placeholder="Enter Username">
                </div>
                <div class="input-group">
                    <input name="password" type="password" class="form-control" placeholder="Enter Password">
                    <span class="input-group-btn">
                    <button class="btn btn-primary" name="login" type="submit">Submit</button>
                </span>
                </div>
<div class="form-group">
<a href="forgot_password.php?forgot=<?php echo uniqid(true); ?>">Forgot Password?</a>

</div>




            </form>
        </div>

        <?php
    }
    ?>


    
        
    

    <!-- Blog Categories Well -->
    <div class="well">
        
                <?php
                /* Getting the categories from the DB */
                $query = "SELECT * FROM categories"; // LIMIT 3";
                $select_categories_sidebar = mysqli_query($connection, $query);
                ?>
        
        
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12"> 
                <ul class="list-unstyled">
                    <?php
                    /* Setting the categories for the sidebar from the DB
                    and making them filter for posts */
                    while($row = mysqli_fetch_assoc($select_categories_sidebar)){
                    $cat_title = $row['cat_title'];
                    $cat_id = $row['cat_id'];
                    echo "<li><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>

    
    <!-- Side Widget Well -->
<?php include "widget.php"; ?>
    
</div>