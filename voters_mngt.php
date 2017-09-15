
<?php 
		//1.Create database connection
		$server_name = "localhost"; 
		$username = "consolata";
		$dbpass = "1234conso";
		$dbname = "iebc_db";
		$conn = mysqli_connect($server_name,$username,$dbpass,$dbname);

			//test if connection occured successfully
		if (!$conn) {
			die("Database connection failed: " . mysqli_connect_error());

		}else{
			echo"<b>Connection successfull! <b/><br>";
		}

 ?>


 <?php
		//perform a database query
       //sql command shld be in uppercase 
 		$query = "SELECT * FROM registration ";
 		mysqli_query($conn,$query);
 		$result = mysqli_query($conn,$query);
 		//Test if there was a query error
 		if (!$result) {
 			die("Database query failed: " . mysqli_error());
 		}else{
 			echo "<b>Query successful</b><br/>";
 		}


  ?>


<!DOCTYPE html>
<html>
<head>
	<title>IEBC Voters management System</title>
	<link rel="stylesheet" type="text/css" href="Bootstrap/css/bootstrap.css">
	<style type="text/css">
	#edit{
		color: #aqua;
		background-color: yellow;
	}
	#del{
		color: teal;
		background-color: red;
	}

		</style>
	
</head>
<body>
		<div class="container"> 
			<div class="jumbotron text-center"> 
					<h1>IEBC Voters Management System </h1>
					<p class="text-success"> PHP/mySQL CRUD Operations</p>
			</div>
		</div>
		<!-- section to collect  data from user -->
		<div class="container-fluid bg-primary">
			<h4 class="text-center text-danger">Post Data to the DB</h4>

			<form action="voters_mngt.php" method="POST">

			 	<div class="row align="center" ">
					 	<div  class=" col-md-6">
					 		<div class="form-group">
					 			<label>Name:
					 				<input type="text" name="name" class="form-control" placeholder ="Enter your full Names" required >
					 			</label>
					 		</div>
					 		<div class="form-group">
					 			<label>ID:
					 				<input type="numberr" name="id" class="form-control" placeholder ="Enter your ID no." required >
					 			</label>
					 		</div>
					 		<div class="form-group">
					 			<label>County:
					 				<input type="text" name="county" class="form-control" placeholder ="Enter your county location" required >
					 			</label>
					 		</div>
					 </div>

					 	<div class= "col-md-6">
					 		<div class="form-group">
					 			<label>Date:
					 				<input type="date" name="date" class="form-control" placeholder ="Enter the date" required >
					 			</label>
					 		</div>
					 		<div class="form-group">
					 			<label>Polling Station:
					 				<input type="text" name="Pollingstation" class="form-control" placeholder ="Enter your Polling Station" required >
					 			</label>
					 	</div>
					 		<input type="submit" name="submit" value="Submit Data" class="btn-danger">
				</div>
		 		
		 	</div>
		 		
		 	</form>
			
		</div>


		<!-- Section to display data from Database -->
		<div class="container-fluid"> </div>
				<h4 class="text-center text-warning"> Read from mySQL Database </h4>
				<table class="text-center table bg-success">

					<thead>
						<tr> 
							<th>No</th>
							<th> Name</th>
							<th > ID</th>
							<th> County</th>
							<th> Date</th>
							<th> Pollingstation</th>
							<th id="del">Delete</th>
							<th id="edit">Update</th>
						</tr>
					 </thead>
					 <tbody>
					 <?php 
						//3rd step:use the returned data if any
					 	//iterate the array result and use the data in the table
						//getting data can be got in 2 ways:mysqli_fetch();
					 		//and mysqli_fetch_assoc();
					 while( $row = mysqli_fetch_assoc($result)) {
					 	//var_dump($row);
					 	//echo "<hr>";
					 	echo "<tr>
					 				<td>$row[No]</td>
					 				<td>$row[Name]</td>
					 				<td>$row[ID]</td>
					 				<td>$row[County]</td>
					 				<td>$row[Date]</td>
					 				<td>$row[Pollingstation]</td>
					 				<td><a href='voters_mngt.php?del_id=$row[No]' class='btn btn-danger'>Delete</a></td>
					 				<td><a href='#' class='btn btn-info'>Edit</a></td>
					 				

					 			</tr>"	;
					 	
					 }

						 

					  ?> 

					 </tbody> 
				</table>
	


</body>
</html>
<?php 
//Process user input and push data to the Db
	if (isset($_POST['submit'])) {
		$name = $_POST['name'];
		$id = $_POST['id'];
		$county = $_POST['county'];
		$date = $_POST['date'];
		$pollingstation = $_POST['Pollingstation'];
		//push data to the db
		//use the insert command
		$insert ="INSERT INTO registration (Name,ID,County,Date,Pollingstation)
		VALUES ('$name','$id','$county','$date','$pollingstation')";
		//Run your query
		//mysqli_query($conn,$insert);
		//the problem with the above code when it runs is when refreshed the same name keeps repeatinng.
		if(mysqli_query($conn,$insert)){
			//for reloading the page or page redirect if query successfull
			echo "insert successfull";


	 ?>
		<!-- closed tag p reload using JS -->
		<script> window.location = "voters_mngt.php ";</script>

		<?php

			//if get a header error,wrap
			//header("location:voters_mngt.php")
			//reload();


			}else{
				die("Query failed " .mysqli_error($conn));
			}

	}

 ?>
 <?php 
   //Delete a particular row by assigning a GET
 	//variable to each unique NO.field
 	if (isset($_GET['del_id'])) {
 		//SQL DELETE SYNTAX/QUERY
 		$query_del = "DELETE FROM registration WHERE No = '$_GET[del_id]' ";
 		//Run the query
 		if (mysqli_query($conn,$query_del)) {
 			//Reload page query successfull
 			echo "Delete successfull"; ?>
 			<script >window.location = "voters_mngt.php";
 			</script>
 			<?php

 				}else{
 					die("delete failed:" .mysqli_error($conn));
 				}
 			}

  ?>