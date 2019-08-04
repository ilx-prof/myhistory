4<html>
<head>
	<title>Анкета1</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Cache-Control" content="no-cache">
	<style>
	body, table
	{
		font-family: Arial;
		font-size: 14px;
		font-weight: bold;
		color: #4e4e4e;
	}
	#maintable
	{
		border: 1px solid black;
		width: 800px;
		height: 100%;
	}
	#maintitle
	{
		font-size: 60px;
		color: #0099cf;
		text-align: center;
		vertical-align: top;
		height: 100px;
		font-family: "Times New Roman";
	}
	.text
	{
		width: 200px;
		height: 17px;
		font-family: Tahoma;
		font-weight: bold;
		font-size: 11px;
		color: #000000;
		border: 1px solid #000000;
	}
	.bigtext
	{
		width: 100%;
		height: 55px;
		font-family: Tahoma;
		font-weight: bold;
		font-size: 11px;
		color: #000000;
		border: 1px solid #000000;
	}
	.submit
	{
		width: 240px;
		height: 30px;
		font-family: Tahoma;
		font-weight: bold;
		font-size: 13px;
		color: #000000;
		border: 1px solid #000000;
		background-color: #ece9d8;
	}
	.question
	{
		color: #000000;
		vertical-align: bottom;
		height: 40px;
	}
	</style>
</head>
<body bgcolor="#a9a9a9" leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">
<? $radio_type="type=\"Checkbox\" checked";
	$other="Другое";
	$_POST=array();
?>
<table id="maintable" align="center" bgcolor="#ffffff"><tr><td>
<table width="730" height="100%" align="center" cellspacing="0" cellpadding="4">
<form method="post" action="static.php">
<tr>
	<td id="maintitle" colspan="4">А н к е т а&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Г о с т я</td>
</tr>
<tr>
	<td>Фамилия</td>
	<td><input type="text" checked class="text" value="" name="last_name"></td>
	<td>Номер комнаты</td>
	<td><input type="text" class="text" value="" name="room_number"></td>
</tr>
<tr>
	<td>Имя</td>
	<td><input type="text" class="text" value="" name="first_name"></td>
	<td>Период проживания</td>
	<td><input type="text" class="text" value="" name="length_of_stay"></td>
</tr>
<tr>
	<td>Ваш пол</td>
	<input type="Hidden" class="Hidden" value="" name="unstatic[Пол][Пол][жен]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[Пол][Пол][муж]">	
	<td>Адрес эл. почты</td>
	<td><input type="text" class="text" value="" name="e-mail"></td>
</tr>
<tr>
	<input type="Hidden" class="Hidden" value="" name="unstatic[Возраст][Возраст][до 31]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[Возраст][Возраст][31-40]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[Возраст][Возраст][41-50]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[Возраст][Возраст][от 50]">
</tr>
<tr>
	<td colspan="4" class="question">Как Вы узнали о гостинице "Октябрьская"?</td>
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][Как Вы узнали о гостинице Октябрьская?][Постоянный гость]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][Как Вы узнали о гостинице Октябрьская?][Информация в справочниках]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][Как Вы узнали о гостинице Октябрьская?][Рекомендации]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][Как Вы узнали о гостинице Октябрьская?][Информация в СМИ]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][Как Вы узнали о гостинице Октябрьская?][Интернет]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][Как Вы узнали о гостинице Октябрьская?][Реклама в аэропорте]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][Как Вы узнали о гостинице Октябрьская?][Другое]">
</tr>
<tr>
	<td colspan="4" class="question">Каким образом было сделано бронирование Вашего номера?</td>
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][Каким образом было сделано бронирование Вашего номера?][Мной лично по телефону или факсу]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][Каким образом было сделано бронирование Вашего номера?][Мной лично посредством сети Интернет или эл. почты]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][Каким образом было сделано бронирование Вашего номера?][Моей компанией]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][Каким образом было сделано бронирование Вашего номера?][Принимающей стороной]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][Каким образом было сделано бронирование Вашего номера?][Интернет]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][Каким образом было сделано бронирование Вашего номера?][Реклама в аэропорте]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][Каким образом было сделано бронирование Вашего номера?][Турагентством]">
</tr>
<tr>
	<td colspan="4" class="question">Каким видом транспорта Вы предпочитаете пользоваться, планирую поездку в Нижний Новгород?</td>
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][Каким видом транспорта Вы предпочитаете пользоваться, планирую поездку в Нижний Новгород?][Авиакомпания]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][Каким видом транспорта Вы предпочитаете пользоваться, планирую поездку в Нижний Новгород?][Железная дорога]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][Каким видом транспорта Вы предпочитаете пользоваться, планирую поездку в Нижний Новгород?][Автомобиль]">
</tr>
<tr>
	<td colspan="4" class="question">Какие услуги дополнительно Вы хотели бы видеть в "Октябрьской"?</td>
