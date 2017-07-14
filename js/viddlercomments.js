$v=jQuery.noConflict();

$v(document).ready(function() {

 	viddler_loginform = '<ul class="fbnavigation"><li class="active">Login</li><li>Record</li><li>Choose</li></ul><h2>Log into Viddler</h2><p>Please enter your username and password.</p><form onsubmit="viddlerSignin(); return false;" method="post" name="viddlerloginform" id="viddlerloginform"><input type="text" name="viddleruser" size="15" onfocus="if (this.value == \'Username\') {this.value = \'\';}" id="viddleruser" value="Username" /> <input size="15" type="password" name="viddlerpass" id="viddlerpass" /> <input type="submit" value=" Log in " /></form><ul class="signup"><li>Need an account? <a href="#register" onclick="viddler_register();">Sign up <em>right here!</em></a></li></ul>';
 	
 	viddler_registerform = '<ul class="fbnavigation"><li><a href="#login" onclick="viddler_login();">Login</a></li><li>Record</li><li>Choose</li></ul><h2>Create an account</h2><p>All fields are required. This will just take a minute.</p><form onsubmit="viddlercompleteregistration(); return false;" method="post" id="viddlerregisterform" name="viddlerregisterform"><p><label for="user">Username:</label> <input type="text" name="user" id="user" /></p><p><label for="password">Password:</label> <input type="password" name="password" id="password" /></p><p><label for="password2">Retype:</label> <input type="password" name="password2" id="password2" /></p><p><label for="emaila">Email:</label> <input type="text" name="emaila" id="emaila" /></p><p><label for="fname">First Name:</label> <input type="text" name="fname" id="fname" /></p><p><label for="lname">Last Name:</label> <input type="text" name="lname" id="lname" /></p><p class="registerbutton"><input type="submit" value=" Register " /></p></form><p><small>By submitting this form you are accepting the <a href="http://www.viddler.com/terms-of-use/" target="_blank">terms of use</a>.</small></p><p><small>Viddler cares about your privacy. We will not, under any circumstances, give your contact information to any third party.</small></p>';
	
	// Hide divs
	$v('#viddlerdiv').hide();
	
	// Wait for Facebox
	$v('a[rel*=facebox]').click(function(e) {
		e.preventDefault();
		
		viddlerSignin();
		
		var sessionid = get_cookie('viddlersessionid');
		var u = get_cookie('viddlerusername');
		
		if (sessionid) { // Logged in already
			$v.facebox(function() {
			var html = '<ul class="fbnavigation"><li><a class="logout" href="#logout" onclick="viddler_logout();">Logout</a></li><li><a href="#record" onclick="viddler_loadrecorder(\''+sessionid+'\');">Record</a></li><li><a href="#viddlerchoose" onclick="viddler_loadvideos(\''+sessionid+'\',\''+u+'\');">Choose</a></li></ul><h2>Logged in</h2><p>Congratulations! <strong>You\'re logged in.</strong> <p>You may now <a href="#viddleroptions" onclick="viddler_loadrecorder(\''+sessionid+'\');">record a video</a> comment with your webcam or <a href="#viddlerchoose" onclick="viddler_loadvideos(\''+sessionid+'\',\''+u+'\');">choose a video</a> that you\'ve already uploaded to Viddler.</p>';
			
			$v.facebox(html)});
		} else { // Needs to log in or sign up
			$v.facebox(function() {
			var html = viddler_loginform;
			$v.facebox(html)});
		}
	});
	
	$v('a[rel*=reload]').facebox(function(){
		$v("#viddlerdiv").text('Change.');
	});
	
	$v('a[rel*=viddlervideo]').facebox();
	
});


function viddler_login() {
	var html = viddler_loginform;
	$v('#facebox .content').html(html);
}

