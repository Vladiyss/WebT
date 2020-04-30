<?php

/* Вариант 4: Создайте 2 массива с целыми числами через 2 поля формы,
объедините два массива в один (не используя специальные функции PHP
типа array_merge(arr1,arr2)!), Выведите все чётные числа из получившегося массива. */

if ( (isset($_POST['FirstArray'])) && (isset($_POST['SecondArray'])) ) {

	$firstString = $_POST['FirstArray'];
	$secondString = $_POST['SecondArray'];
	
	$firstArray = explode(' ', $firstString);
	$secondArray = explode(' ', $secondString);
	
	foreach ($firstArray as $value) {
        $newArray[] = $value;
	}
	foreach ($secondArray as $value) {
        $newArray[] = $value;
	}
	
	print_r($firstArray);
	echo "<br>";
	print_r($secondArray);
	echo "<br>";
	print_r($newArray);
	echo "<br>";
	
	echo "Even numbers - ";
	foreach($newArray as $value) {
	    if (($value % 2) === 0)
                echo $value . ' ';			
	}
}
else
	echo "Заполните поля целыми числами";

