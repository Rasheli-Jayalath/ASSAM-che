/*
Written By 
Copyright 2008 Writer
*/

function doSearchProduct(url){

	var frm = document.productSearch;
	var qString = '';
	if(frm.order.value != ''){
		qString += (qString.indexOf('?') == -1) ? '&' : '?';
		qString += 'order=' + frm.order.value;
	}
	
	/*if(frm.perpage.value != ''){
		qString += (qString.indexOf('?') == -1) ? '?' : '&';
		qString += '&perpage=' + frm.perpage.value;
	}*/
	document.location = '?p=reports'+ qString;
}
function doSearchProduct1(url){

	var frm = document.productSearch;
	var qString = '';
	if(frm.order.value != ''){
		qString += (qString.indexOf('?') == -1) ? '&' : '?';
		qString += 'order=' + frm.order.value;
	}
	
	/*if(frm.perpage.value != ''){
		qString += (qString.indexOf('?') == -1) ? '?' : '&';
		qString += '&perpage=' + frm.perpage.value;
	}*/
	document.location = '?p=diamond_reports'+ qString;
}

/* Email validator */
function emailCheck (emailStr){
	/* The following variable tells the rest of the function whether or not
	to verify that the address ends in a two-letter country or well-known
	TLD.  1 means check it, 0 means don't. */

	var checkTLD=1;

	/* The following is the list of known TLDs that an e-mail address must end with. */

	var knownDomsPat=/^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;

	/* The following pattern is used to check if the entered e-mail address
	fits the user@domain format.  It also is used to separate the username
	from the domain. */
	
	var emailPat=/^(.+)@(.+)$/;
	
	/* The following string represents the pattern for matching all special
	characters.  We don't want to allow special characters in the address. 
	These characters include ( ) < > @ , ; : \ " . [ ] */

	var specialChars="\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
	
	/* The following string represents the range of characters allowed in a 
	username or domainname.  It really states which chars aren't allowed.*/
	
	var validChars="\[^\\s" + specialChars + "\]";
	
	/* The following pattern applies if the "user" is a quoted string (in
	which case, there are no rules about which characters are allowed
	and which aren't; anything goes).  E.g. "jiminy cricket"@disney.com
	is a legal e-mail address. */
	
	var quotedUser="(\"[^\"]*\")";

	/* The following pattern applies for domains that are IP addresses,
	rather than symbolic names.  E.g. joe@[123.124.233.4] is a legal
	e-mail address. NOTE: The square brackets are required. */
	
	var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
	
	/* The following string represents an atom (basically a series of non-special characters.) */
	
	var atom=validChars + '+';
	
	/* The following string represents one word in the typical username.
	For example, in john.doe@somewhere.com, john and doe are words.
	Basically, a word is either an atom or quoted string. */
	
	var word="(" + atom + "|" + quotedUser + ")";

	// The following pattern describes the structure of the user
	
	var userPat=new RegExp("^" + word + "(\\." + word + ")*$");
	
	/* The following pattern describes the structure of a normal symbolic
	domain, as opposed to ipDomainPat, shown above. */
	
	var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$");
	
	/* Finally, let's start trying to figure out if the supplied address is valid. */
	
	/* Begin with the coarse pattern to simply break up user@domain into
	different pieces that are easy to analyze. */

	var matchArray=emailStr.match(emailPat);

	if (matchArray==null) {

		/* Too many/few @'s or something; basically, this address doesn't
		even fit the general mould of a valid e-mail address. */
		
		//alert("Email address seems incorrect (check @ and .'s)");
		return false;
	}
	var user=matchArray[1];
	var domain=matchArray[2];

	// Start by checking that only basic ASCII characters are in the strings (0-127).

	for (i=0; i<user.length; i++) {
		if (user.charCodeAt(i)>127) {
			//alert("Ths username contains invalid characters.");
			return false;
		}
	}
	for (i=0; i<domain.length; i++) {
		if (domain.charCodeAt(i)>127) {
			//alert("Ths domain name contains invalid characters.");
			return false;
		}
	}

	// See if "user" is valid 
	
	if (user.match(userPat)==null) {
		
		// user is not valid
	
		//alert("The username doesn't seem to be valid.");
		return false;
	}

	/* if the e-mail address is at an IP address (as opposed to a symbolic
	host name) make sure the IP address is valid. */

	var IPArray=domain.match(ipDomainPat);
	if (IPArray!=null) {
		// this is an IP address
		for (var i=1;i<=4;i++) {
			if (IPArray[i]>255) {
				//alert("Destination IP address is invalid!");
				return false;
			}
		}
		return true;
	}

	// Domain is symbolic name.  Check if it's valid.
 
	var atomPat=new RegExp("^" + atom + "$");
	var domArr=domain.split(".");
	var len=domArr.length;
	for (i=0;i<len;i++) {
		if (domArr[i].search(atomPat)==-1) {
			//alert("The domain name does not seem to be valid.");
			return false;
		}
	}

	/* domain name seems valid, but now make sure that it ends in a
	known top-level domain (like com, edu, gov) or a two-letter word,
	representing country (uk, nl), and that there's a hostname preceding 
	the domain or country. */

	if (checkTLD && domArr[domArr.length-1].length!=2 && 
		domArr[domArr.length-1].search(knownDomsPat)==-1) {
		//alert("The address must end in a well-known domain or two letter " + "country.");
		return false;
	}

	// Make sure there's a host name preceding the domain.
	
	if (len < 2) {
		//alert("This address is missing a hostname!");
		return false;
	}

	// If we've gotten this far, everything's valid!
	return true;
}