function viddlerSignin() { 

//fbload('start');
var u = $v('#viddleruser').val();
var p = $v('#viddlerpass').val();

var m = 'viddler.users.auth'
var a = 'u='+u+'&p='+p+'&admin=N';
var gw = $v('#viddlergateway').val()+'viddlergateway.php';

$v.ajax({
    url: gw,
    type: 'GET',
    data: 'm='+m+'&'+a,
    dataType: 'text',
    timeout: 2000,
    error: function(){
    	$v('#facebox .content').html(viddler_loginform+'<p class="error">There was an error logging you in, unrelated to your login information.  Sorry.  Try again.</p>');
    },
    success: function(sessionid){
    	if (sessionid != 'error') {
			// Set cookie
			var viddlercommentscookiedate = new Date();
			var viddlerexpdate = viddlercommentscookiedate.getTime();
			viddlerexpdate += 600*1000; //expires soon (milliseconds) 
			viddlercommentscookiedate.setTime(viddlerexpdate);
			document.cookie = "viddlersessionid="+sessionid+";expires=" + viddlercommentscookiedate.toGMTString();
			document.cookie = "viddlerusername="+u+";expires=" + viddlercommentscookiedate.toGMTString();
			document.cookie = "viddlerpassword="+p+";expires=" + viddlercommentscookiedate.toGMTString();
			
			if (!u || u == 'undefined') {
				viddler_loadrecorder(sessionid);
			} else {
			
		   		$v('#facebox .content').html('<ul class="fbnavigation"><li><a class="logout" href="#logout" onclick="viddler_logout();">Logout</a></li><li><a href="#record" onclick="viddler_loadrecorder(\''+sessionid+'\');">Record</a></li><li><a href="#viddlerchoose" onclick="viddler_loadvideos(\''+sessionid+'\',\''+u+'\');">Choose</a></li></ul><h2>Logged in</h2><p>Congratulations! <strong>You\'re logged in.</strong></p><p>You may now <a href="#viddleroptions" onclick="viddler_loadrecorder(\''+sessionid+'\');">record a video</a> comment with your webcam or <a href="#viddlerchoose" onclick="viddler_loadvideos(\''+sessionid+'\',\''+u+'\');">choose a video</a> that you\'ve already uploaded to Viddler.</p>');
		   
		   }
		  } else {
		  	// Login failed
		  	$v('#facebox .content').html(viddler_loginform+'<p class="error">Username and/or password incorrect.</p>');
		  }
       
    }});

}

function viddler_logout() {
		var sessionid = get_cookie('viddlersessionid');
		var username = get_cookie('viddlerusername');
		var password = get_cookie('viddlerpassword');
	
		// Set cookie
    	var viddlercommentscookiedate = new Date();
		var viddlerexpdate = viddlercommentscookiedate.getTime();
		viddlerexpdate -= 3600*1000; // Expires NOW! 
		viddlercommentscookiedate.setTime(viddlerexpdate);
		document.cookie = "viddlersessionid="+sessionid+";expires=" + viddlercommentscookiedate.toGMTString();
		document.cookie = "viddlerusername="+username+";expires=" + viddlercommentscookiedate.toGMTString();
		document.cookie = "viddlerpassword="+password+";expires=" + viddlercommentscookiedate.toGMTString();
		
		$v('#facebox .content').html('<ul class="fbnavigation"><li><a href="#login" onclick="viddler_login();">Login</a></li><li>Record</li><li>Choose</li></ul><h2>Logged out</h2><p>You\'ve been logged out of the Viddler video commenting plugin.  You can log in again, or just close the window.</p>');
}

function viddler_register() {
	var html = viddler_registerform;
	$v('#facebox .content').html(html);

}

