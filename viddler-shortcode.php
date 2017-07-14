<?
/*
::Examples::
[viddler id=e453bb4e w=1200]
[viddler id=e453bb4e w=437 h=288 t=99 a=t p=player b=f lr=cats]
[viddler id=e453bb4e&t=99&a=f&p=simple&b=f]
[viddler id=e453bb4e&w=437&w=700&lr=preroll&wm=transparent]

::Required::
id = required, Viddler video ID. (alpha-numeric)

::Optional shortened variables::
w = width (int) default:437 (or the content_width)
h = height (int)
t = time to start video playhead (int) default:0
a = autoplay switch (t or f) default:f
    WPCOM only VIPs can autoplay
p = player type to use (simple, full or mini) default:full
b = branding switch (t or f) default:f
lr = flashvars for LiveRail (flashvar is liverailTags) (alpha) default: none
wm = wmode (transparent, opaque, window) default: none

::NOW SUPPORTS ALL VIDDLER FLASHVARS::
You don't have to use the shortened variables above, just submit the actual real
viddler flashvar and the code snippet will place it for you.

::Example of real flash vars::
[viddler id=e453bb4e&w=437&h=700&autoplay=t&hd=t]
[viddler id=e453bb4e w=437 h=700 autoplay=t hd=t]

::Flashvar List::
http://developers.viddler.com/documentation/player/

::Specify Embed Code Type::
- legacy
[viddler id=e453bb4e w=437 h=700 autoplay=t hd=t embed=legacy]

- html5fallback
[viddler id=e453bb4e w=437 h=700 autoplay=t hd=t embed=html5fallback]

- iframe
[viddler id=e453bb4e w=437 h=700 autoplay=t hd=t embed=iframe]
*/

add_shortcode('viddler', 'viddler_sc_handler');

