<?php
session_start();
include ("./func/install.php");

$products = get_products();
$accounts = get_accounts();

?>
<html>
	<head>
		<link rel="stylesheet" href="css/style.css">
		<title>e-commerce</title>
	</head>
	<nav>
		<div class="title"><div class="title-text">e-vinyl</div></div>
		<div class="menu">
			<div class="menu-text">home</div>
			<div class="menu-overlay">
				<a href="index.php" class="menu-link"><div class="menu-text">home</div></a>
			</div>
		</div>
		<div class="menu">
			<div class="menu-text">vinyls</div>
			<div class="menu-overlay">
				<a href="vinyls.php" class="menu-link"><div class="menu-text">vinyls</div></a>
			</div>
		</div>
		<div class="menu">
			<div class="menu-text">cart</div>
			<div class="menu-overlay">
				<a href="cart.php" class="menu-link"><div class="menu-text">cart</div></a>
			</div>
		</div>
		<div class="menu">
			<div class="menu-text">
			<?php
				if (isset($_SESSION["logged_user"]))
					echo $_SESSION["logged_user"]["login"]." (logged on)";
				else
					echo "connect";
			?>
			</div>
			<div class="menu-overlay">
				<?php
					if (isset($_SESSION["logged_user"]))
						echo '<a href="profil.php" class="menu-link">';
					else
						echo '<a href="connect.html" class="menu-link">';
				?>
					<div class="menu-text">
						<?php
						if (isset($_SESSION["logged_user"]))
							echo $_SESSION["logged_user"]["login"]." (logged on)";
						else
							echo "connect";
						?>
					</div>
				</a>
			</div>
		</div>
	</nav>
	<body>
		<div class="hot">
			<h1>what's new</h1>
			<div id="slideshow">
					<div id="album-cover-slideshow">
						<?php
							foreach($products as $key => $tab)
							{
								if ($tab["hot"] == true)
									echo '<img src='.$tab["image"].' class="cover"/>';
							}
						?>
				</div>
		</div>
	</body>
</html>