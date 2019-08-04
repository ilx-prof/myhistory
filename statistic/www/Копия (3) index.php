<html>
<head>
	<title>Анкета</title>
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
	$oter="Другое";
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
	<td><input <? print $radio_type?> class="radio" value="муж" name="static[Пол][Пол]"> муж <input <? print $radio_type?> class="radio" value="жен" name="static[Пол][Пол]"> жен</td>
	<td>Адрес эл. почты</td>
	<td><input type="text" class="text" value="" name="e-mail"></td>
</tr>
<tr>
	<td colspan="4">Ваш возраст&nbsp;&nbsp;&nbsp;&nbsp;<input <? print $radio_type?> class="radio" value="до 31" name="static[Возраст][Возраст]"> до 31 <input <? print $radio_type?> class="radio" value="31-40" name="static[Возраст][Возраст]"> 31-40 <input <? print $radio_type?> class="radio" value="41-50" name="static[Возраст][Возраст]"> 41-50 <input <? print $radio_type?> class="radio" value="от 50" name="static[Возраст][Возраст]"> от 50</td>
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
	<td colspan="2"><input <? print $radio_type?> class="radio" value="Постоянный гость" name="static[<? print $other ?>][Как Вы узнали о гостинице Октябрьская?]"> Постоянный гость</td>
	<td colspan="2"><input <? print $radio_type?> class="radio" value="Информация в справочниках" name="static[<? print $other ?>][Как Вы узнали о гостинице Октябрьская?]"> Информация в справочниках</td>
</tr>
<tr>
	<td colspan="2"><input <? print $radio_type?> class="radio" value="Рекомендации" name="static[<? print $other ?>][Как Вы узнали о гостинице Октябрьская?]">Рекомендации</td>
	<td colspan="2"><input <? print $radio_type?> class="radio" value="Информация в СМИ" name="static[<? print $other ?>][Как Вы узнали о гостинице Октябрьская?]"> Информация в СМИ</td>
</tr>
<tr>
	<td colspan="2"><input <? print $radio_type?> class="radio" value="Интернет" name="static[<? print $other ?>][Как Вы узнали о гостинице Октябрьская?]"> Интернет</td>
	<td colspan="2"><input <? print $radio_type?> class="radio" value="Реклама в аэропорте" name="static[<? print $other ?>][Как Вы узнали о гостинице Октябрьская?]"> Реклама в аэропорте</td>
</tr>
<tr>
	<td colspan="2"><input <? print $radio_type?> class="radio" value="Турагентство" name="static[<? print $other ?>][Как Вы узнали о гостинице Октябрьская?]"> Турагентство</td>
	<td colspan="2"><input <? print $radio_type?> class="radio" value="Другое" name="static[<? print $other ?>][Как Вы узнали о гостинице Октябрьская?]"> Другое</td>
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
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Мной лично по телефону или факсу" name="static[<? print $other ?>][Каким образом было сделано бронирование Вашего номера?]"> Мной лично по телефону или факсу</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Мной лично посредством сети Интернет или эл. почты" name="static[<? print $other ?>][Каким образом было сделано бронирование Вашего номера?]"> Мной лично посредством сети Интернет или эл. почты</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Моей компанией" name="static[<? print $other ?>][Каким образом было сделано бронирование Вашего номера?]"> Моей компанией</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Принимающей стороной" name="static[<? print $other ?>][Каким образом было сделано бронирование Вашего номера?]"> Принимающей стороной</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Турагентством" name="static[<? print $other ?>][Каким образом было сделано бронирование Вашего номера?]"> Турагентством</td>
</tr>