function viddler_sc_handler($atts)
{
  //If only one variable, probably old shortcode with '&', fix it
  if (count($atts) == 1) {
    $keys = array_keys($atts);
    $tmp = array();
    foreach (explode('&amp;', $atts[$keys[0]]) as $v) {
      if (! strstr($v, '=')) {
        $tmp[$keys[0]] = $v;
      }
      else {
        $arr = explode('=', $v);
        $tmp[$arr[0]] = $arr[1];
      }
    }
    $atts = $tmp;
  }
  
  //Set up the default vars
  $vars       = NULL;
  $players    = array('player', 'simple', 'mini', 'full');
  $embeds     = array('legacy','html5fallback', 'iframe');
  $wmode      = array('transparent', 'opaque', 'window');
  $flashvars  = array();
  $camel      = array(
    'forcehtml5'    =>  'forceHtml5',
    'liverailtags'  =>  'liverailTags'
  );
  $default_vars = array(
    'id'    =>  '',
    'w'     =>  437,
    'h'     =>  '',
    't'     =>  '',
    'p'     =>  'embed',
    'a'     =>  'f',
    'b'     =>  'f',
    'lr'    =>  '',
    'wm'    =>  '',
    'embed' =>  'iframe',
    'bfp'   =>  'f',
    'bfpt'  =>  'current'
  );
  
  //Set PHP symbols (variables) from the defaults and shortcode attributes
  extract(shortcode_atts($default_vars, $atts));
  
  //Set width
  $w = (isset($w) && ! empty($w) && is_numeric($w)) ? $w : 437;
  $w = (! empty($GLOBALS['content_width']) && $w > $GLOBALS['content_width']) ? $GLOBALS['content_width'] : $w;
  
  //Set height
  $h = (isset($h) && ! empty($h) && is_numeric($h) && $h >= 250 & $h <= 1200) ? $h : ceil($w * 370 / 437);
  
  //Set time offset
  $t = (isset($t) && ! empty($t) && is_numeric($t)) ? $t : NULL;
  
  //Embed Code Type
  $embed = (isset($embed) && ! empty($embed) && in_array($embed, $embeds)) ? $embed : 'iframe';
  
  //Player Type
	$p = (isset($p) && ! empty($p) && in_array($p, $players)) ? $p : 'player';
	$p = ($p == 'full' && $embed != 'iframe') ? 'player' : $p;
	if ($embed == 'iframe') {
	 $flashvars['player'] = ($p == 'player') ? 'full' : $p;
	}
  
  //Window Mode
  $wm = (isset($wm) && ! empty($wm) && in_array($wm, $wmode)) ? $wm : NULL;
  
  /** Start Flashvars **/
  //Auto-play
  $flashvars['autoplay'] = (isset($a) && ($a == '1' || $a == 't')) ? 't' : 'f';
  
  //Branding
  $flashvars['disablebranding'] = (isset($b) && ($b == '1' || $b == 't')) ? 't' : 'f';
  
  //LiveRail
  //Used to verify the liverail tag(s) submitted, removed that
  $flashvars['liverailTags'] = (isset($lr) && ! empty($lr)) ? $lr : '';
  
  //Post Roll Permalinks
  if (isset($bfp) && ($bfp == '1' || $bfp == 't' || $bfp == 'true')) {
    $flashvars['videobrowserfollowpermalink'] = 't';
    $flashvars['videobrowserfollowpermalinktarget'] = (isset($bfpt) && ! empty($bfpt) && in_array($bfpt, array('current','new'))) ? $bfpt : 'current';
  }
  
  //All other flashvars
  foreach ($atts as $k => $v) {
    if (! array_key_exists($k, $default_vars)) {
      $k = (array_key_exists($k, $camel)) ? $camel[$k] : $k;
      $v = (string) $v;
      $flashvars[$k] = $v;
      if ($k == 'secret') {
        $flashvars['openUrl'] = $v;
      }
    }
  }
  
  //If forceHtml5 = t||true||1, set player type to embed and embed type to iframe
  if (isset($flashvars['forceHtml5']) && ($flashvars['forceHtml5'] == '1' || $flashvars['forceHtml5'] == 't' || $flashvars['forceHtml5'] == 'true')) {
    $flashvars['forceHtml5'] = 'true';
    $p = 'embed';
    $embed = 'iframe';
  }
  
  //Create the flashvar query string
  foreach ($flashvars as $k => $v) {
    $vars .= '&' . $k . '=' . $v;
  }
  
  //Embed Types
  //Legacy
  $legacy    = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' . $w . '" height="' . $h . '" id="viddler_' . $p . '_' . $w . '">';
  $legacy   .= ' <param name="movie" value="//www.viddler.com/' . $p . '/' . $id . '/' . $t . '">';
  $legacy   .= '<param name="allowScriptAccess" value="always"/>';
  $legacy   .= '<param name="allowNetworking" value="all"/>';
  $legacy   .= '<param name="wmode" value="' . $wm . '"/>';
  $legacy   .= '<param name="allowFullScreen"value="true"/>';
  $legacy   .= '<param name="flashVars" value="f=1' . $vars . '"/>';
  $legacy   .= '<embed src="//www.viddler.com/' . $p . '/' . $id . '/' . $t . '" width="' . $w . '" height="' . $h . '" ';
  $legacy   .= 'type="application/x-shockwave-flash" wmode="' . $wm . '" allowScriptAccess="always" allowFullScreen="true" ';
  $legacy   .= 'allowNetworking="all" name="viddler_' . $p . '_' . $w . '" flashVars="f=1' . $vars . '"></embed></object>';
  
  //HTML5 Fallback
  $fallback  = '<!--[if IE]><object width="' . $w . '" height="' . $h . '" id="viddlerOuter-' . $id . '" ';
  $fallback .=  'classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">';
  $fallback .= '<param value="//www.viddler.com/' . $p . '/' . $id . '/' . $t . '" name="movie">';
  $fallback .= '<param value="always" name="allowScriptAccess">';
  $fallback .= '<param name="wmode" value="' . $wm . '"/>';
  $fallback .= '<param value="true" name="allowFullScreen">';
  $fallback .= '<param name="FlashVars" value="f=1' . $vars . '">';
  $fallback .= '<object id="viddlerInner-' . $id . '">';
  $fallback .= '<video id="viddlerVideo-' . $id . '" src="//www.viddler.com/file/' . $id . '/html5mobile/" ';
  $fallback .= 'type="video/mp4" width="' . $w . '" height="' . $h . '" poster="//www.viddler.com/thumbnail/' . $id . '/" controls="controls"></video>';
  $fallback .=  '</object></object>';
  $fallback .= '<![endif]--> <!--[if !IE]> <!--> ';
  $fallback .= '<object width="' . $w . '" height="' . $h . '" id="viddlerOuter-' . $id . '" type="application/x-shockwave-flash" ';
  $fallback .= 'data="//www.viddler.com/' . $p . '/' . $id . '/' . $t . '">';
  $fallback .= '<param value="//www.viddler.com/' . $p . '/' . $id . '/' . $t . '" name="movie">';
  $fallback .= '<param name="wmode" value="' . $wm . '"/>';
  $fallback .=  '<param value="always" name="allowScriptAccess">';
  $fallback .= '<param value="true" name="allowFullScreen">';
  $fallback .= '<param name="FlashVars" value="f=1' . $vars . '">';
  $fallback .= '<object id="viddlerInner-' . $id . '">';
  $fallback .= '<video id="viddlerVideo-' . $id . '" src="//www.viddler.com/file/' . $id . '/html5mobile/" ';
  $fallback .= 'type="video/mp4" width="' . $w. '" height="' . $h . '" poster="//www.viddler.com/thumbnail/' . $id . '/" controls="controls"></video>';
  $fallback .= '</object></object> <!--<![endif]-->';
  
  //iframe
  $iframe    = '<iframe id="viddler-' . $id . '" src="//www.viddler.com/embed/' . $id . '/' . $t . '?f=1' . $vars . '" width="' . $w . '" ';
  $iframe   .= 'height="' . $h . '" frameborder="0" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>';
  
  //Return the correct embed code
  if (is_feed() || $embed == 'legacy') {
    return $legacy;
  }
  elseif ($embed == 'html5fallback') {
    return $fallback;
  }
  
  return $iframe;
}