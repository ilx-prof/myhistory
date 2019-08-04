tempBarR='';
barBuiltR=0;
lastYR=0;
sIR=new Array();
movingR=setTimeout('null',1);

function moveOutR(){
	if (parseInt(ssmR.right)<0){
		clearTimeout(movingR);
		movingR = setTimeout('moveOutR()', slideSpeedR);
		slideMenuR(10)
	}
	else{
		clearTimeout(movingR);
		movingR=setTimeout('null',1)
	}
}

function moveBackR(){
	clearTimeout(movingR);
	movingR = setTimeout('moveBack1R()', waitTimeR)
}

function moveBack1R(){
	if (parseInt(ssmR.right)>(-menuWidthR)){
		clearTimeout(movingR);
		movingR = setTimeout('moveBack1R()', slideSpeedR);
		slideMenuR(-10)
	}
	else{
		clearTimeout(movingR);
		movingR=setTimeout('null',1)
	}
}

function slideMenuR(num){
	ssmR.right = parseInt(ssmR.right)+num;
	if (NS){
		bssmR.clip.right+=num;
		bssm2R.clip.right+=num;
		if (bssmR.right+bssmR.clip.right>document.width) document.width+=num
	}
}

function makeStaticR(){
	winYR=(IE)?document.body.scrollTop:window.pageYOffset;
	if (winYR!=lastYR&&winYR>YOffsetR-staticYOffsetR){
		smoothR = .2 * (winYR - lastYR - YOffsetR + staticYOffsetR);
	}
	else 
		if (YOffsetR-staticYOffsetR+lastYR>YOffsetR-staticYOffsetR&&winYR<=YOffsetR-staticYOffsetR){
			smoothR = .2 * (winYR - lastYR - (YOffsetR-(YOffsetR-winYR)));
		}
		else {smoothR=0}
	if (smoothR > 0) smoothR = Math.ceil(smoothR);
	else smoothR = Math.floor(smoothR);
	bssmR.top=parseInt(bssmR.top)+smoothR
	lastYR = lastYR+smoothR;
	setTimeout('makeStaticR()', 10)
}

function buildBarR(){
	if (barTextR.toLowerCase().indexOf('<img')>-1){
		tempBarR=barTextR
	}
	else{
		for (bc=0;bc<barTextR.length;bc++){
			tempBarR+=barTextR.charAt(bc)+"<BR>"
		}
	}
	document.write('<tr><td align="center" rowspan="100" width="'+barWidthR+'" valign="'+barVAlignR+'" align=center><table cellpadding="0" cellspacing="0" border="0" width="23" height="226" align="center"><tr><td background="images/centrNav.gif" height="100%" align="center"><font face="'+barFontFamilyR+'" Size="'+barFontSizeR+'" COLOR="'+barFontColorR+'"><B>'+tempBarR+'<font color="#FFFFFF"><br>Ê<br>Ð<br>-<br><b style="color:Red;">2</b></font></B></font></td></tr></table></td><td></td></tr>')
}

function initSlideR(){
	if (NS6||IE){
		ssmR=(NS6)?document.getElementById("thessmR"):document.all("thessmR");
		bssmR=(NS6)?document.getElementById("basessmR").style:document.all("basessmR").style;
		bssmR.clip="rect(0 "+ssmR.offsetWidth+" "+(((IE)?document.body.clientHeight:0)+ssmR.offsetHeight)+" 0)";
		bssmR.visibility="visible";
		ssmR=ssmR.style;
		if(NS6) bssmR.top=YOffsetR
	}
	else 
		if (NS) {
			bssmR=document.layers["basessm1R"];
			bssm2=bssmR.document.layers["basessm2R"];
			ssmR=bssm2R.document.layers["thessmR"];
			bssm2R.clip.right=0;
			ssmR.visibility = "show";
		}
	if (menuIsStaticR=="yes") makeStaticR();
}

