<?php
session_start();

include("./func/install.php");
include("./func/manage_cart.php");

$products = get_products();
$accounts = get_accounts();

if ($_GET["submit"] == "MODIFY")
{
	$return = check_product_quantity_validity($_GET["product_id"], $_GET["quantity"]);
	if ($return == 1)
		add_to_cart($_GET["product_id"], (int)$_GET["quantity"], true);
}
else if ($_GET["submit"] == "DELETE")
{
	$return = check_product_quantity_validity($_GET["product_id"], $_GET["quantity"]);
	if ($return == 1)
		delete_from_cart($_GET["product_id"]);
}
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
			<div class="box1" style="margin-left:360px;width:1200px;height:auto;">
				<h1>panier</h1>
				<table class="panier-table">
				<?php
				$total_price = 0;
				if (isset($_SESSION["panier"]))
				{
					foreach ($_SESSION["panier"] as $tab)
					{
						foreach ($products as $key => $tab_products)
						{
							if ($tab["product_id"] == $tab_products["product_id"])
							{
								?>
								<tr style="height:200px;">
								<td class="panier-elem">
									<img src=<?php echo $tab_products["image"]; ?> style="width:200px; height:200px;"/>
								</td>
								<td class="panier-elem" style="overflow:hidden;width:400px;">
									<?php echo '<div class="panier-text" style="width:400px;">'.$tab_products["artist"].'</div>'; ?>
									<?php echo '<div class="panier-text" style="width:400px;">'.$tab_products["album"].'</div>'; ?>
								</td>
								<td class="panier-elem" style="width:200px;">
									<?php 
										echo '<div class="panier-text">'.$tab_products["price"] * $tab["quantity"].' $</div>';
										$total_price += $tab_products["price"] * $tab["quantity"];
									?>	
								</td>
								<td class="panier-elem" style="width:60px;">
									<form action="cart.php" method="get">
									<input type="hidden" name="product_id" value=<?php echo $tab_products["product_id"];?>>
									<input type="number" name="quantity" min="1" max="99" style="margin-left:15px; margin-bottom:10px;" value=<?php echo $tab["quantity"]; ?> ><br />

									<input type="submit" name="submit" value="MODIFY" style="margin-left:10px; margin-bottom:10px;">
									<input type="submit" name="submit" value="DELETE" style="margin-left:10px;">
									</form>
								</td>
								</tr>
							<?php
							}
						}
					}
					?>
					<tr style="height:60px;">
						<td></td>
						<td></td>
						<td class="panier-elem" style="width:200px;">
							<?php echo '<div class="panier-text">'.$total_price.' $</div>'; ?>	
						</td>
						<td class="panier-elem">
							<form action="check.php" method="get">
								<input type="submit" name="submit" value="VALID" style="margin-left:20px; margin-top:0px;"> <br />
								<input type="submit" name="submit" value="CLEAR" style="margin-left:20px; margin-top:0px;">
							</form>	
						</td>
					</tr>
					</table>
				<?php
				}
				?>	
			</div>
		</body>
	</html>