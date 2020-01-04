<?php


function confirmQuery($result){
    global $connection;
    if(!$result){
        die("QUERY FAILED" . mysqli_error($connection));
    }
}



function insert_categories(){
    global $connection;
    if(isset($_POST['submit'])){
        $cat_title = mysqli_real_escape_string($connection, $_POST['cat_title']);
                                
        if($cat_title == " " || empty($cat_title)){ //empty string or empty field
            echo "This field cannot be empty.";                                
        } else {
            $query = "INSERT INTO categories(cat_title) VALUE('$cat_title')";
            $create_category_query = mysqli_query($connection, $query);
                                
            if(!$create_category_query){
                die('QUERY FAILED' . mysqli_error($connection));
            } else {
                echo "<p class='bg-success'>Category Created.</p>";
            }
        }
    }
}



function findAllCategories(){
    global $connection;
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);

        /*Setting the categories and categories id for the table from the DB */
        while ($row = mysqli_fetch_assoc($select_categories)) {
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];

            echo "<tr>";
            echo "<td>{$cat_id}</td>";
            echo "<td>{$cat_title}</td>";
            echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
            echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete the Category?') \" href='categories.php?delete={$cat_id}'>Delete</a></td>";
            echo "</tr>";
        }
}



function deleteCategories(){
    global $connection;
    if(isset($_GET['delete'])) {
            $the_cat_id = $_GET['delete'];
            $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
            $delete_query = mysqli_query($connection, $query);

            if (!$delete_query) {
                die("QUERY FAILED" . mysqli_error($connection));
            } else {
                echo "<p class='bg-success'>Category Deleted.</p>";
            }
//        /* Refreshing the page, so deleting to hapend with one click */
//        header( "Location: categories.php");
        }
}




function deletePosts()
{
    global $connection;
    if (isset($_GET['delete'])) {
        /*
        Only logedin users with can delete posts,
        no one outside from admin can't delete data
        */
        $query = "SELECT * FROM users ";
        $select_all_users_query = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($select_all_users_query);
        $user_role = $row ['user_role'];

        if($user_role == 'admin' || $user_role == 'subscriber'){

            $the_post_id = $_GET['delete'];
            $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
            $delete_query = mysqli_query($connection, $query);
            /* Refreshing the page, so deleting to happend with one click */
            //header("Location: posts.php");

            if (!$delete_query) {
                die("QUERY FAILED" . mysqli_error($connection));
            } else {
                echo "<p class='bg-success'>Post Deleted.</p>";
            }
        }
    }
}




