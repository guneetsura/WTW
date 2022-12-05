<?php
    set_error_handler(function (int $errno, string $errstr) {
        if ((strpos($errstr, 'Undefined array key') === false) && (strpos($errstr, 'Undefined variable') === false)) {
            return false;
        } else {
            return true;
        }
    }, E_WARNING);
    session_start();
    if (!empty($_POST['email'])) {
        $s = $_POST['email'];
    } else {
        $s = $_SESSION['email'];
    }
?>
<!DOCTYPE html>

<html>

<head>
    <title>About WTW</title>
    <link rel="stylesheet" type="text/css" href="./styles/about.css">
</head>
<?php
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>
<?php
$mail = new PHPMailer(true);
//ltssqbxmeuteoghe ************************************

try {
    if (isset($_POST['submit'])) {

        $name = $_POST['name'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

            try {
                require 'config.php';
                $stmt = $connect->prepare('INSERT INTO contact(name,email,subject,message) VALUES (:name, :email, :subject, :message)');
                $stmt->execute(array(
                    ':name' => $name,
                    ':email' => $s,
                    ':subject' => $subject,
                    ':message' => $message,
                ));

            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'heywhatstheweather@gmail.com';                     //SMTP username
        $mail->Password   = 'ltssqbxmeuteoghe';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('heywhatstheweather@gmail.com');
        $mail->addAddress($s);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Thanks for Contacting us @WTW';
        $mail->Body    = 'Hello! This is to acknowledge you that your input has been recieved! Our team will reach out to you as soon as possible.<br><br>Peace!<br>WTW';
        $mail->AltBody = 'This is to acknowledge you that your input has been recieved! Our team will reach out to you as soon as possible. Peace!';

        header("Location:about.php");
        $mail->send();
        exit();
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}



?>

<body>
    <?php include 'header.php' ?>

    <section id="contact">
        <div class="form-wrap">
            <h2 class="form-title">Contact Us</h2>
            <form method="POST" action="">
                <input type="text" name="name" id="name" placeholder="Name">
                <input type="email" id="email" name="email" placeholder="Email">
                <input type="text" id="subject" name="subject" placeholder="Subject">
                <textarea type="text" maxlength="750" id="message" name="message" placeholder="Message (Limit: 750 characters)"></textarea>
                <span class="err-msg"></span>
                <button type="submit" name="submit" class="btn-grad">Submit</button>

            </form>
        </div>
    </section>
</body>

</html>
