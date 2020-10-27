<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Say Something | Home</title>

    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="formDiv">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <p>
                <input class="txtIn" name="name" type="text" placeholder="Inserisci il nome">
            </p>

            <p>
                <input class="txtIn" name="textDesc" type="text" placeholder="Scrivi ciò che vuoi">
            </p>

            <p style="margin-top: 30px;">
                <input class="btn red" type="submit" value="Invia">
            </p>
        </form>
    </div>

    <div class="contScheda">
        <?php @createSchede() ?>
    </div>
</body>

<script src="js/index.js"></script>
</html>

<?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        @uploadData();
    }

    function uploadData() {
        $servername = "localhost";
        $username = "bottegasasso";
        $password = "";
        $dbname = "my_test";

        $name = test_input($_POST["name"]);
        $text = test_input($_POST["textDesc"]);

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if (!$conn) {
            die("<p>Connessione col database non riuscita!</p>");
        }

        $id = 0;
        $sql = "SELECT id FROM commenti";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                if ($row['id'] > $id) {
                    $id = $row['id'];
                }
            }
            
        }
        
        $id ++;

        $sql = "INSERT into commenti (id, nome, testo) VALUES
        ('$id', '$name', '$text')";

        mysqli_query($conn, $sql);

        mysqli_close($conn);
        header("Refresh:0");
    }

    function createSchede() {
        $servername = "localhost";
        $username = "bottegasasso";
        $password = "";
        $dbname = "my_test";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if (!$conn) {
            die("<p>Connessione col database non riuscita!</p>");
        }

        $sql = "SELECT id, nome, testo FROM commenti";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                echo '<div class="scheda"><h1>' . $row['nome'] . '</h1><p>' . $row['testo'] . '</p></div>';
            }
            
        } else {
            echo "<p>Non ci sono esercizi nel database!</p>";
        }

        mysqli_close($conn);
    }

    // Testa input
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>