<tr>
	<td colspan="4" class="question">Каким видом транспорта Вы предпочитаете пользоваться, планирую поездку в Нижний Новгород?</td>
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][Каким видом транспорта Вы предпочитаете пользоваться, планирую поездку в Нижний Новгород?][Авиакомпания]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][Каким видом транспорта Вы предпочитаете пользоваться, планирую поездку в Нижний Новгород?][Железная дорога]">
	<input type="Hidden" class="Hidden" value="" name="unstatic[<? print $other ?>][Каким видом транспорта Вы предпочитаете пользоваться, планирую поездку в Нижний Новгород?][Автомобиль]">
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Авиакомпания" name="static[<? print $other ?>][Каким видом транспорта Вы предпочитаете пользоваться, планирую поездку в Нижний Новгород?]"> Авиакомпания&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="text" value="" name="Авиакомпания"> (пожалуйста, укажите какая)</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Железная дорога" name="static[<? print $other ?>][Каким видом транспорта Вы предпочитаете пользоваться, планирую поездку в Нижний Новгород?]"> Железная дорога</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Автомобиль" name="static[<? print $other ?>][Каким видом транспорта Вы предпочитаете пользоваться, планирую поездку в Нижний Новгород?]"> Автомобиль</td>
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
			
			
			<td align="center"><input <? print $radio_type?> name="static[Бронирование номера][Бронирование]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Бронирование номера][Бронирование]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Бронирование номера][Бронирование]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Общее впечатление</td>
			<td align="center"><input <? print $radio_type?> name="static[Бронирование номера][Общее впечатление]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Бронирование номера][Общее впечатление]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Бронирование номера][Общее впечатление]" value="Плохо"></td>
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
			<td>Организация трансфера</td>
			<td align="center"><input <? print $radio_type?> name="static[Прибытие][Организация трансфера]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Прибытие][Организация трансфера]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Прибытие][Организация трансфера]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Качество обслуживания</td>
			<td align="center"><input <? print $radio_type?> name="static[Прибытие][Качество обслуживания]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Прибытие][Качество обслуживания]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Прибытие][Качество обслуживания]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Доброжелательное отношение</td>
			<td align="center"><input <? print $radio_type?> name="static[Прибытие][Доброжелательное отношение]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Прибытие][Доброжелательное отношение]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Прибытие][Доброжелательное отношение]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Желание помочь</td>
			<td align="center"><input <? print $radio_type?> name="static[Прибытие][Желание помочь]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Прибытие][Желание помочь]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Прибытие][Желание помочь]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Быстрота размещения</td>
			<td align="center"><input <? print $radio_type?> name="static[Прибытие][Быстрота размещения]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Прибытие][Быстрота размещения]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Прибытие][Быстрота размещения]" value="Плохо"></td>
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
			<td>Общее впечатление</td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Общее впечатление]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Общее впечатление]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Общее впечатление]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Чистота</td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Чистота]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Чистота]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Чистота]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Комфорт</td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Комфорт]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Комфорт]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Комфорт]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Гостевые принадлежности</td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Гостевые принадлежности]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Гостевые принадлежности]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Гостевые принадлежности]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Телефонная связь</td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Телефонная связь]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Телефонная связь]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Телефонная связь]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Обслуживание в номере</td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Обслуживание в номере]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Обслуживание в номере]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Обслуживание в номере]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Прачечная, химчистка</td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Прачечная, химчистка]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Прачечная, химчистка]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Номер][Прачечная, химчистка]" value="Плохо"></td>
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
			<td>Качество обслуживания</td>
			<td align="center"><input <? print $radio_type?> name="static[Завтрак][Качество обслуживания]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Завтрак][Качество обслуживания]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Завтрак][Качество обслуживания]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Доброжелательное отношение</td>
			<td align="center"><input <? print $radio_type?> name="static[Завтрак][Доброжелательное отношение]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Завтрак][Доброжелательное отношение]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Завтрак][Доброжелательное отношение]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Внешний вид сотрудников</td>
			<td align="center"><input <? print $radio_type?> name="static[Завтрак][Внешний вид сотрудников]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Завтрак][Внешний вид сотрудников]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Завтрак][Внешний вид сотрудников]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Качество блюд</td>
			<td align="center"><input <? print $radio_type?> name="static[Завтрак][Качество блюд]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Завтрак][Качество блюд]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Завтрак][Качество блюд]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Разнообразие меню</td>
			<td align="center"><input <? print $radio_type?> name="static[Завтрак][Разнообразие меню]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Завтрак][Разнообразие меню]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Завтрак][Разнообразие меню]" value="Плохо"></td>
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
			<td>Качество обслуживания</td>
			<td align="center"><input <? print $radio_type?> name="static[Ресторан Премьер][Качество обслуживания]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Ресторан Премьер][Качество обслуживания]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Ресторан Премьер][Качество обслуживания]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Доброжелательное отношение</td>
			<td align="center"><input <? print $radio_type?> name="static[Ресторан Премьер][Доброжелательное отношение]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Ресторан Премьер][Доброжелательное отношение]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Ресторан Премьер][Доброжелательное отношение]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Внешний вид сотрудников</td>
			<td align="center"><input <? print $radio_type?> name="static[Ресторан Премьер][Внешний вид сотрудников]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Ресторан Премьер][Внешний вид сотрудников]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Ресторан Премьер][Внешний вид сотрудников]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Качество блюд</td>
			<td align="center"><input <? print $radio_type?> name="static[Ресторан Премьер][Качество блюд]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Ресторан Премьер][Качество блюд]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Ресторан Премьер][Качество блюд]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Разнообразие меню</td>
			<td align="center"><input <? print $radio_type?> name="static[Ресторан Премьер][Разнообразие меню]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Ресторан Премьер][Разнообразие меню]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Ресторан Премьер][Разнообразие меню]" value="Плохо"></td>
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
			<td>Качество обслуживания</td>
			<td align="center"><input <? print $radio_type?> name="static[Лобби-бар/Кафе][Качество обслуживания]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Лобби-бар/Кафе][Качество обслуживания]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Лобби-бар/Кафе][Качество обслуживания]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Доброжелательное отношение</td>
			<td align="center"><input <? print $radio_type?> name="static[Лобби-бар/Кафе][Доброжелательное отношение]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Лобби-бар/Кафе][Доброжелательное отношение]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Лобби-бар/Кафе][Доброжелательное отношение]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Внешний вид сотрудников</td>
			<td align="center"><input <? print $radio_type?> name="static[Лобби-бар/Кафе][Внешний вид сотрудников]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Лобби-бар/Кафе][Внешний вид сотрудников]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Лобби-бар/Кафе][Внешний вид сотрудников]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Качество блюд</td>
			<td align="center"><input <? print $radio_type?> name="static[Лобби-бар/Кафе][Качество блюд]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Лобби-бар/Кафе][Качество блюд]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Лобби-бар/Кафе][Качество блюд]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Разнообразие меню</td>
			<td align="center"><input <? print $radio_type?> name="static[Лобби-бар/Кафе][Разнообразие меню]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Лобби-бар/Кафе][Разнообразие меню]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Лобби-бар/Кафе][Разнообразие меню]" value="Плохо"></td>
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
			<td>Качество обслуживания</td>
			<td align="center"><input <? print $radio_type?> name="static[Бизнес-центр][Качество обслуживания]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Бизнес-центр][Качество обслуживания]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Бизнес-центр][Качество обслуживания]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Доброжелательное отношение</td>
			<td align="center"><input <? print $radio_type?> name="static[Бизнес-центр][Доброжелательное отношение]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Бизнес-центр][Доброжелательное отношение]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Бизнес-центр][Доброжелательное отношение]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Желание помочь</td>
			<td align="center"><input <? print $radio_type?> name="static[Бизнес-центр][Желание помочь]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Бизнес-центр][Желание помочь]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Бизнес-центр][Желание помочь]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Необходимое оборудование</td>
			<td align="center"><input <? print $radio_type?> name="static[Бизнес-центр][Необходимое оборудование]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Бизнес-центр][Необходимое оборудование]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Бизнес-центр][Необходимое оборудование]" value="Плохо"></td>
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
			<td>Качество обслуживания</td>
			<td align="center"><input <? print $radio_type?> name="static[Конференц-зал][Качество обслуживания]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Конференц-зал][Качество обслуживания]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Конференц-зал][Качество обслуживания]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Необходимое оборудование</td>
			<td align="center"><input <? print $radio_type?> name="static[Конференц-зал][Необходимое оборудование]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Конференц-зал][Необходимое оборудование]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Конференц-зал][Необходимое оборудование]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Помещение</td>
			<td align="center"><input <? print $radio_type?> name="static[Конференц-зал][Помещение]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Конференц-зал][Помещение]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Конференц-зал][Помещение]" value="Плохо"></td>
		</tr>
		
		<tr>
			<td colspan="4" class="question">Парикмахерская</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[Парикмахерская][Общее впечатление][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Парикмахерская][Общее впечатление][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Парикмахерская][Общее впечатление][Плохо]">

		</tr>
		<tr>
			<td>Общее впечатление</td>
			<td align="center"><input <? print $radio_type?> name="static[Парикмахерская][Общее впечатление]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Парикмахерская][Общее впечатление]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Парикмахерская][Общее впечатление]" value="Плохо"></td>
		</tr>
		
		<tr>
			<td colspan="4" class="question">Оздоровительный центр</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[Оздоровительный центр][Общее впечатление][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Оздоровительный центр][Общее впечатление][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Оздоровительный центр][Общее впечатление][Плохо]">

		</tr>
		<tr>
			<td>Общее впечатление</td>
			<td align="center"><input <? print $radio_type?> name="static[Оздоровительный центр][Общее впечатление]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Оздоровительный центр][Общее впечатление]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Оздоровительный центр][Общее впечатление]" value="Плохо"></td>
		</tr>
		
		<tr>
			<td colspan="4" class="question">Тренажерный зал</td>
			<input type="Hidden" class="Hidden" value="" name="unstatic[Тренажерный зал][Общее впечатление][Превосходно]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Тренажерный зал][Общее впечатление][Хорошо]">
			<input type="Hidden" class="Hidden" value="" name="unstatic[Тренажерный зал][Общее впечатление][Плохо]">
			
		</tr>
		<tr>
			<td>Общее впечатление</td>
			<td align="center"><input <? print $radio_type?> name="static[Тренажерный зал][Общее впечатление]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Тренажерный зал][Общее впечатление]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Тренажерный зал][Общее впечатление]" value="Плохо"></td>
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
			<td>Организация трансфера</td>
			<td align="center"><input <? print $radio_type?> name="static[Выезд][Организация трансфера]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Выезд][Организация трансфера]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Выезд][Организация трансфера]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Качество обслуживания</td>
			<td align="center"><input <? print $radio_type?> name="static[Выезд][Качество обслуживания]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Выезд][Качество обслуживания]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Выезд][Качество обслуживания]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Доброжелательное отношение</td>
			<td align="center"><input <? print $radio_type?> name="static[Выезд][Доброжелательное отношение]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Выезд][Доброжелательное отношение]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Выезд][Доброжелательное отношение]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Желание помочь</td>
			<td align="center"><input <? print $radio_type?> name="static[Выезд][Желание помочь]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Выезд][Желание помочь]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Выезд][Желание помочь]" value="Плохо"></td>
		</tr>
		<tr>
			<td>Быстрота расчета</td>
			<td align="center"><input <? print $radio_type?> name="static[Выезд][Быстрота расчета]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Выезд][Быстрота расчета]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Выезд][Быстрота расчета]" value="Плохо"></td>
		</tr>
		</table>
	</td>
