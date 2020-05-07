<?php

/*Вариант 3: Сделайте авторизацию: login, password (исп. $_SESSION
для хранения при перезагрузке страницы, bcrypt/argon2 - для хеширования password).
Проверьте наличие минимального количества символов в логине (например, 2),
пароле (например, 5), корректность символов. При успешной регистрации
должно появляться приветствие "Здравствуйте, login".
Реализуйте функцию выхода с возвратом к форме регистрации.*/

const MIN_LOGIN_LENGTH = 2;
const MIN_PASSWORD_LENGTH = 7;

function get_form($uname = '', $message = '') {

    $form = '';
    if ($message !== '') {
        $form .= '<b>' . $message . '</b><br />';
    }
    $form .= '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
    $form .= 'Username: <input type="text" name="usrName" value="' . $uname . '" /><br />';
    $form .= 'Password: <input type="password" name="usrPassword" /><br />';

    $form .= '<input type="submit" name="Login" value="Войти" />';
	$form .= '<input type="submit" name="Registrate" value="Зарегистрироваться" /><br />';
    return $form;
}

function registrateUser($uLogin, $uPassword) {
    
    $mysqli = new mysqli('localhost', 'root', '2438041', 'clinic2');
    if ($mysqli->connect_errno) {
        printf("Не удалось подключиться: %s<br />", $mysqli->connect_error);
        exit();
    }
	
    $mysqli->set_charset('UTF8');
    
    $uPassword = password_hash($uPassword, PASSWORD_BCRYPT);
    $uLogin = $mysqli->real_escape_string($uLogin);
    
    $result = $mysqli->query("INSERT INTO `site` (`login`, `password`) VALUES ('$uLogin', '$uPassword')");
	
    $mysqli->close();
    
    if ($result === TRUE) {
        $_SESSION['isUserLoggedIn'] = TRUE;
        $_SESSION['userName'] = $uLogin;

        return TRUE;
    } 
	else {
        $_SESSION['isUserLoggedIn'] = FALSE;
		
        return FALSE;
    }
}

function login($uname, $upass) : bool {
    
    $mysqli = new mysqli('localhost', 'root', '2438041', 'clinic2');
    if ($mysqli->connect_errno) {
        printf("Не удалось подключиться: %s<br />", $mysqli->connect_error);
        exit();
    }
	
    $mysqli->set_charset('UTF8');
    $uname = $mysqli->real_escape_string($uname);
    
    $resultRow = $mysqli->query("SELECT `password` FROM `site` WHERE `login`='" 
    . $uname . "'");
	$rowsNumber = $resultRow->num_rows;
    
    $mysqli->close();
    
    if ($rowsNumber === 1) {
        $row = $resultRow->fetch_assoc();
        if (password_verify($upass, $row['password'])) {
            $_SESSION['isUserLoggedIn'] = TRUE;
            $_SESSION['userName'] = $uname;
            $resultRow->free();
		
            return TRUE;
        } 
    }
	
    $_SESSION['isUserLoggedIn'] = FALSE;
    $resultRow->free();
		
    return FALSE;
}

if ((isset($_SESSION['isUserLoggedIn'])) && ($_SESSION['isUserLoggedIn'] === TRUE)) {
    echo 'Здравствуйте, ' . $_SESSION['userName'] . '<br />';
    echo '<a href="' . $_SERVER['PHP_SELF'] . '?logout=logout">Выйти</a>';
    echo "<br /><br />";

    if ((isset($_GET['logout'])) && ($_GET['logout'] === 'logout')) {

        $_SESSION['isUserLoggedIn'] = FALSE;
        session_destroy();
        unset($_SESSION);

        echo 'Вы вышли!';
		echo get_form();
    }
} 
else {
    if (sizeof($_POST) !== 0) {
        if ((isset($_POST['usrName'])) && (isset($_POST['usrPassword'])) ) {
            $entryFailedMessage = '';
            $isInputCorrect = TRUE;
	        if (mb_strlen($_POST['usrName']) <= MIN_LOGIN_LENGTH) {
                $isInputCorrect = FALSE;
                $entryFailedMessage .= "Логин должен содержать не менее " . MIN_LOGIN_LENGTH . " символов!<br />";
            }
            
			if (mb_strlen($_POST['usrPassword']) <= MIN_PASSWORD_LENGTH) {
                $isInputCorrect = FALSE;
                $entryFailedMessage .= "Пароль должен содержать не менее " . MIN_PASSWORD_LENGTH . " символов!<br />";
            }
            
            if ($isInputCorrect) {
                if (isset($_POST['Login'])) {
                    $result = login($_POST['usrName'], $_POST['usrPassword']);
                    if ($result === TRUE) {
                        echo 'Здравствуйте, ' . $_SESSION['userName'] . '<br />';
                        echo '<a href="' . $_SERVER['PHP_SELF'] . '?logout=logout">Выйти</a>';
                        echo "<br /><br />";
                    } else {
                        echo get_form($_POST['usrName'], 'Неверно введён логин и/или пароль!<br />');
                    }
			    }
                else {
                    if (isset($_POST['Registrate'])) {
                        $result = registrateUser($_POST['usrName'], $_POST['usrPassword']);
                        if ($result === TRUE) {
                            echo 'Здравствуйте, ' . $_SESSION['userName'] . '<br />';
                            echo '<a href="' . $_SERVER['PHP_SELF'] . '?logout=logout">Выйти</a>';
                            echo "<br /><br />";
                        } else {
                            echo "Произошла ошибка добавления в БД<br />";
                            echo get_form();
                        }						
			        }
                }
            }
            else				
                echo get_form($_POST['usrName'], $entryFailedMessage);			
        }
        else
            echo "Введите логин и/или пароль";
    } 
	else {
        echo get_form();
    }
}
