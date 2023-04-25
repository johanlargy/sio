if(document.images) /* PRECHARGEMENT DE L IMAGE DANS LE CACHE DU NAVIGATEUR */
	{
	zTous = new Image;
	zTous = "images/cocheR.gif";
	}

function format_euro(valeur) 
{
// formate un nombre avec 2 chiffres après la virgule et un espace separateur de milliers
	var ndecimal=2;
	var separateur=' ';
	var deci=Math.round( Math.pow(10,ndecimal)*(Math.abs(valeur)-Math.floor(Math.abs(valeur)))) ; 
	var val=Math.floor(Math.abs(valeur));
	if ((ndecimal==0)||(deci==Math.pow(10,ndecimal))) {val=Math.floor(Math.abs(valeur)); deci=0;}
	var val_format=val+"";
	var nb=val_format.length;
	for (var i=1;i<4;i++) 
	{
		if (val>=Math.pow(10,(3*i))) 
		{
			val_format=val_format.substring(0,nb-(3*i))+separateur+val_format.substring(nb-(3*i));
		}
	}
	if (ndecimal>0) 
	{
		var decim=""; 
		for (var j=0;j<(ndecimal-deci.toString().length);j++) {decim+="0";}
		deci=decim+deci.toString();
		val_format=val_format+","+deci;
	}
	if (parseFloat(valeur)<0) {val_format="-"+val_format;}
	return val_format;
}

// ========================= fonctions de navigation dans les listes (mois/visiteurs)
function premier(statut)
	{ 
	if (statut=='V') {
		document.choixM.lstMois.value = document.choixM.lstMois.options[0].value;
		document.choixM.submit();}
	else { 
		document.choixV.lstVisiteurs.value = document.choixV.lstVisiteurs.options[0].value;
		document.choixV.submit();}
	}
	
function precedent(statut)
	{
	if (statut=='V') {
		document.choixM.lstMois.value = document.choixM.lstMois.options[Math.max(0,document.choixM.lstMois.selectedIndex-1)].value;
		document.choixM.submit(statut);}
	else {
		document.choixV.lstVisiteurs.value = document.choixV.lstVisiteurs.options[Math.max(0,document.choixV.lstVisiteurs.selectedIndex-1)].value;
		document.choixV.submit();}
	}
	
function suivant(statut)
	{
	if (statut=='V') {
		document.choixM.lstMois.value = document.choixM.lstMois.options[(Math.min((document.choixM.lstMois.options.length-1),document.choixM.lstMois.selectedIndex+1))].value;
		document.choixM.submit();}
	else {
		document.choixV.lstVisiteurs.value = document.choixV.lstVisiteurs.options[(Math.min((document.choixV.lstVisiteurs.options.length-1),document.choixV.lstVisiteurs.selectedIndex+1))].value;
		document.choixV.submit();}
	}
	
function dernier(statut)
	{
	if (statut=='V') {
		document.choixM.lstMois.value = document.choixM.lstMois.options[(document.choixM.lstMois.options.length-1)].value;
		document.choixM.submit();}
	else {
		document.choixV.lstVisiteurs.value = document.choixV.lstVisiteurs.options[(document.choixV.lstVisiteurs.options.length-1)].value;
		document.choixV.submit();}
	}
	
// ========================= acivation/desactivation des cases a cocher "justificatifs" pour les frais hors forfaits	
function tousLesJustificatifs(frm)
	{
	inputs = frm.getElementsByTagName("input");
	var sens = frm.zSens.value;
	for(i=0 ; i<inputs.length ; i++)
		{
		    if(inputs[i].type=="checkbox")
			{	
			if (sens=="off") {inputs[i].checked = true;} else {inputs[i].checked = false;};
			}
		
		}
	if (sens=="off") {frm.zSens.value="on";} else {frm.zSens.value="off";}
	}
		
function tousLesJustificatifs2(frm)
	{
	var sens = frm.zSens.value;
	for (i = 0; i < frm.justificatifs.length; i++) 
		{	
		if (sens=="off") {frm.justificatifs[i].checked = true;} else {frm.justificatifs[i].checked = false;};
		}
	if (sens=="off") {frm.zSens.value="on";} else {frm.zSens.value="off";}
	}
