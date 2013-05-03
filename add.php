<?php
header("Content-Type: text/javascript"."\n");
if(isset($_REQUEST["text"])&&$_REQUEST["text"]!="") { $text=$_REQUEST["text"]; } else { $text=""; }
// text
?>
function storeCaret<?php if($text!="") print("_$text"); ?>(textEl<?php if($text!="") print("_$text"); ?>) {
	if (textEl<?php if($text!="") print("_$text"); ?>.createTextRange) textEl<?php if($text!="") print("_$text"); ?>.caretPos = document.selection.createRange().duplicate();
}
function insertElt<?php if($text!="") print("_$text"); ?>(text<?php if($text!="") print("_$text"); ?>,nothing<?php if($text!="") print("_$text"); ?>) {
	if (document.getElementById("post<?php if($text!="") print("_$text"); ?>").contenu.createTextRange && document.getElementById("post<?php if($text!="") print("_$text"); ?>").contenu.caretPos) {
		var caretPos = document.getElementById("post<?php if($text!="") print("_$text"); ?>").contenu.caretPos;
		caretPos.text<?php if($text!="") print("_$text"); ?> = caretPos.text<?php if($text!="") print("_$text"); ?>.charAt(caretPos.text<?php if($text!="") print("_$text"); ?>.length - 1) == ' ' ? text<?php if($text!="") print("_$text"); ?> + ' ' : text<?php if($text!="") print("_$text"); ?>;
		document.getElementById("post<?php if($text!="") print("_$text"); ?>").contenu.focus();
	} else {
		document.getElementById("post<?php if($text!="") print("_$text"); ?>").contenu.value  += text<?php if($text!="") print("_$text"); ?>;
		document.getElementById("post<?php if($text!="") print("_$text"); ?>").contenu.focus();
	}
}
function getarraysize<?php if($text!="") print("_$text"); ?>(thearray<?php if($text!="") print("_$text"); ?>) {
	for (i<?php if($text!="") print("_$text"); ?> = 0; i<?php if($text!="") print("_$text"); ?> < thearray<?php if($text!="") print("_$text"); ?>.length; i<?php if($text!="") print("_$text"); ?>++) {
		if ((thearray<?php if($text!="") print("_$text"); ?>[i<?php if($text!="") print("_$text"); ?>] == "undefined") || (thearray<?php if($text!="") print("_$text"); ?>[i<?php if($text!="") print("_$text"); ?>] == "") || (thearray<?php if($text!="") print("_$text"); ?>[i<?php if($text!="") print("_$text"); ?>] == null))
			return i<?php if($text!="") print("_$text"); ?>;
		}
	return thearray<?php if($text!="") print("_$text"); ?>.length;
}
function arraypush<?php if($text!="") print("_$text"); ?>(thearray<?php if($text!="") print("_$text"); ?>,value<?php if($text!="") print("_$text"); ?>) {
	thearray<?php if($text!="") print("_$text"); ?>[ getarraysize<?php if($text!="") print("_$text"); ?>(thearray<?php if($text!="") print("_$text"); ?>) ] = value<?php if($text!="") print("_$text"); ?>;
}
function arraypop<?php if($text!="") print("_$text"); ?>(thearray<?php if($text!="") print("_$text"); ?>) {
	thearraysize<?php if($text!="") print("_$text"); ?> = getarraysize<?php if($text!="") print("_$text"); ?>(thearray<?php if($text!="") print("_$text"); ?>);
	retval<?php if($text!="") print("_$text"); ?> = thearray<?php if($text!="") print("_$text"); ?>[thearraysize<?php if($text!="") print("_$text"); ?> - 1];
	delete thearray<?php if($text!="") print("_$text"); ?>[thearraysize<?php if($text!="") print("_$text"); ?> - 1];
	return retval<?php if($text!="") print("_$text"); ?>;
}
function mozWrap<?php if($text!="") print("_$text"); ?>(txtarea<?php if($text!="") print("_$text"); ?>, open<?php if($text!="") print("_$text"); ?>, close<?php if($text!="") print("_$text"); ?>)
{
	var selLength<?php if($text!="") print("_$text"); ?> = txtarea<?php if($text!="") print("_$text"); ?>.textLength;
	var selStart<?php if($text!="") print("_$text"); ?> = txtarea<?php if($text!="") print("_$text"); ?>.selectionStart;
	var selEnd<?php if($text!="") print("_$text"); ?> = txtarea<?php if($text!="") print("_$text"); ?>.selectionEnd;
	if (selEnd<?php if($text!="") print("_$text"); ?> == 1 || selEnd<?php if($text!="") print("_$text"); ?> == 2)
		selEnd<?php if($text!="") print("_$text"); ?> = selLength<?php if($text!="") print("_$text"); ?>;

	var s1<?php if($text!="") print("_$text"); ?> = (txtarea<?php if($text!="") print("_$text"); ?>.value).substring(0,selStart<?php if($text!="") print("_$text"); ?>);
	var s2<?php if($text!="") print("_$text"); ?> = (txtarea<?php if($text!="") print("_$text"); ?>.value).substring(selStart<?php if($text!="") print("_$text"); ?>, selEnd<?php if($text!="") print("_$text"); ?>)
	var s3<?php if($text!="") print("_$text"); ?> = (txtarea<?php if($text!="") print("_$text"); ?>.value).substring(selEnd<?php if($text!="") print("_$text"); ?>, selLength<?php if($text!="") print("_$text"); ?>);
	txtarea<?php if($text!="") print("_$text"); ?>.value = s1<?php if($text!="") print("_$text"); ?> + open<?php if($text!="") print("_$text"); ?> + s2<?php if($text!="") print("_$text"); ?> + close<?php if($text!="") print("_$text"); ?> + s3<?php if($text!="") print("_$text"); ?>;
	return;
}
function bbstyle<?php if($text!="") print("_$text"); ?>(bbnumber<?php if($text!="") print("_$text"); ?>) {
	var txtarea<?php if($text!="") print("_$text"); ?> = document.getElementById("post<?php if($text!="") print("_$text"); ?>").contenu;

	donotinsert<?php if($text!="") print("_$text"); ?> = false;
	theSelection<?php if($text!="") print("_$text"); ?> = false;
	bblast<?php if($text!="") print("_$text"); ?> = 0;

	if (bbnumber<?php if($text!="") print("_$text"); ?> == -1) { // Close all open tags & default button names
		while (bbcode<?php if($text!="") print("_$text"); ?>[0]) {
			butnumber<?php if($text!="") print("_$text"); ?> = arraypop<?php if($text!="") print("_$text"); ?>(bbcode<?php if($text!="") print("_$text"); ?>) - 1;
			txtarea<?php if($text!="") print("_$text"); ?>.value += bbtags<?php if($text!="") print("_$text"); ?>[butnumber<?php if($text!="") print("_$text"); ?> + 1];
		}
		imageTag<?php if($text!="") print("_$text"); ?> = false; // All tags are closed including image tags :D
		txtarea<?php if($text!="") print("_$text"); ?>.focus();
		return;
	}

	if ((clientVer<?php if($text!="") print("_$text"); ?> >= 4) && is_ie<?php if($text!="") print("_$text"); ?> && is_win<?php if($text!="") print("_$text"); ?>)
	{
		theSelection<?php if($text!="") print("_$text"); ?> = document.selection.createRange().text; // Get text selection
		if (theSelection<?php if($text!="") print("_$text"); ?>) {
			// Add tags around selection
			document.selection.createRange().text = bbtags<?php if($text!="") print("_$text"); ?>[bbnumber<?php if($text!="") print("_$text"); ?>] + theSelection<?php if($text!="") print("_$text"); ?> + bbtags<?php if($text!="") print("_$text"); ?>[bbnumber<?php if($text!="") print("_$text"); ?>+1];
			txtarea<?php if($text!="") print("_$text"); ?>.focus();
			theSelection<?php if($text!="") print("_$text"); ?> = '';
			return;
		}
	}
	else if (txtarea<?php if($text!="") print("_$text"); ?>.selectionEnd && (txtarea<?php if($text!="") print("_$text"); ?>.selectionEnd - txtarea<?php if($text!="") print("_$text"); ?>.selectionStart > 0))
	{
		mozWrap<?php if($text!="") print("_$text"); ?>(txtarea<?php if($text!="") print("_$text"); ?>, bbtags<?php if($text!="") print("_$text"); ?>[bbnumber<?php if($text!="") print("_$text"); ?>], bbtags<?php if($text!="") print("_$text"); ?>[bbnumber<?php if($text!="") print("_$text"); ?>+1]);
		return;
	}

	// Find last occurance of an open tag the same as the one just clicked
	for (i<?php if($text!="") print("_$text"); ?> = 0; i<?php if($text!="") print("_$text"); ?> < bbcode<?php if($text!="") print("_$text"); ?>.length; i<?php if($text!="") print("_$text"); ?>++) {
		if (bbcode<?php if($text!="") print("_$text"); ?>[i<?php if($text!="") print("_$text"); ?>] == bbnumber<?php if($text!="") print("_$text"); ?>+1) {
			bblast<?php if($text!="") print("_$text"); ?> = i<?php if($text!="") print("_$text"); ?>;
			donotinsert<?php if($text!="") print("_$text"); ?> = true;
		}
	}

	if (donotinsert<?php if($text!="") print("_$text"); ?>) {		// Close all open tags up to the one just clicked & default button names
		while (bbcode<?php if($text!="") print("_$text"); ?>[bblast<?php if($text!="") print("_$text"); ?>]) {
				butnumber<?php if($text!="") print("_$text"); ?> = arraypop<?php if($text!="") print("_$text"); ?>(bbcode<?php if($text!="") print("_$text"); ?>) - 1;
				txtarea<?php if($text!="") print("_$text"); ?>.value += bbtags<?php if($text!="") print("_$text"); ?>[butnumber<?php if($text!="") print("_$text"); ?> + 1];
				imageTag<?php if($text!="") print("_$text"); ?> = false;
			}
			txtarea<?php if($text!="") print("_$text"); ?>.focus();
			return;
	} else { // Open tags

		if (imageTag<?php if($text!="") print("_$text"); ?> && (bbnumber<?php if($text!="") print("_$text"); ?> != 14)) {		// Close image tag before adding another
			txtarea<?php if($text!="") print("_$text"); ?>.value += bbtags<?php if($text!="") print("_$text"); ?>[15];
			lastValue<?php if($text!="") print("_$text"); ?> = arraypop<?php if($text!="") print("_$text"); ?>(bbcode<?php if($text!="") print("_$text"); ?>) - 1;	// Remove the close image tag from the list
			//document.post.addbbcode14.value = "Img";	// Return button back to normal state
			imageTag<?php if($text!="") print("_$text"); ?> = false;
		}

		// Open tag
		txtarea<?php if($text!="") print("_$text"); ?>.value += bbtags<?php if($text!="") print("_$text"); ?>[bbnumber<?php if($text!="") print("_$text"); ?>];
		if ((bbnumber<?php if($text!="") print("_$text"); ?> == 14) && (imageTag<?php if($text!="") print("_$text"); ?> == false)) imageTag<?php if($text!="") print("_$text"); ?> = 1; // Check to stop additional tags after an unclosed image tag
		arraypush<?php if($text!="") print("_$text"); ?>(bbcode<?php if($text!="") print("_$text"); ?>,bbnumber<?php if($text!="") print("_$text"); ?>+1);
		txtarea<?php if($text!="") print("_$text"); ?>.focus();
		return;
	}
	storeCaret<?php if($text!="") print("_$text"); ?>(txtarea<?php if($text!="") print("_$text"); ?>);
}

