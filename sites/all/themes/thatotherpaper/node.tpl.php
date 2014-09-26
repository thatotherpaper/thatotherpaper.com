<div class="node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">
	<?php if ($page == 0) : ?>
		<h2 class="title"><a href="<?php print $node_url ?>" 
			title="<?php print pressflow_typeset_render($title) ?>"><?php print pressflow_typeset_render($title) ?></a></h2>
	<?php endif; ?>

  <?php if (module_exists('author_taxonomy')) { print author_taxonomy_output($node); } ?>

  <div class="node-inner">
    <div class="content">
      <?php print $content; ?>

      <?php if ($has_map && !$teaser) { print thatotherpaper_library_map($node); } ?>

      <?php /*
      <?php if (count($taxonomy)) { ?>
        <div class="taxonomy"><?php print t('Posted in ') . $terms; ?></div>
      <?php } ?>
      */ ?>
    </div><!-- /content -->

    <?php if (module_exists('thatotherpaper_library')) {
      // print thatotherpaper_library_relatedlinks($node, $teaser);
      print thatotherpaper_library_readmore_link($node, $teaser, 'post');
      print thatotherpaper_library_custom_links($node->links, 'post');
      } ?>
  </div><!-- /node-inner -->
</div><!-- end node -->
