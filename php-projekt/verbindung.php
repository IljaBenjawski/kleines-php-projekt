<html>
<head>
</head>
<body>
    
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "haro"; 
// Ich habe sehr viel auskommentiert, da mein Mikro nicht geht

// Überprüfen, ob die Formularvariable gesetzt ist, man kann es machen, muss aber nicht sein 
if(is_numeric($_POST["KdNr"])) {  
    $KdNr = $_POST["KdNr"];
    echo "Ihre Kundennummer ist: " . $KdNr; // Kundenummer zuweisen

    /* Verbindung herstellen */
    $conn = mysqli_connect($servername, $username, $password, $database);// Info für die Verbindung

    if (!$conn) {// wenn keine Verbindung möglich ist
        die('Verbindungsfehler: ' . mysqli_connect_error());
    }

    /* Kunden in der Datenbank überprüfen */
    $check = "SELECT * FROM kunden WHERE KdNr = '$KdNr'"; // check (Abfrage)sucht die KdNr in kunden und soll alles ausgeben
    $result = mysqli_query($conn, $check); // result schickt mit conn(connection) die check Abfrage

    if (!$result) { 
        die('Abfragefehler: ' . mysqli_error($conn));
    }

    $rowCount = mysqli_num_rows($result);// Zählt die Reihen um zusagen ob es den Kunden gibt

    if ($rowCount > 0) { // wenn es mehr als 0 Reihen gibt, dann gibt es den Kuden
        echo "<br />Kunde gefunden!";// ich erstelle eine html Tabelle mit den Informationen aus der SQL Tabelle
		echo "<table border='1'> 
		<tr>
			<th>Kundennummer</th>
			<th>Name</th>
			<th>Strasse</th>
			<th>PLZ</th>
			<th>Ort</th>
			<th>Passwort</th>
			
		</tr>";


while ($row = mysqli_fetch_assoc($result)) { //fetch ist ein assoziativer array, unten kommen die Daten aus der Tabelle
	echo "<tr>
			<td>" . $row['KdNr'] . "</td> 
			<td>" . $row['Name'] . "</td>
			<td>" . $row['Strasse'] . "</td>
			<td>" . $row['PLZ'] . "</td>
			<td>" . $row['Ort'] . "</td>
			<td>" . $row['Passwort'] . "</td>
			
		  </tr>";
}					//Associative arrays sind arrays die named keys benutzen, die man zu denen zugewiesen hat
					// Man spricht Daten im Array über Namen an, wie KdNr, der Name der in der SQL Tabelle ist
echo "</table>";
    } else {
        echo "<br />Kunde nicht gefunden. Bitte überprüfen Sie Ihre Kundennummer.";
    }

    /*Verbindung schließen  */
    $conn->close();
} else {
    echo "Bitte geben Sie Ihre Kundennummer ein. Das muss eine Zahl sein";
}
?>
</body>
</html>