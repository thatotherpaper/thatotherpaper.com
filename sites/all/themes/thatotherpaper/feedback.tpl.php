<div id="slideshow">
	<div id="slideshow-image-wrapper">
		<img id="slideshow-image" src="<?php echo $image; ?>" alt="<?php echo $title; ?>" />
	</div>
	<div id="slideshow-nav">
		<?php echo theme('slideshow_previous', $previous); ?>
		<?php echo ' | <strong id="slideshow-current">' . $current . '</strong> of ' . $total . ' | '; ?>
		<?php echo theme('slideshow_next', $next); ?>
	</div>
	<div id="slideshow-title">
		<?php echo $title; ?>
	</div>
</div>

<div id="slideshow-body">
<?php echo $body; ?>
</div>
