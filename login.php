<?php // Do not put any HTML above this line
session_start();
$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123

$q='@';
// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION['error'] = "Email and password are required";
        header("Location: login.php");
        return;
    } elseif(strpos($_POST['email'], $q) === false) {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;
    }else{
        $check = hash('md5', $salt.$_POST['pass']);
        if ( $check == $stored_hash ) {
            // Redirect the browser to view.php
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['success']="Login Successful";
            header("Location: index.php");
            return;
        } else {
            $_SESSION['error'] = "Incorrect password";
            header("Location: login.php");
            return;
        }
    }
}

// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Harsh Gupta 42759774 Login Page</title>
</head>
<body>
    <div class="container">
    <h1>Please Log In</h1>
    <?php
    // Note triple not equals and think how badly double
    // not equals would work here...
    if ( isset($_SESSION['error']) ) {
        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
    ?>
    <form method="POST">
        <label for="email">Email</label>
        <input type="text" name="email" id="email"><br>
        <label for="id_1723">Password</label>
        <input type="text" name="pass" id="id_1723"><br>
        <input type="submit" value="Log In">
        <a href="index.php">Cancel</a>
    </form>

    <p>
    For a password hint, view source and find a password hint
    in the HTML comments.
    <!-- Hint: The password is the  php (all lower case) followed by 123. -->
    </p>
    </div>
</body>
</html>