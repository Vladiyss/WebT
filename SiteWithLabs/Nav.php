<link rel="stylesheet" href="common.css" type="text/css" />
			<a class=<?php
			echo $_SERVER['SCRIPT_NAME'] === '/example2/new11.php' ? 'active__tab' : 'notactive__tab';?> href="new11.php">Главная</a>
			<a class=<?php
			echo (($_SERVER['SCRIPT_NAME'] === '/example2/Recordss.php') || ($_SERVER['SCRIPT_NAME'] === '/example2/Records_Hott.php'))
			? 'active__tab' : 'notactive__tab';?> href="Recordss.php">Рекорды</a>
			<a class=<?php
			echo $_SERVER['SCRIPT_NAME'] === '/example2/Antirecordss.php' ? 'active__tab' : 'notactive__tab';?> href="Antirecordss.php">
			Антирекорды<sup class="sup">new</sup></a>
			<a class=<?php
			echo $_SERVER['SCRIPT_NAME'] === '/example2/SiteDescriptionn.php' ? 'active__tab' : 'notactive__tab';?> href="SiteDescriptionn.php">
			Описание сайта</a>
			<a class=<?php
			echo $_SERVER['SCRIPT_NAME'] === '/example2/Form.php' ? 'active__tab' : 'notactive__tab';?> href="Form.php">Форма</a>