</tr>

<tr>
	<td colspan="4" class="question">Мы хотели бы своевременно сообщать нашим гостям о новых услугах, появляющихся в "Октябрьской". Какую рекламу гостиницы вы считаете наиболее запоминающейся?</td>
<input <? print $radio_type?> name="static[<? print $oter?>][Какую рекламу гостиницы вы считаете наиболее запоминающейся?][Информация в Интернет]"  value="">
<input <? print $radio_type?> name="static[<? print $oter?>][Какую рекламу гостиницы вы считаете наиболее запоминающейся?][Информация в СМИ]" value="">
<input <? print $radio_type?> name="static[<? print $oter?>][Какую рекламу гостиницы вы считаете наиболее запоминающейся?][Наружная реклама]" value="">
<input <? print $radio_type?> name="static[<? print $oter?>][Какую рекламу гостиницы вы считаете наиболее запоминающейся?][Рекламные буклеты]" value="">
<input <? print $radio_type?> name="static[<? print $oter?>][Какую рекламу гостиницы вы считаете наиболее запоминающейся?][Сувенирная продукция]" value="">

</td>
	<td align="center">
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Информация в Интернет" name="static[<? print $oter?>][Какую рекламу гостиницы вы считаете наиболее запоминающейся?]"> Информация в Интернет</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Информация в СМИ" name="static[<? print $oter?>][Какую рекламу гостиницы вы считаете наиболее запоминающейся?]"> Информация в СМИ</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Наружная реклама" name="static[<? print $oter?>][Какую рекламу гостиницы вы считаете наиболее запоминающейся?]"> Наружная реклама</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Рекламные буклеты" name="static[<? print $oter?>][Какую рекламу гостиницы вы считаете наиболее запоминающейся?]"> Рекламные буклеты</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Сувенирная продукция" name="static[<? print $oter?>][Какую рекламу гостиницы вы считаете наиболее запоминающейся?]"> Сувенирная продукция</td>
</tr>
<tr>
			<td colspan="4" class="question">Возникали проблемы?</td>
