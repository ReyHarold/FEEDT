<?php 
session_start(); 
include "conn.php";
if (isset($_POST['name']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['name']);
	$pass = validate($_POST['password']);

	if (empty($uname)) {
		header("Location: index.php?error=User Name is required");
	    exit();
	}else if(empty($pass)){
        header("Location: index.php?error=Password is required");
	    exit();
	}else{
		$sql = "SELECT * FROM user WHERE name='$uname' AND password='$pass'";

		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
			if($row['active'] === "false"){
				header("Location: index.php?error=Account is suspended!");
				exit();
		}
            elseif ($row['name'] === $uname && $row['password'] === $pass) {
            	$_SESSION['name'] = $row['name'];
                $_SESSION['privilage'] = $row['privilage'];
            	$_SESSION['id'] = $row['userid'];
				$sql2 = "INSERT INTO `log`( `userid`, `type`,`description`) VALUES ('".$row['userid']."','in','Logged in')";
				$result = mysqli_query($conn, $sql2);
            	header("Location: frontend/main.php");
		        exit();
            }
				else{
				header("Location: index.php?error=Incorrect User name or password");
		        exit();
			}
		}else{
			header("Location: index.php?error=Incorrect User name or password");
	        exit();
		}
	}

}else{
	header("Location: index.php");
	exit();
}
?>