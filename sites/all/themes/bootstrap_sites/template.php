<?php

/**
 * @file
 * template.php
 */

function bootstrap_sites_bootstrap_search_form_wrapper($variables) {
  $output = '<div class="input-group">';
  $output .= '<div class="hidden"><a name="search"></a><label for="edit-search-block-form--2">Search</label></div>';
  $output .= $variables['element']['#children'];
  $output .= '<span class="input-group-btn">';
  $output .= '<button type="submit" class="btn btn-default">';
  // We can be sure that the font icons exist in CDN.
  //if (theme_get_setting('bootstrap_cdn')) {
    $output .= "<span class='icon glyphicon glyphicon-search' aria-hidden='true'></span>";
  //}
  //else {
    //$output .= t('Search');
  //}
  $output .= '</button>';
  $output .= '</span>';
  $output .= '</div>';
  return $output;
}




function bootstrap_sites_preprocess_breadcrumb(&$variables) {
	if (!drupal_is_front_page()) {
		$breadcrumb = &$variables['breadcrumb'];
		$breadcrumb[0] = l("Home","http://its.umich.edu/computing/computers-software/campus-computing-sites");
		return($breadcrumb);
	}
}

