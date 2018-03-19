<?php
/**
 * @file views-views-json-style-simple.tpl.php
 * Default template for the Views JSON style plugin using the simple format
 *
 * Variables:
 * - $view: The View object.
 * - $rows: Hierachial array of key=>value pairs to convert to JSON
 * - $options: Array of options for this style
 *
 * @ingroup views_templates
 */

$jsonp_prefix = $options['jsonp_prefix'];

if ($view->override_path) {
  // We're inside a live preview where the JSON is pretty-printed.
  $json = _views_json_encode_formatted($rows, $options);
  if ($jsonp_prefix) $json = "$jsonp_prefix($json)";
  print "<code>$json</code>";
}
else {

/////Begin exceedingly proper Schleif additions:
	
	//var_dump(db_query("SELECT n.title, c.field_category_value FROM n, c
      //     USING {node} AS n, {field_data_field_category} AS c
        //   WHERE (n.nid = c.entity_id)"));
$result = db_query("SELECT n.title, {field_data_field_category}.field_category_value FROM {node} n INNER JOIN {field_data_field_category} ON {field_data_field_category}.entity_id = n.nid WHERE `type` = 'feature'");
$feats = $result->fetchAll();
//var_dump($feats);
//echo "\n\r";
//var_dump($query->execute());	
	
	$result = db_query("SELECT DISTINCT(title) FROM {node} WHERE `type` = 'feature'");
	$feats = $result->fetchAll();
	//var_dump($rows);	
	$demolfeats = array();
	$i = 0;
	//var_dump($rows);
	foreach ($rows["sites"] as $row) {
		//var_dump(in_array("Electronic Classrooms",explode(", ",$row["Site"]["Features"])));
		foreach ($feats as $feat) {
			//data feed request to be boolean, so we'll use in_array, i 'spose
			$demolfeats[preg_replace('/[^a-zA-Z0-9_.]/', '', strtolower($feat->title))] = in_array($feat->title, explode(", ",$row["Site"]["Features"]));
			$demolfeats["Central"] = in_array("Central", explode(", ",$row["Site"]["Campus"]));
			$demolfeats["Medical"] = in_array("Medical", explode(", ",$row["Site"]["Campus"]));
			$demolfeats["North"] = in_array("North", explode(", ",$row["Site"]["Campus"]));
			$demolfeats["South"] = in_array("South", explode(", ",$row["Site"]["Campus"]));
			
			if (strpos($row["Site"]["TodaysHours"], "NOW-OPEN") !== false) {$demolfeats["opennow"] = true;}
			else {$demolfeats["opennow"] = false;}
//mac
			if (intval($row["Site"]["MacMachines"]) > 0) {$demolfeats["MacMachines"] = true;}
			else {$demolfeats["MacMachines"] = false;}
	//os
			if (intval($row["Site"]["WindowsMachines"]) > 0) {$demolfeats["WindowsMachines"] = true;}
			else {$demolfeats["WindowsMachines"] = false;}
		//caen	
			if (intval($row["Site"]["CAENMachines"]) > 0) {$demolfeats["CAENMachines"] = true;}
			else {$demolfeats["CAENMachines"] = false;}
		}
		$rows["sites"][$i]["Site"]["BetterFeatures"] = $demolfeats;
		
		unset($coords);
		$coords = array();
		
		foreach (explode(", ", $rows["sites"][$i]["Site"]["geometry"]) as $coordinate) {
			array_push($coords, floatval($coordinate));
		}
		
		
		$rows["sites"][$i]["Site"]["geometry"] = $coords;
		
		$i++;
	}
	/////end them ol' Schleif adds
	
  $json = _views_json_json_encode($rows, $bitmask);
  if ($options['remove_newlines']) {
     $json = preg_replace(array('/\\\\n/'), '', $json);
  }

  if (isset($_GET[$jsonp_prefix]) && $jsonp_prefix) {
    $json = check_plain($_GET[$jsonp_prefix]) . '(' . $json . ')';
  }

  if ($options['using_views_api_mode']) {
    // We're in Views API mode.
    print $json;
  }
  else {
    // We want to send the JSON as a server response so switch the content
    // type and stop further processing of the page.
    $content_type = ($options['content_type'] == 'default') ? 'application/json' : $options['content_type'];
    drupal_add_http_header("Content-Type", "$content_type; charset=utf-8");
    print $json;
    drupal_page_footer();
    exit;
  }
}
