<body oncontextmenu="return false" onmousedown="open_r_menu()" onclick="close_r_menu()">
<div id="right_button_menu"></div>

var items_right_button_menu=new Array()
var menu_width=200
var offsetY=0

//������� ����.
items_right_button_menu[0]="<a href=\"NewForum\" target=\"_blank\" onmouseover=\"window.status='�����';return true;\" onmouseout=window.status='WSR'>�����</a>";offsetY+=15
items_right_button_menu[1]="<hr size=1 width=100%>";offsetY+=15
items_right_button_menu[2]="<a href=\"?show=okr/about.html\" onmouseover=\"window.status='���������� �� ��-1';return true;\" onmouseout=window.status='WSR'>���������� �� ��-1</a>";offsetY+=21
items_right_button_menu[3]="<a href=\"?show=okr2/about.html\" onmouseover=\"window.status='���������� �� ��-2';return true;\" onmouseout=window.status='WSR'>���������� �� ��-2</a>";offsetY+=21
items_right_button_menu[4]="<hr size=1 width=100%>";offsetY+=15
items_right_button_menu[5]="<a href=javascript:history.back(); onmouseover=\"window.status='�����';return true;\" onmouseout=window.status='WSR'>�����</a>";offsetY+=21
items_right_button_menu[6]="<a href=javascript:history.forward(); onmouseover=\"window.status='������';return true;\" onmouseout=window.status='WSR'>������</a>";offsetY+=21
items_right_button_menu[7]="<hr size=1 width=100%>";offsetY+=15
items_right_button_menu[8]="<a href=\"#\" onclick=\"javascript:this.style.behavior='url(#default#homepage)';this.setHomePage('http://www.worldkr.fatal.ru/'); return false;\" onmouseover=\"window.status='������� ���������';return true;\" onmouseout=window.status='WSR'>������� ���������</a>";offsetY+=15
items_right_button_menu[9]="<a href=\"javascript:window.external.addFavorite('http://www.worldkr.fatal.ru/', 'World of Space Rangers');\" onmouseover=\"window.status='�������� � ���������';return true;\" onmouseout=window.status='WSR'><nobr>�������� � ���������</nobr></a>";offsetY+=21
items_right_button_menu[10]="<hr size=1 width=100%>";offsetY+=15
items_right_button_menu[11]="<a href=\"mailto:vpah@mail.ru\" onmouseover=\"window.status='�������� ������ ������ �������'; return true;\" onmouseout=window.status='WSR'><nobr>�������� ������ ������</nobr></a>"; offsetY+=21
items_right_button_menu[12]="<a href=javascript:location.reload(); onmouseover=\"window.status='�������� ���������';return true;\" onmouseout=window.status='WSR'>��������</a>";offsetY+=21
items_right_button_menu=items_right_button_menu.join("")

function open_r_menu()
{
	if(event.button==2)
	{
	var menu=document.all["right_button_menu"];
	var x = document.body.scrollLeft + event.clientX;
	var y = document.body.scrollTop + event.clientY;
	
	menu.innerHTML=items_right_button_menu
	menu.style["width"]=menu_width
	menu.style["left"]=x
	menu.style["top"]=y
	menu.style["visibility"]="visible";
	
	}
}

function close_r_menu() {
	document.all["right_button_menu"].style["visibility"]="hidden";
}
