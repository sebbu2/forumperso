<?php
header('Content-Type: text/javascript'."\r\n");
if(isset($_REQUEST['text'])&&$_REQUEST['text']!='') { $text=$_REQUEST['text']; } else { $text=''; }
// text
?>
//--------------------------------------------
// Set up our simple tag open values
//--------------------------------------------
//
// Modified by Volker Puttrich to allow IE 4+
// on windows to use cursor position for inserting
// tags / smilies

var B_open<?php if($text!='') print('__'.$text); ?> = 0;
var I_open<?php if($text!='') print('__'.$text); ?> = 0;
var U_open<?php if($text!='') print('__'.$text); ?> = 0;
var QUOTE_open<?php if($text!='') print('__'.$text); ?> = 0;
var CODE_open<?php if($text!='') print('__'.$text); ?> = 0;
var SQL_open<?php if($text!='') print('__'.$text); ?> = 0;
var HTML_open<?php if($text!='') print('__'.$text); ?> = 0;

var bbtags<?php if($text!='') print('__'.$text); ?>   = new Array();

// Determine browser type and stuff.
// Borrowed from http://www.mozilla.org/docs/web-developer/sniffer/browser_type.html

var myAgent<?php if($text!='') print('__'.$text); ?>   = navigator.userAgent.toLowerCase();
var myVersion<?php if($text!='') print('__'.$text); ?> = parseInt(navigator.appVersion);

var is_ie<?php if($text!='') print('__'.$text); ?>   = ((myAgent<?php if($text!='') print('__'.$text); ?>.indexOf("msie") != -1)  && (myAgent<?php if($text!='') print('__'.$text); ?>.indexOf("opera") == -1));
var is_nav<?php if($text!='') print('__'.$text); ?>  = ((myAgent<?php if($text!='') print('__'.$text); ?>.indexOf('mozilla')!=-1) && (myAgent<?php if($text!='') print('__'.$text); ?>.indexOf('spoofer')==-1)
                && (myAgent<?php if($text!='') print('__'.$text); ?>.indexOf('compatible') == -1) && (myAgent<?php if($text!='') print('__'.$text); ?>.indexOf('opera')==-1)
                && (myAgent<?php if($text!='') print('__'.$text); ?>.indexOf('webtv') ==-1)       && (myAgent<?php if($text!='') print('__'.$text); ?>.indexOf('hotjava')==-1));

var is_win<?php if($text!='') print('__'.$text); ?>   =  ((myAgent<?php if($text!='') print('__'.$text); ?>.indexOf("win")!=-1) || (myAgent<?php if($text!='') print('__'.$text); ?>.indexOf("16bit")!=-1));
var is_mac<?php if($text!='') print('__'.$text); ?>    = (myAgent<?php if($text!='') print('__'.$text); ?>.indexOf("mac")!=-1);

// Set the initial radio button status based on cookies

var allcookies<?php if($text!='') print('__'.$text); ?> = document.cookie;
var pos<?php if($text!='') print('__'.$text); ?> = allcookies<?php if($text!='') print('__'.$text); ?>.indexOf("bbmode=");

prep_mode<?php if($text!='') print('__'.$text); ?>();

function prep_mode<?php if($text!='') print('__'.$text); ?>()
{
	if (pos<?php if($text!='') print('__'.$text); ?> != 1) {
		var cstart<?php if($text!='') print('__'.$text); ?> = pos<?php if($text!='') print('__'.$text); ?> + 7;
		var cend<?php if($text!='') print('__'.$text); ?>   = allcookies<?php if($text!='') print('__'.$text); ?>.indexOf(";", cstart<?php if($text!='') print('__'.$text); ?>);
		if (cend<?php if($text!='') print('__'.$text); ?> == -1) { cend<?php if($text!='') print('__'.$text); ?> = allcookies<?php if($text!='') print('__'.$text); ?>.length; }
		cvalue<?php if($text!='') print('__'.$text); ?> = allcookies<?php if($text!='') print('__'.$text); ?>.substring(cstart<?php if($text!='') print('__'.$text); ?>, cend<?php if($text!='') print('__'.$text); ?>);
		
		if (cvalue<?php if($text!='') print('__'.$text); ?> == 'ezmode') {
			document.getElementById("post<?php if($text!='') print('_'.$text); ?>").bbmode[0].checked = true;
		} else {
			document.getElementById("post<?php if($text!='') print('_'.$text); ?>").bbmode[1].checked = true;
		}
	} 
	else {
		// default to normal mode.
		document.getElementById("post<?php if($text!='') print('_'.$text); ?>").bbmode[1].checked = true;
	}
}