</tr>
<tr>
	<td colspan="4"><textarea class="bigtext" value="" name="Какие услуги дополнительно Вы хотели бы видеть в Октябрьской?"></textarea></td>
</tr>

<tr>
	<td colspan="4" class="question">Как Вы считаете, в чем отличие гостиницы "Октябрьская" от гостиниц Нижнего Новгорода?</td>
</tr>
<tr>
	<td colspan="4"><textarea class="bigtext" value="" name="Как Вы считаете, в чем отличие гостиницы Октябрьская от гостиниц Нижнего Новгорода?"></textarea></td>
</tr>

<tr>
	<td colspan="4" class="question">Заполните пожалуйста таблицу согласно вашим ощущениям</td>
</tr>
<tr>
	<td colspan="4">
		<table cellspacing="0" cellpadding="4" width="100%">
		<tr>
			<td>&nbsp;</td>
			<td align="center" width="130">Превосходно</td>
			<td align="center" width="130">Хорошо</td>
			<td align="center" width="130">Плохо</td>
		</tr>
		
		<tr>
			<td colspan="4" class="question">Бронирование номера</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[Бронирование номера][Бронирование][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Бронирование номера][Бронирование][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Бронирование номера][Бронирование][Плохо]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[Бронирование номера][Общее впечатление][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Бронирование номера][Общее впечатление][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Бронирование номера][Общее впечатление][Плохо]">
		
		</tr>
		
		<tr>
			<td colspan="4" class="question">Прибытие</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[Прибытие][Организация трансфера][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Прибытие][Организация трансфера][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Прибытие][Организация трансфера][Плохо]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[Прибытие][Качество обслуживания][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Прибытие][Качество обслуживания][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Прибытие][Качество обслуживания][Плохо]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[Прибытие][Доброжелательное отношение][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Прибытие][Доброжелательное отношение][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Прибытие][Доброжелательное отношение][Плохо]">
									
			<input type="Hidden" class="Hidden" value="" name="unstatic[Прибытие][Желание помочь][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Прибытие][Желание помочь][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Прибытие][Желание помочь][Плохо]">
			
						
			<input type="Hidden" class="Hidden" value="" name="unstatic[Прибытие][Быстрота размещения][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Прибытие][Быстрота размещения][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Прибытие][Быстрота размещения][Плохо]">
		</tr>
	
		<tr>
			<td colspan="4" class="question">Номер</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Общее впечатление][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Общее впечатление][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Общее впечатление][Плохо]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Качество обслуживания][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Качество обслуживания][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Качество обслуживания][Плохо]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Чистота][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Чистота][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Чистота][Плохо]">
									
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Комфорт][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Комфорт][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Комфорт][Плохо]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Гостевые принадлежности][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Гостевые принадлежности][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Гостевые принадлежности][Плохо]">
						
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Телефонная связь][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Телефонная связь][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Телефонная связь][Плохо]">
									
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Обслуживание в номере][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Обслуживание в номере][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Обслуживание в номере][Плохо]">
									
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Прачечная, химчистка][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Прачечная, химчистка][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Номер][Прачечная, химчистка][Плохо]">
			
		</tr>

		<tr>
			<td colspan="4" class="question">Завтрак</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[Завтрак][Качество обслуживания][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Завтрак][Качество обслуживания][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Завтрак][Качество обслуживания][Плохо]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[Завтрак][Доброжелательное отношение][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Завтрак][Доброжелательное отношение][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Завтрак][Доброжелательное отношение][Плохо]">
						
			<input type="Hidden" class="Hidden" value="" name="unstatic[Завтрак][Внешний вид сотрудников][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Завтрак][Внешний вид сотрудников][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Завтрак][Внешний вид сотрудников][Плохо]">
	
	
			<input type="Hidden" class="Hidden" value="" name="unstatic[Завтрак][Качество блюд][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Завтрак][Качество блюд][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Завтрак][Качество блюд][Плохо]">
									
			<input type="Hidden" class="Hidden" value="" name="unstatic[Завтрак][Разнообразие меню][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Завтрак][Разнообразие меню][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Завтрак][Разнообразие меню][Плохо]">
		</tr>
		
		<tr>
			<td colspan="4" class="question">Ресторан "Премьер"</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[Ресторан Премьер][Качество обслуживания][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Ресторан Премьер][Качество обслуживания][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Ресторан Премьер][Качество обслуживания][Плохо]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[Ресторан Премьер][Доброжелательное отношение][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Ресторан Премьер][Доброжелательное отношение][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Ресторан Премьер][Доброжелательное отношение][Плохо]">
						
			<input type="Hidden" class="Hidden" value="" name="unstatic[Ресторан Премьер][Внешний вид сотрудников][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Ресторан Премьер][Внешний вид сотрудников][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Ресторан Премьер][Внешний вид сотрудников][Плохо]">
	
	
			<input type="Hidden" class="Hidden" value="" name="unstatic[Ресторан Премьер][Качество блюд][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Ресторан Премьер][Качество блюд][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Ресторан Премьер][Качество блюд][Плохо]">
									
			<input type="Hidden" class="Hidden" value="" name="unstatic[Ресторан Премьер][Разнообразие меню][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Ресторан Премьер][Разнообразие меню][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Ресторан Премьер][Разнообразие меню][Плохо]">
			
		</tr>
		
		<tr>
			<td colspan="4" class="question">Лобби-бар/Кафе</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[Лобби-бар/Кафе][Качество обслуживания][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Лобби-бар/Кафе][Качество обслуживания][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Лобби-бар/Кафе][Качество обслуживания][Плохо]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[Лобби-бар/Кафе][Доброжелательное отношение][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Лобби-бар/Кафе][Доброжелательное отношение][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Лобби-бар/Кафе][Доброжелательное отношение][Плохо]">
						
			<input type="Hidden" class="Hidden" value="" name="unstatic[Лобби-бар/Кафе][Внешний вид сотрудников][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Лобби-бар/Кафе][Внешний вид сотрудников][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Лобби-бар/Кафе][Внешний вид сотрудников][Плохо]">
	
	
			<input type="Hidden" class="Hidden" value="" name="unstatic[Лобби-бар/Кафе][Качество блюд][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Лобби-бар/Кафе][Качество блюд][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Лобби-бар/Кафе][Качество блюд][Плохо]">
									
			<input type="Hidden" class="Hidden" value="" name="unstatic[Лобби-бар/Кафе][Разнообразие меню][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Лобби-бар/Кафе][Разнообразие меню][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Лобби-бар/Кафе][Разнообразие меню][Плохо]">
		</tr>
		
		<tr>
			<td colspan="4" class="question">Бизнес-центр</td>
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[Бизнес-центр][Качество обслуживания][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Бизнес-центр][Качество обслуживания][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Бизнес-центр][Качество обслуживания][Плохо]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[Бизнес-центр][Доброжелательное отношение][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Бизнес-центр][Доброжелательное отношение][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Бизнес-центр][Доброжелательное отношение][Плохо]">
						
			<input type="Hidden" class="Hidden" value="" name="unstatic[Бизнес-центр][Желание помочь][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Бизнес-центр][Желание помочь][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Бизнес-центр][Желание помочь][Плохо]">
	
	
			<input type="Hidden" class="Hidden" value="" name="unstatic[Бизнес-центр][Необходимое оборудование][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Бизнес-центр][Необходимое оборудование][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Бизнес-центр][Необходимое оборудование][Плохо]">

		</tr>
		
		<tr>
			<td colspan="4" class="question">Конференц-зал</td>
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[Конференц-зал][Качество обслуживания][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Конференц-зал][Качество обслуживания][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Конференц-зал][Качество обслуживания][Плохо]">
				
			<input type="Hidden" class="Hidden" value="" name="unstatic[Конференц-зал][Необходимое оборудование][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Конференц-зал][Необходимое оборудование][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Конференц-зал][Необходимое оборудование][Плохо]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[Конференц-зал][Помещение][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Конференц-зал][Помещение][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Конференц-зал][Помещение][Плохо]">	

		</tr>
		
		<tr>
			<td colspan="4" class="question">Парикмахерская</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[Парикмахерская][Общее впечатление][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Парикмахерская][Общее впечатление][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Парикмахерская][Общее впечатление][Плохо]">

		</tr>
	
		<tr>
			<td colspan="4" class="question">Оздоровительный центр</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[Оздоровительный центр][Общее впечатление][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Оздоровительный центр][Общее впечатление][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Оздоровительный центр][Общее впечатление][Плохо]">

		</tr>
		<tr>
			<td colspan="4" class="question">Тренажерный зал</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[Тренажерный зал][Общее впечатление][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Тренажерный зал][Общее впечатление][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Тренажерный зал][Общее впечатление][Плохо]">
			
		</tr>
		<tr>
			<td colspan="4" class="question">Выезд</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[Выезд][Организация трансфера][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Выезд][Организация трансфера][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Выезд][Организация трансфера][Плохо]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[Выезд][Качество обслуживания][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Выезд][Качество обслуживания][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Выезд][Качество обслуживания][Плохо]">
			
			<input type="Hidden" class="Hidden" value="" name="unstatic[Выезд][Доброжелательное отношение][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Выезд][Доброжелательное отношение][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Выезд][Доброжелательное отношение][Плохо]">
									
			<input type="Hidden" class="Hidden" value="" name="unstatic[Выезд][Желание помочь][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Выезд][Желание помочь][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Выезд][Желание помочь][Плохо]">
			
						
			<input type="Hidden" class="Hidden" value="" name="unstatic[Выезд][Быстрота размещения][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Выезд][Быстрота размещения][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Выезд][Быстрота размещения][Плохо]">
		</tr>
