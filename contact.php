<?php  // include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>



<?php

/* Sedning emails functionality */

if(isset($_POST['submit'])) {

    $header = mysqli_real_escape_string($connection, $_POST['email']);
    $subject = mysqli_real_escape_string($connection, wordwrap($_POST['subject']));
    $body = mysqli_real_escape_string($connection, $_POST['body']);
    $to = "lilyah.boz@gmail.com";

    mail($to, $subject, $body, $header); // use wordwrap() if lines are longer than 70 characters
}

?>

    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact</h1>
                    <form role="form" action="" method="post" id="contact-form" autocomplete="off">
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="youremail@example.com">
                        </div>
                         <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">
                         </div>
                         <div class="form-group">
                             <textarea name="body" id="body" class="form-control" cols="50" rows="10" placeholder="Enter your massage"></textarea>
                         </div>
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>
        <hr>

<?php include "includes/footer.php";?>