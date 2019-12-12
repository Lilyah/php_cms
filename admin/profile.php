<?php 
include "includes/admin_header.php";
include "functions.php";
ob_start();
?>

<?php
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_profile_query = mysqli_query($connection, $query);

    while($row = mysqli_fetch_array($select_user_profile_query)){
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_role = $row['user_role'];
        $username = $row['username'];
        $user_email = $row['user_email'];
        $user_password = $row['user_password'];
    }
}


if(isset($_POST['edit_user'])){
    $user_firstname = mysqli_real_escape_string($connection, $_POST['user_firstname']);
    $user_lastname = mysqli_real_escape_string($connection, $_POST['user_lastname']);
    $user_role = mysqli_real_escape_string($connection, $_POST['user_role']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $user_email = mysqli_real_escape_string($connection, $_POST['user_email']);
    $user_password = mysqli_real_escape_string($connection, $_POST['user_password']);

    $query = "UPDATE users SET ";
    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";
    $query .= "user_role = '{$user_role}', ";
    $query .= "username = '{$username}', ";
    $query .= "user_email = '{$user_email}', ";
    $query .= "user_password = '{$user_password}' ";
    $query .= "WHERE username = '{$username}' ";

    $edit_user_query = mysqli_query($connection, $query);

    confirmQuery($edit_user_query);

    header ("Location: users.php");
}

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

                <form action="" method="post" enctype="multipart/form-data">


                    <div class="form-group">
                        <label for="user_firstname">First Name</label>
                        <input type="text" class="form-control" value="<?php echo $user_firstname; ?>" name="user_firstname">
                    </div>

                    <div class="form-group">
                        <label for="user_lastname">Last Name</label>
                        <input type="text" class="form-control" value="<?php echo $user_lastname; ?>" name="user_lastname">
                    </div>

                    <div class="form-group">
                        <label for="user_role">User Role: <?php echo $user_role?></label>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" value="<?php echo $username; ?>" name="username">
                    </div>

                    <div class="form-group">
                        <label for="user_email">Email</label>
                        <input type="email" class="form-control" value="<?php echo $user_email; ?>" name="user_email">
                    </div>

                    <div class="form-group">
                        <label for="user_pasword">Password</label>
                        <input type="password" class="form-control" value="<?php echo $user_password; ?>" name="user_password" id="user_password">
                        <input type="checkbox" onclick="visiblePassword()"> Show Password

                        <!-- Option for visible password -->
                        <script>
                            function visiblePassword() {
                                var x = document.getElementById("user_password");
                                if (x.type === "password") {
                                    x.type = "text";
                                } else {
                                    x.type = "password";
                                }
                            }
                        </script>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="edit_user" value="Update Profile">
                    </div>
                </form>


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

