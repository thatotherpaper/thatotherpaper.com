<div id="buzzworthy">
<?php if ($block->subject): ?><h2 class="title"><?php print $block->subject; ?></h2><?php endif;?>
<?php print pressflow_typeset_render($block->content); ?><!-- /block-pressflow_buzzworthy -->
</div><!-- /#buzzworthy -->
