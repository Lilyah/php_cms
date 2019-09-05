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
                    Welcome to admin
                    <small><br>Author name here</small>
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
                        case 'add_post': include "includes/add_post.php"; break;
                        case 'edit_post': include "includes/edit_post.php"; break;

                        default: include "includes/view_all_comments.php"; break;
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
