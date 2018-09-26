<?php
class Application_Model_Showroom extends Zend_Db_Table_Abstract {

	/****** Network Project **********/
	public function insertNetworkinfo($data){
		
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();

		try {
			$result = $db->insert('Network_details', $data);
   			$lastinsertvalue = $db->lastInsertId('Network_details');
   			$sql = "select * from Network_details where S_id='$lastinsertvalue'";
			$stmt = $db->query($sql); 
         	$finalresult =  $stmt->fetchAll();
			return $finalresult;
		}catch ( Exception $e ) {
			echo $e->getMessage ();
			return false;
		}	
	}		 
	
	/****** Toilet Project **********/
	
	public function toiletvalues($UnigueID,$lat,$lang,$gender,$higenic,$placetype,$rating,$disabledaccess,$cost,$address){
	    $image = "";
	    $place = 0;
	    $db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$sql = "INSERT INTO Toilet_Finder_App (Toilet_ID, Lat_Long, Gender, Higenic, Place, Rating, Disabled_Access, Cost, Address, First_Image, Second_Image, Third_Image, Wrong_Place, No_Toilet) VALUES ('$UnigueID', GeomFromText('POINT($lat $lang)'), '$gender', '$higenic','$placetype', '$rating', '$disabledaccess', '$cost', '$address', '$image', '$image', '$image', '$place', '$place')";
		$stmt4 = $db->query($sql);
		
		$sql11 = "SELECT Toilet_ID, X(Lat_Long) AS users_lat, Y(Lat_Long) AS users_long, Gender, Higenic, Place, Rating, Disabled_Access, Cost, Address, First_Image, Second_Image, Third_Image FROM Toilet_Finder_App WHERE Lat_Long = GeomFromText('POINT($lat $lang)')";
		$stmt1 = $db->query($sql11);
		$finalresult =  $stmt1->fetchAll();
		return $finalresult;
	}
	
	public function toiletgetdatavalues($lat,$lang){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		
		$sql11 = "SELECT Toilet_ID, 
		X(Lat_Long) AS users_lat, Y(Lat_Long) AS users_long, (3959 * acos (cos ( radians($lat) )* cos( radians( X(Lat_Long) ) )
      	* cos( radians( Y(Lat_Long) ) - radians($lang) )+ sin ( radians($lat) )* sin( radians( X(Lat_Long) ) ))) AS distance,
      	Gender, Higenic, Place, Rating, Disabled_Access, Cost, Address, First_Image, Second_Image, Third_Image FROM Toilet_Finder_App HAVING distance < 30 ORDER BY distance LIMIT 0 , 20";
		$stmt1 = $db->query($sql11);
		$finalresult =  $stmt1->fetchAll();
		return $finalresult;
	}
	
	public function toiletUpdateImage($target_file,$toilet_ID,$i){
	   $db =Zend_Db_Table_Abstract::getDefaultAdapter();
	   if($i == 0){
			$sql = "UPDATE Toilet_Finder_App SET First_Image = '$target_file' WHERE Toilet_ID = '$toilet_ID'";
	   }else if($i == 1){
	   		$sql = "UPDATE Toilet_Finder_App SET Second_Image = '$target_file' WHERE Toilet_ID = '$toilet_ID'";
	   }else if($i == 2){
	   		$sql = "UPDATE Toilet_Finder_App SET Third_Image = '$target_file' WHERE Toilet_ID = '$toilet_ID'";
	   }
	   $stmt4 = $db->query($sql);
	   
	   $sql11 = "SELECT Toilet_ID, X(Lat_Long) AS users_lat, Y(Lat_Long) AS users_long, Gender, Higenic, Place, Rating, Disabled_Access, Cost, Address, First_Image, Second_Image, Third_Image FROM Toilet_Finder_App WHERE Toilet_ID = '$toilet_ID'";
	   $stmt1 = $db->query($sql11);
	   $finalresult =  $stmt1->fetchAll();
	   return $finalresult;
	}
	