<tr>
	<td colspan="4" class="question">Мы хотели бы своевременно сообщать нашим гостям о новых услугах, появляющихся в "Октябрьской". Какую рекламу гостиницы вы считаете наиболее запоминающейся?</td>
<input type="Hidden" name="unstatic[<? print $other?>][Какую рекламу гостиницы вы считаете наиболее запоминающейся?][Информация в Интернет]"  value="">
<input type="Hidden" name="unstatic[<? print $other?>][Какую рекламу гостиницы вы считаете наиболее запоминающейся?][Информация в СМИ]" value="">
<input type="Hidden" name="unstatic[<? print $other?>][Какую рекламу гостиницы вы считаете наиболее запоминающейся?][Наружная реклама]" value="">
<input type="Hidden"name="unstatic[<? print $other?>][Какую рекламу гостиницы вы считаете наиболее запоминающейся?][Рекламные буклеты]" value="">
<input type="Hidden" name="unstatic[<? print $other?>][Какую рекламу гостиницы вы считаете наиболее запоминающейся?][Сувенирная продукция]" value="">

<tr>
			<td colspan="4" class="question">Возникали проблемы?</td>
</tr>
<tr>
	<td colspan="4" class="question">Столкнулись ли Вы с какими-либо проблемами вовремя пребывания в гостинице?</td>
	
	<input type="Hidden" name="unstatic[Возникали проблемы?][Столкнулись ли Вы с какими-либо проблемами вовремя пребывания в гостинице?][Нет]" value="">
	<input type="Hidden" name="unstatic[Возникали проблемы?][Столкнулись ли Вы с какими-либо проблемами вовремя пребывания в гостинице?][Да]" value="">
	
