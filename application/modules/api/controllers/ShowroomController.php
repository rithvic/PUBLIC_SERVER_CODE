<?php
class Api_ShowroomController extends Zend_Controller_Action
{

 public function init()
    {
		
		$this->header = Zend_Controller_Front::getInstance ()->getResponse ();
		$this->header->setHeader ( "Content-Type", "application/json" );
		$this->header->setHeader ( "Method", $_SERVER ['REQUEST_METHOD'] );
		$this->header->setHeader ( "HOST", $_SERVER ['SERVER_NAME'] );
		$this->_filedate = date("Ymd", time());
		
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$this->Rest = new Classes_Rest;
		$this->Auth = new Classes_Auth;
		
		$this->Showroom = new Application_Model_Showroom;	
		
	}	
	
		/* public function preDispatch() {
			 if (! $this->Auth->authAccepted($this->getRequest()))
			 {
			$encode = json_encode(array('error'=>"Your request is not authenticated."));
				$this->header->setHttpResponseCode ( 401 );
				$respcode = $this->header->getHttpResponseCode ();
				$this->header->setHeader ( "Status", $respcode );
				echo $this->header->setHeader ( "Content-Length", strlen($encode));
				echo $encode;
						
			exit;
			}
		} */

		public function indexAction()
		{
			// action body
			if (!$this->getRequest()->isPost())
			{
				$encode = json_encode(array('error'=>"This function accepts only POST."));
				$this->header->setHttpResponseCode ( 405 );
				$respcode = $this->header->getHttpResponseCode ();
				$this->header->setHeader ( "Status", $respcode );
				echo $this->header->setHeader ( "Content-Length", strlen($encode));			
				echo $encode;
				exit;
			}
		}
	
	/****** Network Project **********/
	public function networkProjectAction(){
			if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}
			