function viddlercompleteregistration() {
	var username = $v('#user').val();
	var password = $v('#password').val();
	var password2 = $v('#password2').val();
	var fname = $v('#fname').val();
	var lname = $v('#lname').val();
	var emaila = $v('#emaila').val();
	
	if (username == '' || password == '' || password2 == '' || fname == '' || lname == '' || emaila == '') {
		$v('#facebox .content').append('<p class="error">Please fill in all fields. '+username+' '+password+' '+password2+' '+fname+' '+lname+' '+emaila+'</p>');
		return;
	}
	
	if (password != password2) {
		$v('#facebox .content').append('<p class="error">Passwords do not match.</p>');
		return;
	}
	
	// Register the user
	var m = 'viddler.users.register'
	var a = 'u='+username+'&p='+password+'&fname='+fname+'&lname='+lname+'&email='+emaila;
	var gw = $v('#viddlergateway').val()+'viddlergateway.php';

$v.ajax({
    url: gw,
    type: 'GET',
    data: 'm='+m+'&'+a,
    dataType: 'text',
    timeout: 2500,
    error: function(){
    	$v('#facebox .content').html('<h2>Sorry</h2>User registration failed.  This shouldn\'t happen, so we appologize now.  Contact cdevroe[at]viddler.com and ask for help.');
    },
    success: function(userresponse){
    	if (userresponse != 'error' && userresponse != 'error username' && userresponse != 'error email') {
    		var html = viddler_loginform;
			$v('#facebox .content').html(html);
			$v('#viddleruser').val(userresponse);
		  } else {
		  	if (userresponse == 'error username') {
		  		errortext = 'This username is already is already in use. Please login or sign up with a different username.';
		  		$v('#facebox .content').append('<p class="error">'+errortext+'</p>');
		  	}
		  	if (userresponse == 'error email') {
		  		var html = viddler_loginform;
				$v('#facebox .content').html(html);
				$v('#viddleruser').val(username);
		  			errortext = 'It seems you\'re already signed up.  Please try logging in.';
		  			$('#facebox .content').append('<p class="error">'+errortext+'</p>');		  	
		  	}
		  	if (userresponse == 'error') {
		  		$v('#facebox .content').append('<p class="error">There has been an error.</p>');
		  	}
		  }
       
    }});
return;
}

function viddler_loadrecorder(sessionid) {
	var gw = $v('#viddlergateway').val()+'viddlergateway.php';
	var m = 'viddler.videos.getRecordToken';
	var u = get_cookie('viddlerusername');
	
	$v.ajax({
		url: gw,
		type: 'GET',
		data: 'm='+m+'&s='+sessionid+'&admin=N',
		dataType: 'text',
		timeout: 2500,
		error: function(){
			$v('#facebox .content').html('Recorder not available. Please try again.');
		},
		success: function(token){			
		   $v('#facebox .content').html('<ul class="fbnavigation"><li><a class="logout" href="#logout" onclick="viddler_logout();">Logout</a></li><li class="active">Record</li><li><a href="#viddlerchoose" onclick="viddler_loadvideos(\''+sessionid+'\',\''+u+'\');">Choose</a></li></ul><h2>Record your comment!</h2><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="449" height="380" id="viddler_recorder" align="middle"><param name="allowScriptAccess" value="always" /><param name="allowNetworking" value="all" /><param name="movie" value="http://static.cdn-ec.viddler.com/flash/recorder.swf" /><param name="quality" value="high" /><param name="scale" value="noScale"><param name="bgcolor" value="#000000" /><param name="flashvars" value="fake=1&recQuality=M&recordToken='+token+'" /><embed src="http://static.cdn-ec.viddler.com/flash/recorder.swf" quality="high" scale="noScale" bgcolor="#000000" allowScriptAccess="always" allowNetworking="all" width="449" height="380" name="viddler_recorder" flashvars="fake=1&recQuality=M&recordToken='+token+'" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object><p><strong>Note:</strong>This video will automatically be made public to view once recorded. When you\'re done recording, we\'ll pop the appropriate code into the comment box on the page.</p>');
		}});
	
	
}

function viddler_loadvideos(sessionid,u,p) {
	if (!p || p == '') {
		p = 1;
	}
	var gw = $v('#viddlergateway').val()+'viddlergateway.php';
	var m = 'viddler.videos.getByUser';
	var s = 'sessionid='+sessionid+'&u='+u+'&page='+p;
	var u = get_cookie('viddlerusername');
	
	$v.ajax({
		url: gw,
		type: 'GET',
		data: 'm='+m+'&'+s,
		dataType: 'text',
		timeout: 2500,
		error: function(){
			$v('#facebox .content').html('Your videos are unavailable. Please try again.');
		},
		success: function(htmllist){			
		   $v('#facebox .content').html('<ul class="fbnavigation"><li><a class="logout" href="#logout" onclick="viddler_logout();">Logout</a></li><li><a href="#record" onclick="viddler_loadrecorder(\''+sessionid+'\');">Record</a></li><li class="active">Choose</li></ul><h2>Your latest videos</h2><p>You may select any of your <i>public</i> videos. Here are your most recent <i>nine</i>.  You may jump to the next set below.</p>'+htmllist);
		}});
	
	
}

