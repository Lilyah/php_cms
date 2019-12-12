<?php 
include "includes/admin_header.php";
include "functions.php";
ob_start();
?>


<div id="wrapper">
    
        
<!-- Navigation -->
<?php 
include "includes/admin_navigation.php"; 
?>
        
        
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Welcome to admin,
                    <small><?php echo $_SESSION['username']?></small>
                </h1>


                <!--Add Table for All Posts in Admin-->
                <div class="col-xs-12">

                    <?php
                    if(isset($_GET['source'])){
                        $source = $_GET['source'];
                    } else {
                        $source = '';
                    }

                    switch($source){
                        case 'add_user': include "includes/add_user.php"; break;
                        case 'edit_user': include "includes/edit_user.php"; break;
                        case 'search': include "includes/search_all_users.php"; break;

                        default: include "includes/view_all_users.php"; break;
                    }

                    ?>



                </div>
            </div>
        </div>
    <!-- /.row -->
    </div>
<!-- /.container-fluid -->
</div>
</div>

<!-- /#page-wrapper -->
        
<?php 
include "includes/admin_footer.php"; 
?>

