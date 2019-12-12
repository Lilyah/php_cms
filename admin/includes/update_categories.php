<form action="" method="post">
    <div class="form-group">

    <?php
    /* Edit categories */
    if(isset($_POST['update_category'])){
        $the_cat_title = mysqli_real_escape_string($connection, $_POST['cat_title']);
        $query = "UPDATE categories SET cat_title = '{$the_cat_title}' WHERE cat_id = {$cat_id}";
        $update_query = mysqli_query($connection, $query);

        if(!$update_query){
            die("QUERY FAILED" . mysqli_error($connection));
            } else {
            //header("Location: ./categories.php");
             echo "<p class='bg-success'>Category Updated.</p>";
             }
        }
    ?>

     <label for="cat-title">Update Category</label> <!-- the code for processing update is above,
                                                    because the msg "Category Updated" has to appeare on top -->
                               
     <?php
     /* Getting the categories from the DB */
     if(isset($_GET['edit'])){
        $cat_id = mysqli_real_escape_string($connection, $_GET['edit']);
                                   
        $query = "SELECT * FROM categories WHERE cat_id = $cat_id";
        $select_categories_id = mysqli_query($connection, $query);
                                
        /*Setting the categories and categories id for the table from the DB */
         while($row = mysqli_fetch_assoc($select_categories_id)){
         $cat_id = $row['cat_id'];
         $cat_title = $row['cat_title'];
                               
     ?>
                                    
      <input value="<?php if(isset($cat_title)){echo $cat_title;}?>" type="text" class="form-control" name="cat_title">
                                    
      <?php
                               
          } // while
      } //if
                               
      ?>
                               
       </div>
                            
       <div class="form-group">
       <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
       </div>
</form>