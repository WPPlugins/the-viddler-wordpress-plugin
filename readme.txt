=== Plugin Name ===
Contributors: phpfunk
Donate link: https://www.viddler.com/plans
Tags: video, viddler, flash, video comments, embed video
Requires at least: 2.5
Tested up to: 3.3.2
Stable tag: 1.5.3

Publish videos from Viddler and enable video comments on your site.

== Description ==

Viddler is the best video platform for businesses to publish video to their Wordpress powered site. With The Viddler Wordpress plugin it makes it as simple as possible to do just that.

Logging into Viddler.com in order to copy and paste an embed code to publish video on your site can be a cumbersome process for those that do that over and over every day. The Viddler Wordpress plugin allows you to access your Viddler videos from within your Wordpress admin and quickly insert a video into a post or page.

In addition to quick access to your Viddler videos this plugin also enables video commenting on your site. Now, rather than only accepting text based comments from your audience you can allow them to use their webcam or upload a video comment directly from your comment form.

== Installation ==

= i. Requirements =
	
* Wordpress 2.x  |  http://wordpress.org/
* cURL (Client URL Library) for PHP | http://us.php.net/curl
	
= ii. Install or Update the plugin =

-- FROM Wordpress plugin directory --
1. Just click install!
(for updating, just click Update!)

Note: If updating from plugin version 1.2.x to 1.3.x you must now 
manually renaming the /viddlercomments/ directory to 
/the-viddler-wordpress-plugin/

-- FROM .zip --
1. Unzip the attached viddlerwpcomments.zip file
2. Upload the /the-viddler-wordpress-plugin/ directory into your
	   WordPress plugins directory.
3. Activate the plugin in the Wordpress admin.
4. (optional) Change preferences in the Comments > Video comments
   preference panel.

= iii. Uninstalling =

WARNING: Uninstalling this plugin will cause any posts,
and/or comments that have the Viddler shortcode in them
to display the shortcode as text, rather than as comments
or videos.

1. De-active the plugin from within Wordpress admin.
2. Remove the /the-viddler-wordpress-plugin/ directory from your
   Wordpress plugins directory.

== Frequently Asked Questions ==

= Do you have to have a Viddler.com account? =
No! But we recommend you do. :)

= Can I use PHP5? =
Version 1.3.7 and up support PHP5.

== Preferences ==

Log into your Wordpress admin and click on Settings > Viddler.

== Support ==

