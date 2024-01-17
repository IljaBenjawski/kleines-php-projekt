<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "haro"; 

if(isset($_POST['Werkzeug'])){
    $Werkzeug = $_POST['Werkzeug'];
    echo "Wilkommen";
    $conn = mysqli_connect($servername, $username, $password, $database);
        if (!$conn) {
            die('Verbindungsfehler: ' . mysqli_connect_error());
        }
    switch ($Werkzeug) {
            case 'zange':
                $WgNr = 1;
                break;
            case 'schraubendreher':
                $WgNr = 2;
                break;
            case 'saegen':
                $WgNr = 3;
                break;
            case 'sonstige':
                $WgNr = 4;
                break;
            
            default:
               print('Nichts auswegählt');
                break;
        }
        
        $check = "SELECT * FROM artikel WHERE WgNr = '$WgNr'"; 
        $result = mysqli_query($conn, $check); //mysqli_query — Führt eine Abfrage in einer Datenbank durch

    if (!$result) { 
        die('Abfragefehler: ' . mysqli_error($conn));
    }

       
          
            echo "<table border='1'> 
            <tr>
                <th>ArtikelNr</th>
                <th>Bezeichnung</th>
                <th>WgNr</th>
                <th>EkPreis</th>
                <th>VkPreis</th>
                <th>Bestand</th>
                <th>MeldeBest</th>
                
            </tr>";
    
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . $row['ArtikelNr'] . "</td> 
                <td>" . $row['Bezeichnung'] . "</td>
                <td>" . $row['WgNr'] . "</td>
                <td>" . $row['EkPreis'] . "</td>
                <td>" . $row['VkPreis'] . "</td>
                <td>" . $row['Bestand'] . "</td>
                <td>" . $row['MeldeBest'] . "</td>
                
              </tr>";}
    				
    echo "</table>";
}
else{
    echo "Wählen Sie etwas aus.";
}
?>