function findAllPosts()
{
    global $connection;
    $query = "SELECT * FROM posts ORDER BY post_id DESC";

//    if(isset($_GET['sort'])){
//        $sort = $_GET['sort'];
//
//        switch($sort){
//            case 'id_asc':  $query = "SELECT * FROM posts ORDER BY post_id ASC"; break;
//            case 'id_desc': $query = "SELECT * FROM posts ORDER BY post_id DESC"; break;
//
//            case 'author_asc':  $query = "SELECT * FROM posts ORDER BY post_author ASC"; break;
//            case 'author_desc': $query = "SELECT * FROM posts ORDER BY post_author DESC"; break;
//
//            case 'status_draft':  $query = "SELECT * FROM posts ORDER BY post_status ASC"; break;
//            case 'status_pub': $query = "SELECT * FROM posts ORDER BY post_status DESC"; break;
//
//            case 'views_asc':  $query = "SELECT * FROM posts ORDER BY post_view_counts ASC"; break;
//            case 'views_desc': $query = "SELECT * FROM posts ORDER BY post_view_counts DESC"; break;
//
//            case 'comments_asc':  $query = "SELECT * FROM posts ORDER BY post_comment_count ASC"; break;
//            case 'comments_desc': $query = "SELECT * FROM posts ORDER BY post_comment_count DESC"; break;
//
//            default: include "includes/view_all_posts.php"; break;
//        }
//    }


    $select_all_posts_query = mysqli_query($connection, $query);

    if ($_SESSION['user_role'] == 'admin' || $_SESSION['user_role'] == 'subscriber') {
        /* Setting the posts in the table */
        while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
            $post_id = $row ['post_id'];
            $post_author = $row ['post_author'];
            $post_title = $row['post_title'];
            $post_category_id = $row ['post_category_id'];
            $post_status = $row ['post_status'];
            $post_image = $row ['post_image'];
            $post_tags = $row ['post_tags'];
            $post_comment_count = $row ['post_comment_count'];
            $post_date = $row ['post_date'];
            $post_view_counts = $row ['post_view_counts'];

            echo "<tr>";
            ?>
            <!-- Checkboxes -->
            <td><input type='checkbox' class='checkBoxes' id='selectAllBoxes' name='checkBoxArray[]'
                       value='<?php echo $post_id ?>'></td>
            <?php
            echo "<td>{$post_id}</td>";
            echo "<td>{$post_author}</td>";
            echo "<td>{$post_title}</td>";


            /* Displaying categories NAME by using categories id */
            $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
            $select_categories_id = mysqli_query($connection, $query);

            /* Setting the categories and categories id for the table from the DB */
            while ($row = mysqli_fetch_assoc($select_categories_id)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                echo "<td>{$cat_title}</td>";
            }

            echo "<td>{$post_status}</td>";
            echo "<td><img width='72' height='42' style='display: block; margin-left: auto; margin-right: auto' src='../images/$post_image'></td>"; // displays the img and setting the size and position
            echo "<td>{$post_tags}</td>";
            echo "<td>{$post_view_counts}</td>";

            /* Comments counter */
            $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
            $send_comment_count_query = mysqli_query($connection, $query);

            //fetching the comment for every specific post so on click to view only comments on one post
            $row = mysqli_fetch_array($send_comment_count_query);
            $comment_id = $row ['comment_id'];
            $count_comments = mysqli_num_rows($send_comment_count_query);
            echo "<td><a href='post_comments.php?id=$post_id'>$count_comments</a></td>";

            echo "<td>{$post_date}</td>";
            echo "<td><a href='../post.php?p_id={$post_id}' title='View post'><i class=\"fa fa-search\"></i></a></td>";
            echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}' title='Edit post'><i class=\"fa fa-pencil-square-o\"></i></a></td>";
            echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete the Post?') \" href='posts.php?source=delete_post&p_id={$post_id}' title='Delete post'><i class=\"fa fa-times\"></i></a></td>";
            echo "</tr>";
        }
    }
}




function findAllComments()
{
    global $connection;
    $query = "SELECT * FROM comments";
    $select_all_comments_query = mysqli_query($connection, $query);

    /* Setting the posts in the table */
    while ($row = mysqli_fetch_assoc($select_all_comments_query)) {
        $comment_id = $row ['comment_id'];
        $comment_post_id = $row ['comment_post_id'];
        $comment_author = $row ['comment_author'];
        $comment_content = $row['comment_content'];
        $comment_email = $row ['comment_email'];
        $comment_status = $row ['comment_status'];
        $comment_date = $row ['comment_date'];

        echo "<tr>";
        echo "<td>{$comment_id}</td>";
        echo "<td>{$comment_author}</td>";
        echo "<td>{$comment_content}</td>";
        echo "<td>{$comment_email}</td>";
        echo "<td>{$comment_status}</td>";

        /* Getting posts NAME by using posts id */
        $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
        $select_post_id_query = mysqli_query($connection, $query);

        /* Setting the posts names and posts id for the table from the DB */
        while($row = mysqli_fetch_assoc($select_post_id_query)){
            $post_id = $row ['post_id'];
            $post_title = $row['post_title'];

            echo "<td><a href='../post.php?p_id={$post_id}'>$post_title</a></td>";
        }

        echo "<td>{$comment_date}</td>";
        echo "<td><a href='comments.php?approve=$comment_id'>Approve</a></td>";
        echo "<td><a href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
        echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete the Comment?') \" href='comments.php?delete=$comment_id' title='Delete comment'><i class=\"fa fa-times\"></i></a></td>";
        echo "</tr>";
    }
}




