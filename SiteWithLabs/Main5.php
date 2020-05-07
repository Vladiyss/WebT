<?php

/*Вариант 2: написать скрипт, отображающий структуру и данные всех таблиц указанной БД.
(таблиц не менее 4-х, отобразить также первичные и вторичные ключи, и типы полей).*/

function WorkWithDatabase($databaseName) {
	
    echo "<table border=\"2\" width=\"30%\" cellpadding=\"5\">";
	
    $host = 'localhost';
    $user = 'root';
	$password = '2438041';
	
	$mysqli = new mysqli($host, $user, $password, $databaseName);
	if ($mysqli->connect_errno) {
        printf("Не удалось подключиться: %s<br />", $mysqli->connect_error);
        exit();
    }
	
    $mysqli->set_charset('UTF8');
	
    $resultAllTables = $mysqli->query("SHOW TABLES FROM $databaseName");
    if ($resultAllTables === false) {
	    printf("Сообщение ошибки запроса : %s<br />", $mysqli->error); 
	}
	else {
	    $tablesNumber = $resultAllTables->num_rows;
		
		for ($i = 0; $i != $tablesNumber; $i++) {
		    $row = $resultAllTables->fetch_row();
		    $table = $row[0];
		    
		    echo "<tr><th>Название таблицы : $table</th></tr>";
		    
		    $resultAllColumns = $mysqli->query("SHOW COLUMNS FROM $table");
            if ($resultAllColumns === false) {
	            printf("Сообщение ошибки запроса : %s<br />", $mysqli->error); 
	        }
	        else {
                echo "<tr>";
				
                while (NULL !== ($row = $resultAllColumns->fetch_assoc())) {
                    $columnType = $row["Type"];
                    if ($row["Key"] === '')
                        $key = 'Else';
                    else					
                        $key = $row["Key"];
                    $columnName = $row["Field"];
                    $isNull = $row["Null"];
                    echo "<td>Поле : $columnName<br />Тип : $columnType<br />Ключ : $key<br />IsNull : $isNull</td>";
                }

				echo "</tr>";
			}
			
			$columnsNubmer = $resultAllColumns->num_rows;
			
            $resultAllColumns->free();
			
		    $allData = $mysqli->query("SELECT * FROM $table");
		    if ($allData === false) {
	            printf("Сообщение ошибки запроса : %s", $mysqli->error); 
	        }
	        else {
			    $dataRowsNumber = $allData->num_rows;
				
			    for ($m = 0; $m != $dataRowsNumber; $m++) {
				    echo "<tr>";
		            $dataRow = $allData->fetch_row();
		            for ($n = 0; $n != $columnsNubmer; $n++) {
					    echo "<td>$dataRow[$n]</td>";
					}
					echo "</tr>";
				}
			}
			$allData->free();
		}
	}
	$resultAllTables->free();
	echo "</table>";
	
	$mysqli->close();
	
}

if (isset($_POST['databaseName']))
    WorkWithDatabase(htmlentities($_POST['databaseName']));
else
	echo "Введите название БД<br />";

	
	