function setmode<?php if($text!='') print('__'.$text); ?>(mVal<?php if($text!='') print('__'.$text); ?>)
{
	document.cookie = "bbmode="+mVal<?php if($text!='') print('__'.$text); ?>+"; path=/; expires=Wed, 1 Jan 2020 00:00:00 GMT;";
}

function get_easy_mode_state<?php if($text!='') print('__'.$text); ?>()
{
	// Returns true if we've chosen easy mode
	
	if (document.getElementById("post<?php if($text!='') print('_'.$text); ?>").bbmode[0].checked) {
		return true;
	}
	else {
		return false;
	}
}

//--------------------------------------------
// Set the help bar status
//--------------------------------------------

function hstat<?php if($text!='') print('__'.$text); ?>(msg<?php if($text!='') print('__'.$text); ?>)
{
	document.getElementById("post<?php if($text!='') print('_'.$text); ?>").helpbox.value = eval( "help_" + msg<?php if($text!='') print('__'.$text); ?> );
}

// Set the number of tags open box

function cstat<?php if($text!='') print('__'.$text); ?>()
{
	var c<?php if($text!='') print('__'.$text); ?> = stacksize<?php if($text!='') print('__'.$text); ?>(bbtags<?php if($text!='') print('__'.$text); ?>);
	
	if ( (c<?php if($text!='') print('__'.$text); ?> < 1) || (c<?php if($text!='') print('__'.$text); ?> == null) ) {
		c<?php if($text!='') print('__'.$text); ?> = 0;
	}
	
	if ( ! bbtags<?php if($text!='') print('__'.$text); ?>[0] ) {
		c<?php if($text!='') print('__'.$text); ?> = 0;
	}
	
	document.getElementById("post<?php if($text!='') print('_'.$text); ?>").tagcount.value = c;
}

//--------------------------------------------
// Get stack size
//--------------------------------------------

function stacksize<?php if($text!='') print('__'.$text); ?>(thearray<?php if($text!='') print('__'.$text); ?>)
{
	for (i = 0 ; i < thearray<?php if($text!='') print('__'.$text); ?>.length; i++ ) {
		if ( (thearray<?php if($text!='') print('__'.$text); ?>[i] == "") || (thearray<?php if($text!='') print('__'.$text); ?>[i] == null) || (thearray<?php if($text!='') print('__'.$text); ?> == 'undefined') ) {
			return i;
		}
	}
	
	return thearray<?php if($text!='') print('__'.$text); ?>.length;
}

//--------------------------------------------
// Push stack
//--------------------------------------------

function pushstack<?php if($text!='') print('__'.$text); ?>(thearray<?php if($text!='') print('__'.$text); ?>, newval<?php if($text!='') print('__'.$text); ?>)
{
	arraysize<?php if($text!='') print('__'.$text); ?> = stacksize<?php if($text!='') print('__'.$text); ?>(thearray<?php if($text!='') print('__'.$text); ?>);
	thearray<?php if($text!='') print('__'.$text); ?>[arraysize<?php if($text!='') print('__'.$text); ?>] = newval<?php if($text!='') print('__'.$text); ?>;
}

//--------------------------------------------
// Pop stack
//--------------------------------------------

function popstack<?php if($text!='') print('__'.$text); ?>(thearray<?php if($text!='') print('__'.$text); ?>)
{
	arraysize<?php if($text!='') print('__'.$text); ?> = stacksize<?php if($text!='') print('__'.$text); ?>(thearray<?php if($text!='') print('__'.$text); ?>);
	theval<?php if($text!='') print('__'.$text); ?> = thearray<?php if($text!='') print('__'.$text); ?>[arraysize<?php if($text!='') print('__'.$text); ?> - 1];
	delete thearray<?php if($text!='') print('__'.$text); ?>[arraysize<?php if($text!='') print('__'.$text); ?> - 1];
	return theval<?php if($text!='') print('__'.$text); ?>;
}


//--------------------------------------------
// Close all tags
//--------------------------------------------

