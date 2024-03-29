﻿<?php
// Member Management Options
$locale['400'] = "Членове";
$locale['401'] = "Потребител";
$locale['402'] = "Добавя";
$locale['403'] = "Тип потребител";
$locale['404'] = "Опции";
$locale['405'] = "Преглед";
$locale['406'] = "Редактира";
$locale['407'] = "Деблокира";
$locale['408'] = "Блокира";
$locale['409'] = "Изтрива";
$locale['410'] = "Няма потребителско име започващо с ";
$locale['411'] = "Показва всичките";
$locale['412'] = "Активира";
// Ban/Unban/Delete Member
$locale['420'] = "Поискано блокиране";
$locale['421'] = "Блокирането премахнато";
$locale['422'] = "Члена е изтрит";
$locale['423'] = "Сигурен ли сте, че искате да изтриете този член?";
$locale['424'] = "Члена е активиран";
$locale['425'] = "Профила е активиран в ";
$locale['426'] = "Здравей [USER_NAME],\n
Вашият профил в ".$settings['sitename']." беше активиран.\n
Сега вече можете да си влезете с потребителското име и парола.\n
Поздравления,
".$settings['siteusername'];
// Edit Member Details
$locale['430'] = "Редактира член";
$locale['431'] = "Членските детайли са обновени";
$locale['432'] = "Назад към Админ. на членовете";
$locale['433'] = "Назад към Администрация";
$locale['434'] = "Невъзможно обновяване на детайлите за:";
// Extra Edit Member Details form options
$locale['440'] = "Запазва промените";
// Update Profile Errors
$locale['450'] = "Неможе да редактирате главният администратор.";
$locale['451'] = "Трябва да укажете потребителско име и email адрес.";
$locale['452'] = "Потребителското име е с грешни символи.";
$locale['453'] = "Потребителското име е ".(isset($_POST['user_name']) ? $_POST['user_name'] : "")." регистрирано.";
$locale['454'] = "Грешен email адрес.";
$locale['455'] = "Този email адрес ".(isset($_POST['user_email']) ? $_POST['user_email'] : "")." е регистриран.";
$locale['456'] = "Новата парола не е еднаква и на двете места.";
$locale['457'] = "Грешна парола, позволени са само букви и цифри.<br>
Паролата трябва да е минимум 6 знака.";
$locale['458'] = "<b>ВНИМАНИЕ:</b> Неочаквано стартиране на скрипта.";
// View Member Profile
$locale['470'] = "Членски профил: ";
$locale['472'] = "Статистики";
$locale['473'] = "Потребителски групи";
// Add Member Errors
$locale['480'] = "Добавя член";
$locale['481'] = "Членският профил е създаден.";
$locale['482'] = "Членският профил не може да бъде създаден.";
?>