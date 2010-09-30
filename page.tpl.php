<?php
// $Id: page.tpl.php,v 1.28.2.1 2009/04/30 00:13:31 goba Exp $
?><!DOCTYPE html>
<html lang="<?php print $language->language ?>">
<head>
	<?php print $head ?>
	<meta charset="utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<?php print $head ?>
	
	<title><?php print $head_title ?></title>
	
	<?php print $styles ?>
	<?php print $scripts ?>
	<script type="text/javascript"><?php /* Needed to avoid Flash of Unstyle Content in IE */ ?> </script>
	
	<!--[if IE 6]>
		<link rel="stylesheet" href="css/build/dws_style_ie6_raw.css" type="text/css" charset="utf-8">
	<![endif]-->
		
	<?php /*<link rel="shortcut icon" href="http://www.akvo.org/images/favicon.ico" /> */?>
	<link rel="alternate" type="application/rss+xml" title="Blog entries" href="/news/?feed=rss2" />
	<link rel="alternate" type="application/rss+xml" title="Project updates" href="/rsr/rss/all-updates" />
	
	</head>
<body>
<div id="header_container" class="container">
	<a href="/">
		<img src="<?php print $logo ?>" width="222" height="41" 
			alt="<?php print $site_name ?>" style="float:left;">
	</a>
	<?php if (isset($primary_links)) { ?>
		<?php print theme('links', $primary_links, array('class' => 'links', 'id' => 'main_nav')) ?>
	<?php } ?>
</div>

<?php /* print $header */ ?>

<div id="main_container" class="container" style="margin-top:30px;">
	<div class="span-14" style="margin-bottom:20px;">
		<div id="breadcrum_back">			
			<?php print $breadcrumb ?>
			<div class="clear"></div>
		</div>
	</div>
	<div class="span-11 first">
		<h1 class="title"><?php print $title ?></h1>
        <div class="tabs"><?php print $tabs ?></div>
		<?php if ($show_messages) { print $messages; } ?>
        <?php print $help ?>
        <?php print $content; ?>
        <?php print $feed_icons; ?>
	</div>
	<div class="span-3 last">
		<?php if ($right) { ?>
	      <?php print $right ?>
		<?php } ?>

		<?php if ($left) { ?>
	      <?php print $left ?>
		<?php } ?>
	</div>
	<div class="span-14" style="display:none;">
		<?php print $footer_message ?>
	 	<?php print $footer ?>
	</div>
</div>

<div id="footer" class="container">
	<div id="footer_bar">&nbsp;</div>

	<p class="small grey">
		Site under 
		<a href="/web/open_license">open licence</a> &nbsp;|&nbsp;
		<a href="/web/terms_of_use">Terms of use</a> &nbsp;|&nbsp;
		<a href="/web/privacy_policy">Privacy policy</a> &nbsp;|&nbsp;
		<a href="/web/credits">Credits</a> &nbsp;|&nbsp;
		<a href="/web/admin">Admin</a>
        
        <a href="/web/contact_us" style="margin-left:30px;">Contact us</a>
        <img src="<?php echo path_to_theme() ?>/img/holland_logo_oranje_74x25.gif" style="float: right; margin-top: -6px;"/>
	</p>
</div>
<?php print $closure ?>

<?php /*
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script>
	!window.jQuery && document.write('<script src="js/jquery-1.4.2.min.js"><\/script>')
</script>

<script type="text/javascript">
	var $ = jQ = jQuery.noConflict();

	jQ(document).ready(function(){

	});		
</script>

*/ ?>
</body>
</html>