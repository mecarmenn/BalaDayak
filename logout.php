<?php
session_start();

if(isset($_SESSION['username']) || isset($_SESSION['AdminUserName']))
{
	session_destroy();

	echo "<script>location.href='index.php'</script>";
}
?>