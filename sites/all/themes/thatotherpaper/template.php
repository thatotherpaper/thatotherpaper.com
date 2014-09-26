<?php

/* custom regions */
function thatotherpaper_regions() {
  return array(
    'left' => t('left sidebar'),
    'right' => t('right sidebar'),
    'header_left' => t('left header'),
    'header_right' => t('right header'),
    'promo' => t('promo'),
    'sellout_above' => t('sellout above'),
    'content' => t('content'),
    'admin_section' => t('admin section'),
    'footer' => t('footer'),
    );
}


/**
 * Return customized comment output
 * 
 * IMPORTANT: This function overrides and eliminates the need for comment.tpl.php!
 *   Delete or comment out this function if you want to use comment.tpl.php
 */
function thatotherpaper_comment($comment, $links = array()) {
  $output = '';

  // Build some comment classes
  $comment_classes = array('comment');
  if ($comment->status == COMMENT_NOT_PUBLISHED) {
    $comment_classes[] = 'comment-unpublished';
  }
  if ($comment->new) {
    $comment_classes[] = 'comment-new';
    $output .= '<div class="new">New!</div>';
  }

  if (module_exists('thatotherpaper_library')) { 
    $output .= thatotherpaper_library_custom_submitted($comment, TRUE, TRUE, 'j F Y g:ia');
  }

  $output .= '<div class="comment-inner">' . "\n";

  // If pictures (avatars) are enabled for comments, generate picture output
  if (theme_get_setting('toggle_comment_user_picture')) {
    $output .= theme('user_picture', $comment);
  }
  // If user_badges module is enable, print badges
  if (module_exists('user_badges')) {
    $output .= user_badges_for_uid($comment->uid);
  }

  $output .= '<div class="content">' . $comment->comment . '</div>' . "\n";
  $output .= '<div class="clear"></div><!-- clears floated picture (avatar) -->' .  "\n";

  if ($links && module_exists('thatotherpaper_library')) {
    $output .= thatotherpaper_library_custom_links($links, 'comment');
  }

  $output .= '</div><!-- /comment-inner -->' . "\n";

  return '<div id="comment-' . $comment->cid . '" class="' . implode(' ', $comment_classes) . '">' . "\n" . $output . '</div><!-- /comment -->' . "\n\n";
}

/*
<div class="comment<?php print ($comment->new) ? ' comment-new' : '' ?>"><div class="comment-inner">
  <?php if ($comment->new) : ?><div class="new"><?php print $new ?></div><?php endif; ?>

  <?php if (module_exists('thatotherpaper_library')) { print thatotherpaper_library_custom_submitted($comment); } ?>

  <?php if ($picture) print $picture; ?>
  <?php if (module_exists('user_badges')) { print user_badges_for_uid($comment->uid); } ?>

  <div class="content"><?php print $content ?></div>

  <?php if (module_exists('thatotherpaper_library')) { print thatotherpaper_library_custom_links($comment, 'comment', $links); } ?>
</div></div><!-- /comment-inner /comment -->
*/


/**
 * Add a better wrapper around entire comment section
 */
function thatotherpaper_comment_wrapper($content) {
  $output = '';

  $has_comments = FALSE;
  if (arg(0) == 'node' && is_numeric(arg(1)) && !arg(2)) {
    $node = node_load(arg(1));
    if ($node->comment_count > 0) {
      $has_comments = TRUE;
    }
  }

  // if the node has no comments, nothing will output
  if ($content) {
    $output .= '<div id="comments">' . "\n";

    if ($has_comments) {
      $output .= '<h2 class="title">' . t('Comments') . '</h2>' . "\n";
    }

    $output .= $content . "\n";
    $output .= '</div><!-- /#comments -->' . "\n";
  }

  return $output;
}


/* custom search box (in header) 
function phptemplate_search_theme_form($form) {
  return _phptemplate_callback('search-theme-form', array('form' => $form));
}*/


/**
 * Override breadcrumb output
 */
function thatotherpaper_breadcrumb($breadcrumb) {
  unset($breadcrumb[0]); // Remove "Home"
  if (!empty($breadcrumb)) {
    return '<div id="breadcrumb">'. implode(' :: ', $breadcrumb) .'</div>';
  }
}


/**
 * Weather module: Override block output
 */