function findAllCommentsForExactPost()
{
    global $connection;
    $query = "SELECT * FROM comments WHERE comment_post_id =" . mysqli_real_escape_string($connection, $_GET['id'])." ";
    $select_all_comments_query = mysqli_query($connection, $query);

    /* Setting the posts in the table */
    while ($row = mysqli_fetch_assoc($select_all_comments_query)) {
        $comment_id = $row ['comment_id'];
        $comment_post_id = $row ['comment_post_id'];
        $comment_author = $row ['comment_author'];
        $comment_content = $row['comment_content'];
        $comment_email = $row ['comment_email'];
        $comment_status = $row ['comment_status'];
        $comment_date = $row ['comment_date'];

        echo "<tr>";
        echo "<td>{$comment_id}</td>";
        echo "<td>{$comment_author}</td>";
        echo "<td>{$comment_content}</td>";
        echo "<td>{$comment_email}</td>";
        echo "<td>{$comment_status}</td>";

        /* Getting posts NAME by using posts id */
        $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
        $select_post_id_query = mysqli_query($connection, $query);

        /* Setting the posts names and posts id for the table from the DB */
        while($row = mysqli_fetch_assoc($select_post_id_query)){
            $post_id = $row ['post_id'];
            $post_title = $row['post_title'];

            echo "<td><a href='../post.php?p_id={$post_id}'>$post_title</a></td>";
        }

        echo "<td>{$comment_date}</td>";
        echo "<td><a href='post_comments.php?approve=$comment_id&id=" . $_GET['id'] ."''>Approve</a></td>";
        echo "<td><a href='post_comments.php?unapprove=$comment_id&id=" . $_GET['id'] ."''>Unapprove</a></td>";
        echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete the Comment?') \" href='post_comments.php?delete=$comment_id&id=" . $_GET['id'] ."'>Delete</a></td>";
        echo "</tr>";
    }
}






function approveComments(){
    global $connection;
    if(isset($_GET['approve'])){
        $the_comment_id = $_GET['approve'];
        $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = {$the_comment_id} ";
        $approve_comment_query = mysqli_query($connection, $query);
        //confirmQuery($approve_comment_query);
        /* Refreshing the page, so approving to happend with one click */
        header("Location: comments.php");
    }
}


function approveCommentsForExactPost(){
    global $connection;
    if(isset($_GET['approve'])){
        $the_comment_id = $_GET['approve'];
        $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = {$the_comment_id} ";
        $approve_comment_query = mysqli_query($connection, $query);
        //confirmQuery($approve_comment_query);
        /* Refreshing the page, so approving to happend with one click */
        header("Location: post_comments.php?id=" . $_GET['id'] ."");
    }
}



function unapproveComments(){
    global $connection;
    if(isset($_GET['unapprove'])){
        $the_comment_id = $_GET['unapprove'];
        $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = {$the_comment_id} ";
        $unapprove_comment_query = mysqli_query($connection, $query);
        confirmQuery($unapprove_comment_query);
        /* Refreshing the page, so unapproving to hapend with one click */
        header("Location: comments.php");
    }
}



function unapproveCommentsForExactPost(){
    global $connection;
    if(isset($_GET['unapprove'])){
        $the_comment_id = $_GET['unapprove'];
        $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = {$the_comment_id} ";
        $unapprove_comment_query = mysqli_query($connection, $query);
        confirmQuery($unapprove_comment_query);
        /* Refreshing the page, so unapproving to hapend with one click */
        header("Location: post_comments.php?id=" . $_GET['id'] ."");
    }
}



function deleteComments(){
    global $connection;
    if(isset($_GET['delete'])){
        $the_comment_id = $_GET['delete'];
        $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id}";
        $delete_query = mysqli_query($connection, $query);
        //confirmQuery($the_comment_id);
        /* Refreshing the page, so deleting to hapend with one click */
        header("Location: comments.php");
    }
}



