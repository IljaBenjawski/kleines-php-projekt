<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellungen</title>
</head>
<body>
<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'haro';

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die('Verbindungsfehler: ' . mysqli_connect_error());
}

if (isset($_POST['KdNr']) && is_numeric($_POST['KdNr'])) {
    $KdNr = $_POST['KdNr'];
} else {
    die("Die Kundennummer darf nur Zahlen enthalten oder wurde nicht gesetzt.");
}

if (isset($_POST['pwd']) && is_numeric($_POST['pwd'])) {
    $pwd = $_POST['pwd'];
} else {
    die("Das Passwort darf nur Zahlen enthalten oder wurde nicht gesetzt.");
}

$check_query = "SELECT * FROM kunden WHERE KdNr = '$KdNr' AND Passwort = '$pwd'";
$check_result = mysqli_query($conn, $check_query);

if (!$check_result) {
    die('Abfragefehler: ' . mysqli_error($conn));
}

$rowCount = mysqli_num_rows($check_result);

if ($rowCount > 0) {
    $aufnr_query = "SELECT AufNr FROM auftragskoepfe WHERE KdNr = '$KdNr'";
    $aufnr_result = mysqli_query($conn, $aufnr_query);

    if ($aufnr_result) {
        $row = mysqli_fetch_assoc($aufnr_result);

        $artikelnr = "SELECT ArtikelNr FROM auftragspositionen WHERE AufNr = '" . $row['AufNr'] . "'";
        $artikelnr_result = mysqli_query($conn, $artikelnr);

        if ($artikelnr_result) {
            echo "<table border='1'> 
                    <tr>
                        <th>ArtikelNr</th>
                        <th>Bezeichnung</th>
                        <th>Preis</th>
                    </tr>";

            while ($row2 = mysqli_fetch_assoc($artikelnr_result)) {
                if ($row2['ArtikelNr'] !== null) {
                    $artikel_query = "SELECT * FROM artikel WHERE ArtikelNr = '" . $row2['ArtikelNr'] . "'";
                    $artikel_result = mysqli_query($conn, $artikel_query);

                    if ($artikel_result) {
                        while ($artikel_row = mysqli_fetch_assoc($artikel_result)) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($artikel_row['ArtikelNr']) . "</td>
                                    <td>" . htmlspecialchars($artikel_row['Bezeichnung']) . "</td>
                                    <td>" . htmlspecialchars($artikel_row['VkPreis']) . "</td>
                                  </tr>";
                        }
                    } else {
                        die('Abfragefehler (Artikel): ' . mysqli_error($conn));
                    }
                } else {
                    echo "<tr><td colspan='3'>ArtikelNr ist null</td></tr>";
                }
            }

            echo "</table>";
        } else {
            die('Abfragefehler (Artikelnr): ' . mysqli_error($conn));
        }
    } else {
        die('Abfragefehler (Auftragsnr): ' . mysqli_error($conn));
    }
} else {
    echo "Kein Kunde gefunden.";
}
?>
</body>
</html>
