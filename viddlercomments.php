<?php
/*
Plugin Name: Viddler Wordpress plugin
Plugin URI: http://wordpress.org/extend/plugins/the-viddler-wordpress-plugin/
Description: Video commenting and publishing made easy. Power your blog with Viddler using this plugin to easily publish videos within your posts and pages as well as enable video commenting!
Author: Jeff Johns
Version: 1.5.3
Author URI: http://www.viddler.com
*/

// Load optional configuration options / securely
include('viddlerconfig.php');


// DO NOT EDIT
// Load configuration options
if (!get_option('viddler_player_type_comments')) {
	$viddler_player_type_comments = 'simple';
} else {
	$viddler_player_type_comments = get_option('viddler_player_type_comments');
}

if (!get_option('viddler_player_type_posts')) {
	$viddler_player_type_posts = 'player';
} else {
	$viddler_player_type_posts = get_option('viddler_player_type_posts');
}

if (!get_option('viddler_comment_box_id')) {
	$viddler_comment_box_id = 'comment';
} else {
	$viddler_comment_box_id = get_option('viddler_comment_box_id');
}

if (!get_option('viddler_embed_swapper')) {
	$viddler_embed_swapper= 'true';
} else {
	$viddler_embed_swapper = get_option('viddler_embed_swapper');
}

if (!get_option('viddler_default_link')) {
	$viddler_default_link= 'true';
} else {
	$viddler_default_link = get_option('viddler_default_link');
}

if (!get_option('viddler_download_source')) {
	$viddler_download_source = 'false'; // Change to false
} else {
	$viddler_download_source = get_option('viddler_download_source');
}

if (!get_option('viddler_button_text')) {
	$viddler_button_text = 'Record or choose a video?';
} else {
	$viddler_button_text = get_option('viddler_button_text');
}

if (!get_option('viddler_custom_tags')) {
	$viddler_custom_tags = '';
} else {
	$viddler_custom_tags = get_option('viddler_custom_tags');
}

if (!get_option('viddler_show_widget')) {
	$viddler_show_widget= 'false';
} else {
	$viddler_show_widget = get_option('viddler_show_widget');
}

if (!get_option('viddler_allow_login')) {
	$viddler_allow_login= 'true';
} else {
	$viddler_allow_login = get_option('viddler_allow_login');
}


function viddler_edit_commentform($post) {

	global $viddler_player_type_comments, $viddler_comment_box_id, $viddler_button_text, $viddler_custom_tags;
	
	$v = '<div id="videocomment">'."\n";
		// Record a video link?
		$v .= '<input type="hidden" id="viddlergateway" name="viddlergateway" value="'.get_bloginfo('wpurl').'/wp-content/plugins/the-viddler-wordpress-plugin/" /><input type="hidden" id="viddlerposttitle" name="viddlerposttitle" value="'.the_title('','',false).'" /><input type="hidden" id="viddlerposturl" name="viddlerposturl" value="'.get_permalink().'" /><input type="hidden" id="viddlercommentpost" name="viddlercommentpost" value="'.$viddler_comment_box_id.'" /><input type="hidden" id="viddlercustomtags" name="viddlercustomtags" value="'.$viddler_custom_tags.'" /><input type="hidden" id="viddlerplayertype" name="viddlerplayertype" value="'.$viddler_player_type_comments.'" /><a href="#viddler" rel="facebox">'.$viddler_button_text.'</a>'."\n";
		
	$v .= '</div>'."\n";
	
	echo $v;
}

function viddler_recordlink($text='') {

	global $viddler_player_type_comments, $viddler_comment_box_id, $viddler_button_text, $viddler_custom_tags,$viddler_yourusername,$viddler_yourpasswd;
	
	if (!$text || $text == '') {
		$text = $viddler_button_text;
	}
	
	if (is_numeric($text)) {
		$text = $viddler_button_text;
	}
	
	$v = '<div id="videocomment">'."\n";
		// Record a video link?
		$v .= '<input type="hidden" id="viddlergateway" name="viddlergateway" value="'.get_bloginfo('wpurl').'/wp-content/plugins/the-viddler-wordpress-plugin/" /><input type="hidden" id="viddlerposttitle" name="viddlerposttitle" value="'.the_title('','',false).'" /><input type="hidden" id="viddlerposturl" name="viddlerposturl" value="'.get_permalink().'" /><input type="hidden" id="viddlercommentpost" name="viddlercommentpost" value="'.$viddler_comment_box_id.'" /><input type="hidden" id="viddlercustomtags" name="viddlercustomtags" value="'.$viddler_custom_tags.'" /><input type="hidden" id="viddlerplayertype" name="viddlerplayertype" value="'.$viddler_player_type_comments.'" /><a href="#viddler" rel="facebox">'.$text.'</a>'."\n";
		
	$v .= '</div>'."\n";
	
	echo $v;


}

function viddler_add_editform($post) {

	global $viddler_player_type_posts, $viddler_comment_box_id;
	
	$v = '<div id="videopost">'."\n";
		// Record a video link?
		$v .= '<input type="hidden" id="viddlergateway" name="viddlergateway" value="'.get_bloginfo('wpurl').'/wp-content/plugins/the-viddler-wordpress-plugin/" /><input type="hidden" id="viddlercommentpost" name="viddlercommentpost" value="content" /><input type="hidden" id="viddlerplayertype" name="viddlerplayertype" value="'.$viddler_player_type_posts.'" /><a href="#viddler" rel="facebox">Add a video to your post?</a> - <i>Note:</i> This will not work with the Visual Editor.'."\n";
		
	$v .= '</div>'."\n";
	
	echo $v;
}

// Javascript
function viddler_add_js() {
	$pluginurl = get_bloginfo('wpurl').'/wp-content/plugins/the-viddler-wordpress-plugin/';

	//$jQuery = $pluginurl.'js/jquery.js';
	$js = $pluginurl.'js/viddlercomments.js';
	$faceboxCSS = $pluginurl.'js/facebox/facebox.css';
	$faceboxJS = $pluginurl.'js/facebox/facebox.js';
	
	//echo "\n".'<script src="'.$jQuery.'" type="text/javascript"></script>'."\n";
	wp_enqueue_script( 'jquery' ); // Submitted by Joshua Strebel of Page.ly
	echo "\n".'<script src="'.$js.'" type="text/javascript"></script>'."\n";
	echo "\n".'<link href="'.$faceboxCSS.'" media="screen" rel="stylesheet" type="text/css"/>'."\n";
	echo "\n".'<script src="'.$faceboxJS.'" type="text/javascript"></script>'."\n";
}

// Embed Code Swapper JS
function viddler_js_embed_swapper() {
  echo '<script type="text/javascript" src="http://cdn-static.viddler.com/js/replacer.js"> </script>';
}

function viddler_embedcomment($comment) {

	global $viddler_player_type_comments,$post;

	$rn = rand(0,100000);	
	$theurl = $post->guid;

	// Find rel attributes
	$newpatterns[0] = '/\\[viddler id-(.*?)\\]/';
	
	// Add classes based on rel attributes
	$replacements[0] = '<div id="viddlervideo-'.$rn.'-\1" class="viddlercomment"><p><a href="'.$theurl.'#viddlercomment-'.$rn.'-\1" onclick="loadViddlerVideo(\''.$rn.'\',\'\1\',\''.$viddler_player_type_comments.'\',\'\',\'\'); return false;" title="Click to play this video."><img src="http://cdn-thumbs.viddler.com/thumbnail_1_\1.jpg" alt="Video thumbnail." /></a></p><p><a href="'.$theurl.'#viddlercomment-'.$rn.'-\1" onclick="loadViddlerVideo(\''.$rn.'\',\'\1\',\''.$viddler_player_type_comments.'\',\'\',\'\'); return false;">Click to play this video.</a></p></div>';
	
	// Regular expression replace
	$comment = preg_replace($newpatterns, $replacements, $comment);

	return $comment;
}