function closeall<?php if($text!='') print('__'.$text); ?>()
{
	if (bbtags<?php if($text!='') print('__'.$text); ?>[0]) {
		while (bbtags<?php if($text!='') print('__'.$text); ?>[0]) {
			tagRemove<?php if($text!='') print('__'.$text); ?> = popstack<?php if($text!='') print('__'.$text); ?>(bbtags<?php if($text!='') print('__'.$text); ?>)
			document.getElementById("post<?php if($text!='') print('_'.$text); ?>").contenu.value += "[/" + tagRemove<?php if($text!='') print('__'.$text); ?> + "]";
			
			// Change the button status
			// Ensure we're not looking for FONT, SIZE or COLOR as these
			// buttons don't exist, they are select lists instead.
			
			if ( (tagRemove<?php if($text!='') print('__'.$text); ?> != 'FONT') && (tagRemove<?php if($text!='') print('__'.$text); ?> != 'SIZE') && (tagRemove<?php if($text!='') print('__'.$text); ?> != 'COLOR') )
			{
				eval("document.getElementById(\"post<?php if($text!='') print('_'.$text); ?>\")." + tagRemove<?php if($text!='') print('__'.$text); ?> + ".value = ' " + tagRemove<?php if($text!='') print('__'.$text); ?> + " '");
				eval(tagRemove<?php if($text!='') print('__'.$text); ?> + "_open = 0");
			}
		}
	}
	
	// Ensure we got them all
	document.getElementById("post<?php if($text!='') print('_'.$text); ?>").tagcount.value = 0;
	bbtags<?php if($text!='') print('__'.$text); ?> = new Array();
	document.getElementById("post<?php if($text!='') print('_'.$text); ?>").contenu.focus();
}

//--------------------------------------------
// EMOTICONS
//--------------------------------------------

function emoticon<?php if($text!='') print('__'.$text); ?>(theSmilie<?php if($text!='') print('__'.$text); ?>)
{
	doInsert<?php if($text!='') print('__'.$text); ?>(" " + theSmilie<?php if($text!='') print('__'.$text); ?> + " ", "", false);
}

//--------------------------------------------
// ADD CODE
//--------------------------------------------

function add_code<?php if($text!='') print('__'.$text); ?>(NewCode<?php if($text!='') print('__'.$text); ?>)
{
    document.getElementById("post<?php if($text!='') print('_'.$text); ?>").contenu.value += NewCode<?php if($text!='') print('__'.$text); ?>;
    document.getElementById("post<?php if($text!='') print('_'.$text); ?>").contenu.focus();
}

//--------------------------------------------
// ALTER FONT
//--------------------------------------------

function alterfont<?php if($text!='') print('__'.$text); ?>(theval<?php if($text!='') print('__'.$text); ?>, thetag<?php if($text!='') print('__'.$text); ?>)
{
    if (theval<?php if($text!='') print('__'.$text); ?> == 0)
    	return;
	
	if(doInsert<?php if($text!='') print('__'.$text); ?>("[" + thetag<?php if($text!='') print('__'.$text); ?> + "=" + theval<?php if($text!='') print('__'.$text); ?> + "]", "[/" + thetag<?php if($text!='') print('__'.$text); ?> + "]", true))
		pushstack<?php if($text!='') print('__'.$text); ?>(bbtags<?php if($text!='') print('__'.$text); ?>, thetag<?php if($text!='') print('__'.$text); ?>);
	
    document.getElementById("post<?php if($text!='') print('_'.$text); ?>").ffont.selectedIndex  = 0;
    document.getElementById("post<?php if($text!='') print('_'.$text); ?>").fsize.selectedIndex  = 0;
    document.getElementById("post<?php if($text!='') print('_'.$text); ?>").fcolor.selectedIndex = 0;
	
}


//--------------------------------------------
// SIMPLE TAGS (such as B, I U, etc)
//--------------------------------------------

