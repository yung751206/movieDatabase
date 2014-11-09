<!DOCTYPE html>
<html>
<body>
<h1> Search </h1>

<p>
		<a href = './addActorDirector.php'>Add Actor or Director</a>
	 	<a href = './addMovieInfo.php'>Add Movie</a>
	 	<a href = './addMovieActor.php'>Add Actor to Movie</a>
	 	<a href = './addMovieDirector.php'>Add Director to Movie</a>
	 	
<form method = "get" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<input type = "text" name = "keyWord" value="<?php echo htmlspecialchars($_GET["keyWord"]);?>" >
<input type = "submit" value="Submit">
</form>
</p>

<?php
	$connection = False;
	if($_SERVER["REQUEST_METHOD"] == "GET") {
		if (!empty($_GET["keyWord"])){
			$keyWord = $_GET["keyWord"];
			$keyWordArray = explode(' ', $keyWord);	
			$length = count($keyWordArray);
			$query[0] = "select * from Movie where title like '%$keyWord%' ";
			if($length == 2){
				$query[1] = "select * from Actor where first like '%$keyWordArray[0]%' and last like '%$keyWordArray[1]%' " ;
				$query[2] = "select * from Actor where first like '%$keyWordArray[1]%' and last like '%$keyWordArray[0]%' ";
			}
			elseif ($length == 1){
				$query[1] = "select * from Actor where first like '%$keyWordArray[0]%' or last like '%$keyWordArray[0]%' " ;

			}
			else{
				$length = 0;
			}		

			$db_connection_search = mysql_connect("localhost", "cs143", "");
			if ($db_connection_search){
				mysql_select_db("CS143",$db_connection_search);
				$connection = True;
			}
			else{
				$errmsg = mysql_error($db_connection_search);
				print "$errmsg <br>";
				mysql_close($db_connection_search);
				exit(1);
			}
		}
		if($connection){
			$rs = mysql_query($query[0],$db_connection_search);
			if(!$rs){
				$errmsg = mysql_error($db_connection_search);
	    		print "$errmsg <br>";
	    		mysql_close($db_connection_search);	
	    		exit(1);
			}
			else{
				while($row = mysql_fetch_row($rs)){
					echo "Movie: <a href = './showMovieInfo.php?mid=$row[0]''>$row[1]($row[2])  </a><br>";					
				}
			}

			$i=1;
			while($i <= $length){				
				$rs = mysql_query($query[$i],$db_connection_search);
				if(!$rs){
					$errmsg = mysql_error($db_connection_search);
		    		print "$errmsg <br>";
		    		mysql_close($db_connection_search);	
		    		exit(1);
				}
				else{
					while($row = mysql_fetch_row($rs)){
						echo "Actor: <a href = './showActorInfo.php?aid=$row[0]'>$row[2] $row[1]($row[4])  </a><br>";
					}
				}				
				$i++;	
			}
			mysql_close($db_connection_search);		
		}
	}
?>

</body>
</html>

