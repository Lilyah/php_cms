

<div class="page-header">
<?php
/* Users Online counteer showing */
echo "Users Online (with PHP, need refresh of the page): ".usersOnline();
echo "<br>";
echo "Users Online Instant (with AJAX):"?> <span class="usersonline"></span>
</div>



<table class="sortable table table-striped table-bordered table-hover table-condensed">
<thead>
    <tr>
        <th>Id</th>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Role</th>
        <th colspan="4">Action</th>
    </tr>
    <!-- Search form -->
    <tr>
        <th colspan="6">
            <!-- Search Field -->
            <form action="users.php?source=search" method="post">
                <input name="search" type="text" style="width:100%;">
            </form>
        </th>
        <th colspan="4"></th>
    </tr>
    </thead>

    <tbody>

<?php
/* Getting and setting the comments from the DB */
//findAllUsers();


        if (isset($_POST['search']) & !empty($_POST['search'])) {
        $search = $_POST['search'];
        $query = "SELECT * FROM users WHERE 
        user_id LIKE '%$search%' OR
        username LIKE '%$search%' OR
        user_firstname LIKE '%$search%' OR
        user_lastname LIKE '%$search%' OR
        user_email LIKE '%$search%' OR
        user_role LIKE '%$search%'";
        
        $search_query = mysqli_query($connection, $query);

            if (!$search_query) {
            die("QUERY FAILED" . mysqli_error($connection));
            }

        $count = mysqli_num_rows($search_query);
            if ($count == 0) {
                // do nothing if there are no records
            } else {
                /* Displaying the results from the search */
                $search_query = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($search_query)) {
                    $user_id = $row ['user_id'];
                    $username = $row ['username'];
                    $user_password = $row ['user_password'];
                    $user_firstname = $row['user_firstname'];
                    $user_lastname = $row ['user_lastname'];
                    $user_email = $row ['user_email'];
                    $user_image = $row ['user_image'];
                    $user_role = $row ['user_role'];

                    echo "<tr>";
                    echo "<td>{$user_id}</td>";
                    echo "<td>{$username}</td>";
                    echo "<td>{$user_firstname}</td>";
                    echo "<td>{$user_lastname}</td>";
                    echo "<td>{$user_email}</td>";
                    echo "<td>{$user_role}</td>";

                    echo "<td><a href='users.php?change_to_admin=$user_id'>Change to admin</a></td>";
                    echo "<td><a href='users.php?change_to_subscriber=$user_id'>Change to subscriber</a></td>";
                    echo "<td><a href='users.php?source=edit_user&edit_user=$user_id' title='Edit user'><i class=\"fa fa-pencil-square-o\"></i></a></td>";
                    echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete the User?') \" href='users.php?delete=$user_id' title='Delete user'><i class=\"fa fa-times\"></i></a></td>";
                    echo "</tr>";
                }
            }
        } else { header("Location: users.php"); }




changeToAdminUsers();
changeTosubscriberUsers();
deleteUsers();
?>

    </tbody>
</table>