function thatotherpaper_weather($config, $metar) {
  $image = _thatotherpaper_weather_get_image($metar); // Was: _weather_get_image($metar)
  $condition = _weather_format_condition($metar);

  $content .= '<img class="weather-icon" src="' . $image['filename'] . '" alt="'. $condition .'" '. $image['size'] . ' title="'. $condition .'" />' . "\n";
  $content .= '<div class="weather-text">' . "\n";

  if (isset($metar['temperature'])) {
    $content .= '<div class="weather-temp">' . _weather_format_temperature($metar['temperature'], $config['units']) . '</div>' . "\n";
    }

  if ($config['settings']['show_sunrise_sunset']) {
    $content .= '<div class="weather-sun">';

    // Check if there is a sunrise or sunset
    if ($metar['daytime']['no_sunrise']) {
      $content .= t('No sunrise today');
    }
    else if ($metar['daytime']['no_sunset']) {
      $content .= t('No sunset today');
    }
    else {
      $content .= 'Sunrise ' . format_date($metar['daytime']['sunrise_on'], 'custom', 'g:ia') . ' | ';
      $content .= 'Sunset ' . format_date($metar['daytime']['sunset_on'], 'custom', 'g:ia');
    }

    $content .= '</div>' . "\n" . '</div>' . "\n";
  }

  return $content;
}


/**
 * Weather module: Provide alternate images in theme directory
 *
 * Copied wholesale from _weather_get_image()
 * Only two lines have been changed
 */
function _thatotherpaper_weather_get_image($metar) {
  // is there any data available?
  if (!isset($metar['condition_text'])) {
    $name = 'nodata';
  }
  else {
    // handle special case: NSC, we just use few for the display
    if ($metar['condition_text'] == 'no-significant-clouds') {
      $metar['condition_text'] = 'few';
    }
    // calculate the sunrise and sunset times for day/night images
    $name = $metar['daytime']['condition'] .'-'. $metar['condition_text'];

    // handle rain images
    if (isset($metar['phenomena']['rain'])) {
      $rain = $metar['phenomena']['rain'];
    }
    else if (isset($metar['phenomena']['drizzle'])) {
      $rain = $metar['phenomena']['drizzle'];
    }
    if (isset($rain)) {
      if (isset($rain['#light'])) {
        $name .= '-light-rain';
      }
      else if (isset($rain['#heavy'])) {
        $name .= '-heavy-rain';
      }
      else {
        $name .= '-moderate-rain';
      }
    }
  }

  // set up final return array
  $image['filename'] = base_path() . drupal_get_path('theme', 'thatotherpaper') .'/images/weather/'. $name .'.gif'; // CHANGE
//  $image['filename'] = base_path() . drupal_get_path('module', 'weather') .'/images/'. $name .'.png';
  $size = getimagesize(drupal_get_path('theme', 'thatotherpaper') .'/images/weather/'. $name .'.gif'); // CHANGE
//  $size = getimagesize(drupal_get_path('module', 'weather') .'/images/'. $name .'.png');
  $image['size'] = $size[3];
  return $image;
}


/* flickr */
function thatotherpaper_flickr_photo($photo, $size = NULL, $format = NULL) {
  $img_url = flickr_photo_img($photo['server'], $photo['id'], $photo['secret'], $size, $format);
  $img = theme('image', $img_url, $photo['title'], $photo['title'], array('class' => 'flickr photo'), FALSE);
  $photo_url = flickr_photo_page_url($photo['owner'], $photo['id']);
  return "<a href='$photo_url'>$img</a>";
}


/* slideshow module 
function thatotherpaper_slideshow($previous, $current, $next, $total, $title, $image, $body) {
  return _phptemplate_callback('slideshow', array(
    'previous' => $previous, 
    'current' => $current, 
    'next' => $next, 
    'total' => $total,
    'title' => $title, 
    'image' => $image, 
    'body' => $body,
    ));
}*/


