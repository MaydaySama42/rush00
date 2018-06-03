<?php
session_start();

include("./func/install.php");
include("./func/manage_cart.php");

$products = get_products();
$accounts = get_accounts();
$categories = get_categories();

if ($_GET["submit"] == "ADD_CART")
{
	$return = check_product_quantity_validity($_GET["product_id"], $_GET["quantity"]);
	if ($return == 1)
		add_to_cart($_GET["product_id"], (int)$_GET["quantity"], false);
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
		<div class="box1" style="float:left;display:inline-block;margin-left:325px;width:200px;">
			<form action="vinyls.php" method="get">
				<?php
					foreach($categories as $key => $tab)
					{
						echo '<h2><div style="text-align: left;"><input type="checkbox" name="category[]" value='.$tab["category_id"].'>'.$tab["category_name"].'<br></div></h2>';
					}
				?>
				<br />
				<h2><input type="submit" name="submit" value="Search" style="margin-left:10px;"></h2>
			</form>
		</div>
		<div class="box1" style="display:inline-block;margin-left:100px;width:970px;">
			<?php
				foreach($products as $key_products => $tab_products)
				{
					$split = preg_split("/\;/", $tab_products["category_id"]);
					$search_category = (isset($_GET["category"])) ? $_GET["category"] : array(0);
					foreach ($split as $cat)
					{
						if (in_array($cat, $search_category) && $show[$tab_products["product_id"]] == false)
						{
							$show[$tab_products["product_id"]] = true;
			?>
		<div class="products-box">
			<img src=<?php echo $tab_products["image"];?> class="products"/>
			<div class="text-info"><?php echo $tab_products["artist"];?></div><br />
			<div class="text-info"><?php echo $tab_products["album"];?></div><br />
			<div class="text-info"><?php echo "Price: ".$tab_products["price"]." $"; ?> </div>
			<form action="vinyls.php" method="get">
				<input type="number" name="quantity" min="1" max="99" value="1"style="margin-top:3px;margin-left:35px;">
				<input type="hidden" name="product_id" value=<?php echo $tab_products["product_id"];?>>
				<?php
					if (isset($_GET["category"]))
					{
						foreach($_GET["category"] as $cat)
							echo '<input type="hidden" name="category[]" value='.$cat.'>';
					}
				?>
				<input type="submit" name="submit" value="ADD_CART" style="margin-left:10px;">
			</form>
		</div>
		<?php
						}
					}
				}
			?>
		</div>
	</body>
</html>

