<?php
include "includes/admin_header.php";
include_once "functions.php";
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
                        Welcome to comments,
                        <small><?php echo $_SESSION['username']?></small>
                    </h1>




<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>Id</th>
        <th>Author</th>
        <th>Comment</th>
        <th>Email</th>
        <th>Status</th>
        <th>In Response to</th>
        <th>Date</th>
        <th colspan="3">Action</th>
    </tr>
    </thead>

    <tbody>

<?php
// include_once "functions.php";
/* Getting and setting the comments from the DB */
findAllCommentsForExactPost();
approveCommentsForExactPost();
unapproveCommentsForExactPost();
deleteCommentsForExactPost();
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

<!-- /#page-wrapper -->

<?php
include "includes/admin_footer.php";
?>