function thatotherpaper_forward_email($vars) {

  $style = '<style>
      <!--
        body { margin: 15px; background-color: black; font-family: "Trebuchet MS", Verdana, sans-serif; color: white; }
        #container { width: 644px; margin: 0 auto; }
        #header { width: 644px; }
        #body { width: 600px; margin: 10px auto; padding: 20px; background-color: white; border: 2px solid rgb(21,136,200); color: rgb(50,50,50); }
        #footer { width: 644px; text-align: right; }

        .message { margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid rgb(21,136,200); }
        .article-header, .article { margin-bottom: 10px; line-height: 1.5em; }
        .article-title { font-size: 1.5em; line-height 1.5em }
        .links { margin-bottom: 15px; font-size: 1.5em; font-weight: bold; }
        .dynamic-content { padding-top: 10px; border-top: 1px solid rgb(21,136,200); }
        .ad-footer { padding-top: 10px; border-top: 1px solid rgb(21,136,200); text-align: center; }

        .b, .strong { font-weight: bold; }
        .i, .em { font-style: oblique; }
        .u { text-decoration: underline; }
        .allcaps { text-transform: uppercase; }
        .smallcaps { font-variant: small-caps; }
        .dropcap {
          font-family: Georgia, "Times New Roman", Times, serif;                    
          color: rgb(21,136,200);
          line-height: 80%;
          float: left;
          font-size: 5em;
          margin-right: 10px;
          text-transform: uppercase;
          }

        .nob, .nostrong { font-weight: normal; }
        .noi, .noem { font-style: normal; }
        .nospacing { letter-spacing: 0px !important; }
        .rom { font-weight: normal !important; font-style: normal !important; text-decoration: none !important; }

        .small, small { font-size: .75em !important; }
        .big, big { font-size: 1.25em !important; }
        .huge { font-size: 1.5em !important; }

        .on { color: rgb(115,169,201) !important; } /* med blue */
        .off { color: rgb(160,160,160) !important; } /* dark gray */
          .off a { color: rgb(160,160,160) !important; } /* dark gray */

        .lightgray { color: rgb(190,190,190); }
        .medgray { color: rgb(160,160,160); }
        .darkgray { color: rgb(100,100,100); }
        .black { color: rgb(0,0,0); }
        .red { color: rgb(190,0,0); }
        .green { color: rgb(98,157,28); }
        .blue { color: rgb(21,136,200); }
        
        code {
          padding: 0;
          background-color: rgb(240,240,240);
          font-family: Monaco, Courier, monospace;
          }
          div.codeblock { /* class created by the Code Filter module */
            margin: 10px 0;
            }
        
        pre {
          display: block;
          margin: 10px 0;
          padding: 5px;
          border: 1px solid rgb(100,100,100);
          background-color: rgb(240,240,240);
          line-height: 1.5em;
          }
          pre code { overflow: auto; }
          pre.ascii_art_captcha {
            border-color: rgb(138,196,228);
            background-color: rgb(232,243,250);
            font-size: .9em;
            }
        
        acronym, abbr { border-bottom: 1px dashed rgb(100,100,100); cursor: help; }
        strike { text-decoration: line-through; color: rgb(100,100,100); }
        ins { color: rgb(190,0,0); text-decoration: none;}
        
        a { color: rgb(6,104,177); text-decoration: none; }
        a:hover { color: rgb(50,50,50); }
        
        img {
          margin: 0;
          padding: 0;
          border: none;
          }
        div.image {
          margin-bottom: 10px;
          }
        
        h1, h2, h3, h4 {
          margin: 0 0 5px 0;
          padding: 0;
          font-weight: bold;
          line-height: 1.15em;
          }
          h1 a, h2 a, h3 a, h4 a {
            color: rgb(6,104,177) !important;
            }
          h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover {
            color: rgb(50,50,50) !important;
            text-decoration: none !important;
            }
        h1 {
          clear: both;
          color: rgb(6,104,177);
          font-size: 2em;
          }
        h2 {
          color: rgb(21,136,200);
          font-size: 1.5em;
          }
        h3 {
          color: rgb(50,50,50);
          font-size: 1.25em;
          }
        h4 {
          font-size: 1em;
          }
        
        .alignright { float: right; }
        .alignleft { float: left; }
        .aligncenter { display: block; margin-left: auto; margin-right: auto; }
        .aligntop { vertical-align: top; }
        .alignmiddle { vertical-align: middle; }
        .alignbottom { vertical-align: bottom; }
        .floatleft { float: left; margin-right: 15px; margin-bottom: 10px; }
        .floatright { float: right; margin-left: 15px; margin-bottom: 10px; }
        
        .textleft { text-align: left; }
        .textright { text-align: right; }
        .textcenter, .center { text-align: center; }
        
        .last { margin-bottom: 0 !important; padding-bottom: 0 !important; }
        .noline { border-bottom: none !important; }
        .noborder { border: none !important; }
        .clear { clear: both; }
        .hide { display: none; }
        .space { margin-right: 10px; }
        .indent { margin-left: 15px; }
        
        hr {
          clear: both;
          width: 100%; 
          height: 1px;
          margin: 15px auto 15px auto;
          padding: 0;
          border: none;
          background-color: rgb(21,136,200);
          color: rgb(21,136,200);
          }
      -->
    </style>';

  $output = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    '.$style.'
    <base href="'.url('',NULL,NULL,TRUE).'" />
  </head>
  <body>
    <div id="container">
      <div id="header">'.l('<img src="'.$vars['forward_header_image'].'" border="0" alt="'.$vars['site_name'].'">', '',NULL,NULL,NULL,TRUE,TRUE).'</div>
      <div id="body">
        <div class="message">'. $vars['forward_message'];
          if ($vars['message']) {
            $output .= ' <b>'. $vars['message'] .'</b>';
          }
        $output .= '
        </div>
        <div class="article-header">
          <div class="article-title b">'. l($vars['content']->title, 'forward/emailref/'.$vars['path'], NULL, NULL, NULL, TRUE) .'</div>';
          if (theme_get_setting('toggle_node_info_'.$vars['content']->type)) {
            $output .= '<div class="article-byline i">'.t('by %author', array('%author' => $vars['content']->name)).'</div>';
          }
        $output .= '
        </div>
        <div class="article">'.$vars['content']->teaser.'</div>
        <div class="links">'. l('Read more...', 'forward/emailref/'. $vars['path'], NULL, NULL, NULL, TRUE) .'</div>';
        if ($vars['dynamic_content']) {
          $output .= '<div class="dynamic-content">'.$vars['dynamic_content'].'</div>';
        }
        $output .= '
        <div class="ad-footer">'. $vars['forward_ad_footer'] .'</div>
      </div>
      <div id="footer">'. $vars['forward_footer'] .'</div>
    </div>
  </body>
</html>';

  return $output;
}