function viddler_addtocomment(vid) {

	var textareaboxid = $v('#viddlercommentpost').val();
	
	var thecomment = $v('#'+textareaboxid).val();
	
	if (textareaboxid == 'content') {
	
		viddler_insertAtCursor(document.post.content,'[viddler id-'+vid+' h-370 w-437]');
	
		//$v('#'+textareaboxid).val(thecomment+'\n'+'[viddler_video='+vid+',437,370]');
	} else {
		$v('#'+textareaboxid).val(thecomment+'\n'+'[viddler id-'+vid+']');
	}
	
	$v('#videoselect-'+vid).addClass('active');
	
}

function recordDone(u,uvn,vid) {
	sessionid = get_cookie('viddlersessionid');
	u = get_cookie('viddlerusername');

  	var html = '[viddler id-'+vid+']'+"\n";
  	
  	var textareaboxid = $v('#viddlercommentpost').val();
  	
  	var commentsofar = $v('#'+textareaboxid).val();
  	var csf = commentsofar;
  	$v('#'+textareaboxid).val(csf+"\n"+html);
  	
  	var earl = $v('#viddlerposturl').val();
  	var posttitle = $v('#viddlerposttitle').val();
  	var customtags = $v('#viddlercustomtags').val();
  	
  	var gw = $v('#viddlergateway').val()+'viddlergateway.php';
	var m = 'viddler.videos.setDetails';
	var s = 'sessionid='+sessionid+'&video_id='+vid+'&earl='+earl+'&posttitle='+posttitle+'&customtags='+customtags+'&admin=N';
	
	$v.ajax({
		url: gw,
		type: 'GET',
		data: 'm='+m+'&'+s,
		dataType: 'text',
		timeout: 8200,
		error: function(){
			$v('#facebox .content').html('The video was not saved properly. Please try again.');
		},
		success: function(response){
			if (response == 'success') {
			   $v('#facebox .content').html('<ul class="fbnavigation"><li><a class="logout" href="#logout" onclick="viddler_logout();">Logout</a></li><li><a href="#record" onclick="viddler_loadrecorder(\''+sessionid+'\');">Record</a></li><li><a href="#viddlerchoose" onclick="viddler_loadvideos(\''+sessionid+'\',\''+u+'\');">Choose</a></li></ul><h2>Video saved!</h2><p>Your video has been stored in the text box.  You may now close this window, or choose or record another video.  Thanks for commenting!</p>');
			} else {
				$v('#facebox .content').html('<ul class="fbnavigation"><li><a class="logout" href="#logout" onclick="viddler_logout();">Logout</a></li><li><a href="#record" onclick="viddler_loadrecorder(\''+sessionid+'\');">Record</a></li><li><a href="#viddlerchoose" onclick="viddler_loadvideos(\''+sessionid+'\',\''+u+'\');">Choose</a></li></ul><h2>Comment private?</h2><p>Your video may have been saved as private.  Please log into Viddler.com to check it.</p>');
			}
		}});
  	
  	
}

function loadViddlerVideo(rn,vid,playertype,width,height) {

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
	
	html = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'+width+'" height="'+height+'" id="viddler"><param name="wmode" value="opaque"><param name="bgcolor" value="#000" /><param name="movie" value="'+playerurl+'" /><param name="allowScriptAccess" value="always" /><param name="flashvars" value="autoplay=t" /><param name="allowFullScreen" value="true" /><embed src="'+playerurl+'" wmode="opaque" bgcolor="#000" width="'+width+'" height="'+height+'" type="application/x-shockwave-flash" allowScriptAccess="always" allowFullScreen="true" flashvars="autoplay=t" name="viddler"></embed></object>';
	
	$v('#viddlervideo-'+rn+'-'+vid).html(html);

}

function get_cookie (cookie_name) {
  var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );

  if ( results )
    return ( unescape ( results[2] ) );
  else
    return null;
}

function viddler_fbload(l) {
	if (l == 'start') {
		$v('#facebox .content').empty();
		$v('#facebox .body').children().hide().end().append('<div class="loading"><img src="'+$v.facebox.settings.loading_image+'"/></div>');
	} else {
	// Stop
		$v('#facebox .content').empty();
	}
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

// Only used to supress Firebug errors
function playStarted() {
return;
}