function simpletag<?php if($text!='') print('__'.$text); ?>(thetag<?php if($text!='') print('__'.$text); ?>)
{
	var tagOpen<?php if($text!='') print('__'.$text); ?> = eval(thetag<?php if($text!='') print('__'.$text); ?> + "_open");
	
	if ( get_easy_mode_state() ) {
		inserttext<?php if($text!='') print('__'.$text); ?> = prompt(prompt_start<?php if($text!='') print('__'.$text); ?> + "\n[" + thetag<?php if($text!='') print('__'.$text); ?> + "]xxx[/" + thetag<?php if($text!='') print('__'.$text); ?> + "]");
		if ( (inserttext<?php if($text!='') print('__'.$text); ?> != null) && (inserttext<?php if($text!='') print('__'.$text); ?> != "") ) {
			doInsert<?php if($text!='') print('__'.$text); ?>("[" + thetag<?php if($text!='') print('__'.$text); ?> + "]" + inserttext<?php if($text!='') print('__'.$text); ?> + "[/" + thetag<?php if($text!='') print('__'.$text); ?> + "] ", "", false);
		}
	}
	else {
		if (tagOpen<?php if($text!='') print('__'.$text); ?> == 0) {
			if(doInsert<?php if($text!='') print('__'.$text); ?>("[" + thetag<?php if($text!='') print('__'.$text); ?> + "]", "[/" + thetag<?php if($text!='') print('__'.$text); ?> + "]", true)){
				eval(thetag<?php if($text!='') print('__'.$text); ?> + "_open = 1");
				// Change the button status
				eval("document.getElementById(\"post<?php if($text!='') print('_'.$text); ?>\")." + thetag<?php if($text!='') print('__'.$text); ?> + ".value += '*'");
		
				pushstack<?php if($text!='') print('__'.$text); ?>(bbtags<?php if($text!='') print('__'.$text); ?>, thetag<?php if($text!='') print('__'.$text); ?>);
				cstat<?php if($text!='') print('__'.$text); ?>();
				hstat<?php if($text!='') print('__'.$text); ?>('click_close');
			}
		}
		else {
			// Find the last occurance of the opened tag
			lastindex<?php if($text!='') print('__'.$text); ?> = 0;
			
			for (i = 0 ; i < bbtags<?php if($text!='') print('__'.$text); ?>.length; i++ ) {
				if ( bbtags<?php if($text!='') print('__'.$text); ?>[i] == thetag<?php if($text!='') print('__'.$text); ?> ) {
					lastindex<?php if($text!='') print('__'.$text); ?> = i;
				}
			}
			
			// Close all tags opened up to that tag was opened
			while (bbtags<?php if($text!='') print('__'.$text); ?>[lastindex<?php if($text!='') print('__'.$text); ?>]) {
				tagRemove<?php if($text!='') print('__'.$text); ?> = popstack<?php if($text!='') print('__'.$text); ?>(bbtags<?php if($text!='') print('__'.$text); ?>);
				doInsert<?php if($text!='') print('__'.$text); ?>("[/" + tagRemove<?php if($text!='') print('__'.$text); ?> + "]", "", false)
				
				// Change the button status
				eval("document.getElementById(\"post<?php if($text!='') print('_'.$text); ?>\")." + tagRemove<?php if($text!='') print('__'.$text); ?> + ".value = ' " + tagRemove<?php if($text!='') print('__'.$text); ?> + " '");
				eval(tagRemove<?php if($text!='') print('__'.$text); ?> + "_open = 0");
			}

			cstat<?php if($text!='') print('__'.$text); ?>();
		}
	}
}


function tag_list<?php if($text!='') print('__'.$text); ?>()
{
	var listvalue<?php if($text!='') print('__'.$text); ?> = "init";
	var thelist<?php if($text!='') print('__'.$text); ?> = "[LIST]\n";
	
	while ( (listvalue<?php if($text!='') print('__'.$text); ?> != "") && (listvalue<?php if($text!='') print('__'.$text); ?> != null) ) {
		listvalue<?php if($text!='') print('__'.$text); ?> = prompt(list_prompt<?php if($text!='') print('__'.$text); ?>, "");
		if ( (listvalue<?php if($text!='') print('__'.$text); ?> != "") && (listvalue<?php if($text!='') print('__'.$text); ?> != null) ) {
			thelist<?php if($text!='') print('__'.$text); ?> = thelist<?php if($text!='') print('__'.$text); ?>+"[*]"+listvalue<?php if($text!='') print('__'.$text); ?>+"\n";
		}
	}

	doInsert<?php if($text!='') print('__'.$text); ?>(thelist<?php if($text!='') print('__'.$text); ?> + "[/LIST]\n", "", false);
}

function tag_url<?php if($text!='') print('__'.$text); ?>()
{
    var FoundErrors<?php if($text!='') print('__'.$text); ?> = '';
    var enterURL<?php if($text!='') print('__'.$text); ?>   = prompt(text_enter_url<?php if($text!='') print('__'.$text); ?>, "http://");
    var enterTITLE<?php if($text!='') print('__'.$text); ?> = prompt(text_enter_url_name<?php if($text!='') print('__'.$text); ?>, "My Webpage");

    if (!enterURL<?php if($text!='') print('__'.$text); ?>) {
        FoundErrors<?php if($text!='') print('__'.$text); ?> += " " + error_no_url<?php if($text!='') print('__'.$text); ?>;
    }
    if (!enterTITLE<?php if($text!='') print('__'.$text); ?>) {
        FoundErrors<?php if($text!='') print('__'.$text); ?> += " " + error_no_title<?php if($text!='') print('__'.$text); ?>;
    }

    if (FoundErrors<?php if($text!='') print('__'.$text); ?>) {
        alert("Error!"+FoundErrors<?php if($text!='') print('__'.$text); ?>);
        return;
    }

	doInsert<?php if($text!='') print('__'.$text); ?>("[URL="+enterURL<?php if($text!='') print('__'.$text); ?>+"]"+enterTITLE<?php if($text!='') print('__'.$text); ?>+"[/URL]", "", false);
}

