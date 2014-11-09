<!DOCTYPE html>
<html>
<body>
<h1> Add Actor/Director </h1>

	<a href = './addActorDirector.php'>Add Actor or Director</a>
 	<a href = './addMovieInfo.php'>Add Movie</a>
 	<a href = './addMovieActor.php'>Add Actor to Movie</a>
 	<a href = './addMovieDirector.php'>Add Director to Movie</a>
	<form method = "get" action = "./search.php">
		Search:<input type = "text" name = "keyWord">
		<input type = "submit" value="Submit">
	</form>

<p>
<form method = "get" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
Identity: <input type ="radio" name = "identity" value = "actor" checked> Actor <input type ="radio" name = "identity" value = "director"> Director<br>
First Name: <input type = "text" name = "first"><br>
Last Name: <input type = "text" name = "last"><br>
Sex: <input type ="radio" name = "sex" value = "male" checked> Male <input type ="radio" name = "sex" value = "female"> Female<br>
Date of Birth: <input type = "text" name = "dob"><br>
Date of Die: <input type = "text" name = "dod"><br>
<input type = "submit" value = "add">
</form>
</p>

<?php
	$connection = False;
	if(!empty($_GET["dob"])){
		if($_SERVER["REQUEST_METHOD"] == "GET") {
			$identity = $_GET["identity"];
			$first = $_GET["first"];
			$last = $_GET["last"];
			$sex = $_GET["sex"];
			$dob = $_GET["dob"];
			$dod = $_GET["dod"];

			$useless = array(" ","/","\\","-");
			$dob = str_replace($useless, "", $dob);
			$dod = str_replace($useless, "", $dod);

			

			$db_connection_addActorDirector = mysql_connect("localhost", "cs143", "");
			if ($db_connection_addActorDirector){
				mysql_select_db("CS143",$db_connection_addActorDirector);
				$connection = True;
			}
			else{
				$errmsg = mysql_error($db_connection_addActorDirector);
				print "$errmsg <br>";
				mysql_close($db_connection_addActorDirector);
				exit(1);
			}
		}
	}
	if($connection){
		$queryMaxPersonID = "select * from MaxPersonID";
		$rs = mysql_query($queryMaxPersonID,$db_connection_addActorDirector);
		if(!$rs){
			$errmsg = mysql_error($db_connection_addActorDirector);
    		print "$errmsg <br>";
    		mysql_close($db_connection_addActorDirector);	
    		exit(1);
		}
		else{
			while($row = mysql_fetch_row($rs)){
				$id = $row[0]+1;
			}
		}
		if(empty($dod)){
			$dod = 'NULL';
			
		}
		if($identity == "actor"){
			$query = "insert into Actor values ($id,'$last','$first','$sex',$dob,$dod)";		
		}
		else{
			$query = "insert into Director values ($id,'$last','$first',$dob,$dod)";	
		}	
		// echo "$query<br>";

		$rs = mysql_query($query,$db_connection_addActorDirector);
		if(!$rs){
			$errmsg = mysql_error($db_connection_addActorDirector);
    		print "$errmsg <br>";
    		mysql_close($db_connection_addActorDirector);	
    		exit(1);
		}
		else{
			echo "Add successfully<br>";
		}

		$queryMaxPersonID = "update MaxPersonID set id = $id";
		// echo "$queryMaxPersonID";
		$rs = mysql_query($queryMaxPersonID,$db_connection_addActorDirector);
		if(!$rs){
			$errmsg = mysql_error($db_connection_addActorDirector);
    		print "$errmsg <br>";
    		mysql_close($db_connection_addActorDirector);	
    		exit(1);
		}				
		mysql_close($db_connection_addActorDirector);			
	}
	
?>

</body>
</html>