</tr>
<tr>
	<td colspan="4" class="question">Столкнулись ли Вы с какими-либо проблемами вовремя пребывания в гостинице?</td>
	
	<input <? print $radio_type?> name="static[Возникали проблемы?][Столкнулись ли Вы с какими-либо проблемами вовремя пребывания в гостинице?][Нет]" value="">
	<input <? print $radio_type?> name="static[Возникали проблемы?][Столкнулись ли Вы с какими-либо проблемами вовремя пребывания в гостинице?][Да]" value="">
	
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Нет" name="static[Возникали проблемы?][Столкнулись ли Вы с какими-либо проблемами вовремя пребывания в гостинице?]"> Нет</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Да" name="static[Возникали проблемы?][Столкнулись ли Вы с какими-либо проблемами вовремя пребывания в гостинице?]"> Да (пожалуста, опишите проблему)</td>
</tr>
<tr>
	<td colspan="4"><textarea class="bigtext" value="" name="any_problems_text"></textarea></td>
</tr>

<tr>
	<td colspan="4" class="question">Насколько хорошо работники гостиницы справились с проблемой?</td>
	
	<input <? print $radio_type?> name="static[Возникали проблемы?][Насколько хорошо работники гостиницы справились с проблемой?][Лучше, чем я ожидал(а)]" value="">
	<input <? print $radio_type?> name="static[Возникали проблемы?][Насколько хорошо работники гостиницы справились с проблемой?][Согласно ожиданиям]" value="">
	<input <? print $radio_type?> name="static[Возникали проблемы?][Насколько хорошо работники гостиницы справились с проблемой?][Хуже, чем я ожидал(а)]" value="">
	<input <? print $radio_type?> name="static[Возникали проблемы?][Насколько хорошо работники гостиницы справились с проблемой?][Проблема так и не была решена]" value="">
	
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Лучше, чем я ожидал(а)" name="static[Возникали проблемы?][Насколько хорошо работники гостиницы справились с проблемой?]"> Лучше, чем я ожидал(а)</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Согласно ожиданиям" name="static[Возникали проблемы?][Насколько хорошо работники гостиницы справились с проблемой?]"> Согласно ожиданиям</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Хуже, чем я ожидал(а)" name="static[Возникали проблемы?][Насколько хорошо работники гостиницы справились с проблемой?]"> Хуже, чем я ожидал(а)</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Проблема так и не была решена" name="static[Возникали проблемы?][Насколько хорошо работники гостиницы справились с проблемой?]"> Проблема так и не была решена</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="О проблеме не сообщал(а)" name="static[Возникали проблемы?][Насколько хорошо работники гостиницы справились с проблемой?]"> О проблеме не сообщал(а)</td>
</tr>

