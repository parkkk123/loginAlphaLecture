<?PHP
	session_start();
	if(empty($_SESSION['ID']) || empty($_SESSION['NAME']) || empty($_SESSION['SURNAME'])){
		echo '<script>window.location = "Login.php";</script>';
	}


?>
Change password
<?php
if(isset($_POST['submit'])){
		$conn = oci_connect("system", "1234", "//localhost/XE");
	$oldpass = trim($_POST['oldpass']);
		$newpass = trim($_POST['newpass']);
		$query = "SELECT * FROM MEMBERS WHERE ID = ".$_SESSION['ID'];
		//echo $query;
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		// Fetch each row in an associative array
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
	//print $row['PASSWORD'];
		if($row){
		//	echo $oldpass ." - ".$row['PASSWORD'];
			if($oldpass == $row['PASSWORD']){
				$query = "Update MEMBERS set password='".$newpass."' where ID='".$_SESSION['ID']."'";
				$parseRequest = oci_parse($conn, $query);
				oci_execute($parseRequest);
				echo '<script>window.location = "Logout.php";</script>';
			}
			
		}
		oci_close($conn);
}

?>
<form action='changepassword.php' method='post'>
	Old password <br>
	<input name='oldpass' type='password'><br>
	New Password<br>
	<input name='newpass' type='password'><br><br>
	<input name='submit' type='submit' value='Change'>
</form>