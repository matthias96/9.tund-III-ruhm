<?php
   require_once("functions.php");
   if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
	}
	//kasutaja tahab välja logida
	if(isset($_GET["logout"])){
		//addressireal on olemas muutuja logout
		//kustutame kõik sessioonimuutujad
		session_destroy();
		header("Location: login.php");
	}
   $number_plate= $color= "";
   $number_plate_error=$color_error= "";
   if($_SERVER["REQUEST_METHOD"] == "POST") {

   
		if(isset($_POST["add_plate"])){

			if ( empty($_POST["number_plate"])) {
				$number_plate_error = "See väli on kohustuslik";
			}else{
        
				$number_plate = cleanInput($_POST["number_plate"]);
			}

			if ( empty($_POST["color"]) ) {
				$color_error = "See väli on kohustuslik";
			}else{
				$color = cleanInput($_POST["color"]);
			}

     
			if($number_plate_error == "" && $color_error == ""){
				echo "Salvestatud! Numbrimärk on ".$number_plate." ja värv on ".$color. ".";
				$msg= createNumberPlate($number_plate, $color);
				
				if($msg !=""){
					//õnnestus, teeme inputi väljad tühjaks
					$number_plate="";
					$color="";
					
					echo $msg;
				}
				
			}
		}		
   
	   
	 
	   
	   
   }
   function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
	
	
   
 ?> 
 <p>Tere, <?=$_SESSION["logged_in_user_email"];?>
	<a href="?logout=1"> Logi välja <a>
</p>

<h2>Lisa autonumbrimärk </h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="number_plate">Auto numbrimärk</label><br>
  	<input id="number_plate" name="number_plate" type="text"  value="<?php echo $number_plate; ?>"> <?php echo $number_plate_error; ?><br><br>
	<label for="color">Värv</label><br>
  	<input id="color" name="color" type="text"  value="<?php echo $color; ?>"> <?php echo $color_error; ?><br><br>
  	<input type="submit" name="add_plate" value="Salvesta">
  </form>	