function tag_image<?php if($text!='') print('__'.$text); ?>()
{
    var FoundErrors<?php if($text!='') print('__'.$text); ?> = '';
    var enterURL<?php if($text!='') print('__'.$text); ?>   = prompt(text_enter_image<?php if($text!='') print('__'.$text); ?>, "http://");

    if (!enterURL<?php if($text!='') print('__'.$text); ?>) {
        FoundErrors<?php if($text!='') print('__'.$text); ?> += " " + error_no_url<?php if($text!='') print('__'.$text); ?>;
    }

    if (FoundErrors<?php if($text!='') print('__'.$text); ?>) {
        alert("Error!"+FoundErrors<?php if($text!='') print('__'.$text); ?>);
        return;
    }

	doInsert<?php if($text!='') print('__'.$text); ?>("[IMG]"+enterURL<?php if($text!='') print('__'.$text); ?>+"[/IMG]", "", false);
}

function tag_email<?php if($text!='') print('__'.$text); ?>()
{
    var emailAddress<?php if($text!='') print('__'.$text); ?> = prompt(text_enter_email<?php if($text!='') print('__'.$text); ?>, "");

    if (!emailAddress<?php if($text!='') print('__'.$text); ?>) {
		alert(error_no_email<?php if($text!='') print('__'.$text); ?>);
		return; 
	}

	doInsert<?php if($text!='') print('__'.$text); ?>("[EMAIL]"+emailAddress<?php if($text!='') print('__'.$text); ?>+"[/EMAIL]", "", false);
}

//--------------------------------------------
// GENERAL INSERT FUNCTION
//--------------------------------------------
// ibTag: opening tag
// ibClsTag: closing tag, used if we have selected text
// isSingle: true if we do not close the tag right now
// return value: true if the tag needs to be closed later

//

function doInsert<?php if($text!='') print('__'.$text); ?>(ibTag<?php if($text!='') print('__'.$text); ?>, ibClsTag<?php if($text!='') print('__'.$text); ?>, isSingle<?php if($text!='') print('__'.$text); ?>)
{
	var isClose<?php if($text!='') print('__'.$text); ?> = false;
	var obj_ta<?php if($text!='') print('__'.$text); ?> = document.getElementById("post<?php if($text!='') print('_'.$text); ?>").contenu;

	if ( (myVersion<?php if($text!='') print('__'.$text); ?> >= 4) && is_ie<?php if($text!='') print('__'.$text); ?> && is_win<?php if($text!='') print('__'.$text); ?>) // Ensure it works for IE4up / Win only
	{
		if(obj_ta<?php if($text!='') print('__'.$text); ?>.isTextEdit){ // this doesn't work for NS, but it works for IE 4+ and compatible browsers
			obj_ta<?php if($text!='') print('__'.$text); ?>.focus();
			var sel<?php if($text!='') print('__'.$text); ?> = document.selection;
			var rng<?php if($text!='') print('__'.$text); ?> = sel<?php if($text!='') print('__'.$text); ?>.createRange();
			rng<?php if($text!='') print('__'.$text); ?>.colapse;
			if((sel<?php if($text!='') print('__'.$text); ?>.type == "Text" || sel<?php if($text!='') print('__'.$text); ?>.type == "None") && rng<?php if($text!='') print('__'.$text); ?> != null){
				if(ibClsTag<?php if($text!='') print('__'.$text); ?> != "" && rng<?php if($text!='') print('__'.$text); ?>.text.length > 0)
					ibTag<?php if($text!='') print('__'.$text); ?> += rng<?php if($text!='') print('__'.$text); ?>.text + ibClsTag<?php if($text!='') print('__'.$text); ?>;
				else if(isSingle<?php if($text!='') print('__'.$text); ?>)
					isClose<?php if($text!='') print('__'.$text); ?> = true;
	
				rng<?php if($text!='') print('__'.$text); ?>.text = ibTag<?php if($text!='') print('__'.$text); ?>;
			}
		}
		else{
			if(isSingle<?php if($text!='') print('__'.$text); ?>)
				isClose<?php if($text!='') print('__'.$text); ?> = true;
	
			obj_ta<?php if($text!='') print('__'.$text); ?>.value += ibTag<?php if($text!='') print('__'.$text); ?>;
		}
	}
	else
	{
		if(isSingle<?php if($text!='') print('__'.$text); ?>)
			isClose<?php if($text!='') print('__'.$text); ?> = true;

		obj_ta<?php if($text!='') print('__'.$text); ?>.value += ibTag<?php if($text!='') print('__'.$text); ?>;
	}

	obj_ta<?php if($text!='') print('__'.$text); ?>.focus();
	
	// clear multiple blanks
//	obj_ta.value = obj_ta.value.replace(/  /, " ");

	return isClose<?php if($text!='') print('__'.$text); ?>;
}
//--------------------------------------------
// GENERAL VARIABLE
//--------------------------------------------