function deleteCommentsForExactPost(){
    global $connection;
    if(isset($_GET['delete'])){
        $the_comment_id = $_GET['delete'];
        $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id}";
        $delete_query = mysqli_query($connection, $query);
        //confirmQuery($the_comment_id);
        /* Refreshing the page, so deleting to hapend with one click */
        header("Location: post_comments.php?id=" . $_GET['id'] ."");
    }
}


function findAllUsers()
{
    global $connection;
    $query = "SELECT * FROM users";
    $select_all_users_query = mysqli_query($connection, $query);

    /* Users with admin role CAN delete other users */
    if ($_SESSION['user_role'] == 'admin'){
        /* Setting the users in the table */
        while ($row = mysqli_fetch_assoc($select_all_users_query)) {
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

//        /* Getting posts NAME by using posts id */
//        $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
//        $select_post_id_query = mysqli_query($connection, $query);
//
//        /* Setting the posts names and posts id for the table from the DB */
//        while($row = mysqli_fetch_assoc($select_post_id_query)){
//            $post_id = $row ['post_id'];
//            $post_title = $row['post_title'];
//
//            echo "<td><a href='../post.php?p_id={$post_id}'>$post_title</a></td>";
//        }

            echo "<td><a href='users.php?change_to_admin=$user_id'>Change to admin</a></td>";
            echo "<td><a href='users.php?change_to_subscriber=$user_id'>Change to subscriber</a></td>";
            echo "<td><a href='users.php?source=edit_user&edit_user=$user_id' title='Edit user'><i class=\"fa fa-pencil-square-o\"></i></a></td>";
            echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete the User?') \" href='users.php?delete=$user_id' title='Delete user'><i class=\"fa fa-times\"></i></a></td>";
            echo "</tr>";
        }
    }

    /* Users with user role subscriber CAN'T delete other users */
    if ($_SESSION['user_role'] == 'subscriber') {
        /* Setting the users in the table */
        while ($row = mysqli_fetch_assoc($select_all_users_query)) {
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

//        /* Getting posts NAME by using posts id */
//        $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
//        $select_post_id_query = mysqli_query($connection, $query);
//
//        /* Setting the posts names and posts id for the table from the DB */
//        while($row = mysqli_fetch_assoc($select_post_id_query)){
//            $post_id = $row ['post_id'];
//            $post_title = $row['post_title'];
//
//            echo "<td><a href='../post.php?p_id={$post_id}'>$post_title</a></td>";
//        }

            echo "<td><a href='users.php?change_to_admin=$user_id'>Change to admin</a></td>";
            echo "<td><a href='users.php?change_to_subscriber=$user_id'>Change to subscriber</a></td>";
            echo "<td><a href='users.php?source=edit_user&edit_user=$user_id' title='Edit user'><i class=\"fa fa-pencil-square-o\"></i></a></td>";
            echo "<td><a onClick=\"javascript: return confirm('You don\'t have permissions') \" title='Delete user'><i class=\"fa fa-times\"></i></a></td>";
            echo "</tr>";
        }
    }
}



function deleteUsers()
{
    global $connection;
    if (isset($_GET['delete'])) {
        /*
        Only users with admin role ca delete other users
        no one outside from admin can't delete data
        */
        if ($_SESSION['user_role'] == 'admin') {
            $the_user_id = mysqli_real_escape_string($connection, $_GET['delete']);
            $query = "DELETE FROM users WHERE user_id = {$the_user_id}";
            $delete_user_query = mysqli_query($connection, $query);
            confirmQuery($delete_user_query);
            /* Refreshing the page, so deleting to hapend with one click */
            //header("Location: users.php");
            if (!$delete_user_query) {
                die('QUERY FAILED' . mysqli_error($connection));
            } else {
                echo "<p class='bg-success'>User Deleted.</p>";
            }
        }
    }
}



