<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <?php $css = $_COOKIE["theme"];
	if (!$css) { $css = "light"; } ?>
    <link rel="stylesheet" href="./Register/<?php echo $css; ?>.css">
</head>

<body>

    <form>

        <h1 style="text-align: center">Yay!</h1>
       <h2 style="text-align: center">You have been registered!</h2>
       <?php 
       $medical = ($_POST["medical"]);
       foreach ($medical as $med) {
        echo $med;
       } 
       ?>

    </form>

</body>

</html>