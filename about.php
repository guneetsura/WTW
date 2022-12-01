<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>About WTW</title>
    <link rel="stylesheet" type="text/css" href="./styles/about.css">
</head>

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
                <button type="submit" name="login" class="btn-grad">Submit</button>

            </form>
        </div>
    </section>
</body>

</html>