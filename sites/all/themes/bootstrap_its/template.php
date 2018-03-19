<?php

/**
 * @file
 * template.php
 */

function bootstrap_its_bootstrap_search_form_wrapper($variables) {
  $output = '<div class="input-group">';
  $output .= '<div class="hidden"><a name="search"></a><label for="edit-search-block-form--2">Search terms</label></div>';
  $output .= $variables['element']['#children'];
  $output .= '<span class="input-group-btn">';
  $output .= '<div class="hidden"><label for="search-submit-button">Search Submit Button</label></div>';
  $output .= '<button type="submit" class="btn btn-default" id="search-submit-button">';
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



function bootstrap_its_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'course_home_directory_node_form') {
	//*********Note*********
	//you have to append .= to #prefix, not just set it w/ =
	//because there's already a bunch of markup in there
	//echo"<pre>";var_dump($form);echo"</pre>";
	$form['field_course_title_and_number']['und']["#prefix"] .= "<h3>Course Information</h3>";
	$form['field_administrator_name']['und']["#prefix"] .= "<h3>Administrator for this Course Directory</h3>";
	$form['field_authorized_users']['und']["#prefix"] .= "<h3>Authorized Users</h3><p>In addition to the Course Directory Administrator above, the following individuals should have overall administrative rights. They can make additions, deletions, and changes to the directory.</p>";
	$form["field_authorized_users"]["und"]["add_more"]["#value"] = "Add another authorized user";
	//https://drupal.org/node/154137
	$form['actions']['submit']['#value'] = t('Submit'); // Change the text on the label element
	//need to remove the Status field from student job applications only on the node/add form
	if (arg(0) == 'node' && arg(1) == '1') {
	//var_dump($form);
	$form['field_status']['#access'] = 0;
	}
  }
  if ($form_id == 'iq_contact_form_node_form') {
	
	//https://drupal.org/node/154137
	$form['actions']['submit']['#value'] = t('Submit'); // Change the text on the label element
	//need to remove the Status field from student job applications only on the node/add form
	if (arg(0) == 'node' && arg(1) == '1') {
	//var_dump($form);
	$form['field_status']['#access'] = 0;
	}
  }


  
  if ($form_id == 'webform_client_form_4384') {
  	if (isset($form["submitted"]["your_email_address"]["#default_value"])) {
		global $user;
		$form["submitted"]["your_email_address"]["#default_value"] = $user->name."@umich.edu";
		//echo "<!-- ".$_SERVER["REMOTE_USER"]."-----------";
		//var_dump($form["submitted"]["your_email_address"]["#default_value"]);
		//echo "-->";	
	
	}
  }
if ($form_id == "views_exposed_form" && $form['#id'] == "views-exposed-form-its-project-status-dashboard-all-sponsors-page-2") {
	//So, we have a text field, we want a drop-down that is sorted AND the default values from PV imports need to change
	//AND we can't change the backend field to be anything other than a text field AND we need to limit the drop-down to
	//not show ED's with 0 projects (seems like that shouldn't happen, but what do i know). Note the hazard marked below 
	//just sort()ing removes the keys of the array, which breaks the exposed filter by using ints instead of strings, so
	//try to preserve asort(). By the way, have you noticed that the lines in this comment block all have same number of
	//characters? I didn't do that on purpose, but, after the third line, I thought I should keep them all having the sa
	$bigpileofeds = array();
	$result = db_query('SELECT DISTINCT(field_its_project_sponsor_value) FROM {field_data_field_its_project_sponsor}');
	$eds = $result->fetchAll();
	
	foreach ($eds as $ed) {
		$bigpileofeds[$ed->field_its_project_sponsor_value] = $ed->field_its_project_sponsor_value;
	}
	//hazard
	asort($bigpileofeds);
	
	foreach ($bigpileofeds as $ed) {
		if (isset($bigpileofeds[$ed])) {
			if ($ed == "Behm,Jim") {$bigpileofeds[$ed] = "Jim Behm - Enterprise Application Services";}
			else if ($ed == "Bermann,Sol") {$bigpileofeds[$ed] = "Sol Bermann - Information & Infrastructure Assurance";}
			else if ($ed == "Curley,Cathy") {$bigpileofeds[$ed] = "Cathy Curley - Strategy and Planning";}
			else if ($ed == "Demonner,Sean Michael") {$bigpileofeds[$ed] = "Sean Demonner - Teaching & Learning";}
			else if ($ed == "Palms,Andrew T") {$bigpileofeds[$ed] = "Andy Palms - Infrastructure";}
			else if ($ed == "Thiruvengadam,Vijayaraja") {$bigpileofeds[$ed] = "Vijay Thiruvengadam - Information Quest";}
			else if ($ed == "Wang,Amy") {$bigpileofeds[$ed] = "Amy Wang - Support Services";}
			else if ($ed == "Jones II,Robert Douglas") {$bigpileofeds[$ed] = "Bob Jones - Support Services";}
		
			else if ($ed == "Palen,Brock Edward") {$bigpileofeds[$ed] = "Brock Palen - Advanced Research Computing and Technology Services";}
			else if ($ed == "Tawakkol,Dima") {$bigpileofeds[$ed] = "Dima Tawakkol - Project Management Office";}
			else if ($ed == "Jones,Diane") {$bigpileofeds[$ed] = "Diane Jones";}
		}
	}
	
	$bigpileofeds = array_merge(array('' => '- Any -'), $bigpileofeds);
	
	//if (isset($form['field_its_project_sponsor_value'])) {var_dump($form);}

	$form['field_its_project_sponsor_value']['#type'] = "select";
	$form['field_its_project_sponsor_value']['#size'] = null;
	$form['field_its_project_sponsor_value']['#default_value'] = $bigpileofeds[''];
    $form['field_its_project_sponsor_value']['#options'] = $bigpileofeds;
  }
}