/**
 * Intercept template variables
 *
 * @param $hook
 *   The name of the theme function being executed
 * @param $vars
 *   A sequential array of variables passed to the theme function.
 */
function _phptemplate_variables($hook, $vars = array()) {
  switch ($hook) {

    case 'page':

      // ***
      // Set new variables for page.tpl.php

      // Check authenticated user status
      global $user;

      // Check authenticated user status
      global $user;
      if ($user->uid > 0) { // User is logged in (anonymous user has an ID of zero)
        $vars['logged_in'] = TRUE;
      }
      else { // User is NOT logged in
        $vars['logged_in'] = FALSE;
      }

      if (module_exists('thatotherpaper_library')) {
        $vars['thatotherpaper_library_exists'] = TRUE;
        $vars['is_admin'] = thatotherpaper_library_is_admin(); // Determine admin access
      }
      else {
        $vars['thatotherpaper_library_exists'] = FALSE;
      }

      // ***
      // Classes for body element

      $body_classes = array();
      $body_classes[] = ($vars['is_front']) ? 'front' : 'not-front';
      $body_classes[] = ($vars['logged_in']) ? 'logged-in' : 'not-logged-in';

      if ($vars['node']->type) {
        $body_classes[] = 'ntype-'. thatotherpaper_id_safe($vars['node']->type);
      }

      // Set body class for number of columns in use
      if ($vars['left'] && $vars['right']) {
        $body_classes[] = 'both-sidebars';
      }
      else if ($vars['left']) {
        $body_classes[] = 'left-sidebar';
      }
      else if ($vars['right']) {
        $body_classes[] = 'right-sidebar';
      }

      // Determine admin access
      if ($vars['is_admin']) {
        $body_classes[] = 'admin';
      }

      // Implode with spaces
      $vars['body_classes'] = implode(' ', $body_classes);

      break;

    case 'node':

      // ***
      // Set new variables for node.tpl.php

      if (module_exists('thatotherpaper_library')) {
        $vars['thatotherpaper_library_exists'] = TRUE;
        $vars['is_admin'] = thatotherpaper_library_is_admin(); // Determine admin access
        $vars['has_map'] = thatotherpaper_library_has_map($vars['node']);
      }
      else {
        $vars['thatotherpaper_library_exists'] = FALSE;
      }

      // ***
      // Classes for node element

      $node_classes = array('node');
      if ($vars['sticky']) {
        $node_classes[] = 'sticky';
      }
      if (!$vars['node']->status) {
        $node_classes[] = 'node-unpublished';
      }
      $node_classes[] = 'ntype-'. thatotherpaper_id_safe($vars['node']->type);

      // Implode with spaces
      $vars['node_classes'] = implode(' ', $node_classes);

      break;

    case 'comment':

      // we load the node object that the current comment is attached to
      $node = node_load($vars['comment']->nid);

      // if the author of this comment is equal to the author of the node, we set a variable
      // then in our theme we can theme this comment differently to stand out
      $vars['author_comment'] = $vars['comment']->uid == $node->uid ? TRUE : FALSE;

      break;
  }

  return $vars;
}


