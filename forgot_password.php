<?php
include "includes/db.php";
include "includes/header.php";
include_once "admin/functions.php";
include "includes/navigation.php";


// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './classes/Config.php';

// Load Composer's autoloader
require './vendor/autoload.php';


//echo !extension_loaded('openssl') ? "Not Available" : "Available";

    if(!isset($_GET['forgot'])){
        redirect('index');
    }


    if(ifItIsMethod('post')){

        if(isset($_POST['email'])) {
            $email = $_POST['email'];
            $length = 50;
            $token = bin2hex(openssl_random_pseudo_bytes($length));

            if(email_exists($email)){

                if($stmt = mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE user_email= ?")) {

                    mysqli_stmt_bind_param($stmt, "s", $email); // "s" -> string
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);

                    /*
                     *
                     * configure PHPMailer
                     *
                     *
                     */

                    $mail = new PHPMailer(true);


                    /******* THIS IS THE NEW CODE FROM GITHUB ******/


                    try {
                        //Server settings
                        $mail->SMTPDebug = 2;                    // Enable verbose debug output
                        $mail->isSMTP();                                          // Send using SMTP
                        $mail->Host = Config::SMTP_HOST;                    // Set the SMTP server to send through
                        $mail->SMTPAuth = true;                                 // Enable SMTP authentication
                        $mail->Username = Config::SMTP_USER;                    // SMTP username
                        $mail->Password = Config::SMTP_PASSWORD;                // SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                        $mail->Port = Config::SMTP_PORT;                    // TCP port to connect to

                        //Recipients
                        $mail->setFrom('postmaster@mg.lilyah.dev', 'Lilyana Bozheva');
                        $mail->addAddress($email);     // email from the post request
                        #$mail->addAddress('ellen@example.com');               // Name is optional
                        #$mail->addReplyTo('info@example.com', 'Information');
                        #$mail->addCC('cc@example.com');
                        #$mail->addBCC('bcc@example.com');

                        // Attachments
                        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                        // Content
                        $mail->isHTML(true); // Set email format to HTML
                        $mail->CharSet = 'UTF-8'; // Set email charset for any characters
                        $mail->Subject = 'Password reset';
                        //$mail->Body = 'This is the HTML message body <b>in bold!</b>';
                        $mail->Body = '<p>Click the link below to reset your password!</p><br/>
                        <a href="http://localhost/projects/lili/cms/reset.php?email='.$email.'&token='.$token.'">http://localhost/projects/lili/cms/reset.php?email='.$email.'&token='.$token.'</a>
                         ';
                        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                        if ($mail->send()){
                        $emailSent = true;}
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                }
            }
        }
    }

/***** /END NEW CODE ******/





/******** THIS IS THE OLD CODE FROM EDWINS COURSE *******/
//                    $mail->isSMTP();
//                    $mail->Host = Config::SMTP_HOST;
//                    $mail->Username = Config::SMTP_USER;
//                    $mail->Password = Config::SMTP_PASSWORD;
//                    $mail->Port = Config::SMTP_PORT;
//                    $mail->SMTPSecure = 'tls';
//                    $mail->SMTPAuth = true;
//                    $mail->isHTML(true);
//                    $mail->CharSet = 'UTF-8';
//
//                    $mail->setFrom('lilyah.boz@gmail.com', 'Lilyana Bozheva');
//                    $mail->addAddress($email);
//
//                    $mail->Subject = 'This is a test email';
//
//                    $mail->Body = '<p>Please click to reset your password
//
//                    <a href="http://localhost:8888/projects/lili/cms/reset.php?email='.$email.'&token='.$token.' ">http://localhost:888/projects/lili/cms/reset.php?email='.$email.'&token='.$token.'</a>
//
//                    </p>';
//
//                    if($mail->send()){
//                        $emailSent = true;
//                    } else{
//                        echo "NOT SENT";
//                    }
//                }
//            }
//        }
//     }
/******** /END OLD CODE *******/

?>



<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                        <?php if(!isset( $emailSent)): ?>
                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                            <?php else: ?>
                                <h2>Reset password link was send to your email. Please check your email.</h2>
                            <?php endIf; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->