function viddler_embedpost($content) {

	global $viddler_player_type_posts, $viddler_download_source;

	$rn = rand(0,100000); // Random number
	$theurl = $post->guid; // The post URL

	preg_match('/\\[viddler id-(.*?) h-(.*?) w-(.*?)\\]/',$content,$newmatches);
	
  $newpatterns[0] = '/\\[viddler id-(.*?) h-(.*?) w-(.*?)\\]/';
		
  //LEGACY$newreplacements[0] = '<div id="viddlervideo-'.$rn.'-\1" class="viddlervideo"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="\3" height="\2" id="viddler_\1"><param name="movie" value="http://www.viddler.com/'.$viddler_player_type_posts.'/\1/" /><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="true" /><embed src="http://www.viddler.com/'.$viddler_player_type_posts.'/\1/" width="\3" height="\2" type="application/x-shockwave-flash" allowScriptAccess="always" allowFullScreen="true" name="viddler_\1" ></embed></object>';
  
  // New in 1.4.1 iFrame
  $newreplacements[0] = '<div id="viddlervideo-'.$rn.'-\1" class="viddlervideo"><iframe frameborder="0" width="\3" height="\2" src="http://www.viddler.com/embed/\1/?player='.$viddler_player_type_posts.'&amp;wmode=transparent"></iframe>';
  
  if ($viddler_download_source == 'true') {
    // Determine the video_id
    // Call the API for both the URL and the size of the file to be downloaded
    // Cache this call?
    
    // New instance of Viddler class.
    include('phpviddler/phpviddler.php');
	  $v = new Viddler_V2('0118093f713643444556524f452f');
    $videoDetails = $v->viddler_videos_getDetails(array('video_id'=>$newmatches[1]));
        
    $newreplacements[0] .= '<p>[<a href="'.$videoDetails['video']['files'][0]['url'].'">download this video ('.ByteSize($videoDetails['video']['files'][0]['size']).')</a>]</p>';
  }
  
  $newreplacements[0] .= '</div>';
		
  $content = preg_replace($newpatterns, $newreplacements, $content);

	return $content;
}

function ByteSize($bytes)  
    { 
    $size = $bytes / 1024; 
    if($size < 1024) 
        { 
        $size = number_format($size, 2); 
        $size .= ' KB'; 
        }  
    else  
        { 
        if($size / 1024 < 1024)  
            { 
            $size = number_format($size / 1024, 2); 
            $size .= ' MB'; 
            }  
        else if ($size / 1024 / 1024 < 1024)   
            { 
            $size = number_format($size / 1024 / 1024, 2); 
            $size .= ' GB'; 
            }  
        } 
    return $size; 
    }

// Add to admin menu
function viddler_config_page() {
	if ( function_exists('add_submenu_page') )
		add_submenu_page('options-general.php', __('Viddler'), __('Viddler'), 'manage_options', 'viddler-comments-config', 'viddler_comments_config');
	
}

