<?php 

/*Вариант 13: Дан длинный текст, в нём встречаются слова длиннее 7 символов!
Если слово длиннее 7 символов, то необходимо: оставить первые 6 символа и добавить
звёздочку. Осталь-ные символы вырезаются. Шаблон: "я стану крутым программистом после БГУИРа".
Результат: " я стану крутым програм* после БГУИРа ". Текст вводить через форму. */

function RenameLongWords($word) {
    $longWord = $word[0];
    if (mb_strlen($longWord) > 7) {
	    $renamedWord = mb_substr($longWord, 0, 7) . "*";
	    return $renamedWord;
	}
	else
	    return $longWord;	
}

if (isset($_POST["text"])) {
    echo 'Исходный текст - ' . $_POST["text"] . "<br>";    
    echo 'Полученный текст - ' . preg_replace_callback("/[a-zA-Zа-яА-ЯёЁ]+([-][a-zA-Zа-яА-ЯёЁ]+)?/u", 'RenameLongWords', $_POST["text"]);
}
else
    echo "Введите текст в поле ввода!";