<tr>
	<td colspan="4" class="question">Если вы считаете, что кто-то из наших сотрудников хорошо обслужил Вас и может быть отмечен, пожалуйста, укажите его(её) имя:</td>
</tr>
<tr>
	<td colspan="4"><textarea class="bigtext" value="" name="exception_person"></textarea></td>
</tr>

<tr>
	<td colspan="4" class="question">Снова оказавшись в Нижнем Новгороде, воспользуетесь ли Вы услугами нашей гостиницы вновь?</td>
	
				<input <? print $radio_type?> name="static[<? print $oter?>][Снова оказавшись в Нижнем Новгороде, воспользуетесь ли Вы услугами нашей гостиницы вновь?][Определенно да]" value="">
				<input <? print $radio_type?> name="static[<? print $oter?>][Снова оказавшись в Нижнем Новгороде, воспользуетесь ли Вы услугами нашей гостиницы вновь?][Возможно]" value="">
				<input <? print $radio_type?> name="static[<? print $oter?>][Снова оказавшись в Нижнем Новгороде, воспользуетесь ли Вы услугами нашей гостиницы вновь?][Скорнее нет]" value="">
				<input <? print $radio_type?> name="static[<? print $oter?>][Снова оказавшись в Нижнем Новгороде, воспользуетесь ли Вы услугами нашей гостиницы вновь?][Определенно нет]" value="">