function buildMenuR(){
	if (IE||NS6){
		document.write('<DIV ID="basessmR" style="visibility: hidden; Position: Absolute; right: '+XOffsetR+'; Top: '+YOffsetR+'; Z-Index: 20; width:'+(menuWidthR+barWidthR)+'"><DIV ID="thessmR" style="Position: relative; right: '+(-menuWidthR)+'; Top: 0px; Z-Index: 21;'+((IE)?" width:0px":"")+'" onmouseover="moveOutR()" onmouseout="moveBackR()">')
	}
	if (NS){
		document.write('<LAYER name="basessm1R" top="'+YOffsetR+'" right='+XOffsetR+' visibility="show" onload="initSlideR()"><ILAYER name="basessm2R"><LAYER visibility="hide" name="thessmR" bgcolor="'+menuBGColorR+'" right="'+(-menuWidthR)+'" onmouseover="moveOutR()" onmouseout="moveBackR()">')
	}
	if (NS6){
		document.write('<table border="0" cellpadding="0" cellspacing="0" width="'+(menuWidthR+barWidthR+2)+'"><TR><TD>')
	}
	document.write('<div align="left" style="width:'+(menuWidthR+barWidthR+2)+';background:transparent;"><img src="images/verxNav-2.gif" width="23" height="49" alt=""></div>');
	document.write('<table border="0" cellpadding="0" cellspacing="0" width="'+(menuWidthR+barWidthR+2)+'">');
	buildBarR();
	for (j=0; j<sIR.length; j++){
		if (!sIR[j][3]){
			sIR[j][3]=menuColsR;
			sIR[j][5]=menuWidthR-1
		}
		else 
			if (sIR[j][3]!=menuColsR) sIR[j][5]=Math.round((menuWidthR+6)*(sIR[j][3]/menuColsR)-1);
		if (sIR[j-1]&&sIR[j-1][4]!="no"){document.write('<TR>')}
		if (!sIR[j][1]){
			document.write('<TD BGCOLOR="'+hdrBGColorR+'" ALIGN="'+hdrAlignR+'" VALIGN="'+hdrVAlignR+'" WIDTH="'+sIR[j][5]+'" COLSPAN="'+sIR[j][3]+'"><font face="'+hdrFontFamilyR+'" size="'+hdrFontSizeR+'" COLOR="'+hdrFontColorR+'"><b>&nbsp;'+sIR[j][0]+'</TD>')
		}
		else{
			if (!sIR[j][2]) sIR[j][2]=linkTargetR;
			document.write('<TD Background="'+linkBGColorR+'" WIDTH="'+sIR[j][5]+'" COLSPAN="'+sIR[j][3]+'"><ILAYER><LAYER onmouseover="bgColor=\''+linkOverBGColorR+'\'" onmouseout="bgColor=\''+linkBGColorR+'\'" WIDTH="100%" ALIGN="'+linkAlignR+'"><DIV  ALIGN="'+linkAlignR+'"><FONT face="'+linkFontFamilyR+'">&nbsp;<A HREF="'+sIR[j][1]+'" target="'+sIR[j][2]+'" CLASS="ssmItems" style="font-size:'+linkFontSizeR+';"">'+sIR[j][0]+'</DIV></LAYER></ILAYER></TD>')
		}
		if (sIR[j][4]!="no"&&barBuiltR==0){ barBuiltR=1}
		if(sIR[j][4]!="no"){document.write('</TR>')}
	}
	document.write('</table>')
	if (NS6){document.write('</TD></TR></TABLE>')}
	if (IE||NS6){
		document.write('<div align="left" style="width:'+(menuWidthR+barWidthR+2)+'"><img src="images/nizNav-2.gif" width="23" height="49" alt=""></div>');
		document.write('</DIV></DIV>');
		setTimeout('initSlideR();', 1)
	}
	if (NS){document.write('</LAYER></ILAYER></LAYER>')}
}

function addHdrR(name, cols, endrow){sIR[sIR.length]=[name, '', '', cols, endrow]}
function addItemR(name, link, target, cols, endrow){
	if(!link)link="javascript://";
	sIR[sIR.length]=[name, link, target, cols, endrow]
}