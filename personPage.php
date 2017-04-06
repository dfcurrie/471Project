<!DOCTYPE html>

<html>
	<head>
		<meta charset="UTF-8">
		<title>Person</title>
	</head>
	<body>
		<h1>Person</h1>
		<?php
		
			/*
			Code to open page will look something like this:
			
			<form action="personPage.php" method="get">
				<input type="submit" class="button" name="ID" value="3">
			</form>
			
			can also be accessed directly with .../personPage.php?ID=3
			*/
	
	
			// Connect to the database
			$servername = "localhost";		  //should be same for you
			$username = "root";				 //same here
			$password = "";					 //your localhost root password
			$db = "films_db";				   //your database name
			
			$conn = new mysqli($servername, $username, $password, $db);
			if($conn->connect_error){
				die("Connection failed".$conn->connect_error);
			}
			
			$personID = $_GET["ID"]; // This determines which person to show info for
			
			// **** Person information **** //
			$sql = "SELECT * 
			        FROM persons p
			        WHERE p.ID = ".$personID;

			$result = $conn->query($sql);
			if ($result == NULL) {
				die("Failed");
			}
			
			// Basic person info
			$row = $result->fetch_assoc();
			echo "Name: ".$row["name"]."<br>"; 
			if ($row["dateOfBirth"] != 0) {
				echo "Date of birth: ".$row["dateOfBirth"]."<br>";
			}
			if ($row["dateOfDeath"] != 0) {
				echo "Date of death: ".$row["dateOfDeath"]."<br>";
			}
			
			// **** Director information **** //
			$sql = "SELECT * 
			        FROM directors d
					WHERE d.ID = ".$personID;
			
			$result = $conn->query($sql);
			if ($result == NULL) {
				die("Failed");
			}
			
			// If person is a director
			if($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				
				$favFilm = $row["favFilm"];
				$sql = "SELECT * 
				        FROM directors d, films f
				        WHERE d.ID = ".$personID."
				              AND f.director = d.ID
						ORDER BY f.year";
				
				$result = $conn->query($sql);
				if ($result == NULL) {
					die("Failed");
				}
				
				// Print all films directed
				if($result->num_rows > 0) {
					echo "<br>Directed:<br>";
					while($row = $result->fetch_assoc()){
						echo $row["name"]." (".$row["year"].")";
						if ($row["ID"] == $favFilm) {
							echo " - favourite film directed";
						}
						echo "<br>";
					}
				}
			}
			
			// **** Actor information **** //
			$sql = "SELECT * 
			        FROM actors a
					WHERE a.ID = ".$personID;
			
			$result = $conn->query($sql);
			if ($result == NULL) {
				die("Failed");
			}
			
			// If person is an actor
			if($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				
				$favFilm = $row["favRole"];
				$sql = "SELECT * 
				        FROM actors a, films f, acted_in ac
				        WHERE a.ID = ".$personID."
				              AND ac.actorID = a.ID
							  AND ac.filmID = f.ID
						ORDER BY f.year";
				
				$result = $conn->query($sql);
				if ($result == NULL) {
					die("Failed");
				}
				
				// [film] as [role]
				if($result->num_rows > 0) {
					echo "<br>Stared in:<br>";
					while($row = $result->fetch_assoc()){
						echo $row["name"]." (".$row["year"].")"." as ".$row["role"];
						if ($row["ID"] == $favFilm) {
							echo " - favourite role";
						}
						echo "<br>";
					}
				}
			}		  

			// **** Awards **** //
			// Awards won
			$sql = "SELECT f.Name AS fName, a.name AS aName, a.year, a.organization
			        FROM awards a, won w, films f
					WHERE w.awardID = a.ID
						  AND w.filmID = f.ID
						  AND w.personID = ".$personID;

			$result = $conn->query($sql);
			if ($result == NULL) {
				die("Failed");
			}
			
			// Print out awards
			if($result->num_rows > 0){
				echo "<br>Awards won:<br>";
				while($row = $result->fetch_assoc()){
					echo $row["fName"]." for ".$row["organization"]." ".$row["aName"]." ".$row["year"]."<br>";
				}
			}
			
			// Awards nominated
			$sql = "SELECT f.Name AS fName, a.name AS aName, a.year, a.organization
			        FROM awards a, nominated w, films f
					WHERE w.awardID = a.ID
						  AND w.filmID = f.ID
						  AND w.personID = ".$personID;

			$result = $conn->query($sql);
			if ($result == NULL) {
				die("Failed");
			}
			
			// Print out awards
			if($result->num_rows > 0){
				echo "<br>Awards nominated:<br>";
				while($row = $result->fetch_assoc()){
					echo $row["fName"]." for ".$row["organization"]." ".$row["aName"]." ".$row["year"]."<br>";
				}
			}
			
			
			$conn-> close();
		?>
	</body>
</html>
