<?php

/**
 * @file
 * This template is used to print a single field in a view.
 *
 * It is not actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the template is
 * perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */
?>

<?php //print $output;

$i = 0;
$anns = "";
$annleng = "";
$error = "";
$showstuff = "";
$agendaitems = array();

if (isset($row->_field_data["nid"]["entity"]->field_show_meeting_webcast_info_["und"][0]["value"]) && $row->_field_data["nid"]["entity"]->field_show_meeting_webcast_info_["und"][0]["value"] == "1") {
	$showstuff = "Yes";	
}

//echo "<pre>";
//var_dump($row->field_field_location[0]["rendered"]["#markup"]);
//echo "</pre>";
$dateandtime = explode(" - ",$row->field_field_time_and_date[0]["rendered"]["#markup"]);
$times = explode(" to ",$dateandtime[1]);

$date = $dateandtime[0];
//$start = $times[0];$start_string = "2017-09-12 ".strip_tags($times[0]);$start = date('g:i', strtotime($start_string));  $start = str_replace(":00", "", $start);  $start = str_replace("m", ".m.", $start);
$end_string = "2017-09-12 ".strip_tags($times[1]).":00";
$end = date('g:i a', strtotime($end_string));
  $end = str_replace(":00", "", $end);  $end = str_replace("m", ".m.", $end);
echo "<p><strong>Date: ".$date."</strong><br/>
<strong>Time:</strong> ".$start."&ndash;".$end."<br/>
<strong>Location:</strong> ".strip_tags($row->field_field_location[0]["rendered"]["#markup"])."</p>";

foreach ($row->field_field_agenda_items as $thismess) {
///////////paste
	
	foreach ($thismess["rendered"]["entity"]["field_collection_item"] as $ohgodwhy) {
		//var_dump($ohgodwhy["field_agenda_category"]["#object"]);

		$thisitem = array();
		$thismarkup = "";
		//$thismarkup .= "<div class='topicwrap'>";

		//if ($i == 0) {
			$title = $ohgodwhy["field_agenda_category"]["#object"]->field_title["und"][0]["value"];
			//$time = explode(" to ",$node['node']['Time and Date']);
			//$timetwo = explode(" - ",$node['node']['Time and Date2']);
			//$loc = $node['node']['Location'];
			//$anns = $node['node']['Announcements'];
			//$annleng = $node['node']['Expected Announcement Length'];

		$order = $ohgodwhy["field_agenda_category"]["#object"]->field_order["und"][0]["value"];
		$category = $ohgodwhy["field_agenda_category"]["#object"]->field_agenda_category["und"][0]["value"];

			$thismarkup .= "<h4>".$title."</h4>";

			if (count($ohgodwhy["field_agenda_category"]["#object"]->field_recording_url) > 0) {
				$recurl = "";
				if (isset($ohgodwhy["field_agenda_category"]["#object"]->field_recording_url["und"][0]["url"])){
					$recurl = $ohgodwhy["field_agenda_category"]["#object"]->field_recording_url["und"][0]["url"];
				}
				
				$thismarkup .= "<div class=\"ulwatchbuttonwrapper\"><a class=\"btn btn-primary\" href=\"".$recurl."\">Watch the Recording</a><br>";

				if (isset($ohgodwhy["field_agenda_category"]["#object"]->field_recording_captions["und"][0]["value"]) && $ohgodwhy["field_agenda_category"]["#object"]->field_recording_captions["und"][0]["value"] == "Yes") {$caps = "Captioned";}
				else {$caps = "Captions coming soon";}
				$thismarkup .= "<em>".$caps."</em><br /><strong>Length:</strong> ".$ohgodwhy["field_agenda_category"]["#object"]->field_recording_length["und"][0]["value"]."</div>";
			}

			if (isset($ohgodwhy["field_agenda_category"]["#object"]->field_expected_length["und"][0]["value"])) {$thismarkup .= "<p><strong>Length:</strong> ".$ohgodwhy["field_agenda_category"]["#object"]->field_expected_length["und"][0]["value"]."</p>";}
			
			if (isset($ohgodwhy["field_agenda_category"]["#object"]->field_presenters["und"][0]["value"])) {$thismarkup .= "<p><strong>Presenter(s):</strong> ".strip_tags($ohgodwhy["field_agenda_category"]["#object"]->field_presenters["und"][0]["value"],"<a>")."</p>";}
			
			if (isset($ohgodwhy["field_agenda_category"]["#object"]->field_description["und"][0]["value"])) {$thismarkup .= "<p><strong>Description:</strong> ".strip_tags($ohgodwhy["field_agenda_category"]["#object"]->field_description["und"][0]["value"],"<a></p><ul><li>")."</p>";}
			
			//Materials
			//echo "<pre>";
			//var_dump($ohgodwhy["field_agenda_category"]["#object"]->field_materials);
			//echo "</pre>";
			if (isset($ohgodwhy["field_agenda_category"]["#object"]->field_materials["und"])) {
				$thismarkup .= "<p><strong>Materials:</strong></p><ul>";
				
				foreach($ohgodwhy["field_agenda_category"]["#object"]->field_materials["und"] as $thismaterial) {
								//echo "<pre>";var_dump($thismaterial["url"]);echo "</pre>";
					
					//foreach ($ohgodwhy["field_agenda_category"]["#object"]->field_materials as $piece) {
						$thismarkup .= "<li><a href='".$thismaterial["url"]."'>".$thismaterial["title"]."</a></li>";

					//}
					
				}
				$thismarkup .= "</ul>";
			}
			//$thismarkup .= "</div>";
		
			array_push($thisitem, $order, $thismarkup, $category, $title);
			array_push($agendaitems, $thisitem);

	$i++;

	}//end foreach

///////////paste
}
?>

<?php 
if ($error == ""){
	  echo "<h2>Meeting Agenda</h2>";
	  //echo "<table class=\"table\"><tbody>";
	  
	  //if an Announcement came through, print it first
	  if ($anns != "") {
			//echo "<tr><td>";
			echo "<h3>Announcements";
			if ($annleng != "") {echo "<span class='noh3'>&nbsp;&nbsp;($annleng)</span>";}
			echo "</h3>";
			echo $anns;
			//echo "</td></tr>";
	  }
	  
	  //sort by order, in theory
	  sort($agendaitems);
	  $cat = "--";
	  foreach ($agendaitems as $item) {
		//if there's a new cat, print a new tr
		if ($item[2] != $cat) {
			if ($cat !== "--") {
				//echo "</td></tr>";
				//echo "<hr/>";
				}
			//echo "<tr><td>";
			if ($item[2] != "") {echo "<h3>".$item[2]."</h3>";}
		}
		echo($item[1]);
		
		$cat = $item[2];
	  } 
	  //echo " </tbody></table>";
	  }
	  else {echo $error;}

if ($showstuff == "Yes") {
echo "<hr/>

<h2>Meeting Webcast</h2>

<p><strong>To attend online,</strong> you will need to log in to participate.</p>

<ul>
<li>On the day of the event, <a href='https://primetime.bluejeans.com/a2m/live-event/yr85968'>open the BlueJeans meeting</a> 5&ndash;10 minutes before the program starts.</li>
<li>Enter Your Name and Email Address, then click <strong>Join as Guest</strong>.</li>
<li>Click <strong>Join with Browser</strong>.</li>
<li>Type questions in the chat pod.</li>
</ul>

<p>The meeting will be recorded and available 5&ndash;7 business days after the meeting.</p>
";
}

?>