var imageTag<?php if($text!="") print("_$text"); ?> = false;
var theSelection<?php if($text!="") print("_$text"); ?> = false;
var clientPC<?php if($text!="") print("_$text"); ?> = navigator.userAgent.toLowerCase();
var clientVer<?php if($text!="") print("_$text"); ?> = parseInt(navigator.appVersion);
var is_ie<?php if($text!="") print("_$text"); ?> = ((clientPC<?php if($text!="") print("_$text"); ?>.indexOf("msie") != -1) && (clientPC<?php if($text!="") print("_$text"); ?>.indexOf("opera") == -1));
var is_nav<?php if($text!="") print("_$text"); ?> = ((clientPC<?php if($text!="") print("_$text"); ?>.indexOf('mozilla')!=-1) && (clientPC<?php if($text!="") print("_$text"); ?>.indexOf('spoofer')==-1)
				&& (clientPC<?php if($text!="") print("_$text"); ?>.indexOf('compatible') == -1) && (clientPC<?php if($text!="") print("_$text"); ?>.indexOf('opera')==-1)
				&& (clientPC<?php if($text!="") print("_$text"); ?>.indexOf('webtv')==-1) && (clientPC<?php if($text!="") print("_$text"); ?>.indexOf('hotjava')==-1));
var is_moz<?php if($text!="") print("_$text"); ?> = 0;
var is_win<?php if($text!="") print("_$text"); ?> = ((clientPC<?php if($text!="") print("_$text"); ?>.indexOf("win")!=-1) || (clientPC<?php if($text!="") print("_$text"); ?>.indexOf("16bit") != -1));
var is_mac<?php if($text!="") print("_$text"); ?> = (clientPC<?php if($text!="") print("_$text"); ?>.indexOf("mac")!=-1);
bbcode<?php if($text!="") print("_$text"); ?> = new Array();

imageTag<?php if($text!="") print("_$text"); ?> = false;

bbtags<?php if($text!="") print("_$text"); ?> = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]');
<?php

?>