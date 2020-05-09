<?php

function GetOutputTable() {
    $table = '';
	
    $table .= '<table border="2" width="30%" cellpadding="5">';
    $table .= '<tr><th>IP посетителя</th><th>Количество визитов</th></tr>';
	
    $mysqli = new mysqli('localhost', 'root', '2438041', 'clinic2');
    if ($mysqli->connect_errno) {
        printf("Не удалось подключиться: %s<br />", $mysqli->connect_error);
        exit();
    }
	
    $mysqli->set_charset('UTF8');
	
    $resultAllData = $mysqli->query("SELECT * FROM `site_users` ORDER BY `visits_number` DESC");
    while (Null !== ($row = $resultAllData->fetch_assoc())) {
        $table .= '<tr>';
        $table .= '<td>' . $row['IP_address'] . '</td><td>' . $row['visits_number'] . '</td>'; 
        $table .= '</tr>';		
    }
	
    $table .= '</table>';
    $resultAllData->free();
    $mysqli->close();
    return $table;
}

echo GetOutputTable();