</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Определенно да" name="static[<? print $oter?>][Снова оказавшись в Нижнем Новгороде, воспользуетесь ли Вы услугами нашей гостиницы вновь?]"> Определенно да</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Возможно" name="static[<? print $oter?>][Снова оказавшись в Нижнем Новгороде, воспользуетесь ли Вы услугами нашей гостиницы вновь?]"> Возможно</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Скорнее нет" name="static[<? print $oter?>][Снова оказавшись в Нижнем Новгороде, воспользуетесь ли Вы услугами нашей гостиницы вновь?]"> Скорнее нет</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Определенно нет" name="static[<? print $oter?>][Снова оказавшись в Нижнем Новгороде, воспользуетесь ли Вы услугами нашей гостиницы вновь?]"> Определенно нет</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="" name=""> Если ответ отрицательный, укажите, пожалуйста, причину <input type="text" class="text" value="" name="arrive_again_text"></td>
</tr>

<tr>
	<td colspan="4" class="question">Ваши комментарии и дополнения</td>
</tr>
<tr>
	<td colspan="4"><textarea class="bigtext" value="" name="additional_comments"></textarea></td>
</tr>

<tr>
	<td colspan="4" class="question">
		<br>
		<br>
		Спасибо за Ваше время. Ваше мнение очень важно для нас.<br>
		Надеемся вскоре снова приветствовать Вас в Нижнем Новгороде, в гостинице "Октябрьская"***!
	</td>
</tr>
<tr>
	<td colspan="4" align="center" valign="middle" height="225" style="background: url('oktbr.jpg') bottom right no-repeat;"><input type="submit" class="submit" value="" name="submit" value="Отправить данные анкеты"></td>
</tr>
</form>
</table>
</td></tr></table>
</div>
</body>
</html>