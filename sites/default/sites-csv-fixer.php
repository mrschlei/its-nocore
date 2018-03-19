<?php
//https://its.umich.edu/import/sites_software_importer
//if you run into any problems with imports (exp. invalid values), throw a trim() around the output, as you see below in a few places
ob_start();
header( 'Content-Type: text/csv' );
header( 'Content-Disposition: attachment;filename=sites-csv-fixer.csv');



$location = "https://docs.google.com/a/umich.edu/spreadsheets/d/15hHG7TQ3hK_oJHyS_LgltXnXSSXSkZXgPRZZTE9T-CI/pub?single=true&gid=2113559646&output=csv";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $location);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$contents = curl_exec($ch);

$lines = preg_split("/\n/", $contents);

$outputarr = array();
array_push($outputarr, array("Software Title","Students","Staff","Faculty","Affliates (Research)","Guest","Alumni","OSX","Windows","Test"));

for($i = 1; $i < count($lines); $i++)
	{
	$item = preg_split("/,/", $lines[$i]);
	if(strpos($item[0], "Eligible Users:") !== false ) {
		continue;
	}
	if(strpos($item[0], "Grand Total") !== false ) {
		continue;
	}
	if(strlen($item[0]) == 0) {
		continue;
	}
	
	if ($item[1] == "x") {$item[1] ="Students";}
	if ($item[2] == "x") {$item[2] ="Staff";}
	if ($item[3] == "x") {$item[3] ="Faculty";}
	if ($item[4] == "x") {$item[4] ="Affiliates";}
	if ($item[5] == "x") {$item[5] ="Guests";}
	if ($item[6] == "x") {$item[6] ="Alumni";}
	if ($item[7] == "x") {$item[7] ="Mac";}
	if ($item[8] == "x") {$item[8] ="PC";}
	
	unset($tester);
	$tester = array();
	if ($item[7] == "Mac") {
		array_push($tester,$item[7]);
	}
	if ($item[8] == "PC") {
		array_push($tester,$item[8]);
	}

	if (count($tester) > 1) { 
		$pcandormac = implode(",",array_filter($tester));
	}
	else {$pcandormac = trim($item[7]).trim($item[8]);
	}
	

		//If Guest is x'd, Students, Staff, Faculty, and Affiliates (Research) are x'd, even though they aren't actually x'd in the data source.
		//Don't ask.
		if ($item[5] == "Guests") {
			array_push($outputarr, array($item[0],"Students","Staff","Faculty","Affiliates",$item[5],$item[6],trim($item[7]),trim($item[8]),""));
		}
		else {
			array_push($outputarr, array($item[0],$item[1],$item[2],$item[3],$item[4],$item[5],$item[6],trim($item[7]),trim($item[8]),""));
		}
	}
curl_close($ch);



$fp = fopen('php://output', 'w');
foreach ($outputarr as $fields) {
		fputcsv($fp, $fields);
}

fseek($fp, 0);
fpassthru($fp);
fclose($fp);

$out = ob_get_contents();
ob_end_clean();
echo trim($out);


?>