			$json = file_get_contents('php://input');
			$array = json_decode($json);
			$dataarray = array();
			
			
			if($array == null){
			  echo json_encode(array("Error" =>"Does not valid Request"));
			}else{
			 $obj = $array->{'post_data'};
				for($i = 0;$i < count($obj);$i++){
			  $Device_ID = $obj[$i]->{'Device_ID'};
			   $Date = $obj[$i]->{'Date_And_Time'};
 			  $MobileProduct = $obj[$i]->{'Mobile_Product'};
 			  $MobileModel = $obj[$i]->{'Mobile_Model'};
 			  $Sim1NetOperator = $obj[$i]->{'Sim1_Net_Operator'};
 			  $Sim1NetType = $obj[$i]->{'Sim1_Net_Type'};
 			  $Sim1NetStrength = $obj[$i]->{'Sim1_Net_Strength'};
 			  $Sim1NetCountry = $obj[$i]->{'Sim1_Net_Country'};
 			  $Sim1Operator = $obj[$i]->{'Sim1_Sim_Operator'};
 			  $Sim1Country = $obj[$i]->{'Sim1_Sim_Country'};
 			  $Sim2NetOperator = $obj[$i]->{'Sim2_Net_Operator'};
 			  $Sim2NetType = $obj[$i]->{'Sim2_Net_Type'};
 			  $Sim2NetStrength = $obj[$i]->{'Sim2_Net_Strength'};
 			  $Sim2NetCountry = $obj[$i]->{'Sim2_Net_Country'};
 			  $Sim2Operator = $obj[$i]->{'Sim2_Sim_Operator'};
 			  $Sim2Country = $obj[$i]->{'Sim2_Sim_Country'};
 			  $SSID = $obj[$i]->{'WIFI_SSID'};
			  $WifiSpeed = $obj[$i]->{'WIFI_Speed'};
 			  $WifiStrength = $obj[$i]->{'WIFI_Strength'};
 			  $WifiFrequeny = $obj[$i]->{'WIFI_Frequency'};
 			  $Userlat = $obj[$i]->{'User_Latitude'};
 			  $Userlong = $obj[$i]->{'User_Longitude'};
			  $UserCountry = $obj[$i]->{'User_Country'};
			  $UserState = $obj[$i]->{'User_State'};
			  $UserCity = $obj[$i]->{'User_City'};
			  $UserArea = $obj[$i]->{'User_Area'};
			  $Towerlat = $obj[$i]->{'Tower_Latitude'};
			  $Towerlong = $obj[$i]->{'Tower_Longitude'};
			  $TowerAddress = $obj[$i]->{'Tower_Address'};
			  
				$data=array('Device_ID' => $Device_ID,
			  	'Date_&_Time'=>$Date,
    			'Mobile_Product'=>$MobileProduct,
    			'Mobile_Model'=>$MobileModel,
    			'Network_Operator'=>$Sim1NetOperator,
				'Network_Type'=>$Sim1NetType,
				'Network_Strength'=>$Sim1NetStrength,
				'Network_Country'=>$Sim1NetCountry,
				'Sim_Operator'=>$Sim1Operator,
    			'Sim_Country'=>$Sim1Country,
    			'Second_Network_Operator'=>$Sim2NetOperator,
				'Second_Network_Type'=>$Sim2NetType,
				'Second_Network_Strength'=>$Sim2NetStrength,
				'Second_Network_Country'=>$Sim2NetCountry,
				'Second_Sim_Operator'=>$Sim2Operator,
    			'Second_Sim_Country'=>$Sim2Country,
    			'Wifi_SSID'=>$SSID,
				'Wifi_Speed'=>$WifiSpeed,
			    'Wifi_Strength'=>$WifiStrength,
    			'Wifi_Frequency'=>$WifiFrequeny,
    			'User_Latitude'=>$Userlat,
    			'User_Longitude'=>$Userlong,
    			'User_Country'=>$UserCountry,
    			'User_State'=>$UserState,
    			'User_City'=>$UserCity,
    			'User_Area'=>$UserArea,
    			'Tower_Latitude'=>$Towerlat,
    			'Tower_Longitude'=>$Towerlong,
    			'Tower_Address'=>$TowerAddress);
			  
			  $getview = $this->Showroom->insertNetworkinfo($data);
			  	foreach($getview as $gview){
			  		$dataarray[] = $gview['Date_&_Time'];
			  	}
			  }
			  
			  if($dataarray){
			  		echo json_encode(array("Response" =>$dataarray));
			  }else{
			  		echo json_encode(array("Error" =>"Error occured in Insert Data"));
			  }
			  
			}
	}
	/****** Toilet Project **********/
	public function toiletProjectAction(){
			if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}
			
			$json = file_get_contents('php://input');
			$array = json_decode($json);
			//$lat = "55.805550";
			//$lang = "-184.326102";
			if($array == null){
				echo json_encode(array("Error" =>"Does not valid Request"));
			}else{
				$lat = $array->{'Latitude'};
			 	$lang = $array->{'Longitude'};
			 	$gender = $array->{'Gender'};
			 	$higenic = $array->{'Higenic'};
			 	$place = $array->{'Place'};
			 	$rating = $array->{'Rating'};
			 	$disabledaccess = $array->{'Disabled_Access'};
			 	$cost = $array->{'Cost'};
			 	$address = $array->{'Address'};
			 	$comments = $array->{'Comment'};
			 	$UnigueID = uniqid();
			 	
				$dataview = $this->Showroom->toiletvalues($UnigueID,$lat,$lang,$gender,$higenic,$place,$rating,$disabledaccess,$cost,$address,$comments);
			  	if($dataview){
			  		$Dirctory = 'ToiletCSVFiles/'.$UnigueID.'.csv';			 	
			 		$file = fopen($Dirctory, 'a+') or die('cannot open the file'.$Dirctory);
			 		//if($comments != ""){
			 			fputcsv($file, array($UnigueID,$UnigueID.uniqid(),$comments,$rating));
			 		//}
			 		fclose($file);
			 		
			 		$Dirctory1 = 'ToiletReportFiles/'.$UnigueID.'.csv';			 	
			 		$file1 = fopen($Dirctory1, 'w') or die('cannot open the file'.$Dirctory1);
			 		fclose($file1);
			 		
			  		echo json_encode(array("Response" =>$dataview));
			  	}else{
			  		echo json_encode(array("Error" =>"Error occured in Insert Data"));
			  	}
			}			
	}
	
	public function toiletGetDataAction(){
			if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}
			
			$json = file_get_contents('php://input');
			$array = json_decode($json);
			//$lat = "55.805550";
			//$lang = "-184.326102";
			if($array == null){
				echo json_encode(array("Error" =>"Does not valid Request"));
			}else{
				$lat = $array->{'Latitude'};
			 	$lang = $array->{'Longitude'};
				$dataview = $this->Showroom->toiletgetdatavalues($lat,$lang);
				$Holearray = array();
				if($dataview){
			  		foreach($dataview as $data){
			  			$row = 1;
						$select = 2;
						$resarr=array();
						if (($handle = fopen('ToiletCSVFiles/'.$data["Toilet_ID"].'.csv', "r")) !== FALSE) {
  							while (($dataextra = fgetcsv($handle, 1000, ",")) !== FALSE) {
  							$num = count($dataextra);
    						$row++;
    						$newcommarr;
    						for ($c=0; $c < $num; $c++) {       
       							if($c == 1){
      								$newcommarr["Command_ID"] = $dataextra[$c];
      							}else if($c == 2){
      								$newcommarr["Command"] = $dataextra[$c];
      							}else if($c == 3){
      								$newcommarr["Rating"] = $dataextra[$c];
      							}
    						}
    						array_push($resarr,$newcommarr);    						
  						}
  						$data["Comment"] = $resarr;
    					array_push($Holearray,$data);
  						fclose($handle);
						}else{
    						$Dirctory = 'ToiletCSVFiles/'.$data["Toilet_ID"].'.csv';			 	
			 				$file = fopen($Dirctory, 'a+') or die('cannot open the file'.$Dirctory);
			 				fclose($file);
			 				$data["Comment"] = array();
    						array_push($Holearray,$data);
    					}
			  		}
			  		echo json_encode(array("Response" =>$Holearray));
				}else{
			  		echo json_encode(array("Error" =>"Error occured in get Data"));
				}
			} 			
	}
	
	public function toiletUploadImagesAction(){
			if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}
			
			$toilet_ID = trim ( $this->getRequest ()->getParam ( 'Toilet_ID' ) );
			$c = array();
			$i = 0;
			if($toilet_ID != ""){
			$target_dir = "ToiletImages/".$toilet_ID."/";
			$filesiz = count($_FILES);
			if(file_exists($target_dir)){
			$c[]= "already exist directory";
			} else {
				if (mkdir($target_dir, 0777, true)) {
				$c[]= "create directory";
				for ($i; $i < $filesiz; $i++) {
					$target_file = $target_dir . basename($_FILES["pic".$i]["name"]);
					$uploadOk = 1;
					$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
				
					// Check if file already exists
					if (file_exists($target_file)) {
    					$c[]= "Sorry, file already exists.";
    					$uploadOk = 0;
					}
				
					// Check file size
					if ($_FILES["pic".$i]["size"] > 500000) {
    					$c[]= "Sorry, your file is too large.";
    					$uploadOk = 0;
					}
				
					// Allow certain file formats
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    					$c[]= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    					$uploadOk = 0;
					}
				
					// Check if $uploadOk is set to 0 by an error
					if ($uploadOk == 0) {
    					$c[]= "Sorry, your file was not uploaded.";
						// if everything is ok, try to upload file
					} else {
     					if (move_uploaded_file($_FILES["pic".$i]["tmp_name"], $target_file)) {
     						$dataview = $this->Showroom->toiletUpdateImage($target_file,$toilet_ID,$i);
     						if($dataview){
     						$c[]= json_encode($dataview);
     						}
       						$c[]= $_FILES["pic".$i]["name"];
     					} else {
        					$c[]= "Sorry, there was an error uploading your file.";
     					}
					}

				}
				}
			}
			}else{
			$c.= "Without Toilet ID.";
			}
			echo json_encode(array("Response" =>$c));
	}
	
	public function addToiletCommentAction(){
			if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}
			
			$json = file_get_contents('php://input');
			$array = json_decode($json);
			if($array == null){
				echo json_encode(array("Error" =>"Does not valid Request"));
			}else{
				$toiletid = $array->{'Toilet_ID'};
			 	$rating = $array->{'Rating'};
			 	$comment = $array->{'Comment'};
			 	if($toiletid != ""){
			 	  $target_dir = "ToiletCSVFiles/".$toiletid.".csv";
			 	  if(file_exists($target_dir)){
			 	  	$file = fopen($target_dir, 'a+') or die('cannot open the file'.$target_dir);
			 		fputcsv($file, array($toiletid,$toiletid.uniqid(),$comment,$rating));
			 		fclose($file);
			 		echo json_encode(array("Response" =>"Success"));
			 	  }else{
			 	  	echo json_encode(array("Error" =>"No File"));
			 	  }
			 	}
			}
			
	}
	
	public function addReportAction(){
			if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}
			
			$json = file_get_contents('php://input');
			$array = json_decode($json);
			if($array == null){
				echo json_encode(array("Error" =>"Does not valid Request"));
			}else{
				$report = $array->{'Report'};
				$item = $array->{'Item'};
				$toiletid = $array->{'Toilet_ID'};
				if($toiletid != "" && $report != ""){
				    $target_dir = "ToiletReportFiles/".$toiletid.".csv";
				    if($report == "No Toilet"){
				    	$dataview = $this->Showroom->toiletUpdateReport($report,$toiletid);
						echo json_encode(array("Response" =>$dataview));
				    }else if($report == "Wrong Place"){
				    	$file = fopen($target_dir, 'a+') or die('cannot open the file'.$target_dir);
			 			fputcsv($file, array($toiletid,"0",$item));
			 			fclose($file);
			 			$placearray = array();
			 			if (($handle = fopen($target_dir, "r")) !== FALSE) {
			 				while (($dataextra = fgetcsv($handle, 1000, ",")) !== FALSE) {
  								if($dataextra[1] == 0){
									array_push($placearray,$dataextra[2]);
    							}    
    						}
    					}
    					fclose($handle);
    					$count = array_count_values($placearray); 
    					$maxarray = max($count);
    					$val = array_search($maxarray, $count);
    					if($maxarray > 3){
    						$dataview = $this->Showroom->toiletColumnUpdateReport('Place',$val,$toiletid);
    						if($dataview){
    							$file = fopen($target_dir, 'w') or die('cannot open the file'.$target_dir);
    							fclose($file);
    							echo json_encode(array("Response" =>"Report Update Successs"));
    						}else{
    							echo json_encode(array("Response" =>"Error in Update Report"));
    						}
    					}else{
    						echo json_encode(array("Response" =>"Add Report Success"));
    					}
				    }else if($report == "Wrong Gender"){
				    
				    $file = fopen($target_dir, 'a+') or die('cannot open the file'.$target_dir);
			 			fputcsv($file, array($toiletid,"1",$item));
			 			fclose($file);
			 			$placearray = array();
			 			if (($handle = fopen($target_dir, "r")) !== FALSE) {
			 				while (($dataextra = fgetcsv($handle, 1000, ",")) !== FALSE) {
  								if($dataextra[1] == 1){
									array_push($placearray,$dataextra[2]);
    							}    
    						}
    					}
    					fclose($handle);
    					$count = array_count_values($placearray); 
    					$maxarray = max($count);
    					$val = array_search($maxarray, $count);
    					if($maxarray > 3){
    						$dataview = $this->Showroom->toiletColumnUpdateReport('Gender',$val,$toiletid);
    						if($dataview){
    							$file = fopen($target_dir, 'w') or die('cannot open the file'.$target_dir);
    							fclose($file);
    							echo json_encode(array("Response" =>"Report Update Successs"));
    						}else{
    							echo json_encode(array("Response" =>"Error in Update Report"));
    						}
    					}else{
    						echo json_encode(array("Response" =>"Add Report Success"));
    					}
				    
				    }else if($report == "Wrong Disabled Access"){
				    
				    $file = fopen($target_dir, 'a+') or die('cannot open the file'.$target_dir);
			 			fputcsv($file, array($toiletid,"2",$item));
			 			fclose($file);
				    	$placearray = array();
			 			if (($handle = fopen($target_dir, "r")) !== FALSE) {
			 				while (($dataextra = fgetcsv($handle, 1000, ",")) !== FALSE) {
  								if($dataextra[1] == 2){
									array_push($placearray,$dataextra[2]);
    							}    
    						}
    					}
    					fclose($handle);
    					$count = array_count_values($placearray); 
    					$maxarray = max($count);
    					$val = array_search($maxarray, $count);
    					if($maxarray > 3){
    						$dataview = $this->Showroom->toiletColumnUpdateReport('Disabled_Access',$val,$toiletid);
    						if($dataview){
    							$file = fopen($target_dir, 'w') or die('cannot open the file'.$target_dir);
    							fclose($file);
    							echo json_encode(array("Response" =>"Report Update Successs"));
    						}else{
    							echo json_encode(array("Response" =>"Error in Update Report"));
    						}
    					}else{
    						echo json_encode(array("Response" =>"Add Report Success"));
    					}
				    
				    }else if($report == "Wrong Hygenic"){
				    
				    	$file = fopen($target_dir, 'a+') or die('cannot open the file'.$target_dir);
			 			fputcsv($file, array($toiletid,"3",$item));
			 			fclose($file);
				    	$placearray = array();
			 			if (($handle = fopen($target_dir, "r")) !== FALSE) {
			 				while (($dataextra = fgetcsv($handle, 1000, ",")) !== FALSE) {
  								if($dataextra[1] == 3){
									array_push($placearray,$dataextra[2]);
    							}    
    						}
    					}
    					fclose($handle);
    					$count = array_count_values($placearray); 
    					$maxarray = max($count);
    					$val = array_search($maxarray, $count);
    					if($maxarray > 3){
    						$dataview = $this->Showroom->toiletColumnUpdateReport('Higenic',$val,$toiletid);
    						if($dataview){
    							$file = fopen($target_dir, 'w') or die('cannot open the file'.$target_dir);
    							fclose($file);
    							echo json_encode(array("Response" =>"Report Update Successs"));
    						}else{
    							echo json_encode(array("Response" =>"Error in Update Report"));
    						}
    					}else{
    						echo json_encode(array("Response" =>"Add Report Success"));
    					}
				    
				    }
					
				}else{
					echo json_encode(array("Response" =>"No Values"));
				}
			}
	}
	
	public function toiletAddFeedbackAction(){
			if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}
			
			$deviceID = trim ( $this->getRequest ()->getParam ( 'Device' ) );
			$screen = trim ( $this->getRequest ()->getParam ( 'Screen' ) );
			$summary = trim ( str_replace("'","''",$this->getRequest ()->getParam ( 'Summary' )) );
			$suggestion = trim ( str_replace("'","''",$this->getRequest ()->getParam ( 'Suggestion' )) );
			$date = trim ( $this->getRequest ()->getParam ( 'Date' ) );
			
			$target_dir = "ToiletFeedbackImages/";
			$c;
			$imagename = "";
			if (isset($_FILES['pic'])){
			
				$target_file = $target_dir . basename($_FILES["pic"]["name"]);
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
				
				// Check if file already exists
				if (file_exists($target_file)) {
    				echo json_encode(array("Response" =>"Sorry, file already exists."));
    				$uploadOk = 0;
				}
				
				// Check file size
				if ($_FILES["pic"]["size"] > 500000) {
    				echo json_encode(array("Response" =>"Sorry, your file is too large."));
    				$uploadOk = 0;
				}
				
				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    				echo json_encode(array("Response" =>"Sorry, only JPG, JPEG, PNG & GIF files are allowed."));
    				$uploadOk = 0;
				}
				
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
    				echo json_encode(array("Response" =>"Sorry, your file was not uploaded."));
					// if everything is ok, try to upload file
				} else {
     				if (move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file)) {
     					$imagename = "http://quadrobay.co.in/Toilet_App/public/ToiletFeedbackImages/".$_FILES["pic"]["name"];
     					$dataview = $this->Showroom->toiletUpdateFeedback($deviceID,$screen,$summary,$suggestion,$imagename,$date);
     					if($dataview){
     						echo json_encode(array("Response" =>$dataview));
     					}
     				} else {
        				echo json_encode(array("Response" =>"Sorry, there was an error uploading your file."));
     				}
				}
				
			}else{
			
			    $dataview = $this->Showroom->toiletUpdateFeedback($deviceID,$screen,$summary,$suggestion,$imagename,$date);
     				if($dataview){
     					echo json_encode(array("Response" =>$dataview));
     				}
			
			}
			
	}
	
	public function toiletGetFeedbackAction(){
			if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('Error'=>"This function accepts only POST."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}
			
			$deviceID = trim ( $this->getRequest ()->getParam ( 'Device' ) );
			
			if($deviceID != ""){
			
				$dataview = $this->Showroom->toiletGetFeedback($deviceID);
				if($dataview){
     				echo json_encode(array("Response" =>$dataview));
     			}else{
     				echo json_encode(array("Response" =>"No values"));
     			}
			}
	}								
	
	/****** Toilet Project Finish **********/
}	
?>