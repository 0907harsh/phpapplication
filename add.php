<?php
require_once "pdo.php";
session_start();
if(!isset($_SESSION['email']))
{
    die("Access Denied");
}
if ( isset($_POST['Add'])) {

    // Data validation
    if ( strlen($_POST['make']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1|| strlen($_POST['model']) < 1) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: add.php");
        return;
    }

    if ( is_numeric($_POST['year']) === false ) {
        $_SESSION['error'] = 'Year must be an integer';
        header("Location: add.php");
        return;
    }

    if ( is_numeric($_POST['mileage']) === false ) {
        $_SESSION['error'] = 'Mileage must be an integer';
        header("Location: add.php");
        return;
    }

    $sql = "INSERT INTO autos (make, year, mileage, model)
              VALUES (:make, :year, :mileage,:model)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage'],
        ':model' => $_POST['model']));
        $_SESSION['success'] = 'Record Added';
        header( 'Location: index.php' ) ;
        return;
}

?>
<html>
    <head>
        <title>Harsh Gupta CRUD Application</title>
        <?php require_once "bootstrap.php"; ?>
    </head>
    <body>

        <div class="container">
            <h1>Tracking Automobiles for <?= $_SESSION['email'] ?></h1>
            <?php
                // Flash pattern
                if ( isset($_SESSION['error']) ) {
                    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
                    unset($_SESSION['error']);
                }
                if ( isset($_SESSION['success']) ) {
                    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
                    unset($_SESSION['success']);
                }

            ?>
            <form method="post">
                <label for="make">  Make   </label>
                <input type="text" name="make" id="make" size="60"><br><br>
                <label for="model">  Model   </label>
                <input type="text" name="model" id="model"><br><br>
                <label for="year">  Year   </label>
                <input type="number" name="year" id="year"><br><br>
                <label for="mileage">  Mileage   </label>
                <input type="number" name="mileage" id="mileage"><br><br>
                
                <input type="submit" name="Add" value="Add">
                <input type="submit" name="logout" value="logout" >
            </form>
            
    </body>
</html>

