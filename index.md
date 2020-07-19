<?php
require_once "pdo.php";
session_start();
// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    session_destroy();
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
        <h1>Welcome to the Automobiles Database</h1>
        <?php
        if ( isset($_SESSION['error']) ) {
            echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
            unset($_SESSION['error']);
        }
        if ( isset($_SESSION['success']) ) {
            echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
            unset($_SESSION['success']);
        }
        if ( isset($_SESSION['email']) ) {
            $stmt = $pdo->query("SELECT * FROM autos");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo('<table border="1">'."\n");
            if($rows !== false){
                echo "<tr><th>";
                echo("Make");
                echo("</td><th>");
                echo("Model");
                echo("</td><th>");
                echo("Year");
                echo("</td><th>");
                echo("Mileage");
                echo("</td><th>");
                echo('');
                echo("</th></tr>\n");
                foreach($rows as $row) {
                    echo "<tr><td>";
                    echo(htmlentities($row['make']));
                    echo("</td><td>");
                    echo(htmlentities($row['model']));
                    echo("</td><td>");
                    echo(htmlentities($row['year']));
                    echo("</td><td>");
                    echo(htmlentities($row['mileage']));
                    echo("</td><td>");
                    echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
                    echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
                    echo("</td></tr>\n");
                }
                echo("</table>");
            }else{
                echo("<p>No rows Found</p>");
            }
            echo("<p><a href=\"add.php\">Add New Entry</a></p>");
            echo("<form method=\"post\"><input type=\"submit\" name=\"logout\" value=\"logout\") /></form>");
           
        }
        else{
            echo("<p><a href=\"login.php\">Please log in</a></p>");
            echo("<p>Attempt to <a href=\"add.php\">add data</a> without logging in</p>");
            
        }

        ?>
        </table>
        
    </div>
    </body>
</html>
