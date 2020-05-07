<!DOCTYPE html>
<html lang="ru">
<head>
	<meta  charset="utf-8">
	<title>РЕКОРДЫ</title>
	<link rel="stylesheet" href="./form.css" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Philosopher:400,700&display=swap&subset=cyrillic-ext" rel="stylesheet">
</head>
<body>

<header class="header">
	<div class="header__container">
		<div class="header__main">Рекорды моей планеты</div>
		<nav class="nav">
			<?php include 'Nav.php';?>
		</nav>
	</div>
</header>

<main class="introduction">
	<div class="intro__container">
		<div class="main__form">
			<form method="post" action="Main5.php">
				Введите название БД:   <input type="text" name="databaseName" size="100" value="clinic2" /><br />
				<input type="submit" value="OK" /><br />
			</form>
		</div>
		<div class="other__info">
			<form>
				<fieldset>
					<legend>Кого вы считатете лучшим телеведущим?</legend>
					<input id="radio_1" name="First" type="radio" value="1" </input>
					<label for="radio_1">Андрей Панкратов</label><br />
					<input id="radio_2" name="First" type="radio" value="2" </input>
					<label for="radio_2">Тимофей Баженов</label><br />
				</fieldset>
				<p><input type="submit" value="Проголосовать"></p>
				
				<fieldset>
					<legend>На какие темы дальше делаем рекорды?</legend>
					<input id="checkbox_1" name="Second" type="checkbox" </input>
					<label for="checkbox_1">Искусство</label><br />
					<input id="checkbox_2" name="Second" type="checkbox" </input>
					<label for="checkbox_2">Флора</label><br />
					<input id="checkbox_3" name="Second" type="checkbox" </input>
					<label for="checkbox_3">Техника</label><br />
					<input id="checkbox_4" name="Second" type="checkbox" </input>
					<label for="checkbox_4">Фауна</label><br />
				</fieldset>
				<p><input type="submit" value="Подтвердить"></p>
			</form>
		</div>
	</div>
</main>

<footer>
	<p>Copyright &copy 2020 KVV</p>
</footer>

</body>
</html>