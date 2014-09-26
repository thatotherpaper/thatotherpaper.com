<div class="comment<?php print ($comment->new) ? ' comment-new' : '' ?>"><div class="comment-inner">
  <?php if ($comment->new) : ?><div class="new"><?php print $new ?></div><?php endif; ?>

  <?php if (module_exists('thatotherpaper_library')) { print thatotherpaper_library_custom_submitted($comment); } ?>

  <?php if ($picture) print $picture; ?>
  <?php if (module_exists('user_badges')) { print user_badges_for_uid($comment->uid); } ?>

  <div class="content"><?php print $content ?></div>

  <?php if (module_exists('thatotherpaper_library')) { print thatotherpaper_library_custom_links($comment, 'comment', $links); } ?>
</div></div><!-- /comment-inner /comment -->