If you require any help installing this plugin, you may contact	[The Viddler Helpdesk](http://www.viddler.com/help)
	
== Changelog ==

= 1.5.4 =
* Released January 31, 2013
* Updated Asset URL Paths.

= 1.5.3 =
* Released December 11, 2012
* Fixed: Invalid paths to images
* Updated readme.

= 1.5.2 =
* Released December 10, 2012
* Fixed: Syntax error
* Updated readme.

= 1.5.0 =
* Released June 14, 2012
* Fixed: Issue with $player variable instead of $p
* Updated readme.

= 1.4.9 =
* Released June 14, 2012
* Fixed: Issue with iframe embed code
* Updated readme.

= 1.4.8 =
* Released June 6, 2012
* Added: Support for all flashvars in shortcode
* Added: viddler-shortcode.php file
* Updated readme.

= 1.4.7 =
* Released June 6, 2012
* Fixed: Invalid version number
* Updated readme.

= 1.4.6 =
* Released June 6, 2012
* Fixed: Invalid includes on some installations
* Updated readme.

= 1.4.5 =
* Released June 5, 2012
* Added: Ability to authenticate as you
* Added ability to get videos other than public if authenticated as you
* Ability to embed invite only videos
* Removal of featured videos search
* Additional security enhancements
* Embed code is now the iframe embed instead of HTML5 Fallback
* Updated readme.

= 1.4.2 =
* Released Feb 1, 2012
* Fixed: Dates showing up at January 16, 1970 now work correctly.
* Fixed: Updated the way jQuery was loaded to reduce conflicts with other plugins.
* New: The plugin can now support Wordpress.com shortcode syntax in addition to the legacy and original syntax.
* Update: Latest PHPViddler https://github.com/viddler/phpviddler/
* New: Now uses Wordpress.com's shortcode rather than Viddler's own. All are unified. 
* Updated readme.

= 1.4.1 =
* Released on May 4, 2011
* Fixed: Plugin was ignoring Player type in some cases.
* New: The very latest iFrame embed code that supports HTML5 and mobile playback for Business Accounts with encoding enabled.
* New: Support for the brand new Mini player skin!
* Fixed: A bug for accounts that only have one video.
* Updated Readme.

= 1.4 =
* Released on March 25, 2011
* Fixed jQuery loading to be more Wordpress friendly. Thanks Joshua Strebel (Page.ly)
* New: An option to add "download video source" for all embeds.
* Small performance enhancements.
* Updated: Readme (fixed dates)

= 1.3.9 =
* Released on February 8, 2011
* Updated: PHPViddler to 2.2 http://github.com/viddler/phpviddler
* Fixed: Bug in recorder via New Post window. Thanks to Richard Wildman.
* Updated: Removed a few calls to the API to make things a bit snappier.

= 1.3.8 =
* Released on December 30, 2010
* Added: Option to include JavaScript embed code swapper.

= 1.3.7 =
* Released on December 28, 2010
* Upgraded to [PHP Viddler 2](http://developers.viddler.com/projects/api-wrappers/phpviddler/) which uses Viddler API Version 2
* Change: Removed the "image" embed option.
* Change: Now uses the Viddler API version 2 for latest embed code
* Change: Removed support for viddler_video. Current syntax: [viddler id- h- w-]
* Change: Removed support for viddler_comment in comments. Depreciated since 1.1
* Fixed: Dates on Featured videos.
* Change: Removed oEmbed calls (speeds up requests considerably)
* Fixed: Dashboard Widget now works
* Change: Full PHP5 support with no edits needed.
* Updated: Readme.txt
* Fixed: Webcam record for comments.
* New: Option to turn off/on video commenting.

= 1.3.6 =
* Released on December 23, 2010
* Fix: All current releases of Wordpress.

= 1.3.5 =
* Released on April 14, 2009
* Fix: Removed height from the results.
* Change: Removed version numbers from multiple places.

= 1.3.3 =
* Released on April 14, 2009
* Fix: Height of video now properly calculated when embedding. Huzzah!

= 1.3.2 =
* Released on March 21, 2009
* Fix: Video comment short code not saving in comment box properly.
* Fix: Increased length of wait for Viddler API for recording to 8000ms.

= 1.3.1 = 
* Released on March 21, 2009	
* Fix: Problems with file locations and SVN commit.

= 1.3 = 
* Released on March 20, 2009
* Fix: Fixed file location problem /viddlercomments/ replaced with /the-viddler-wordpress-plugin/
* Note: If you still have this error, you need to rename the plugin folder to /the-viddler-wordpress-plugin/
* New: Sorting by tag when viewing "Your videos"!

= 1.2.3 =
* Released on February 9, 2009
* Fix: Turned off Dashboard widget by default - This should address WPMU errors.
* Fix: Searching by tag.
* Update: Using the latest version of phpViddler.
* Update: Includes php5 version of phpViddler.
* Update: No longer relies on dynamic CDN URLs for thumbnails.
* Misc: Improved performance, small bug fixes, slightly less code.

= 1.2.2 = 
* Released on January 20, 2009
* Fix for CDN URLs.

= 1.2.1 = 
* Released on December 30, 2008
* Fix: Fixed plugin navigation. Credit: Rob Santoro.
* Fix: Search results for users with 1 video.
* Fix: Height dimensions on embed being only 1 number.

= 1.2 =
* Released on December 15, 2008
* New: Added more options and settings.
* Fix: PHP errors.
* Fix: Wordpress 2.7 compatible.

= 1.1 Beta 3 =
* Released on May 9, 2008
* Fix: Supports usernames with no video, or 1 video, better.
* Fix: Play button height on Dashboard widget. 
	
= 1.1 Beta 2 =
* Released on April 14, 2008
* Fix: Dashboard, Wordpress News Height problem. (Thanks, Alex Hillman & Jason Waldrip)
* Fix: Improved Search
* Fix: Added paging to search
* Fix: Better paging navigation (search, your videos)
* Fix: PHP 5 Errors removed (Thanks to Lee Adkins.)
* New: Switched short code from [viddler_video=key,width,height] to [viddler id-key h- w-] (All old short codes will still work.) (Thanks to Matt Mullenweg.)
* Fix: Video thumbnails now sized to the same size as the video. (Thanks to John W.)
* New: Play button added to latest featured video in Dashboard widget.

= 1.1 Beta 1 =
* Released on April 10, 2008
* Dashboard widget
		-- Watch daily featured videos and embed them
		-- Preference to turn it off
	-- Add Viddler Video in Wordpress 2.5 Add Media pop-up
		-- Featured videos
			-- Embed featured videos
		-- Your videos
			-- Embed your Viddler videos
			-- Page through all videos
		-- Search!
			-- Search by tag
			-- Search by username
			-- Embed any public Viddler video
		-- Record
			-- Record a new video with your webcam
			-- Embeds when video is saved
	-- Fixed Wordpress 2.5 jQuery conflict
	-- Several bugs fixes and enhancements

1.0 | February 26, 2008
	-- Full 1.0 version release.

1.0 Beta 6c | Feb 21, 2008
	-- Fixed admin error on manage posts
	   and manage pages areas.
	   Thanks to Alex Hillman and Bart Mroz.

1.0 Beta 6b | Feb 20, 2008

	-- Some blogs could not save custom tags.
	-- Custom tags didn't work if you used
	   a custom button.
	-- Extended the amount of timeout
	   for record with webcam.


1.0 Beta 6 | Feb 20, 2008
	
	-- Added custom tags for video comments.
	   See FAQ in admin.
	-- Moved admin panel from Plugins to Options area.
	   Thanks to Daniel Nicolas and Alex Hillman.
	-- Fixed empty viddler_recordlink();
	   Thanks to David Martorana.
	-- Fixed conflicts with Wordpress' built-in
	   widgets system for the sidebar.
	   Thanks to Rob Sandie.
	-- Added ALT attribute to thumbnails for valid XHTML.
	   Thanks to Matt Brett.
	-- Fixed video titles with record with webcam where the blog
	   post title has an apostrophe.
	-- Several copy fixes.
	-- Misc. bug fixes (5).

1.0 Beta 5 | Feb 12, 2008
	-- Added a Readme.txt
	-- Changed the name from 'Video commmenting plugin' to
	   'Video companion plugin'.
	-- Added button text preference.  Now you can choose what the button
	   says on your site.
	-- Added administrative panel to the plugins area of the Wordpress admin.
	   You may now change all preferences there, you no longer need to
	   edit the config file.
	-- Added custom button placement preference.  Instead of the button
	   appearing automatically, now you can place it anywhere in your template
	   (within The_Loop) by using viddler_recordlink('text');
	-- Fix for overlaying the plugin on playing flash video.  The plugin would
	   appear behind any flash videos that were saved.  Fixed.
	   Thanks to Andrew Smith.
	-- Multiple fixes for people that only have 1 video on Viddler.
	-- Added "version" to the TITLE attribute on the "Powered by Viddler." logo.
	   This is simply to help me with support, and to see the adoption rates
	   of each version.		
	-- Fixed height problems for the default player being used
	   in comments
	-- Fixed Simple Player embed to allow autoplaying of comments
	   when the user clicking on "click to play video"
	-- Player background now transparent to match site's background color.


1.0 Beta 4b | Feb 12, 2008
	-- Added hooks to determine where Wordpress is installed.  This
	   means the plugin will work even if the Wordpress installation
	   is NOT in the root directory of your website. (eg. /journal/).
	   Thanks to Daniel Nicolas for finding this.
	-- Fixed a few javascript errors with $v not being changed properly.
	   Complete oversight on my part.

1.0 Beta 4 | Feb 12, 2008
	-- Fixed tiny video comments
	-- Fixed a bug where if you clicked on the text link in a post it
	   would ignore the width and height preferences
	-- Fixed links from RSS for both comments and posts.
	-- Inserting the video into a post now happens at the cursor
	-- Increased recorder saving timeout (should cut down on errors)
	-- Lowered the session expiration.  You'll need to log in more, but
	   the API won't error as much
	-- Changed jQuery namespace to remove conflicts with other versions of
	   jQuery, Prototype, and other JavaScript libraries. (From $ to $v)

1.0 Beta 3 | Feb. 12, 2008
	-- Admin panel: You can now add videos to your posts.
	-- Player preference:  Choose Simple or Normal player for
	   both posts and comments.
	-- Width and Height in posts:  Choose the width and height
	   of the player in posts.
	-- Video comments now autoplay (removes one click) (to be
	   updated behind-the-scenes on 2/13/08)
	-- Larger thumbnail in posts
	-- Handles comment box IDs being different than Wordpress default
	-- Over 55 bug fixes.
	-- Smaller footprint.
	-- Cowbell++
	
1.0 Beta 2 | Never released, tested locally.

1.0 Beta 1 | Feb. 11, 2008
	Initial private release.
		
== Acknowledgements ==

Thanks to all of our BETA testers who took the risk of breaking
their sites to test out this plugin.

In use:
Viddler API:
http://developers.viddler.com/

phpviddler Viddler API wrapper:
https://github.com/viddler/phpviddler

jQuery JavaScript library: http://jquery.com/

Facebox: http://famspam.com/facebox