<?php

if(isset($_GET['edit_user'])) {
    $the_user_id = $_GET['edit_user'];

    $query = "SELECT * FROM users WHERE user_id = $the_user_id";
    $select_all_users_by_id = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_all_users_by_id)) {
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_role = $row['user_role'];
        $username = $row['username'];
        $user_email = $row['user_email'];
        $user_password = $row['user_password'];
    }


    if (isset($_POST['edit_user'])) {
        $user_firstname = mysqli_real_escape_string($connection, $_POST['user_firstname']);
        $user_lastname = mysqli_real_escape_string($connection, $_POST['user_lastname']);
        $user_role = mysqli_real_escape_string($connection, $_POST['user_role']);
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $user_email = mysqli_real_escape_string($connection, $_POST['user_email']);
        $user_password = mysqli_real_escape_string($connection, $_POST['user_password']);

        //$user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10)); //crypt the passwod


//    /* crypt the password when user update it
//    and showing it in the edit field without encryption */
//    $query = "SELECT randSalt FROM users";
//    $select_randsalt_query = mysqli_query($connection, $query);
//
//    if (!$select_randsalt_query){
//        die("Query Failed" . mysqli_error($connection));
//    }
//
//    $row = mysqli_fetch_array($select_randsalt_query);
//    $salt = $row['randSalt'];
//    $hashed_password = crypt($user_password, $salt);


        if (!empty($user_password)) {
            $query_password = "SELECT user_password FROM users WHERE user_id = $the_user_id";
            $get_user_query = mysqli_query($connection, $query);
            //confirmQuery($get_user_query);
            $row = mysqli_fetch_array($get_user_query);
            $db_user_password = $row['user_password'];

            if ($db_user_password != $user_password) {
                $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));
            }

            $query = "UPDATE users SET ";
            $query .= "user_firstname = '{$user_firstname}', ";
            $query .= "user_lastname = '{$user_lastname}', ";
            $query .= "user_role = '{$user_role}', ";
            $query .= "username = '{$username}', ";
            $query .= "user_email = '{$user_email}', ";
            $query .= "user_password = '{$hashed_password}' ";
            $query .= "WHERE user_id = '{$the_user_id}' ";

            $edit_user_query = mysqli_query($connection, $query);
            confirmQuery($edit_user_query);

            echo "<p class='bg-success'>User Updated. <a href='users.php'>View Users</a></p>";

        }
    }
} else { //if in the header we don't have specific user id for whatever reason
    header("Location: users.php");
}


?>





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
        <label for="user_role">User Role</label>
        <br>
        <select name="user_role" id="">
            <option selected="$user_role"><?php echo $user_role; ?></option> <!-- to be default option -->
<!--            <option value="admin">admin</option>-->
            <?php

            if($user_role == 'admin'){
                echo "<option value='Subscriber'>subscriber</option>";
            } else {
                echo "<option value='Admin'>admin</option>";
            };

            ?>

        </select>
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
        <input type="password" class="form-control" autocomplete="off" value="<?php echo $user_password; ?>" name="user_password" id="user_password">
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
        <input type="submit" class="btn btn-primary" name="edit_user" value="Edit User">
    </div>
</form>