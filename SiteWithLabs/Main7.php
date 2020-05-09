<?php

/*Вариант 3: Написать скрипт, отправляющий полученное через
форму письмо списку адресатов, хранящемуся в БД.*/

function get_form($message = '') {

    $form = '';
    if ($message !== '') {
        $form .= '<b>' . $message . '</b><br /><br />';
    }
    $form .= '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
    $form .= 'Тема письма: <input type="text" name="topic" /><br />';
    $form .= 'Текст: <input type="text" name="text" size="100" /><br />';

	$form .= '<input type="submit" name="send" value="Отправить" /><br />';
    return $form;
}

function SendMail($topic, $text) : bool {
	
    $mysqli = new mysqli('localhost', 'root', '2438041', 'clinic2');
	if ($mysqli->connect_errno) {
        printf("Не удалось подключиться: %s<br />", $mysqli->connect_error);
        exit();
    }
	
    $mysqli->set_charset('UTF8');
	
    $resultEmails = $mysqli->query("SELECT `e_mail` FROM `patient`");
    if ($resultEmails === FALSE) {
        printf("Сообщение ошибки запроса : %s<br />", $mysqli->error);		
    }
    else {
        $rowsNumber = $resultEmails->num_rows;
        
        if ($rowsNumber !== 0) {
            $receivers = '';
            for ($i = 0; $i != $rowsNumber - 1; $i++) {
                $row = $resultEmails->fetch_assoc();
                $receivers .= $row['e_mail'] . ', ';				
            }
            $row = $resultEmails->fetch_assoc();
            $receivers .= $row['e_mail'];
			
			print_r($receivers);
			$text = wordwrap($text, 70, "\r\n");
            $headers = 'From: uladhek@gmail.com' . "\r\n" .
            'Reply-To: uladhek@gmail.com' . "\r\n" . 
			'X-Mailer: PHP/' . phpversion();
            $res = mail($receivers, $topic, $text, $headers);
			
            $resultEmails->free();
            $mysqli->close();
            return $res ? TRUE : FALSE;
        }
    }
	
    $mysqli->close();
    return FALSE;
}

if (sizeof($_POST) !== 0) {
    if ( (isset($_POST['topic'])) && (isset($_POST['text'])) ) {
        $result = SendMail(htmlentities($_POST['topic']), htmlentities($_POST['text']));
        if ($result)
            echo get_form('Письмо успешно отправлено!');
        else
            echo get_form('Ошибка отправки сообщения!');			
    }
    else
        echo get_form('Введите тему и/или текст!');		
}
else
    echo get_form();
    