<?php
session_start();
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link rel="stylesheet" href="./Register/light.css">
</head>

<body>
    <?php include 'header.php' ?>
    <?php
    require 'config.php';

    $servername = "localhost";
    $username = "root";
    $password = "";
    $s = $_SESSION['email'];
    $conn = new PDO("mysql:host=$servername;dbname=weather-sign-up", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT name,email,password,age,gender,medical,wheelchair FROM registration WHERE email='$s' ";
    $result = $conn->query($sql);
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $n = $row["name"];
        $e = $row["email"];
        $a = $row["age"];
        $g = $row["gender"];
        $m = $row["medical"];
        $w = $row["wheelchair"];
    }


    if (isset($_POST['Update'])) {
        set_error_handler(function (int $errno, string $errstr) {
            if ((strpos($errstr, 'Undefined array key') === false) && (strpos($errstr, 'Undefined variable') === false)) {
                return false;
            } else {
                return true;
            }
        }, E_WARNING);
        $condition = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["nname"];
            $medical = $_POST["medical"];
            $wheelchair = $_POST["yes_no"];
            foreach ($medical as $med) {
                $condition .= $med . ",";
            }
            $s = $_SESSION['email'];
            $conn1 = new PDO("mysql:host=$servername;dbname=weather-sign-up", $username, $password);
            $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql3 = "UPDATE registration SET name='$name', medical='$condition', wheelchair = '$wheelchair' WHERE email ='$s';";
            $conn1->exec($sql3);

            $conn = new PDO("mysql:host=$servername;dbname=weather-sign-up", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT name,email,password,age,gender,medical,wheelchair FROM registration WHERE email='$s' ";
            $result = $conn->query($sql);
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $n = $row["name"];
                $e = $row["email"];
                $a = $row["age"];
                $g = $row["gender"];
                $m = $row["medical"];
                $w = $row["wheelchair"];
            }
        }
    }
    //         $medical =$_POST["mmedical"];
    //         $wheelchair =$_POST["yyes_no"];
    //         $s=$_SESSION['email'];

    //         foreach ($medical as $med) {
    //             $condition .= $med . ",";
    //         }



    //     $conn1 = new PDO("mysql:host=$servername;dbname=weather-sign-up", $username, $password);
    //     $conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //     $sql3 = "UPDATE registration SET name='$name' WHERE ='$s'";
    //     $conn1->exec($sql3);

    //     $conn2 = new PDO("mysql:host=$servername;dbname=weather-sign-up", $username, $password);
    //     $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //     $sq2 = "SELECT name,email,password,age,gender,medical,wheelchair FROM registration WHERE email='$s' ";
    //     $result = $conn2->query($sq2);
    //     while($row = $result->fetch(PDO::FETCH_ASSOC)) 
    //     {
    //     $n=$row["name"];
    //     $e=$row["email"];
    //     $a=$row["age"];
    //     $g=$row["gender"];
    //     $m=$row["medical"];
    //     $w=$row["wheelchair"];

    //     }
    // }

    //     }

    ?>



    <section id="sign-up-form">
        <form action="" method="POST">

            <h1>My Account</h1>

            <fieldset>
                <legend><span class="number">1</span> Basic info</legend>
                <label for="name">Name: <?php echo $n; ?></label>
                <label for="email">Email: <?php echo $e; ?></label>
                <label>Gender: <?php echo $g; ?></label>
                <label>Age: <?php echo $a; ?></label>
            </fieldset>

            <fieldset>

                <legend><span class="number">2</span> Your medical profile (optional)</legend>
                <label>Medical Conditions specified: <?php if (!empty($m)) { echo $m; } else { echo "Not specified"; } ?></label>
                <label>Associated with a wheelchair? <?php if (!empty($w)) { echo $w; } else { echo "Not specified"; } ?></label>

            </fieldset>

            <fieldset>

                <legend><span class="number">#</span>Update Details</legend>
                <label for="name">Name:</span></label>
                <input type="text" id="name" name="nname">

                <div class="flex-radio">
                    <div>
                        <label>Check if you have any of the following conditions</label>
                        <input type="checkbox" id="asthama" value="asthama" name="medical[]"><label class="light" for="asthama">Asthama</label><br>
                        <input type="checkbox" id="photophobia" value="photophobia" name="medical[]"><label class="light" for="photophobia">Photophobia</label><br>
                        <input type="checkbox" id="skin_disease" value="skin_disease" name="medical[]"><label class="light" for="skin_disease">Skin disease</label><br>
                        <input type="checkbox" id="cancer" value="cancer" name="medical[]"><label class="light" for="cancer">Cancer</label><br>
                    </div>
                    <div>
                        <label>Are you associated with a wheelchair?</label>
                        <input type="radio" id="yes" value="yes" name="yes_no"><label class="light" for="yes">Yes</label><br>
                        <input type="radio" id="no" value="no" name="yes_no"><label class="light" for="no">No</label>
                    </div>
                </div>

            </fieldset>
            <button type="submit" name="Update" class="submit-btn" id="update">Update</button>
            <a href="logout.php"><button type="submit" name="Logout" class="submit-btn" id="logout">Logout</button></a>
        </form>
    </section>

</body>

</html>