<?php
	session_start();
	include_once('../include/database.php');
	include ("../include/alt_db.php");

	if(isset($_POST['add'])){
		$database = new Connection();
		$db = $database->open();
		$year = $_POST['startYear']."-".$_POST['endYear'];
		if($_POST['endYear'] <= $_POST['startYear']){
			$_SESSION['e_message'] = "The ending school year should not be less than or equal to the starting school year!";
			header('location:../super_admin/sem_year.php?failed=added');
			exit();
		}

		try{
			//make use of prepared statement to prevent sql injection
			$sql = $db->prepare("INSERT INTO yearsemester (schoolYear, stat, activated) VALUES (:schoolYear, :stat, :activated)");

			//bind
			$sql->bindParam(':schoolYear', $year);
			$sql->bindParam(':stat', $_POST['status']);
			$sql->bindParam(':activated', $_POST['activate']);

			//if-else statement in executing our prepared statement
			$_SESSION['message'] = ( $sql->execute()) ? 'School Year was added successfully' : 'Something went wrong. Cannot added school year';

		
		}
		catch(PDOException $e){
			$_SESSION['e_message'] = "This school year is already existing!";
			header('location:../super_admin/sem_year.php?failed=added');
			exit();
		}

		//close connection
		$database->close();
		header('location:../super_admin/sem_year.php?succesful=added');
		
		
	}
	else{
		$_SESSION['e_message'] = 'Fill up add form first';
		header('location:../super_admin/sem_year.php?failed=empty');
		exit();
	}
	
?>