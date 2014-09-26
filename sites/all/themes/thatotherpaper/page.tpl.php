<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language ?>" xml:lang="<?php print $language ?>">

<head>
  <title><?php print $head_title; ?></title>
  <?php print $head; ?>
  <?php print $styles; ?>
  <?php print $scripts; ?>

  <!--[if lt IE 7]>
  <style type="text/css" media="all">@import "<?php print $base_path . $directory; ?>/style_ie6.css";</style>
  <![endif]-->
  <!--[if IE 7]>
  <style type="text/css" media="all">@import "<?php print $base_path . $directory; ?>/style_ie7.css";</style>
  <![endif]-->
  <style type="text/css" media="print">@import "<?php print $base_path . $directory; ?>/print.css";</style>
</head>

<body class="<?php print $body_classes; ?>">
<div id="outerWrapper">

<div id="header"><div id="skyline">

  <div id="headerLeft">
    <!--[if lt IE 7]>
    <div id="logo-gif" class="logo"><a href="<?php print $base_path ?>" title="That Other Paper"><img 
      src="<?php print $base_path . $directory . '/images/header.logo.gif' ?>" 
      alt="That Other Paper" /></a></div>
    <style type="text/css">
    #logo-png { display: none; }
    </style>
    <![endif]-->

    <div id="logo-png" class="logo"><a href="<?php print $base_path ?>" title="That Other Paper"><img 
      src="<?php print $base_path . $directory . '/images/header.logo.png' ?>" 
      alt="That Other Paper" /></a></div>

    <?php print $header_left; ?>
  </div><!-- /#headerLeft -->

  <div id="headerRight">
    <?php print $header_right; ?>
  </div><!-- /#headerRight -->

</div></div><!-- /#skyline, /#header -->

<div id="subheader">
  <?php if ($primary_links) { ?>
    <div id="primary"><?php print theme('menu_links', $primary_links); ?></div>
  <?php } ?>
  <?php if ($search_box) print $search_box; ?>
</div><!-- /#subheader -->

<div id="columnCenter">

  <div id="print_header">
    <img id="print_logo" src="<?php print $base_path . $directory . '/images/print.logo.png' ?>" alt="That Other Paper logo" />
    <div class="print_sourceurl"><small>Printed from</small> <strong><?php print url($_GET['q'], NULL, NULL, TRUE); ?></strong></div>
  </div><!-- /#print_header -->

  <?php if ($promo) : ?><div id="promo"><?php print $promo; ?></div><!-- /#promo region --><?php endif; ?>

  <?php if ($sellout_above) : ?>
    <div id="sellout_above" class="sellout<?php if (!$promo) { print ' nopromo'; } ?>">
      <?php print $sellout_above; ?>
    </div><!-- /#sellout_above region -->
  <?php endif; ?>

  <?php if ($breadcrumb) print $breadcrumb; ?>

  <div id="main">

    <?php if ($content_top) { ?><div id="content-top"><?php print $content_top; ?></div><?php } ?>

    <?php if (!$is_front && $title) : ?><h1 id="page-title" class="title"><?php print pressflow_typeset_render($title) ?></h1><?php endif; ?>
    <?php if ($tabs) : ?><div id="tabs"><?php print $tabs ?></div><?php endif; ?>

    <div id="main-inner">
      <?php print $messages; ?>
      <?php print $help; ?>
      <?php print $content; ?>
    </div><!-- /#main-inner -->

    <?php if ($admin_section) { ?>
      <div id="admin_section">
        <p class="textcenter allcaps">Admin section (not visible to user)</p>
        <?php print $admin_section; ?>
      </div><!-- /#admin_section region -->
    <?php } ?>

<?php /*
    <div id="content-bottom">
      <div id="content-bottom-gads-left">
        <!-- 250x250, created 7/14/09 -->
        <script type="text/javascript"><!--
          google_ad_client = "pub-4467390543328959";
          google_ad_slot = "4992111306";
          google_ad_width = 250;
          google_ad_height = 250;
          //-->
        </script>
        <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
      </div>
      <div id="content-bottom-gads-right">
        <!-- 300x250, created 7/14/09 -->
        <script type="text/javascript"><!--
          google_ad_client = "pub-4467390543328959";
          google_ad_slot = "8864660602";
          google_ad_width = 300;
          google_ad_height = 250;
          //-->
        </script>
        <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
      </div>
    </div><!-- /#content-bottom -->
*/ ?>

  </div><!-- /#main -->
  
  <div id="print_footer">
    <div class="print_sourceurl bottom"><small>Printed from</small> <strong><?php print url($_GET['q'], NULL, NULL, TRUE); ?></strong></div>
    <strong>That Other Paper</strong> | <strong>thatotherpaper.com</strong><br />Copyright Four Kitchens, LLC | Creative Commons licensed
  </div><!-- /#print_footer -->

