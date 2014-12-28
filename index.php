<?php 
$fh = fopen('awards.csv', 'r');
$fhg = fopen('contracts.csv', 'r');
while (($data = fgetcsv($fh, 0, ",")) !== FALSE) {
	$awards[]=$data;

}
while (($data = fgetcsv($fhg, 0, ",")) !== FALSE) {
	$contracts[]=$data;
}
//echo "<pre>";
//print_r($awards);
//print_r($contracts);
//echo "</pre>";

 // 2nd section   
for($x=0;$x< count($contracts);$x++)
{
	if($x==0){
		unset($awards[0][0]);
		$line[$x]=array_merge($contracts[0],$awards[0]); //header
		//If you want to add more field 
		$moreFields = array('latlon');
		$line[$x] = array_merge($line[$x], $moreFields);
	}
	else{
		$deadlook=0;
		for($y=1;$y < count($awards);$y++){
			if($awards[$y][0] == $contracts[$x][0]){
				$copy = $awards[$y];
				unset($copy[0]);
				$line[$x]=array_merge($contracts[$x],$copy);
				// Adding Data to newFields
				//echo "address: ";
				$Address=$copy[4];
				//print_r($Address);
				$request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$Address."&sensor=true";
				$xml = simplexml_load_file($request_url) or die("url not loading");
				$status = $xml->status;
				if ($status=="OK") {
					$Lat = $xml->result->geometry->location->lat;
					$Lon = $xml->result->geometry->location->lng;
					$LatLng = "$Lat,$Lon";
					//echo $LatLng;
				}
				//print_r($LatLng);
				//$moreFieldsData = array('nirmala'.$x);
				$moreFieldsData[0] = $LatLng;
				$line[$x] = array_merge($line[$x], $moreFieldsData);
				$deadlook=1;
			}           
		}
		if($deadlook==0)
			$line[$x]=$contracts[$x];
	}
}
// 3 section     
$fp = fopen('final.csv', 'w');//output file set here
echo "<pre>";
//print_r($line);
echo "</pre>";
$sum=0;
	foreach ($line as $arr) {
		foreach ($arr as $key => $value) {
			if ($arr[1]=='Closed' && array_key_exists(12,$arr)){
			$sum=$sum+$arr[12];
			
			}
		}
		
	}
//echo $sum;
echo "Total amount of closed contracts:".$sum;
foreach ($line as $fields) {
	fputcsv($fp, $fields);
}
fclose($fp);



        ?>
