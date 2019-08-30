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
                        case '34': echo "NICE"; break;
                        case '100': echo "NICE2"; break;
                        case '200': echo "NICE3"; break;

                        default: include "includesview_all_posts.php";
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