function changeToAdminUsers(){
    global $connection;
    if(isset($_GET['change_to_admin'])){
        $the_user_id = $_GET['change_to_admin'];
        $query = "UPDATE users SET user_role = 'admin' WHERE user_id = {$the_user_id}";
        $change_to_admin_query = mysqli_query($connection, $query);
        confirmQuery($change_to_admin_query);
        /* Refreshing the page, so the changes to happend with one click */
        // header("Location: users.php");
        if(!$change_to_admin_query){
            die('QUERY FAILED' . mysqli_error($connection));
        } else {
            echo "<p class='bg-success'>User Role changed to admin.</p>";
        }
    }
}



//case 'draft':
//                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
//                $update_to_draft_status = mysqli_query($connection, $query);
//                if(!$update_to_draft_status){
//                    die("QUERY FAILED" . mysqli_error($connection));
//                } else {
//                    echo "<p class='bg-success'>Post status changed ot Draft.</p>";
//                }
//                break;






function changeToSubscriberUsers(){
    global $connection;
    if(isset($_GET['change_to_subscriber'])){
        $the_user_id = $_GET['change_to_subscriber'];
        $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = {$the_user_id}";
        $change_to_subscriber_query = mysqli_query($connection, $query);
        confirmQuery($change_to_subscriber_query);
        /* Refreshing the page, so the changes to happend with one click */
        header("Location: users.php");
    }
}



function usersOnline(){
    /* Users Online Counter */
    global $connection;
    $session = session_id(); //catch the id session
    $time = time();
    $time_out_in_seconds = 30; // seconds
    $time_out = $time - $time_out_in_seconds;

    $query = "SELECT * FROM users_online WHERE session ='$session' ";
    $send_query = mysqli_query($connection, $query);
    $count = mysqli_num_rows($send_query); //counting if everybody is online

    if ($count == NULL) { //if nobody is online
        mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session','$time')");
    } else {
        mysqli_query($connection, "UPDATE users_online SET time ='$time' WHERE session = '$session' ");
    }

    $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out' ");
    return $count_user = mysqli_num_rows($users_online_query);
}



function usersOnlineInstant()
{
    if(isset($_GET['onlineusers'])) {

        /* Users Online Counter */
        global $connection;

        if (!$connection) {
            session_start();
            include("../includes/db.php");

            $session = session_id(); //catch the id session
            $time = time();
            $time_out_in_seconds = 05; // seconds
            $time_out = $time - $time_out_in_seconds;

            $query = "SELECT * FROM users_online WHERE session ='$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query); //counting if everybody is online

            if ($count == NULL) { //if nobody is online
                mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session','$time')");
            } else {
                mysqli_query($connection, "UPDATE users_online SET time ='$time' WHERE session = '$session'");
            };

            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
            echo $count_user = mysqli_num_rows($users_online_query);
        } //end of get request
    }
};
usersOnlineInstant();



function username_exists($username){
    global $connection;

    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if(mysqli_num_rows($result) > 0){
        return true;
    } else {
        return false;
    }
}




function email_exists($email){
    global $connection;

    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if(mysqli_num_rows($result) > 0){
        return true;
    } else {
        return false;
    }
}


function register_user($username, $email, $password){
    global $connection;

    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);


    if (username_exists($username)){
        $message = "This username already exist, please choose another one";
    } else {

        /* For empty fields in "Leave a comment" */
            $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12)); //more simple way to do the same crypt ad commented one below

            $query = "INSERT INTO users (username, user_email, user_password, user_role) VALUES ('{$username}', '{$email}', '{$password}', 'subscriber')";
            $register_user_query = mysqli_query($connection, $query);

            confirmQuery($register_user_query);
    }
}



function login_user($username, $password){
    global $connection;

    $username = mysqli_real_escape_string($connection, trim($username));
    $password = mysqli_real_escape_string($connection, trim($password));

    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);

    if(!$select_user_query){
        die("QUERY FAILED" . mysqli_error($connection));
    }

    while($row = mysqli_fetch_array($select_user_query)){
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];
    }

    if(password_verify($password, $db_user_password)){ //Verifies that a password matches a hash
        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_user_firstname;
        $_SESSION['lastname'] = $db_use_lastname;
        $_SESSION['user_role'] = $db_user_role;

        header("Location: ../admin");

    } else {
        header("Location: ../index.php");
    }
}

?>