/**
 * Converts a string to a suitable html ID attribute.
 * - Prefixes string with 'n' if the initial character is numeric.
 * - Replaces non-alphanumeric characters with '-'.
 * - Converts entire string to lowercase.
 * - Works for classes too!
 * 
 * @param string $string
 *  the string
 * @return
 *  the converted string
 */
function thatotherpaper_id_safe($string) {
  if (is_numeric($string{0})) {
    // if the first character is numeric, add 'n' in front
    $string = 'n' . $string;
  }
  return strtolower(preg_replace('/[^a-zA-Z0-9-]+/', '-', $string));
}


function thatotherpaper_views_rss_feed($view, $nodes, $type){
  if ($type == 'block') {
      return;
    }
    global $base_url;
  
    $channel = array(
      // a check_plain isn't required on these because format_rss_channel
      // already does this.
      'title'       => views_get_title($view, 'page'),
      'link'        => url($view->feed_url ? $view->feed_url : $view->real_url, NULL, NULL, true),
      'description' => $view->description,
    );
  
    $item_length = variable_get('feed_item_length', 'teaser');
    $namespaces = array('xmlns:dc="http://purl.org/dc/elements/1.1/"');
  
    // Except for the original being a while and this being a foreach, this is
    // completely cut & pasted from node.module.
    foreach ($nodes as $node) {
      // Load the specified node:
      $item = node_load($node->nid);
      $link = url("node/$node->nid", NULL, NULL, 1);
  
      if ($item_length != 'title') {
        $teaser = ($item_length == 'teaser') ? TRUE : FALSE;
  
        // Filter and prepare node teaser
        if (node_hook($item, 'view')) {
          node_invoke($item, 'view', $teaser, FALSE);
        }
        else {
          $item = node_prepare($item, $teaser);
        }
  
        // Allow modules to change $node->teaser before viewing.
        node_invoke_nodeapi($item, 'view', $teaser, FALSE);
      }
  
      // Allow modules to add additional item fields
      $extra = node_invoke_nodeapi($item, 'rss item');
      $extra = array_merge($extra, array(array('key' => 'pubDate', 'value' =>  date('r', $item->created)), array('key' => 'dc:creator', 'value' => $item->name), array('key' => 'guid', 'value' => $item->nid . ' at ' . $base_url, 'attributes' => array('isPermaLink' => 'false'))));
      foreach ($extra as $element) {
        if ($element['namespace']) {
          $namespaces = array_merge($namespaces, $element['namespace']);
        }
      }
      
      // Prepare the item description
      switch ($item_length) {
        case 'fulltext':
          $item_text = $item->body;
          break;
        case 'teaser':
          $item_text = $item->teaser;
          if ($item->readmore) {
            $item_text .= '<p>'. l(t('read more'), 'node/'. $item->nid, NULL, NULL, NULL, TRUE) .'</p>';
          }
          break;
        case 'title':
          $item_text = '';
          break;
      }
  
      $items .= "<item>\n";
      $items .= ' <title>'. check_plain($item->title) ."</title>\n";
      $items .= ' <link>'. check_url($link) ."</link>\n";
      $items .= ' <description>'. "<![CDATA[" . $item_text . "]]>" ."</description>\n";
      $items .= format_xml_elements( $extra);
      $items .= "</item>\n";
    }
  
    $channel_defaults = array(
      'version'     => '2.0',
      'title'       => variable_get('site_name', 'drupal') .' - '. variable_get('site_slogan', ''),
      'link'        => $base_url,
      'description' => variable_get('site_mission', ''),
      'language'    => $GLOBALS['locale'],
    );
    $channel = array_merge($channel_defaults, $channel);
  
    $path = drupal_get_path('module', 'views');
    $output = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    $output .= "<rss version=\"". $channel["version"] . "\" xml:base=\"". $base_url ."\" ". implode(' ', $namespaces) .">\n";
    $output .= format_rss_channel($channel['title'], $channel['link'], $channel['description'], $items, $channel['language']);
    $output .= "</rss>\n";
  
    drupal_set_header('Content-Type: text/xml; charset=utf-8');
    print $output;
    module_invoke_all('exit');
    exit;
}
