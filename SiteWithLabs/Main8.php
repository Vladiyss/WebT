<?php

/*Вариант 5: написать скрипт, собирающий статистику по ip-адресам, 
с которых посетители заходили на сайт. Выводить результаты в виде
HTML-таблицы со списком ip-адресов, отсортированным по убыванию
количества посещений с каждого адреса.*/

$visitorIP = $_SERVER['REMOTE_ADDR'];

$mysqli = new mysqli('localhost', 'root', '2438041', 'clinic2');
    if ($mysqli->connect_errno) {
        printf("Не удалось подключиться: %s<br />", $mysqli->connect_error);
        exit();
    }
	
$mysqli->set_charset('UTF8');
    
$resultVisitor = $mysqli->query("SELECT `IP_address` FROM `site_users` WHERE `IP_address`='$visitorIP'");
$rowsNumber = $resultVisitor->num_rows;
        
if ($rowsNumber === 1) {
    $result = $mysqli->query("UPDATE `site_users` SET `visits_number`=`visits_number`+1 WHERE `IP_address`='$visitorIP'");
}
else {
    $result = $mysqli->query("INSERT INTO `site_users` (`IP_address`, `visits_number`) VALUES ('$visitorIP', '1')");		
}
 
$resultVisitor->free();
$mysqli->close();
 