///////////////webform themin'
///////////////default: http://www.drupalcontrib.org/api/drupal/contributions!webform!webform.module/function/theme_webform_element/7
function bootstrap_its_webform_element($variables) {
  // Ensure defaults.
  $variables['element'] += array(
    '#title_display' => 'before',
  );

  $element = $variables['element'];

  // All elements using this for display only are given the "display" type.
  if (isset($element['#format']) && $element['#format'] == 'html') {
    $type = 'display';
  }
  else {
    $type = (isset($element['#type']) && !in_array($element['#type'], array('markup', 'textfield', 'webform_email', 'webform_number'))) ? $element['#type'] : $element['#webform_component']['type'];
  }

  // Convert the parents array into a string, excluding the "submitted" wrapper.
  $nested_level = $element['#parents'][0] == 'submitted' ? 1 : 0;
  $parents = str_replace('_', '-', implode('--', array_slice($element['#parents'], $nested_level)));

  $wrapper_attributes = isset($element['#wrapper_attributes']) ? $element['#wrapper_attributes'] : array('class' => array());
  $wrapper_classes = array(
    'form-item',
    'webform-component',
    'webform-component-' . $type,
  );
  if (isset($element['#title_display']) && strcmp($element['#title_display'], 'inline') === 0) {
    $wrapper_classes[] = 'webform-container-inline';
  }
  $wrapper_attributes['class'] = array_merge($wrapper_classes, $wrapper_attributes['class']);
  $wrapper_attributes['id'] = 'webform-component-' . $parents;
  $output = '<div ' . drupal_attributes($wrapper_attributes) . '>' . "\n";

  // If #title_display is none, set it to invisible instead - none only used if
  // we have no title at all to use.
  if ($element['#title_display'] == 'none') {
    $variables['element']['#title_display'] = 'invisible';
    $element['#title_display'] = 'invisible';
    if (empty($element['#attributes']['title']) && !empty($element['#title'])) {
      $element['#attributes']['title'] = $element['#title'];
    }
  }
  // If #title is not set, we don't display any label or required marker.
  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }
  $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . _webform_filter_xss($element['#field_prefix']) . '</span> ' : '';
  $suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . _webform_filter_xss($element['#field_suffix']) . '</span>' : '';

  $desc = "";
  if (!empty($element['#description'])) {
    $desc = ' <div class="description help-block">' . $element['#description'] . "</div>\n";
  }

  switch ($element['#title_display']) {
    case 'inline':
    case 'before':
    case 'invisible':
      $output .= ' ' . theme('form_element_label', $variables);
      $output .= $desc;
	  $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;

    case 'after':
      $output .= ' ' . $prefix . $element['#children'] . $suffix;
      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      break;

    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;
  }



  $output .= "</div>\n";

  return $output;
}
///////////////end webform themin'


function bootstrap_its_preprocess_breadcrumb(&$variables) {
	if (strpos($_SERVER['REQUEST_URI'],'e-signature') !== false) {
		$breadcrumb = &$variables['breadcrumb'];
		$breadcrumb[0] = l("ITS","http://its.umich.edu");
		return($breadcrumb);
	}
	else if (strpos($_SERVER['REQUEST_URI'],'performance-management') !== false) {
		$breadcrumb = &$variables['breadcrumb'];
		$breadcrumb[0] = l("ITS","http://its.umich.edu");
		return($breadcrumb);
	}	
	else if (strpos($_SERVER['REQUEST_URI'],'privascope') !== false) {
		$breadcrumb = &$variables['breadcrumb'];
		$breadcrumb[0] = l("ITS","http://its.umich.edu");
		return($breadcrumb);
	}
	else if (strpos($_SERVER['REQUEST_URI'],'web-platform-services') !== false) {
		$breadcrumb = &$variables['breadcrumb'];
		$breadcrumb[0] = l("ITS","http://its.umich.edu");
		return($breadcrumb);
	}			
}