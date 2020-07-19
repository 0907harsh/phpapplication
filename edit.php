<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['Update']) &&  isset($_GET['autos_id']) ) {

    // Data validation
    if ( strlen($_POST['make']) < 1 || strlen($_POST['mileage']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['model']) < 1) {
        $_SESSION['error'] = 'Fields Are requires';
        header("Location: edit.php?autos_id=".$_GET['autos_id']);
        return;
    }

    if ( is_numeric($_POST['year']) === false ) {
        $_SESSION['error'] = 'Year must be numeric';
        header("Location: edit.php?autos_id=".$_GET['autos_id']);
        return;
    }

    if ( is_numeric($_POST['mileage']) === false ) {
        $_SESSION['error'] = 'Mileage must be numeric';
        header("Location: edit.php?autos_id=".$_GET['autos_id']);
        return;
    }

    $sql = "UPDATE autos SET make = :make,
            year = :year, mileage = :mileage, 
            model=:model, autos_id=:autos_id
            WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage'],
        ':model' => $_POST['model'],
        ':autos_id' => $_GET['autos_id']));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that autos_id is present
if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing autos_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
}


$n = htmlentities($row['make']);
$e = htmlentities($row['year']);
$p = htmlentities($row['mileage']);
$mo = htmlentities($row['model']);
$autos_id = $row['autos_id'];
?>
<html>
    <head>
        <title>Harsh Gupta CRUD Application</title>
        <?php require_once "bootstrap.php"; ?>
    </head>
    <body>
    <div class="container">
        
        <h1>Edit User</h1>
        <?php
            // Flash pattern
         if ( isset($_SESSION['error']) ) {
            echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
            unset($_SESSION['error']);
        }
        ?>
<form method="post">
        <p>make:
        <input type="text" name="make" value="<?= $n ?>"></p>
        <p>Model:
        <input type="text" name="model" value="<?= $mo ?>"></p>
        <p>year:
        <input type="number" name="year" value="<?= $e ?>"></p>
        <p>mileage:
        <input type="number" name="mileage" value="<?= $p ?>"></p>

        <input type="hidden" name="autos_id" value="<?= $autos_id ?>">
        <p><input type="submit" name="Update" value="Save"/>
        <a href="index.php">Cancel</a></p>
        </form>

        </div>
    </body>
</html>

