4<html>
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
<? $radio_type="type=\"radio\" ";
	$other="Другое";
?>
<table id="maintable" align="center" bgcolor="#ffffff"><tr><td>
<table width="730" height="100%" align="center" cellspacing="0" cellpadding="4">
<form method="post" action="static.php">
<tr>
	<td id="maintitle" colspan="4">А н к е т а&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Г о с т я</td>
</tr>
<tr>
	<td>Фамилия</td>
	<td><input type="text" checked class="text" value="" name="personality[Фамилия]"></td>
	<td>Имя</td>
	<td><input type="text" class="text" value="" name="personality[Имя]"></td>
</tr>
<tr>
	<td>Номер комнаты</td>
	<td><input type="text" class="text" value="" name="personality[Номер комнаты]"></td>
	<td>Период проживания</td>
	<td><input type="text" class="text" value="" name="personality[Период проживания]"></td>
</tr>
<tr>
	<td>Ваш пол</td>

	<td><input <? print $radio_type?> class="radio" value="муж" name="static[Пол][Пол]"> муж <input <? print $radio_type?> class="radio" value="жен" name="static[Пол][Пол]"> жен</td>
	<td>Адрес эл. почты</td>
	<td><input type="text" class="text" value="" name="personality[e-mail]"></td>
</tr>
<tr>
	<td colspan="4">Ваш возраст&nbsp;&nbsp;&nbsp;&nbsp;<input <? print $radio_type?> class="radio" value="до 31" name="static[Возраст][Возраст]"> до 31 <input <? print $radio_type?> class="radio" value="31-40" name="static[Возраст][Возраст]"> 31-40 <input <? print $radio_type?> class="radio" value="41-50" name="static[Возраст][Возраст]"> 41-50 <input <? print $radio_type?> class="radio" value="от 50" name="static[Возраст][Возраст]"> от 50
</td>
</tr>

<tr>
	<td colspan="4" class="question">Как Вы узнали о гостинице "Октябрьская"?</td>
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
	<td colspan="4"><textarea class="bigtext" value="" name="personality[Какие услуги дополнительно Вы хотели бы видеть в Октябрьской?]"></textarea></td>
</tr>

<tr>
	<td colspan="4" class="question">Как Вы считаете, в чем отличие гостиницы "Октябрьская" от гостиниц Нижнего Новгорода?</td>
</tr>
<tr>
	<td colspan="4"><textarea class="bigtext" value="" name="personality[Как Вы считаете, в чем отличие гостиницы Октябрьская от гостиниц Нижнего Новгорода?]"></textarea></td>
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
			<td>Бронирование номера</td>
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
		</tr>
		<tr>
			<td>Общее впечатление</td>
			<td align="center"><input <? print $radio_type?> name="static[Парикмахерская][Общее впечатление]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Парикмахерская][Общее впечатление]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Парикмахерская][Общее впечатление]" value="Плохо"></td>
		</tr>
		
		<tr>
			<td colspan="4" class="question">Оздоровительный центр</td>
		</tr>
		<tr>
			<td>Общее впечатление</td>
			<td align="center"><input <? print $radio_type?> name="static[Оздоровительный центр][Общее впечатление]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Оздоровительный центр][Общее впечатление]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Оздоровительный центр][Общее впечатление]" value="Плохо"></td>
		</tr>
		
		<tr>
			<td colspan="4" class="question">Тренажерный зал</td>
		</tr>
		<tr>
			<td>Общее впечатление</td>
			<td align="center"><input <? print $radio_type?> name="static[Тренажерный зал][Общее впечатление]" value="Превосходно"></td>
			<td align="center"><input <? print $radio_type?> name="static[Тренажерный зал][Общее впечатление]" value="Хорошо"></td>
			<td align="center"><input <? print $radio_type?> name="static[Тренажерный зал][Общее впечатление]" value="Плохо"></td>
		</tr>

		<tr>
			<td colspan="4" class="question">Выезд</td>
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
</td>
	<td align="center">
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Информация в Интернет" name="static[<? print $other?>][Какую рекламу гостиницы вы считаете наиболее запоминающейся?]"> Информация в Интернет</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Информация в СМИ" name="static[<? print $other?>][Какую рекламу гостиницы вы считаете наиболее запоминающейся?]"> Информация в СМИ</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Наружная реклама" name="static[<? print $other?>][Какую рекламу гостиницы вы считаете наиболее запоминающейся?]"> Наружная реклама</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Рекламные буклеты" name="static[<? print $other?>][Какую рекламу гостиницы вы считаете наиболее запоминающейся?]"> Рекламные буклеты</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Сувенирная продукция" name="static[<? print $other?>][Какую рекламу гостиницы вы считаете наиболее запоминающейся?]"> Сувенирная продукция</td>
</tr>
<tr>
			<td colspan="4" class="question">Возникали проблемы?</td>
</tr>
<tr>
	<td colspan="4" class="question">Столкнулись ли Вы с какими-либо проблемами вовремя пребывания в гостинице?</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Нет" name="static[Возникали проблемы?][Столкнулись ли Вы с какими-либо проблемами вовремя пребывания в гостинице?]"> Нет</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Да" name="static[Возникали проблемы?][Столкнулись ли Вы с какими-либо проблемами вовремя пребывания в гостинице?]"> Да (пожалуста, опишите проблему)</td>
</tr>
<tr>
	<td colspan="4"><textarea class="bigtext" value="" name="personality[описание возникших проблем]"></textarea></td>
</tr>

<tr>
	<td colspan="4" class="question">Насколько хорошо работники гостиницы справились с проблемой?</td>
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
	<td colspan="4"><textarea class="bigtext" value="" name="personality[Наградить сотрудника]"></textarea></td>
</tr>

<tr>
	<td colspan="4" class="question">Снова оказавшись в Нижнем Новгороде, воспользуетесь ли Вы услугами нашей гостиницы вновь?</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Определенно да" name="static[<? print $other?>][Снова оказавшись в Нижнем Новгороде, воспользуетесь ли Вы услугами нашей гостиницы вновь?]"> Определенно да</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Возможно" name="static[<? print $other?>][Снова оказавшись в Нижнем Новгороде, воспользуетесь ли Вы услугами нашей гостиницы вновь?]"> Возможно</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Скорнее нет" name="static[<? print $other?>][Снова оказавшись в Нижнем Новгороде, воспользуетесь ли Вы услугами нашей гостиницы вновь?]"> Скорнее нет</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="Определенно нет" name="static[<? print $other?>][Снова оказавшись в Нижнем Новгороде, воспользуетесь ли Вы услугами нашей гостиницы вновь?]"> Определенно нет</td>
</tr>
<tr>
	<td colspan="4"><input <? print $radio_type?> class="radio" value="" name=""> Если ответ отрицательный, укажите, пожалуйста, причину <input type="text" class="text" value="" name="personality[Не приеду сюда потому что]"></td>
</tr>

<tr>
	<td colspan="4" class="question">Ваши комментарии и дополнения</td>
</tr>
<tr>
	<td colspan="4"><textarea class="bigtext" value="" name="personality[Ваши комментарии и дополнения]"></textarea></td>
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