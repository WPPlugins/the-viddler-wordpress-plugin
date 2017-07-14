/* 
 Insert video short code into Wordpress admin
*/ 

function loadViddlerVideo(vid,playertype,width,height) {

	width +='';
	height +='';
	
	if (width == '' || !width) {
		width = '320';
	}
	if (height == '' || !width) {
		height = '282';
	}
	
	if (playertype=='simple') {
		playerurl = 'http://www.viddler.com/simple/'+vid+'/';
	} else {
		playerurl = 'http://www.viddler.com/player/'+vid+'/';
	}
	
	html = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'+width+'" height="'+height+'" id="viddler"><param name="wmode" value="opaque"><param name="bgcolor" value="#000" /><param name="movie" value="'+playerurl+'" /><param name="allowScriptAccess" value="always" /><param name="wmode" value="transparent" /><param name="flashvars" value="autoplay=t" /><param name="allowFullScreen" value="true" /><embed src="'+playerurl+'" wmode="opaque" bgcolor="#000" width="'+width+'" height="'+height+'" type="application/x-shockwave-flash" allowScriptAccess="always" wmode="transparent" allowFullScreen="true" flashvars="autoplay=t" name="viddler"></embed></object>';
	
	jQuery('#viddlervideo-'+vid).html(html);

}

function playStarted() {
return;
}

function recordDone(u,uvn,vid) {
	sessionid = jQuery('#sessionid').val();
	
	// Legacy Viddler var html = '[viddler id-'+vid+' h-282 w-320]'+"\n";
  
  var html = '[viddler id='+vid+' h=282 w=320]'+"\n"; // To mimic Wordpress.com shortcodes
  
  var gw = jQuery('#viddlergateway').val();
	var m = 'viddler.videos.setDetails';
	var s = 'sessionid='+sessionid+'&video_id='+vid;
	
	jQuery.ajax({
		url: gw,
		type: 'GET',
		data: 'm='+m+'&'+s,
		dataType: 'text',
		timeout: 4000,
		error: function(){
			jQuery('#viddlerrecorder').html('The video was not saved properly. Please try again by clicking Record above.');
		},
		success: function(response){
			if (response == 'success') {
			   jQuery('#viddlerrecorder').html('We\'ve saved your video and added the embed code to your post for you.');
			} else {
				jQuery('#viddlerrecorder').html('Your video was saved, but we couldn\'t make it public. Please log into Viddler and make it public.  If you get this error a lot, please contact Viddler support at viddler.com/help');
			}
		}});
		
		viddlerAddToPost(vid,'320','282');
}

function viddlerAddToPost(vid,w,h,sk) {
	
	// Determine w/h
	if (!w) w = 437;
	if (!h) h = 370;
	
	// Legacy Viddler html = '[viddler id-'+vid+' h-'+h+' w-'+w+']';
	sk = (sk != '') ? ' secret=' + sk : '';
	html = '[viddler id=' + vid + ' h=' + h + ' w=' + w + sk + ']'; // Mimic Wordpress.com
	var win = window.opener ? window.opener : window.dialogArguments;
	if ( !win )
		win = top;
	tinyMCE = win.tinyMCE;
	if ( typeof tinyMCE != 'undefined' && tinyMCE.getInstanceById('content') ) {
		tinyMCE.selectedInstance.getWin().focus();
		tinyMCE.execCommand('mceInsertContent', false, html);
	} else {
		win.edInsertContent(win.edCanvas, html);
	}
	
	// Beta 3 TO DO 
	// Remove the Thickbox window
}


function viddler_insertAtCursor(myField, myValue) {

  //IE support

  if (document.selection) {

    myField.focus();

    sel = document.selection.createRange();

    sel.text = myValue;

  }

  //MOZILLA/NETSCAPE support

  else if (myField.selectionStart || myField.selectionStart == '0') {

    var startPos = myField.selectionStart;

    var endPos = myField.selectionEnd;

    myField.value = myField.value.substring(0, startPos)

                  + myValue

                  + myField.value.substring(endPos, myField.value.length);

  } else {

    myField.value += myValue;

  }

}