// Admin page
function viddler_comments_config() {

	global $viddler_username;
	
	?>
	<?php if (isset($_POST['submit'])) {
		// Update all options
		update_option('viddler_player_type_comments', $_POST['viddler_player_type_comments']);
		update_option('viddler_player_type_posts', $_POST['viddler_player_type_posts']);
		update_option('viddler_player_width', $_POST['viddler_player_width']);
		update_option('viddler_download_source', $_POST['viddler_download_source']);
		update_option('viddler_embed_swapper', $_POST['viddler_embed_swapper']);
		update_option('viddler_comment_box_id', $_POST['viddler_comment_box_id']);
		update_option('viddler_button_text', $_POST['viddler_button_text']);
		update_option('viddler_default_link', $_POST['viddler_default_link']);
		update_option('viddler_custom_tags', $_POST['viddler_custom_tags']);	
		update_option('viddler_yourusername', $_POST['viddler_yourusername']);
		update_option('viddler_yourpassword', $_POST['viddler_yourpassword']);
		update_option('viddler_show_widget', $_POST['viddler_show_widget']);
		update_option('viddler_allow_login', $_POST['viddler_allow_login']);
		} ?>
		
	<?php if ( !empty($_POST ) ) : ?>
		<div id="message" class="updated fade"><p><strong><?php _e('Options saved.') ?></strong></p></div>
	<?php endif; ?>
	<div class="wrap">
		<h2>The Viddler Wordpress Plugin Options</h2>
		<p class="adminpoweredby" style="float: right;"><a class="poweredby" href="http://viddler.com/" title="Powered by Viddler"><img src="http://static.cdn-ec.viddler.com/wp-plugin/v1/images/pwviddler.png" /></a></p>
		
		<div class="narrow viddlernarrow">
		<form action="" method="post" id="viddler-conf" style="margin: auto; width: 400px; ">

<h3>Post videos options</h3>
			<p><label for="viddler_player_type_posts">Posts player:</label>
			<select id="viddler_player_type_posts" name="viddler_player_type_posts">
			<option value="player" <?php if (get_option('viddler_player_type_posts') == 'player' || !get_option('viddler_player_type_posts')) { echo 'selected'; } ?>>Default player</option>
				<option value="simple" <?php if (get_option('viddler_player_type_posts') == 'simple') { echo 'selected'; } ?>>Simple player</option>
				<option value="mini" <?php if (get_option('viddler_player_type_posts') == 'mini') { echo 'selected'; } ?>>Mini player</option>
			</select> (<?php _e('<a href="#viddlerfaq-postsplayer">?</a>'); ?>)</p>
			
			<p><label for="viddler_player_width">Default width (in pixels):</label> <input type="text" name="viddler_player_width" id="viddler_player_width" size="6" value="<?php if (!get_option('viddler_player_width')) { echo '437'; } else { echo get_option('viddler_player_width'); } ?>" /> (<?php _e('<a href="#viddlerfaq-playerwidth">?</a>'); ?>)</p>
			
			<p><label for="viddler_download_source">Show link to download source?:</label>
			<select id="viddler_download_source" name="viddler_download_source">
			  <option value="false" <?php if (get_option('viddler_download_source') == 'false' || !get_option('viddler_download_source')) { echo 'selected'; } ?>>No.</option>
				<option value="true" <?php if (get_option('viddler_download_source') == 'true') { echo 'selected'; } ?>>Yes.</option>
			</select> (<?php _e('<a href="#viddlerfaq-downloadsource">?</a>'); ?>)</p>
			
			<p><label for="viddler_embed_swapper">Turn on old-embed swapper?:</label>
			<select id="viddler_embed_swapper" name="viddler_embed_swapper">
			  <option value="false" <?php if (get_option('viddler_embed_swapper') == 'false' || !get_option('viddler_embed_swapper')) { echo 'selected'; } ?>>No.</option>
				<option value="true" <?php if (get_option('viddler_embed_swapper') == 'true') { echo 'selected'; } ?>>Yes.</option>
			</select> (<?php _e('<a href="#viddlerfaq-embedswapper">?</a>'); ?>)</p>

<h3>Comment videos options</h3>
      <p><label for="viddler_default_link">Turn video comments on?:</label>
			<select id="viddler_default_link" name="viddler_default_link">
				<option value="true" <?php if (get_option('viddler_default_link') == 'true' || !get_option('viddler_default_link')) { echo 'selected'; } ?>>Yes, please.</option>
				<option value="false" <?php if (get_option('viddler_default_link') == 'false') { echo 'selected'; } ?>>No, leave them off.</option>
			</select> (<?php _e('<a href="#viddlerfaq-autocreatebutton">?</a>'); ?>)</p>
			<p><label for="viddler_allow_login">Force commenters to use your Viddler account?</label>
			<select id="viddler_allow_login" name="viddler_allow_login">
				<option value="true" <?php if (get_option('viddler_allow_login') == 'true' || !get_option('viddler_allow_login')) { echo 'selected'; } ?>>No, they can use their Viddler account.</option>
				<option value="false" <?php if (get_option('viddler_allow_login') == 'false') { echo 'selected'; } ?>>Yes, store all comments in my Viddler account.</option>
			</select> (<?php _e('<a href="#viddlerfaq-allowlogin">?</a>'); ?>)<br />
			<?php if (get_option('viddler_allow_login') == 'false') { 
			if ($viddler_username == '') {
			
			echo $viddler_username;  ?>
			<span style="color: red;">Important: You must edit viddlerconfig.php in wp-content/plugins/the-viddler-wordpress-plugin/ and add your Viddler password.</span><?php } } ?></p>

			<p><label for="viddler_player_type_comments">Comments player:</label>
			<select id="viddler_player_type_comments" name="viddler_player_type_comments">
				<option value="simple" <?php if (get_option('viddler_player_type_comments') == 'simple' || !get_option('viddler_player_type_comments')) { echo 'selected'; } ?>>Simple player</option>
				<option value="player" <?php if (get_option('viddler_player_type_comments') == 'player') { echo 'selected'; } ?>>Default player</option>
			</select> (<?php _e('<a href="#viddlerfaq-commentsplayer">?</a>'); ?>)</p>
			
			<p><label for="viddler_button_text">Button text:</label> <input type="text" name="viddler_button_text" id="viddler_button_text" size="25" value="<?php if (!get_option('viddler_button_text')) { echo 'Leave a video comment?'; } else { echo get_option('viddler_button_text'); } ?>" /> (<?php _e('<a href="#viddlerfaq-buttontext">?</a>'); ?>)</p>
			
			<p><label for="viddler_comment_box_id">Comment Box ID:</label> <input type="text" name="viddler_comment_box_id" id="viddler_comment_box_id" size="10" value="<?php if (!get_option('viddler_comment_box_id')) { echo 'comment'; } else { echo get_option('viddler_comment_box_id'); } ?>" /> (<?php _e('<a href="#viddlerfaq-commentboxid">?</a>'); ?>)</p>

<h3>Wordpress admin options</h3>
			<p><label for="viddler_yourusername">Your username:</label> <input type="text" name="viddler_yourusername" id="viddler_yourusername" size="25" value="<?php if (!get_option('viddler_yourusername')) { echo ''; } else { echo get_option('viddler_yourusername'); } ?>" /> (<?php _e('<a href="#viddlerfaq-yourusername">?</a>'); ?>)<br />Store your username so you don't have to retype it.</p>
			
			<p><label for="viddler_yourpassword">Your password:</label> <input type="password" name="viddler_yourpassword" id="viddler_yourpassword" size="25" value="<?php if (!get_option('viddler_yourpassword')) { echo ''; } else { echo get_option('viddler_yourpassword'); } ?>" /> (<?php _e('<a href="#viddlerfaq-yourpassword">?</a>'); ?>)</p>
				
			<p><label for="viddler_show_widget">Show Dashboard widget?:</label>
			<select id="viddler_show_widget" name="viddler_show_widget">
				<option value="true" <?php if (get_option('viddler_show_widget') == 'true' || !get_option('viddler_show_widget')) { echo 'selected'; } ?>>Yes, please.</option>
				<option value="false" <?php if (get_option('viddler_show_widget') == 'false') { echo 'selected'; } ?>>No, thanks.</option>
			</select> (<?php _e('<a href="#viddlerfaq-showwidget">?</a>'); ?>)</p>
			
			<p><label for="viddler_custom_tags">Custom tags (separate with commas, no spaces):</label> <input type="text" name="viddler_custom_tags" id="viddler_custom_tags" size="25" value="<?php if (!get_option('viddler_custom_tags')) { echo ''; } else { echo get_option('viddler_custom_tags'); } ?>" /> (<?php _e('<a href="#viddlerfaq-customtags">?</a>'); ?>)</p>
		
			<p class="submit"><input type="submit" name="submit" value="<?php _e('Update options &raquo;'); ?>" /></p>
		</form>
		</div>
		
	<h3>Help</h3>
	<p>Just in case the above options confuse you, here is what each of them means.</p>
	
	<h4 id="viddlerfaq-postsplayer">The posts player</h4>
	<p>Just like the comments player setting, this lets you choose which player to use in your web site's posts.  By default the plugin will use the default player, as it has many more features, conversational qualities, and embed options built-in.  Changing this setting will force all of your posts to use the player you choose.  However, if you'd like to use a specific player for a single post, we recommend grabbing the embed code from the Viddler.com web site.</p>
	
	<h4 id="viddlerfaq-allowlogin">Force users to use your account?</h4>
	<p>If you would like all video comments to use 1 Viddler account, as opposed to every single video comment being saved into their own individual Viddler accounts.</p>
	
	<h4 id="viddlerfaq-downloadsource">What is a link to download source?</h4>
	<p>When this option is turned on a link to download the original source file that was uploaded to Viddler will be shown. So if you've uploaded a WMV, MOV, or MP4 file to Viddler, someone can download the video with a single click.</p>
	
	<h4 id="viddlerfaq-embedswapper">What is the Embed Code Swapper?</h4>
	<p>If you have old embed codes, not short codes created by this plugin, that are not mobile compatible embed codes you may want to turn this option on. In other words, if you've emebedded videos using full HTML before you used this plugin prior to September 2010 you may want to turn this option on.</p>
	
	<h4 id="viddlerfaq-yourusername">Your username</h4>
	<p>The username you use to log into Viddler's Web site. Saving your username helps to speed up the posting process. This username <em>is not used</em> to enable single-account video comment saving.</em></p>
	
	<h4 id="viddlerfaq-yourpassword">Your password</h4>
	<p>Your viddler password. This will be required if your account is private or you want to get non-public videos to embed.</em></p>
	
	<h4 id="viddlerfaq-customtags">Custom tags</h4>
	<p>By default, when you or anyone leaves a video comment on one of your posts using the record with webcam feature, this plugin tags each of these videos with three default tags: videocomment, comment, webcam.  You may add tags relevant to your site for tracking purposes (ie. cdevroe.com).  You can add more than one tag by separating with commas, <em>no spaces</em> (ie. yoursitename,yourname,anothertag).</p>
	
		<h4 id="viddlerfaq-autocreatebutton">Turn comments on?</h4>
	<p>By default this plugin will automatically insert a link after your Wordpress comments form.  From there, you can style that link however you'd like. (See readme.txt section 3. i. for instructions).</p>
	
	<h4 id="viddlerfaq-commentsplayer">The comments player</h4>
	<p>The option sets the default player to be used for the comments on your site.  By default the plugin will use the simple player, as its lightweight and faster to load than the default player.  However, you can choose to change this by setting the dropdown to whichever player you'd like.</p>
	
	<h4 id="viddlerfaq-buttontext">The button text</h4>
	<p>By default the plugin will use the text 'Record or choose video?' as the text for the link, or button, in your comments form.  You might not like this, so you can change it to anything you'd like by editing the text in the box.</p>
	
	<h4 id="viddlerfaq-commentboxid">The comment box id</h4>
	<p>Most of you will never need to change this setting.  How do you know if you need to?  If you're using a Wordpress template that changes the default Wordpress comments form, then you'll need to.  What should you change it to?  Take a look at the name (or ID) of the comment box that your web site's visitors type their comment into.  If the ID of that box is 'words', then enter words into the box and click Update options.</p>
	
	<h4 id="viddlerfaq-commentboxid">Show Dashboard Widget?</h4>
	<p>This will either show, or hide, the "Daily Featured Video" dashboard widget from your Wordpress dashboard.</p>
	
	
	</div>
	<?

}