</div><!-- /columnCenter -->

<div id="columnLeft">

  <!-- features --><div class="navSection">
    <div class="navSectionTitle"><img 
      src="<?php print $base_path . $directory . '/images/nav.section.features.gif' ?>"
      alt="Features" /></div>
    <ul class="navSection_features">
      <li><a href="/features/overheard_in_austin" class="nospacing">Overheard in Austin</a></li>
      <li><a href="/features/happiest_hours" class="nospacing">The Happiest Hours</a></li>
    </ul>
  </div><!-- /itineraries -->

  <!-- columns --><div class="navSection">
    <div class="navSectionTitle"><img 
      src="<?php print $base_path . $directory . '/images/nav.section.columns.gif' ?>"
      alt="Columns and Opinion" /></div>
    <ul class="navSection_columns">
      <li><a href="/columns/all_you_can_eat">All You Can Eat</a></li>
      <li><a href="/columns/capital_city_cheapo" class="nospacing">Capital City Cheapo</a></li>
      <li><a href="/columns/dr_daley">Dr. Daley</a></li>
      <li><a href="/columns/geekpop">GeekPop!</a></li>
      <li><a href="/columns/listening_parties">Listening Parties</a></li>
      <li><a href="/columns/safe_word">The Safe Word</a></li>
      <li><a href="/columns/techsploitation">Techsploitation</a></li>
    </ul>
  </div><!-- /columns -->

  <!-- itineraries --><div class="navSection">
    <div class="navSectionTitle"><img 
      src="<?php print $base_path . $directory . '/images/nav.section.itineraries.gif' ?>"
      alt="Itineraries (Stuff to Do)" /></div>
    <ul class="navSection_itineraries">
      <li><a href="/itineraries/top_picks">TOP Picks</a></li>
      <li><a href="/itineraries">Itineraries</a></li>
    </ul>
  </div><!-- /itineraries -->

  <!-- comics --><div class="navSection">
    <div class="navSectionTitle"><img 
      src="<?php print $base_path . $directory . '/images/nav.section.comics.gif' ?>"
      alt="Comics" /></div>
    <ul class="navSection_comics">
      <li><a href="/comics/bill_and_erik">Bill and Erik</a></li>
      <li><a href="/comics/honest_to_god">Honest to God</a></li>
      <li><a href="/comics/penciltucky">Penciltucky</a></li>
      <li><a href="/comics/south_40">South 40</a></li>
      <li><a href="/comics/strippy">Strippy</a></li>
    </ul>
  </div><!-- /comics -->

  <?php print $sidebar_left; ?>
</div><!-- /#columnLeft -->

<div id="columnRight">
  <?php print $sidebar_right; ?>

<?php /*
  <div id="columnRight-gads">
    <!-- 120x600, created 7/14/09 -->
    <script type="text/javascript"><!--
      google_ad_client = "pub-4467390543328959";
      google_ad_slot = "4343334392";
      google_ad_width = 120;
      google_ad_height = 600;
      //-->
    </script>
    <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
  </div>
*/ ?>
</div><!-- /#columnRight -->

<div class="clear"></div>
<div id="footerTop">
  <a href="http://www.fourkitchens.com/" title="created by Four Kitchens in Austin, Texas" index="nofollow"><img id="fklogo" src="<?php print $base_path . $directory . '/images/footer.fklogo.png' ?>" alt="created by Four Kitchens in Austin, Texas" /></a>
</div><!-- /#footerTop -->

<div id="footer">
  <?php if ($footer_message) print $footer_message; ?>
</div><!-- /#footer -->

</div><!-- /#outerWrapper -->

<?php print $closure; ?>

<!--    _____ ______ __  __ ______
       / ___// __  // / / // __  /
      / /_  / / / // / / // /_/ /              designed by
     / __/ / /_/ // /_/ // _  _/            Four Kitchens
    /_/   /_____//_____//_/ \_\  http://fourkitchens.com
    __  __  __ _______ _____ __   __ _____ __  __ _____
   / /_/ / / //__  __// ___// /__/ // ___//  \/ // ___/
  /   __/ / /   / /  / /   / ___  // __/ / /\  // /__
 / /\ \  / /   / /  / /__ / /  / // ___ / / / /___  /
/_/  \_\/_/   /_/  /____//_/  /_//____//_/ /_//____/ -->

</body>
</html>