function doSwapImage(source, image_name){
	if(image_name){
		var img = document.getElementById('product_large_image');
		var src = document.getElementById(source);
		src.className = 'imgSelected';
		img.src = image_name;
	}
}
function doToggle(ele){
	var obj = document.getElementById(ele);
	if(obj){
		if(obj.style.display == ""){
			obj.style.display = "none";
		}
		else{
			obj.style.display = "";
		}
	}
}

function doEnlarge(page, winName, options){
	window.open(page, winName, options);
}

/*
Checks the given string like elements are given some input or not.
Returns false if any are empty, true otherwise.
*/
function CheckLikeElement(frm, strLike, type){
	var check = false;
	for(var j = 0; j < frm.length; j++){
		var frmElement = frm.elements[j];
		if(frmElement.type == 'checkbox'){
			if(frmElement.name.substring(0, strLike.length) == strLike && frmElement.checked == true){
				check = true;
				break;
			}
		}
		else if(frmElement.type == 'text'){
			if(frmElement.name.substring(0, strLike.length) == strLike && frmElement.value == ""){
				check = true;
				break;
			}
			if(type == "I"){
				if(isNaN(frmElement.value)){
					check = true;
					break;
				}
			}
		}
		else if(frmElement.tagName.toLowerCase() == 'select'){
			if(frmElement.name.substring(0, strLike.length) == strLike && frmElement.value == ""){
				check = true;
				break;
			}
		}
	}
	return check;
}

/* 
Select all and unselect all function
*/
function selectAllUnSelectAll(chkAll, strSelecting, frm){
	if(chkAll.checked == true){
		for(var i = 0; i < frm.elements.length; i++){
			if(frm.elements[i].name == strSelecting){
				frm.elements[i].checked = true;
			}
		}
	}
	else{
		for(var i = 0; i < frm.elements.length; i++){
			if(frm.elements[i].name == strSelecting){
				frm.elements[i].checked = false;
			}
		}
	}
}
/* 
Marks checked the Select All checkbox at the top if all teh check boxes are selected.
*/
function seeAllChecked(frm, strSelecting,checkall){
	var checked = true;
	for(var i = 0; i < frm.elements.length; i++){
		if(frm.elements[i].name == strSelecting){
			if(frm.elements[i].checked != true){
				checked = false;
				break;
			}
		}
	}
	if(checked == true){
		checkall.checked = true;
	}
	else{
		checkall.checked = false;
	}
}
/* 
Checks whether any of the checkbox in the list has been selected or not.
Returns false if none are selected, true otherwise.
*/
function isChecked(frm, object_string){
	
	var flag 	= false;
	for(var i = 0; i < frm.length; i++){
		var ele = frm.elements[i];
		if(ele.name.substring(0, object_string.length) == object_string && ele.checked == true){
			flag = true;
			break;
		}
	}
	return flag;
}

function doAddTr(arrTds, tblName){
	var tbl = document.getElementById(tblName);
	if(arrTds.length >= 1 && tbl){
		var tr = document.createElement('tr');
		for(var i = 0; i < arrTds.length; i++){
			var td = document.createElement('td');
			td.innerHTML = arrTds[i];
			tr.appendChild(td);
		}
		tbl.appendChild(tr);
	}
}
// function to delete the tr
function doRmTr(obj,itemid){
	var parent_td 	= obj.parentNode;
	var parent_tr 	= parent_td.parentNode;
	if(parent_tr){
		var divas 	= parent_tr.parentNode;
		divas.removeChild(parent_tr);
		document.getElementById("addnew"+itemid).style.display="block";
	}
}
/* Ajax Confirmatoin */
function doAjaxConfirm(url, msg, divContent, divLoading){
	if(confirm(msg)){
		sendGetRequest(url, divContent, divLoading);
	}
	else{
		return false;
	}
}

/* Do normal confirmatoin */
function doConfirm(msg){
	if(confirm(msg)){
		return true;	
	}
	else{
		return false;
	}
}

/* Jump to the specified URL */
function jumpURL(url){
	if(url){
		document.location = url;	
	}
}
/* **************** Unused functions **************************** */
/********** General/Common functions *************/
function createGenericElement(obj, eleName, innerText){
	var curleft = getLeft(obj);
	var curtop = getTop(obj);
	var myBody = document.getElementByTag('body');
	var newEle = document.createElement('div');
	newEle.id = eleName;
	newEle.style.position = 'absolute';
	newEle.style.left = curleft;
	newEle.style.top = curtop;
	myBody.appendChild(newEle);
}
/* 
* This function is used to get the left offset 
* position of a particular object
*/
function getLeft(obj){
	var curLeft = 0;
	if (obj.offsetParent) {
		curleft = obj.offsetLeft
		while (obj = obj.offsetParent) {
			curleft += obj.offsetLeft
		}
	}
	return curleft;
}
/* 
* This function is used to get the top offset 
* position of a particular object
*/
function getTop(obj){
	var curtop = 0;
	if (obj.offsetParent) {
		curtop = obj.offsetTop
		while (obj = obj.offsetParent) {
			curtop += obj.offsetTop
		}
	}
	return curtop;
}