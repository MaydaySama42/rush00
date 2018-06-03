<?php
session_start();

include("./func/install.php");
include("./func/manage_cart.php");
include("./func/manage_accounts.php");

$products = get_products();
$accounts = get_accounts();
$orders = get_orders();

?>
<html>
	<?php
		if ($_GET["submit"] == "CONNECT")
		{
			$return = auth($_GET["login"], $_GET["pwd"]);
			if ($return == 1)
				redirection("index.php");
			else
				redirection("connect.html");
		}
		else if ($_GET["submit"] == "CREATE")
		{
			$return = create_account($_GET["login"], $_GET["pwd"], "user");
			if ($return == 1)
			{
				auth($_GET["login"], $_GET["pwd"]);
				redirection("index.php");
			}
				
			else
				redirection("create.html");
		}
		else if ($_GET["submit"] == "VALID")
		{
			$return = valid_cart();
			if ($return == -1)
				redirection("connect.html");
			else
				redirection("profil.php");
		}
		else if ($_GET["submit"] == "LOGOUT")
		{
			unset($_SESSION["logged_user"]);
			redirection("index.php");
		}
		else if ($_GET["submit"] == "CLEAR")
		{
			unset($_SESSION["panier"]);
			redirection("vinyls.php");
		}
		else if ($_GET["submit"] == "DELETED")
		{
			unset($_SESSION["logged_user"]);
			redirection("index.php");
		}
	?>
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
				<a href="3" class="menu-link"><div class="menu-text">cart</div></a>
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
		<div class="box1">
			<?php
				if ($_GET["submit"] == "CONNECT")
				{
					if ($return == 1)
						echo "<h1>connected succesfully !<br />back to the home</h1>";
					else
						echo "<h1>connection failure ! try again !</h1>";
				}
				else if ($_GET["submit"] == "CREATE")
				{
					if ($return == 1)
						echo "<h1>account created succesfully !<br />back to the home</h1>";
					else if ($return == -1)
						echo "<h1>login already used ! try again !</h1>";
					else if ($return == -2)
						echo "<h1>blank input ! <br />try again !</h1>";
				}
				else if ($_GET["submit"] == "LOGOUT")
				{
					echo "<h1>logout successful !<br />back to the home</h1>";
				}
				else if ($_GET["submit"] == "VALID")
				{
					if ($return == -1)
						echo "<h1>you're not logged !<br />redirect to login page</h1>";
					else
						echo "<h1>order validated !<br />thanks !</h1>";
				}
				else if ($_GET["submit"] == "CLEAR")
				{
					echo "<h1>cart deleted !<br />go back to shopping !</h1>";
				}
				else if ($_GET["submit"] == "DELETED")
				{
					echo "<h1>user deleted !<br />back to the home !</h1>";
				}
			?>
		</div>
	</body>
</html>