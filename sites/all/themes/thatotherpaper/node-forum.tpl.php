<div class="node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">
  <?php if (module_exists('thatotherpaper_library')) { print thatotherpaper_library_custom_submitted($node); } ?>

  <div class="node-inner">
    <?php if ($picture) print $picture; ?>
    <?php if (module_exists('user_badges')) { print user_badges_for_uid($node->uid); } ?>

    <div class="content">
      <?php print $content; ?>
    </div><!-- /content -->

    <div class="clear"></div><!-- clears floated picture (avatar) -->

    <?php if (module_exists('thatotherpaper_library')) { print thatotherpaper_library_custom_links($node->links, 'post'); } ?>
  </div><!-- /node-inner -->
</div><!-- end node -->
