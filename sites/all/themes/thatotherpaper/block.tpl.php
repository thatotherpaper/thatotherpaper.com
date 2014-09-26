<div id="block-<?php print $block->module . "-" . $block->delta ?>" class="block block-<?php print $block->module?>">
  <?php if ($block->subject): ?><h2 class="title"><?php print pressflow_typeset_render($block->subject); ?></h2><?php endif;?>
  <div class="content"><?php print pressflow_typeset_render($block->content); ?></div>
  <div class="clear"></div>
</div><!-- /block -->