/* ADMIN ONLY */

// Javascript for admin only
function viddler_add_jsAdmin() {
	$pluginurl = get_bloginfo('wpurl').'/wp-content/plugins/the-viddler-wordpress-plugin/';

	$jsAdmin = $pluginurl.'js/viddleradmin.js';
				
	echo "\n".'<script src="'.$jsAdmin.'" type="text/javascript"></script>'."\n";
}

function add_viddlerTab($stuff) {
	$stuff['viddlervideos'] = 'Viddler';
	return $stuff;
}

function media_upload_viddlervideos() {
	if ($_GET['response'] == 'error') {
		$errors='Login didn\'t work.';
		echo 'error';
	}
	
	$subtab = $_GET['subtab'];
	if (!$subtab) { $subtab = 'featured'; }
	
	//print_r($_COOKIE);
	if (isset($_GET['sessionid'])) {
		return wp_iframe( 'media_upload_viddler_'.$subtab, 'viddlervideos', $errors, $id, $_GET['sessionid'] );
	} else {
		return wp_iframe( 'media_upload_viddler_'.$subtab, 'viddlervideos', $errors, $id );
	}// end if cookie
}

function wp25mediaCSS() {
	echo '<style type="text/css">
	.viddlermediapanel { clear: both; margin: 35px 10px; }
	.viddlermediapanel ul { padding: 0; margin: 5px 0 0 0; list-style-type: none; }
	.viddlermediapanel ul li { display: block; float: left; padding: 5px 8px; font-size: 0.9em; border-right: 1px solid #E9E0E2; }
	.viddlermediapanel ul li.last { border: none; }
	.viddlermediapanel ul li a { text-decoration: none; }
	.viddlermediapanel ul li a.active { text-decoration: none; border-bottom: 1px solid #223852; }
	.viddlermediapanel a.poweredby { text-decoration: none; border: none; float: right; margin-top: 5px; padding-right: 15px; }
	.viddlermediapanel h3 { margin: 20px 0px; padding-top: 8px; clear: both; }
	
	.todaysfeaturedvideo { width: 600px; }
	.todaysfeaturedvideo img { float: left; border: 5px solid #eee; }
	.todaysfeaturedvideo p { margin: 5px; float: left; }
	.todaysfeaturedvideo p strong { font-size: 1.2em; }
	.viddlermediapanel ul.viddlerpreviousfeatures { clear:both; padding-top: 5px; margin: 10px 10px 20px 0px; width: 600px; }
	.viddlermediapanel ul.viddlerpreviousfeatures li { border: none; width: 180px; margin; 10px 5px 10px 0px; display: block; float: left; height: 250px; }
	.viddlermediapanel ul.viddlerpreviousfeatures li img { border: 3px solid #eee; }
	p.viddlerpagenav { clear: both; text-align: center; width: 100%; padding: 0; margin: 20px 0 0 0; }
	
	.sortbytag { clear:both; }
	
	.poweredby { clear: both; }
	</style>';
}

function wp25adminheader($activetab='login',$type,$errors=null,$id=null,$sessionid=null) {
	$pluginurl = get_bloginfo('wpurl').'/wp-content/plugins/the-viddler-wordpress-plugin/';
	media_upload_header();
	
	switch ($activetab) {
		case 'login':
			$loginClass = ' class="active"';
		break;
		case 'record':
			$recordClass = ' class="active"';
		break;
		case 'yourvideos':
			$videoClass = ' class="active"';
		break;
		case 'search':
			$searchClass = ' class="active"';
		break;
		case 'featured':
			$featuredClass = ' class="active"';
		break;
		default:
			$loginClass = ' class="active"';
		break;
	}
	
	//print_r($_COOKIE);
	if (isset($sessionid)) {
		//$sessionid = $_COOKIE['viddlerwp[sessionid]'];
		$username = $_COOKIE['viddlerwp[username]'];
		$password = $_COOKIE['viddlerwp[password]'];
	}
	
	$headerhtml = '
	<div class="viddlermediapanel">
		<ul>
			<li><a href="'.get_option('siteurl'). '/wp-admin/media-upload.php?type=video&tab=viddlervideos&subtab=yourvideos&post_id='.$id.'"'.$videoClass.'>Your Videos</a></li>
			<li><a href="'.get_option('siteurl'). '/wp-admin/media-upload.php?type=video&tab=viddlervideos&subtab=search&post_id='.$id.'"'.$searchClass.'>Search</a></li>
			<li class="last"><a href="'.get_option('siteurl'). '/wp-admin/media-upload.php?type=video&tab=viddlervideos&subtab=record&post_id='.$id.'"'.$recordClass.'>Record</a></li>
		</ul>
		<a class="poweredby" href="http://viddler.com/" title="Powered by Viddler"><img src="http://static.cdn-ec.viddler.com/wp-plugin/v1/images/pwviddler.png" /></a>';
		
		return $headerhtml;
}

function viddler_media_login($type,$errors=null,$id=null) {
	$pluginurl = get_bloginfo('wpurl').'/wp-content/plugins/the-viddler-wordpress-plugin/';
	$post_id = intval($_REQUEST['post_id']);
	$form_action_url = $pluginurl."viddlergateway.php";
	$callback = "type_form_$type";
	$callback_url = get_option('siteurl') . "/wp-admin/media-upload.php?type=viddlerlogin&tab=viddlerlogin&post_id=$post_id";
	
	echo wp25adminheader($activetab='login',$type,$errors,$id).'
	
	<h3>Login to Viddler</h3>
	<form method="get" action="'.$form_action_url.'">
	<input type="hidden" name="m" id="m" value="viddler.users.auth" />
	<input type="hidden" name="admin" id="admin" value="y" />
	<table class="describe"><tbody>
		<tr>
			<th valign="top" scope="row" class="label">
				<span class="alignleft"><label for="u">' . __('Username') . '</label></span>
				<span class="alignright"><abbr title="required" class="required">*</abbr></span>
			</th>
			<td class="field"><input id="viddleruser" name="u" value="" type="text" /></td>
		</tr>
		<tr>
			<th valign="top" scope="row" class="label">
				<span class="alignleft"><label for="viddlerpass">' . __('Password') . '</label></span>
				<span class="alignright"><abbr title="required" class="required">*</abbr></span>
			</th>
			<td class="field"><input id="viddlerpass" name="p" value="" type="password" /></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" class="button" name="viddlerlogin" value="' . attribute_escape(__('Log in')) . '" />
				<input type="hidden" name="viddlercallback" id="viddlercallback" value="'.$callback_url.'" />
			</td>
		</tr>
	</tbody></table></form></div></body></html>
';
}

/*
This will show Viddler's featured video for the day. Huzzah!
*/

function media_upload_viddler_featured($type,$errors=null,$id=null) {
	$pluginurl = get_bloginfo('wpurl').'/wp-content/plugins/the-viddler-wordpress-plugin/';
	$form_action_url = $pluginurl."viddlergateway.php";
	
	include('phpviddler/phpviddler.php');
	
	// New instance of Viddler class.
	$v = new Viddler_V2('0118093f713643444556524f452f');
	
	$featuredvideos = $v->viddler_videos_getFeatured();
	$i = 1;

	foreach ($featuredvideos['list_result']['featured_videos'] as $feature) {
		
			if ($i == 1) {
				$todaysfeaturedvideo = '<div class="todaysfeaturedvideo"><a href="'.$feature['video']['url'].'" target="_blank"><img width="240" class="featuredthumb" src="'.$feature['video']['thumbnail_url'].'" /></a><p><strong><a href="'.$feature['url'].'" target="_blank">'.$feature['video']['title'].'</a></strong><br />By: <i><a href="'.get_option('siteurl'). '/wp-admin/media-upload.php?type=video&tab=viddlervideos&subtab=search&viddlersearchtype=&viddlerstring='.$feature['author'].'&post_id='.$id.'">'.$feature['video']['author'].'</a></i> <br />Published: '.date("F d, Y",$feature['featured_at']).'<br /><i>('.$feature['video']['comment_count'].' comments, '.number_format($feature['video']['view_count']).' views)</i><br /><a href="#" onclick="viddlerAddToPost(\''.$feature['video']['id'].'\'); return false;">+ Insert into post</a></p></div>';
			} elseif ($i>1 && $i<=7) {
				$previousfeaturedvideos .= '<li><a href="'.$feature['video']['url'].'" target="_blank"><img width="120" class="featuredthumb" src="'.$feature['video']['thumbnail_url'].'" /></a><p><strong><a href="'.$feature['video']['url'].'" target="_blank">'.$feature['video']['title'].'</a></strong><br />By: <i><a href="'.get_option('siteurl'). '/wp-admin/media-upload.php?type=video&tab=viddlervideos&subtab=search&viddlersearchtype=&viddlerstring='.$feature['author'].'&post_id='.$id.'">'.$feature['video']['author'].'</a></i> <br />Published: '.date("F d, Y",$feature['featured_at']).'<br /><i>('.$feature['video']['comment_count'].' comments, '.number_format($feature['video']['view_count']).' views)</i><br /><a href="#" onclick="viddlerAddToPost(\''.$feature['video']['id'].'\'); return false;">+ Insert into post</a></p></li>';
			} elseif ($i > 7) {
				continue;
			}
			
			$i++;
		}
	
	$post_id = intval($_REQUEST['post_id']);
	
	$callback = "type_form_$type";
	$callback_url = get_option('siteurl') . "/wp-admin/media-upload.php?type=viddlerlogin&tab=viddlerlogin&post_id=$post_id";
	
	echo wp25adminheader($activetab='featured',$type,$errors,$id).'
	
	<h3>Most recent featured videos</h3>'.$todaysfeaturedvideo.'
	
	<ul class="viddlerpreviousfeatures">'.$previousfeaturedvideos.'</ul>
	
	</div></body></html>
';
}

/*
Your videos 
*/

function media_upload_viddler_yourvideos($type,$errors=null,$id=null) {

	$pluginurl = get_bloginfo('wpurl').'/wp-content/plugins/the-viddler-wordpress-plugin/';
	$form_action_url = $pluginurl."viddlergateway.php";
	$html = '';
	
	include('phpviddler/phpviddler.php');
	include('viddlerconfig.php');
	
	// New instance of Viddler class.
	$v = new Viddler_V2('0118093f713643444556524f452f');
	
	$yourusername = $viddler_username;
	$yourusername = (empty($yourusername)) ? get_option('viddler_yourusername') : $yourusername;
	$yourusername = (empty($yourusername)) ? $_GET['viddlerusername'] : $yourusername;
	
	$yourpassword = $viddler_password;
	$yourpassword = (empty($yourpassword)) ? get_option('viddler_yourpassword') : $yourpassword;
	
	if (empty($yourusername)) {
	 $html = '<p>You must supply your Viddler username. You can do this in the plugin settings or the viddlerconfig.php file.</p>';
	}
	else {
    $p = $_GET['p'];
    $p = (empty($p) || $p < 1) ? 1 : $p;
    $tags = $_GET['tags'];
    $pp = 9;
    
    $sessionid = null;
    $args = array(
      'page'        =>  $p,
      'per_page'    =>  $pp,
      'tags'        =>  $tags,
      'visibility'  =>  'public,invite,embed'
    );
    
    if (isset($yourpassword) & ! empty($yourpassword)) {
      $auth = $v->viddler_users_auth(array(
        'user'      =>  $yourusername,
        'password'  =>  $yourpassword
      ));
      
      if (isset($auth['auth']['sessionid'])) {
        $args['sessionid'] = $auth['auth']['sessionid'];
      }
      else {
        	$html = '<p>Your viddler.com password is incorrect. Please update your settings.</p>';
      }
    }
    
    if (! empty($sessionid)) {
      $args['sessionid'] = $sessionid;
    }
    else {
      $args['user'] = $yourusername;
    }
  }
		
  if (empty($html)) {
    $yourvideos = $v->viddler_videos_getByUser($args);
    $numvideos = (isset($yourvideos['list_result']['video_list'])) ? count($yourvideos['list_result']['video_list']) : 0;
    
    if ($numvideos == 0) {
  	 $html = '<p>Your search did not return any results.</p>';
    }
    else {
	    $i = 1;
      $defaultwidth = get_option('viddler_player_width');
      $viddler_player_type_posts = get_option('viddler_player_type_posts');
      if (!$defaultwidth) { $defaultwidth = '437'; }
      if (!$viddler_player_type_posts) { $viddler_player_type_posts = 'player'; }
      foreach ($yourvideos['list_result']['video_list'] as $video) {
      
        $sk = $video['permissions']['secreturl'];
        if (! empty($sk)) {
          $sk = explode('=', $sk);
          $sk = $sk[1];
        }
	
        $height = $video['height'];
        if ($viddler_player_type_posts == 'mini') { $width = $video['width']; } else { $width = $defaultwidth; }

        $html .= '<li><a href="'.$video['url'].'" target="_blank"><img width="120" class="featuredthumb" src="'.$video['thumbnail_url'].'" /></a><p><strong><a href="'.$video['url'].'" target="_blank">'.$video['title'].'</a></strong><br />By: <i><a href="'.get_option('siteurl'). '/wp-admin/media-upload.php?type=video&tab=viddlervideos&subtab=search&viddlersearchtype=&viddlerstring='.$video['author'].'&post_id='.$id.'">'.$video['author'].'</a></i> <br />Published: '.date("F d, Y",$video['upload_time']).'<br /><i>('.$video['comment_count'].' comments, '.number_format($video['view_count']).' views)</i><br /><a href="#" onclick="viddlerAddToPost(\''.$video['id'].'\',\''.$width.'\',\''.$height.'\',\''.$sk.'\'); return false;">+ Insert into post</a></p></li>';
       }
    }
	
    if ($numvideos > 1) {
      if ($p != 1) $pages .= '<a href="'.get_option('siteurl'). '/wp-admin/media-upload.php?type=video&tab=viddlervideos&subtab=yourvideos&viddlersearchtype=&viddlerusername='.$feature['author'].'&post_id='.$id.'&p='.($p-1).'">&laquo; Previous</a> | ';

      if ($p < $numvideos) $pages .= '<a href="'.get_option('siteurl'). '/wp-admin/media-upload.php?type=video&tab=viddlervideos&subtab=yourvideos&viddlersearchtype=&viddlerusername='.$feature['author'].'&post_id='.$id.'&p='.($p+1).'">Next &raquo;</a>';

      $html = '<form class="sortbytag" method="get" action="'.get_option('siteurl'). '/wp-admin/media-upload.php">
<p>Sort by tag: <input type="text" size="6" name="tags" id="tags" value="'.$tags.'" /> <input type="submit" value=" &raquo; " /></p>
<input type="hidden" name="type" value="video" />
			<input type="hidden" name="tab" value="viddlervideos" />
			<input type="hidden" name="subtab" value="yourvideos" />
			<input type="hidden" name="post_id" value="'.$id.'" />
			<input type="hidden" name="pp" value="1" /></form><p class="viddlerpagenav">'.$pages.'</p>'.'<ul  class="viddlerpreviousfeatures">'.$html.'</ul>'.'<p class="viddlerpagenav">'.$pages.'</p>';
		}
      
	} else {
		$html = '<h3>What is your username?</h3>
	<form method="get" action="'.get_option('siteurl'). '/wp-admin/media-upload.php">
	<table class="describe"><tbody>
		<tr>
			<th valign="top" scope="row" class="label">
				<span class="alignleft"><label for="u">' . __('Username') . '</label></span>
				<span class="alignright"><abbr title="required" class="required">*</abbr></span>
			</th>
			<td class="field"><input id="viddlerusername" name="viddlerusername" value="" type="text" /></td>
			
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" class="button" value="' . attribute_escape(__(' Submit ')) . '" />
				<input type="hidden" name="type" value="video" />
				<input type="hidden" name="tab" value="viddlervideos" />
				<input type="hidden" name="subtab" value="yourvideos" />
				<input type="hidden" name="post_id" value="'.$id.'" />
				<input type="hidden" name="pp" value="1" />
			</td>
			
		</tr>
		<tr>
			<td colspan="2"><p>Tip: You can save your username, so you don\'t have to fill it in, by going to Settings > Viddler.</p></td>
		</tr>
	</tbody></table></form>';
	}
	
	$post_id = intval($_REQUEST['post_id']);
	
	$callback = "type_form_$type";
	$callback_url = get_option('siteurl') . "/wp-admin/media-upload.php?type=viddlerlogin&tab=viddlerlogin&post_id=$post_id";
	
	if (empty($yourpassword)) {
    $html .= '<p style="font-size:125%;">You did not supply your Viddler password. If you have non-public videos or a private account, you will need to do this in order to work with those videos.</p>';
    $html .= '<p style="font-size:125%;">You can supply your Viddler password under the <a href="/wp-admin/options-general.php?page=viddler-comments-config" target="_top">Viddler Plugin settings page.</a></p>';
  }
	
	echo wp25adminheader($activetab='yourvideos',$type,$errors,$id).'<br /><br />'.$html.'</div></body></html>';
}

/*
Search
*/

function media_upload_viddler_search($type,$errors=null,$id=null) {
	$pluginurl = get_bloginfo('wpurl').'/wp-content/plugins/the-viddler-wordpress-plugin/';
	$form_action_url = $pluginurl."viddlergateway.php";
	
	include('phpviddler/phpviddler.php');
	
	// New instance of Viddler class.
	$v = new Viddler_V2('0118093f713643444556524f452f');
	
	// Determine search type
	if ($_GET['viddlersearchtype']) {
		switch ($_GET['viddlersearchtype']) {
			case 'tag':
				$tagsearchtype = 'selected';
			break;
			case 'user':
				$usersearchtype = 'selected';
			break;
			default:
				$tagsearchtype = 'selected';
			break;
		}
		
	}
	
	// Search form
	$form = '<h3 style="clear: both;">Search by username or tag!</h3>
	<form method="get" action="'.get_option('siteurl'). '/wp-admin/media-upload.php">
	<table class="describe"><tbody>
		<tr>
			<th valign="top" scope="row" class="label"></th>
			<td>
			<select name="viddlersearchtype" id="viddlersearchtype">
				<option value="tag" '.$tagsearchtype.'>Tag</option>
				<option value="user" '.$usersearchtype.'>Username</option>
			</select></td>
		</tr>
		<tr>
			<th valign="top" scope="row" class="label">
				<span class="alignleft"><label for="u">' . __('Search') . '</label></span>
				<span class="alignright"><abbr title="required" class="required">*</abbr></span>
			</th>
			<td class="field"><input id="viddlerstring" name="viddlerstring" value="'.$_GET['viddlerstring'].'" type="text" /></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" class="button" value="' . attribute_escape(__(' Submit ')) . '" />
				<input type="hidden" name="type" value="video" />
				<input type="hidden" name="tab" value="viddlervideos" />
				<input type="hidden" name="subtab" value="search" />
				<input type="hidden" name="post_id" value="'.$id.'" />
				<input type="hidden" name="pp" value="1" />
			</td>
		</tr>
	</tbody></table></form>';
	
	if ($_GET['viddlerstring']) {
		$p = $_GET['p'];
		$pp = 9;
		
		if (!$p || $p < 1) $p = 1;
		
		$sessionid = null;
		
		if ($_GET['viddlersearchtype'] == 'user') {
				$featuredvideos = $v->viddler_videos_getByUser(array('user'=>$_GET['viddlerstring'],'page'=>$p,'per_page'=>$pp));
				$numvideos = count($featuredvideos['list_result']['video_list']);
		} else {
				$featuredvideos = $v->viddler_videos_getByTag(array('tag'=>$_GET['viddlerstring'],'page'=>$p,'per_page'=>$pp));
				$numvideos = count($featuredvideos['list_result']['video_list']);; // Hot patch. Need to figure out how to determine number of videos.
		}
	
		$i = 1;
		
	$defaultwidth = get_option('viddler_player_width');
		if (!$defaultwidth) { $defaultwidth = '437'; }
	
	if ($numvideos > 1) {
		foreach ($featuredvideos['list_result']['video_list'] as $feature) {
		
    		$height = $video['height'];
    		
    		$html .= '<li><a href="'.$feature['url'].'" target="_blank"><img width="120" class="featuredthumb" src="'.$feature['thumbnail_url'].'" /></a><p><strong><a href="'.$feature['url'].'" target="_blank">'.$feature['title'].'</a></strong><br />By: <i><a href="'.get_option('siteurl'). '/wp-admin/media-upload.php?type=video&tab=viddlervideos&subtab=search&viddlersearchtype=&viddlerstring='.$feature['author'].'&post_id='.$id.'">'.$feature['author'].'</a></i> <br />Published: '.date("F d, Y",$feature['upload_time']).'<br /><i>('.$feature['comment_count'].' comments, '.number_format($feature['view_count']).' views)</i><br /><a href="#" onclick="viddlerAddToPost(\''.$feature['id'].'\',\''.$defaultwidth.'\',\''.$height.'\'); return false;">+ Insert into post</a></p></li>';
		}
	} else {
			$height = $video['height'];
			
			$html .= '<li><a href="'.$featuredvideos['video_list']['video']['url'].'" target="_blank"><img width="120" class="featuredthumb" src="'.$featuredvideos['video_list']['video']['thumbnail_url'].'" /></a><p><strong><a href="'.$featuredvideos['video_list']['video']['url'].'" target="_blank">'.$featuredvideos['video_list']['video']['title'].'</a></strong><br />By: <i><a href="'.get_option('siteurl'). '/wp-admin/media-upload.php?type=video&tab=viddlervideos&subtab=search&viddlersearchtype=&viddlerstring='.$featuredvideos['video_list']['video']['author'].'&post_id='.$id.'">'.$featuredvideos['video_list']['video']['author'].'</a></i> <br />Published: '.date("F d, Y",$featuredvideos['video_list']['video']['upload_time']).'<br /><i>('.$featuredvideos['video_list']['video']['comment_count'].' comments, '.number_format($feature['view_count']).' views)</i><br /><a href="#" onclick="viddlerAddToPost(\''.$featuredvideos['video_list']['video']['id'].'\',\''.$defaultwidth.'\',\''.$height.'\'); return false;">+ Insert into post</a></p></li>';
	}
	
		if ($p != 1) $pages .= '<a href="'.get_option('siteurl'). '/wp-admin/media-upload.php?type=video&tab=viddlervideos&subtab=search&viddlersearchtype='.$_GET['viddlersearchtype'].'&viddlerstring='.$_GET['viddlerstring'].'&post_id='.$id.'&p='.($p-1).'">&laquo; Previous</a> | ';
	
	if ($p < 6) $pages .= '<a href="'.get_option('siteurl'). '/wp-admin/media-upload.php?type=video&tab=viddlervideos&subtab=search&viddlersearchtype='.$_GET['viddlersearchtype'].'&viddlerstring='.$_GET['viddlerstring'].'&post_id='.$id.'&p='.($p+1).'">Next &raquo;</a>';
	
	$html = $form.'<p class="viddlerpagenav">'.$pages.'</p>'.'<ul  class="viddlerpreviousfeatures">'.$html.'</ul>'.'<p class="viddlerpagenav">'.$pages.'</p>';
	
	} else {
		$html = $form;
	}
	
	$post_id = intval($_REQUEST['post_id']);
	
	$callback = "type_form_$type";
	$callback_url = get_option('siteurl') . "/wp-admin/media-upload.php?type=viddlerlogin&tab=viddlerlogin&post_id=$post_id";
	
	echo wp25adminheader($activetab='search',$type,$errors,$id).$html.'</div></body></html>';
}

/*
Recording!
*/

function media_upload_viddler_record($type,$errors=null,$id=null) {
	$pluginurl = get_bloginfo('wpurl').'/wp-content/plugins/the-viddler-wordpress-plugin/';
	$form_action_url = $pluginurl."viddlergateway.php";
	
	include('phpviddler/phpviddler.php');
	
	// New instance of Viddler class.
	$v = new Viddler_V2('0118093f713643444556524f452f');
	
	// Login form
	$form = '<h3>Record a video using your webcam!</h3>
	<p>You will need a webcam attached to your computer to record.</p>
	<form method="get" action="'.get_option('siteurl'). '/wp-admin/media-upload.php">
	<table class="describe"><tbody>
		<tr>
			<th valign="top" scope="row" class="label">
				<span class="alignleft"><label for="viddlerusername">' . __('Username') . '</label></span>
				<span class="alignright"><abbr title="required" class="required">*</abbr></span>
			</th>
			<td class="field"><input id="viddlerusername" name="viddlerusername" value="'.$_GET['viddlerusername'].'" type="text" /></td>
		</tr>
		<tr>
			<th valign="top" scope="row" class="label">
				<span class="alignleft"><label for="viddlerpassword">' . __('Password') . '</label></span>
				<span class="alignright"><abbr title="required" class="required">*</abbr></span>
			</th>
			<td class="field"><input id="viddlerpassword" name="viddlerpassword" value="'.$_GET['viddlerpassword'].'" type="password" /></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="submit" class="button" value="' . attribute_escape(__(' Submit ')) . '" />
				<input type="hidden" name="type" value="video" />
				<input type="hidden" name="tab" value="viddlervideos" />
				<input type="hidden" name="subtab" value="record" />
				<input type="hidden" name="post_id" value="'.$id.'" />
				<input type="hidden" name="pp" value="1" />
			</td>
		</tr>
	</tbody></table></form>';
	
	if ($_GET['viddlerusername']) {
		// Login
			$sessionid = $v->viddler_users_auth(array('user'=>$_GET['viddlerusername'],'password'=>$_GET['viddlerpassword'],'get_record_token'=>1));
			// Error
			if ($sessionid['error']) {
				$html = '<p style="color:red;">Username and/or password were incorrect.</p>'.$form;
			} else {
				// Success
				$recordtoken = $sessionid['auth']['record_token'];
				
				$recorder = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"  codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="449" height="380"
id="viddler_recorder" align="middle"> <param name="allowScriptAccess" value="always" /> <param name="allowNetworking" value="all" /> <param name="movie" value="http://cdn-static.viddler.com/flash/recorder.swf" /> <param name="quality" value="high" /> <param name="scale" value="noScale"> <param name="bgcolor" value="#000000" /> <param name="flashvars" value="fake=1&recordToken='.$recordtoken.'" /> <embed src="http://cdn-static.viddler.com/flash/recorder.swf" quality="high" scale="noScale" bgcolor="#000000"
allowScriptAccess="always" allowNetworking="all" width="449" height="380" name="viddler_recorder"
flashvars="fake=1&recordToken='.$recordtoken.'" align="middle" allowScriptAccess="sameDomain"
type="application/x-shockwave-flash"  pluginspage="http://www.macromedia.com/go/getflashplayer" /> </object>';
				
				
				$html = '<h3>Record your video!</h3>
				<p>Easy: Click red record button, click stop when finished, click save to confirm.</p>
				<div id="viddlerrecorder">'.$recorder.'</div>
				<input type="hidden" id="sessionid" name="sessionid" value="'.$sessionid['auth']['sessionid'].'" />
				<input type="hidden" id="viddlergateway" name="viddlergateway" value="'.$form_action_url.'" />';
			}
			
	} else {
		// Just show login form
		$html = $form;
	}
	
	$post_id = intval($_REQUEST['post_id']);
	
	$callback = "type_form_$type";
	$callback_url = get_option('siteurl') . "/wp-admin/media-upload.php?type=viddlerlogin&tab=viddlerlogin&post_id=$post_id";
	
	echo wp25adminheader($activetab='record',$type,$errors,$id).$html.'</div></body></html>';
}



function viddler_add_widget($widgets) {
	// wp_dashboard_empty: we load in the content after the page load via JS
	wp_register_sidebar_widget( 'viddler_dashboard', __( 'Viddler\'s featured videos' ), 'wp_dashboard_empty', array(
		'all_link' => 'http://www.viddler.com/explore/featured/',
		'feed_link' => 'http://www.viddler.com/explore/featured/feed/',
		'width' => 'half'
	) );

	add_action( 'admin_head', 'viddler_dashboard_head' );
	
	array_splice( $widgets, 2, 0, 'viddler_dashboard' );
	
	return $widgets;
}

// Used by Admin Javascript only!
function viddler_page() {
	if ( isset( $_GET['noheader'] ) )
		return viddler_dashboard_content();
}

function viddler_admin_menu() {
	add_submenu_page('index.php', __('Viddler'), __(''), 'manage_options', 'viddler', 'viddler_page');
}

// This fills in the Dashboard widget
function viddler_dashboard_content() {

	$pluginurl = get_bloginfo('wpurl').'/wp-content/plugins/the-viddler-wordpress-plugin/';
	$form_action_url = $pluginurl."viddlergateway.php";
	
	include('phpviddler/phpviddler.php');
	
	// New instance of Viddler class.
	$v = new Viddler_V2('0118093f713643444556524f452f');
	$featuredvideos = $v->viddler_videos_getFeatured();
	$i = 1;
		
	foreach ($featuredvideos['list_result']['featured_videos'] as $feature) {
		
			if ($i == 1) {
				$todaysfeaturedvideo = '<div class="todaysfeaturedvideo"><p><strong>LATEST: <a href="'.$feature['video']['url'].'" target="_blank">'.$feature['video']['title'].'</a></strong><br />By: <a href="http://www.viddler.com/explore/'.$feature['author'].'/"><i>'.$feature['video']['author'].'</i></a> <br /><i>'.$feature['video']['comment_count'].' comments<br /> '.number_format($feature['video']['view_count']).' views</i><br /><a href="post-new.php?text='.urlencode('[viddler id-'.$feature['video']['id'].' h-370 w-437]').'&popupurl='.urlencode($feature['video']['url']).'&popuptitle='.urlencode($feature['video']['title']).'">+ Insert into post</a></p><div id="viddlervideo-'.$feature['video']['id'].'"><a href="#loadvideo" title="Watch this video!" onclick="loadViddlerVideo(\''.$feature['video']['id'].'\',\'simple\',\'280\',\'200\'); return false;"><img width="240" class="featuredthumb" src="'.$feature['video']['thumbnail_url'].'" /></a><br /><a href="#loadvideo" title="Watch this video!" onclick="loadViddlerVideo(\''.$feature['video']['id'].'\',\'simple\',\'280\',\'200\'); return false;"><img style="border: none; position: absolute; top: 70px; left: 15px;" src="'.$pluginurl.'images/play.png" /></a></div></div><div style="clear:both;"></div>'."\n\n";
			} elseif ($i>1 && $i<=7) {
				$previousfeaturedvideos .= '<li><a href="'.$feature['video']['url'].'" target="_blank"><img width="120" class="featuredthumb" src="'.$feature['video']['thumbnail_url'].'" /></a><p><strong><a href="'.$feature['video']['url'].'" target="_blank">'.$feature['title'].'</a></strong>By: <i><a href="'.get_option('siteurl'). '/wp-admin/media-upload.php?type=video&tab=viddlervideos&subtab=search&viddlersearchtype=&viddlerstring='.$feature['video']['author'].'&post_id='.$id.'">'.$feature['video']['author'].'</a></i> <br />Published: '.date("F d, Y",$feature['featured_at']).'<br /><i>('.$feature['video']['comment_count'].' comments, '.number_format($feature['video']['view_count']).' views)</i><br /><a href="post-new.php?text='.urlencode('[viddler id-'.$feature['video']['id'].' h-370 w-437]').'&popupurl='.urlencode($feature['url']).'&popuptitle='.urlencode($feature['video']['title']).'">+ Insert into post</a></p></li>';
			} elseif ($i > 7) {
				continue;
			}
			
			$i++;
		}
	
	$post_id = intval($_REQUEST['post_id']);
	
	$callback = "type_form_$type";
	$callback_url = get_option('siteurl') . "/wp-admin/media-upload.php?type=viddlerlogin&tab=viddlerlogin&post_id=$post_id";
	
	echo $todaysfeaturedvideo.'<h3 class="viddlerdashboard">Previous features</h3><ul class="viddlerpreviousfeatures">'.$previousfeaturedvideos.'</ul>
	<p class="dashboardpoweredby"><a class="poweredby" href="http://viddler.com/" title="Powered by Viddler"><img src="http://static.cdn-ec.viddler.com/wp-plugin/v1/images/pwviddler.png" /></a></p>
	<br class="clear" />';
exit;
}


function viddler_dashboard_head() {
?><script type="text/javascript">
/* <![CDATA[ */
jQuery( function($) {
	var dashViddler = $('#viddler_dashboard div.inside');
	dashViddler.load('index.php?page=viddler&noheader');
} );
/* ]]> */
</script>
<style type="text/css">
#viddler_dashboard div.inside .todaysfeaturedvideo { margin: 0 0 20px 0; }
#viddler_dashboard div.inside .todaysfeaturedvideo img { border: 5px solid #eee; }
#viddler_dashboard div.inside .todaysfeaturedvideo p { float: right; width: 160px; margin: 5px; }
#viddler_dashboard div.inside .todaysfeaturedvideo p strong { font-size: 1.1em; }
#viddler_dashboard div.inside .todaysfeaturedvideo div { margin: 0; padding: 0; }
#viddler_dashboard div.inside h3.viddlerdashboard { margin: 5px 0; padding: 5px 8px; clear: both; }
#viddler_dashboard div.inside ul.viddlerpreviousfeatures { list-style: none; padding: 0; margin: 0; width: 400px; clear: both; }
#viddler_dashboard div.inside ul.viddlerpreviousfeatures li { float: left; height: 180px; width: 200px; }
  #viddler_dashboard div.inside ul.viddlerpreviousfeatures li a {margin: 0; padding:0;}
#dashboard_secondary div.inside ul li a { height: auto !important; }
#viddler_dashboard div.inside ul.viddlerpreviousfeatures li img { border: 3px solid #eee; }
#viddler_dashboard div.inside ul.viddlerpreviousfeatures li a { height: inherit; }
div.dashboard_content ul li a { height: inherit !important; }
#viddler_dashboard div.inside p.dashboardpoweredby { clear: both; }
</style>
<?php
}




// Login screen
add_action('media_upload_viddlervideos', 'media_upload_viddlervideos');

// Featured
//add_action('admin_head_viddler_media_featured', 'media_admin_css');
add_action('admin_head_media_upload_viddler_featured', 'wp25mediaCSS');
add_action('admin_head_media_upload_viddler_featured', 'viddler_add_jsAdmin');
// Login
//add_action('admin_head_viddler_media_login', 'media_admin_css');
add_action('admin_head_media_upload_viddler_login', 'wp25mediaCSS');
add_action('admin_head_media_upload_viddler_login', 'viddler_add_jsAdmin');
// Your videos
//add_action('admin_head_viddler_media_yourvideos', 'media_admin_css');
add_action('admin_head_media_upload_viddler_yourvideos', 'wp25mediaCSS');
add_action('admin_head_media_upload_viddler_yourvideos', 'viddler_add_jsAdmin');
// Search
//add_action('admin_head_viddler_media_search', 'media_admin_css');
add_action('admin_head_media_upload_viddler_search', 'wp25mediaCSS');
add_action('admin_head_media_upload_viddler_search', 'viddler_add_jsAdmin');
// Record
//add_action('admin_head_viddler_media_record', 'media_admin_css');
add_action('admin_head_media_upload_viddler_record', 'wp25mediaCSS');
add_action('admin_head_media_upload_viddler_record', 'viddler_add_jsAdmin');

// Add Viddler Videos tab
add_action('media_upload_tabs','add_viddlerTab');
add_action('media_buttons', 'media_buttons'); 
//function media_buttons() {}
add_filter('media_buttons_context', 'media_buttons_context');
// BETA BETA 
function media_buttons_context($context) {
		global $post_ID, $temp_ID;
		$dir = dirname(__FILE__);

		$image_btn = get_option('siteurl').'/wp-content/plugins/the-viddler-wordpress-plugin/images/viddler.png';
		$image_title = 'Viddler';
		
		$uploading_iframe_ID = (int) (0 == $post_ID ? $temp_ID : $post_ID);

		$media_upload_iframe_src = get_option('siteurl')."/wp-admin/media-upload.php?type=image&tab=viddlervideos&subtab=yourvideos&post_id=$uploading_iframe_ID";
		$out = ' <a href="'.$media_upload_iframe_src.'&TB_iframe=true" class="thickbox" title="'.$image_title.'"><img src="'.$image_btn.'" alt="'.$image_title.'" /></a>';
		
		return $context.$out;
	}

add_action('admin_menu', 'viddler_config_page');

// Wordpress 2.5 Dashboard widget
if ($viddler_show_widget == 'true') {
	add_filter( 'wp_dashboard_widgets', 'viddler_add_widget' );
	add_action("load-index.php", 'viddler_page');
	add_action("admin_head", 'viddler_dashboard_head');
	add_action( 'admin_menu', 'viddler_admin_menu' );
	add_action("load-index.php", 'viddler_add_jsAdmin');
}

add_filter('comment_text', 'viddler_embedcomment');
add_filter('the_content', 'viddler_embedpost');


add_action('wp_head', 'viddler_add_js');

if ($viddler_embed_swapper == 'true') {
  add_action('wp_head', 'viddler_js_embed_swapper');
}

if ($viddler_default_link == 'true') {
	add_action('comment_form', 'viddler_recordlink');
}

//Viddler Shortcode Support
include 'viddler-shortcode.php';

?>