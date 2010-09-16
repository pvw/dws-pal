<?php
// $Id: block.tpl.php,v 1.3 2007/08/07 08:39:36 goba Exp $
?>
<?php/*
	<div class="block block-<?php print $block->module; ?>" id="block-<?php print $block->module; ?>-<?php print $block->delta; ?>">
    <h2 class="title"><?php print $block->subject; ?></h2>
    <div class="content"><?php print $block->content; ?></div>
 </div>
*/?>
<div id="name" class="gradient_box">
	<div class="space10">
		<h2 class="title"><?php print $block->subject; ?></h2>
	    <div class="content"><?php print $block->content; ?></div>
	</div>
</div>
<div class="linear_bg_bottom">
	&nbsp;
</div>