</tr>
<tr>
	<td colspan="4" class="question">Насколько хорошо работники гостиницы справились с проблемой?</td>
	
	<input type="Hidden" name="unstatic[Возникали проблемы?][Насколько хорошо работники гостиницы справились с проблемой?][Лучше, чем я ожидал(а)]" value="">
	<input type="Hidden"name="unstatic[Возникали проблемы?][Насколько хорошо работники гостиницы справились с проблемой?][Согласно ожиданиям]" value="">
	<input type="Hidden" name="unstatic[Возникали проблемы?][Насколько хорошо работники гостиницы справились с проблемой?][Хуже, чем я ожидал(а)]" value="">
	<input type="Hidden" name="unstatic[Возникали проблемы?][Насколько хорошо работники гостиницы справились с проблемой?][Проблема так и не была решена]" value="">
	
</tr>
<tr>
	<td colspan="4" class="question">Снова оказавшись в Нижнем Новгороде, воспользуетесь ли Вы услугами нашей гостиницы вновь?</td>
	
				<input type="Hidden" name="unstatic[<? print $other?>][Снова оказавшись в Нижнем Новгороде, воспользуетесь ли Вы услугами нашей гостиницы вновь?][Определенно да]" value="">
				<input type="Hidden" name="unstatic[<? print $other?>][Снова оказавшись в Нижнем Новгороде, воспользуетесь ли Вы услугами нашей гостиницы вновь?][Возможно]" value="">
				<input type="Hidden" name="unstatic[<? print $other?>][Снова оказавшись в Нижнем Новгороде, воспользуетесь ли Вы услугами нашей гостиницы вновь?][Скорнее нет]" value="">
				<input type="Hidden" name="unstatic[<? print $other?>][Снова оказавшись в Нижнем Новгороде, воспользуетесь ли Вы услугами нашей гостиницы вновь?][Определенно нет]" value="">

</tr>
<tr>
	<td colspan="4" align="center" valign="middle" height="225" style="background: url('oktbr.jpg') bottom right no-repeat;"><input type="submit" class="submit" value="" name="submit" value="Отправить данные анкеты"></td>
</tr>
</form>
