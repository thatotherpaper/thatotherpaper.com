<div id="block-<?php print $block->module . "-" . $block->delta ?>" class="block block-<?php print $block->module?>">
  <div class="block-flickr-title"><a href="http://flickr.com/photos/austins_only_paper" title="That Other Paper's flickr stream"><img src="<?php print base_path() . path_to_theme() . '/images/nav.block.flickr.gif' ?>" alt="That Other Flickr"></a></div>
  <div class="content"><?php print pressflow_typeset_render($block->content); ?>FLICKR</div>
</div><!-- /block-flickr -->