// IBC Code stuff
	var text_enter_url<?php if($text!='') print('__'.$text); ?>      = "Entrez l'URL complète pour le lien";
	var text_enter_url_name<?php if($text!='') print('__'.$text); ?> = "Entrez le titre de la page web";
	var text_enter_image<?php if($text!='') print('__'.$text); ?>    = "Entrez l'URL complète de l'image";
	var text_enter_email<?php if($text!='') print('__'.$text); ?>    = "Entrez l'adresse email";
	var text_enter_flash<?php if($text!='') print('__'.$text); ?>    = "Entrer l'URL de l'Animation Flash.";
	var text_code<?php if($text!='') print('__'.$text); ?>           = "Usage: [CODE] Votre Code Ici.. [/CODE]";
	var text_quote<?php if($text!='') print('__'.$text); ?>          = "Usage: [QUOTE] Votre Citation Ici.. [/QUOTE]";
	var error_no_url<?php if($text!='') print('__'.$text); ?>        = "Vous devez entrer une URL";
	var error_no_title<?php if($text!='') print('__'.$text); ?>      = "Vous devez entrer un titre";
	var error_no_email<?php if($text!='') print('__'.$text); ?>      = "Vous devez entrer une adresse email";
	var error_no_width<?php if($text!='') print('__'.$text); ?>      = "Vous devez entrer une largeur";
	var error_no_height<?php if($text!='') print('__'.$text); ?>     = "Vous devez entrer une hauteur";
	var prompt_start<?php if($text!='') print('__'.$text); ?>        = "Entrez le texte devant être formaté";
	
	var help_bold<?php if($text!='') print('__'.$text); ?>           = "Insérer Texte Gras (alt + b)";
	var help_italic<?php if($text!='') print('__'.$text); ?>         = "Insérer Texte Italique (alt + i)";
	var help_under<?php if($text!='') print('__'.$text); ?>          = "Insérer Texte Souligné (alt + u)";
	var help_font<?php if($text!='') print('__'.$text); ?>           = "Insérer tags Police";
	var help_size<?php if($text!='') print('__'.$text); ?>           = "Insérer tags Taille Police";
	var help_color<?php if($text!='') print('__'.$text); ?>          = "Insérer tags Couleur Police";
	var help_close<?php if($text!='') print('__'.$text); ?>          = "Fermer tous les tags ouverts";
	var help_url<?php if($text!='') print('__'.$text); ?>            = "Insérer Hyperlien (alt+ h)";
	var help_img<?php if($text!='') print('__'.$text); ?>            = "Image (alt + g) [img]http://www.dom.com/img.gif[/img]";
	var help_email<?php if($text!='') print('__'.$text); ?>          = "Insérer Adresse Email (alt + e)";
	var help_quote<?php if($text!='') print('__'.$text); ?>          = "Insérer Citation (alt + q)";
	var help_list<?php if($text!='') print('__'.$text); ?>           = "Créer une liste (alt + l)";
	var help_code<?php if($text!='') print('__'.$text); ?>           = "Insérer Texte Monotype (alt + p)";
	var help_click_close<?php if($text!='') print('__'.$text); ?>    = "Cliquer à nouveau sur le bouton pour fermer";
	var list_prompt<?php if($text!='') print('__'.$text); ?>         = "Entrez un objet de liste. Cliquez sur 'annuler' ou laissez à blanc pour terminer la liste";
