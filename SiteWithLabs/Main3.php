<?php

/*Вариант 4: написать функцию, формирующую полный список файлов в указанном каталоге
(включая подкаталоги) и считающую общий объём файлов. Имя каталога,
в котором следует выполнять поиск, получать через веб-форму. Отобразить в табличном виде. */

function FindFiles($path, &$commonSize) {
	if ($openedDir = opendir($path)) {
		$result = '';
	    while (($item = readdir($openedDir)) !== false) {
		    if (('.' != $item) and ('..' != $item)) {
			    if (is_file($path . $item)) {
				    $stat = stat($path . $item);
				    if ($stat !== false) { 
					    $commonSize += $stat['size'];
					    $result .= '<tr><td>' . $item . '</td><td>' . $stat['size'] . '</td></tr>';
					}
				}
				else {
				    $result .= FindFiles($path . $item . "/", $commonSize);	
				}
			}
		}
		closedir($openedDir);
	}
	return $result;
}

if (isset($_POST["directory"])) {
    if (is_dir($_POST["directory"])) {
	    $directory = $_POST["directory"];
		
		$lastSymbolIndex = mb_strlen($directory) - 1;
	    if ($directory[$lastSymbolIndex] !== '/') {
		    $directory .= '/'; 
		}
		
	    $commonSize = 0;
	    $table = '<table border="2" width="30%" cellpadding="5"><tr><td>Имя файла</td><td>Размер, байт</td></tr>';
	    $table .= FindFiles($directory, $commonSize) . 
		'<tr><td>' . 'Общий размер' . '</td><td>' . $commonSize . '=' . (int)($commonSize/1024) . 'Кбайт' . '</td></tr>' . '</table>';
	    echo $table;
	}
    else {
	    echo "Такого каталога не существует!"; 
	}
}
else {
    echo "Введите каталог для поиска файлов!";
}
?>