	public function toiletUpdateReport($report,$toiletid){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		if($report == "Wrong Place"){
			$sql = "SELECT Wrong_Place  FROM Toilet_Finder_App WHERE Toilet_ID = '$toiletid'";
			$stmt = $db->query($sql);
			$result =  $stmt->fetchAll();
			foreach($result as $fresult){
				if($fresult["Wrong_Place"] == 0){
					$sql1 = "UPDATE Toilet_Finder_App SET Wrong_Place = '1' WHERE Toilet_ID = '$toiletid'";
				}else{
					$add_value = $fresult["Wrong_Place"] + 1;
					if($add_value > 3){
						$sql1 = "DELETE FROM Toilet_Finder_App WHERE Toilet_ID = '$toiletid'";
					}else{
						$sql1 = "UPDATE Toilet_Finder_App SET Wrong_Place = '$add_value' WHERE Toilet_ID = '$toiletid'";
					}
				}
				$stmt1 = $db->query($sql1);
			}
			
			return "Success";
			
		}else if($report == "No Toilet"){
			$sql = "SELECT No_Toilet  FROM Toilet_Finder_App WHERE Toilet_ID = '$toiletid'";
			$stmt = $db->query($sql);
			$result =  $stmt->fetchAll();
			foreach($result as $fresult){
				if($fresult["No_Toilet"] == 0){
					$sql1 = "UPDATE Toilet_Finder_App SET No_Toilet = '1' WHERE Toilet_ID = '$toiletid'";
				}else{
					$add_value = $fresult["No_Toilet"] + 1;
					if($add_value > 3){
						$sql1 = "DELETE FROM Toilet_Finder_App WHERE Toilet_ID = '$toiletid'";
					}else{
						$sql1 = "UPDATE Toilet_Finder_App SET No_Toilet = '$add_value' WHERE Toilet_ID = '$toiletid'";
					}	
				}
				$stmt1 = $db->query($sql1);
			}
			return "Success";				
		}
	}
	
	public function toiletColumnUpdateReport($column,$val,$toiletid){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$sql1 = "UPDATE Toilet_Finder_App SET $column = '$val' WHERE Toilet_ID = '$toiletid'";
		$stmt1 = $db->query($sql1);
		
		$sql11 = "SELECT Toilet_ID, X(Lat_Long) AS users_lat, Y(Lat_Long) AS users_long, Gender, Higenic, Place, Rating, Disabled_Access, Cost, Address, First_Image, Second_Image, Third_Image FROM Toilet_Finder_App WHERE Toilet_ID = '$toiletid'";
	   	$stmt11 = $db->query($sql11);
	   	$finalresult =  $stmt11->fetchAll();
	   	return $finalresult;
	}
	
	public function toiletUpdateFeedback($deviceID,$screen,$summary,$suggestion,$imagename,$date){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$sql = "INSERT INTO Toilet_Feedback (Device_ID, Screen, Summary, Suggestion, Screenshot, Updated_Time) VALUES ('$deviceID', '$screen', '$summary','$suggestion', '$imagename', '$date')";
		$stmt = $db->query($sql);
		
		$sql1 = "SELECT Device_ID, Screen, Summary, Suggestion, Screenshot, Updated_Time FROM Toilet_Feedback WHERE Device_ID = '$deviceID'";
		$stmt1 = $db->query($sql1);
		$finalresult =  $stmt1->fetchAll();
	   	return $finalresult;
	}
	
	public function toiletGetFeedback($deviceID){
	
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();		
		$sql1 = "SELECT Device_ID, Screen, Summary, Suggestion, Screenshot, Updated_Time FROM Toilet_Feedback WHERE Device_ID = '$deviceID'";
		$stmt1 = $db->query($sql1);
		$finalresult =  $stmt1->fetchAll();
	   	return $finalresult;
	
	}	
	/****** End Toilet Project **********/
	
}	
	
		
?>