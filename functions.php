<?php
   // Loon andmebaasi ühenduse
	require_once("/../config_global.php");
	$database= "if15_mats_3";
	//tekitatakse session, mis hoitakse serveris
	//kõik muutujad on kättesaadavad kuni viimase brauseriakne sulgemiseni
	session_start();
	
	
	
   //võtab andmed ja sisestab ab'i
   //võtame vastu 2 muutujat
   function createUser($create_email, $hash){
	   //Global muutujad, et andmed kätte saada
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email,password) VALUES (?,?)");
		$stmt->bind_param("ss", $create_email, $hash);
		$stmt->execute();
		$stmt->close();
	   
	$mysqli->close();  
   }
   
   function loginUser ($email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
		$stmt = $mysqli->prepare ("SELECT id, email FROM user_sample WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute ();
		if($stmt->fetch()){
			echo " Email ja parool õiged, kasutaja id=".$id_from_db.".";
			
			//tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"]=$id_from_db;
			$_SESSION["logged_in_user_email"]=$email_from_db;
			//suunan data.php lehele
			header("Location: data.php");
			
		}else{
				//ei leidnud
			echo  "Wrong credentials";
		}
				
		$stmt->close();
	
		$mysqli->close();
	   
   }
   
   function createNumberPlate($car_plate,$car_color){
    $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $stmt = $mysqli->prepare("INSERT INTO car_plates (user_id, number_plate, color) VALUES (?,?,?)");
        
        $stmt->bind_param("iss", $_SESSION['logged_in_user_id'], $car_plate, $car_color);
        
		//sõnum
        $message = "";
        
   
        if($stmt->execute()){
			//kui on tõene, siis INSERT õnnestus
            $message = "Sai edukalt lisatud.";
			
        }else{
			//kui on väär, siis error
			echo $stmt->error;
			
		}
        
		return $message;
		
        $stmt->close();
        $mysqli->close();
    }
	
    
 ?>