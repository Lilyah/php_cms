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
                        
            <div class="col-xs-6">
                            
            <?php
                            
            /* Adding categories from admin page to DB */
            insert_categories();
            ?>
                            
            <form action="" method="post">
                <div class="form-group">
                <label for="cat-title">Add Category</label>
                <input class="form-control" type="text" name="cat_title">                        
                </div>
                            
                <div class="form-group">
                <input class="btn btn-primary" type="submit" name="submit" value="Add Category">                        
                </div>
            </form>
                            
            <?php 
            /* Include update_categories.php */                         
            if(isset($_GET['edit'])){
                $cat_id = $_GET['edit'];
                include "includes/update_categories.php";  
            }                    
            ?>
            </div>
                
            <!--Add Category Form-->
            <div class="col-xs-6">
            <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Id</th>
                <th>Category Title</th>    
                <th colspan="2">Action</th> 
            </tr>
            </thead>
                            
            <tbody>
            <?php
            /* Getting the categories from the DB */
            findAllCategories();
                                    
            /* Delete categories */
            deleteCategories();
            ?>
            </tbody>
            </table>
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
