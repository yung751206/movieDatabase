<!DOCTYPE html>
<html>
<body>
<h1> Show Actor Info </h1>

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
</form>
</p>

<?php
	$connection = False;
	if($_SERVER["REQUEST_METHOD"] == "GET") {
		if (!empty($_GET["aid"])){
			$aID = $_GET["aid"];
			$query[0] = "select * from Actor where id = $aID ";	
			$query[1] = "select * from Movie M,MovieActor MA where MA.mid = M.id and MA.aid = $aID ";
			$db_connection_actorInfo = mysql_connect("localhost", "cs143", "");
			if ($db_connection_actorInfo){
				mysql_select_db("CS143",$db_connection_actorInfo);
				$connection = True;
			}
			else{
				$errmsg = mysql_error($db_connection_actorInfo);
				print "$errmsg <br>";
				mysql_close($db_connection_actorInfo);
				exit(1);
			}
		}
		if($connection){
			$rs = mysql_query($query[0],$db_connection_actorInfo);
			if(!$rs){
				$errmsg = mysql_error($db_connection_actorInfo);
	    		print "$errmsg <br>";
	    		mysql_close($db_connection_actorInfo);	
	    		exit(1);
			}
			else{
				while($row = mysql_fetch_row($rs)){
					echo "Name: $row[2] $row[1]<br>";
					echo "Sex: $row[3]<br>";
					echo "Date of Birth: $row[4]<br>";
					if(empty($row[5])){
						echo "Date of Death: alive<br>";	
					}
					else{
						echo "Date of Death: $row[5]<br>";
					}	
				}
				echo "<br>";
			}

			echo "Act In<br>";
			$rs = mysql_query($query[1],$db_connection_actorInfo);
			if(!$rs){
				$errmsg = mysql_error($db_connection_actorInfo);
	    		print "$errmsg <br>";
	    		mysql_close($db_connection_actorInfo);	
	    		exit(1);
			}
			else{
				while($row = mysql_fetch_row($rs)){	
					echo"Act '$row[7]' in <a href = './showMovieInfo.php?mid=$row[0]''>$row[1] </a><br>";
				}
			}			
		}
		mysql_close($db_connection_actorInfo);	
	}
?>

</body>
</html>

