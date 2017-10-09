<!DOCTYPE html>
<html>
<head>
	<?php session_start(); 
		if(empty($title)){
			$title = "A Simple Card Game";
		}
	?>
	<link rel="icon" href="../img/Flaminko.png">
	<link rel="stylesheet" type="text/css" href="../css/layout.css">
	<link rel="stylesheet" type="text/css" href="../css/content.css">
	
	<title>Flaminko | <?php echo $title; ?></title>
</head>
	<body>
		<div class="topNav">
			<?php 
				if(isset($_SESSION['userDetails'])){
					echo '<form action="../profile/redirect.php" method="POST">';
			        echo '<input class="button topNavRight" id="btn-cmd" name="btn-cmd" type="submit" value="Log out" onclick="return confirm(\'Are you sure you want to log out?\');"/>';
				    echo '</form>';
				}
			?>
			<ul>
				<h3>FLAMINKO IN THE CLOUD</h3>
				<li class="topNavItem" onclick="openNav()">Menu</li>
			</ul>
		</div>
		
<nav id="sideNav" class="sideNav">
	<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
	<?php 
		if(isset($_SESSION['userDetails']) && $_SESSION['userDetails']['admin']=="false"){
			//folder name may change
			echo '<a href="../game/game.php" style="font-weight:bold;font-size:200%;">Play Game</a>';
			echo '<a href="../profile/user.php">Player Profile</a>';
			echo '<a href="#">Edit Profile</a>';
		}
	?>
	<?php 
		if(isset($_SESSION['userDetails']) && $_SESSION['userDetails']['admin']=="true"){
			echo '<a href="#">Admin Profile</a>';
			echo '<a href="/list_users.php">List Users</a>';
			echo '<a href="/delete_user.php">Delete Users</a>';
		}
	?>
	<a href="../utils/leaderboard.php">Leader Board</a>
	<?php 
		if(isset($_SESSION['userDetails'])){
			echo '<a href="../profile/user.php">Home</a>';
		}
		else{
			echo '<a href="../main/index.php">Home</a>';
		}
	?>		
</nav>
