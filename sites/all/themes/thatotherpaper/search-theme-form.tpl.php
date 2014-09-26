<?php
/**
 * Customizing the search box | http://drupal.org/node/45295
 * Using search-box.tp.php | http://drupal.org/node/45295
 *    - discusses form_token fix
 */

/*
<div id="search" class="container-inline"><input 
	type="text" id="edit-search_theme_form_keys" class="form-text" 
		name="edit[search_theme_form_keys]" value="" 
		alt="search That Other Paper" /><input 
	type="image" id="search_theme_form_go" class="form-submit" name="op" 
		src="<?php print base_path() . path_to_theme() . '/images/search_theme_form_go.gif' ?>" /><input 
	type="hidden" name="edit[form_id]" value="search_theme_form" /><input 
	type="hidden" id="edit-form_token" name="edit[form_token]" 
		value="<?php echo drupal_get_token('search_theme_form_keys'); ?>" /></div>
*/ ?>

<?php
	$form_id = 'search_theme_form';	

	$form[$form_id .'_keys'] = array(
		'#value' => '<input type="text" id="edit-search_theme_form_keys" class="form-text" name="edit[search_theme_form_keys]" value="" 
		alt="search That Other Paper" /><input type="image" id="search_theme_form_go" class="form-submit" name="op" src="' . base_path() . path_to_theme() . '/images/search_theme_form_go.gif" alt="search" />');

	unset($form['submit']);

	// Always go to the search page since the search form is not guaranteed to be
	// on every page.
	$form['#action'] = url('search/node');

	echo drupal_get_form($form_id, $form, 'search_box_form');
?>
