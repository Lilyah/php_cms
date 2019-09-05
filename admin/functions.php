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
        $cat_title = $_POST['cat_title'];
                                
        if($cat_title == " " || empty($cat_title)){ //empty string or empty field
            echo "This field cannot be empty.";                                
            } else {
            $query = "INSERT INTO categories(cat_title) VALUE('$cat_title')";
            $create_category_query = mysqli_query($connection, $query);
                                
                if(!$create_category_query){
                die('QUERY FAILED' . mysqli_error($connection));
                }                             
        }
    }
                            
  }



function findAllCategories(){
    global $connection;
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);
                                
    /*Setting the categories and categories id for the table from the DB */
    while($row = mysqli_fetch_assoc($select_categories)){
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
                                    
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";                                    
    }
}
              



function deleteCategories(){
    global $connection;
    if(isset($_GET['delete'])){
        $the_cat_id = $_GET['delete'];                                    
        $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
        $delete_query = mysqli_query($connection, $query);
        /* Refreshing the page, so deleting to hapend with one click */
        header("Location: categories.php");
    }
}




function deletePosts(){
    global $connection;
    if(isset($_GET['delete'])){
        $the_post_id = $_GET['delete'];
        $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
        $delete_query = mysqli_query($connection, $query);
        /* Refreshing the page, so deleting to happend with one click */
        header("Location: posts.php");
    }
}




function findAllPosts()
{
    global $connection;
    $query = "SELECT * FROM posts";
    $select_all_posts_query = mysqli_query($connection, $query);

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

        echo "<tr>";
        echo "<td>{$post_id}</td>";
        echo "<td>{$post_author}</td>";
        echo "<td>{$post_title}</td>";

        /* Displaying categories NAME by using categories id */
        $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
        $select_categories_id = mysqli_query($connection, $query);

        /* Setting the categories and categories id for the table from the DB */
        while($row = mysqli_fetch_assoc($select_categories_id)) {
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];

            echo "<td>{$cat_title}</td>";
        }

        echo "<td>{$post_status}</td>";
        echo "<td><img width='72' height='42' style='display: block; margin-left: auto; margin-right: auto' src='../images/$post_image'></td>"; // displays the img and setting the size and position
        echo "<td>{$post_tags}</td>";
        echo "<td>{$post_comment_count}</td>";
        echo "<td>{$post_date}</td>";
        echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
        echo "<td><a href='posts.php?delete={$post_id}'>Delete</a></td>";
        echo "</tr>";
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
        echo "<td><a href='comments.php?delete=$comment_id'>Delete</a></td>";
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


function findAllUsers()
{
    global $connection;
    $query = "SELECT * FROM users";
    $select_all_users_query = mysqli_query($connection, $query);

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

        echo "<td><a href='users.php?approve='>Approve</a></td>";
        echo "<td><a href='users.php?unapprove='>Unapprove</a></td>";
        echo "<td><a href='users.php?delete='>Delete</a></td>";
        echo "</tr>";
    }
}





?>