<?php
session_start();

include("./func/install.php");
include("./func/manage_accounts.php");
include("./func/manage_products.php");
include("./func/manage_category.php");

if ($_GET["modify_user"] == "MODIFY")
	$return = modify_account($_GET["user_id"], $_GET["login"], $_GET["pwd"], $_GET["rights"]);
if ($_GET["delete_user"] == "DELETE ACCOUNT" || $_GET["delete_user"] == "DELETE")
{
	$return = delete_account($_GET["user_id"]);
	if ($return == 1 && $_GET["user_id"] == $_SESSION["logged_user"]["user_id"])
	{
		redirection("check.php?submit=DELETED");
	}
}
	
if ($_GET["add_user"] == "ADD")
	$return = create_account($_GET["new_login"], $_GET["new_pwd"], $_GET["new_rights"]);
if ($_GET["modify_product"] == "MODIFY")
	$return = modify_product($_GET["product_id"], $_GET["artist"], $_GET["album"], $_GET["image"], $_GET["price"], implode(";", $_GET["category"]));
if ($_GET["delete_product"] == "DELETE")
	$return = delete_product($_GET["product_id"]);
if ($_GET["add_product"] == "ADD")
	$return = create_product($_GET["new_artist"], $_GET["new_album"], $_GET["new_image"], $_GET["new_price"], implode(";", $_GET["new_category"]));
if ($_GET["modify_category"] == "MODIFY")
	$return = modify_category($_GET["category_id"], $_GET["category_name"]);
if ($_GET["delete_category"] == "DELETE")
	$return = delete_category($_GET["category_id"]);
if ($_GET["add_category"] == "ADD")
	$return = create_category($_GET["new_category_name"]);

$accounts = get_accounts();
$products = get_products();
$orders = get_orders();
$categories = get_categories();

?>
<html>
	<head>
		<link rel="stylesheet" href="css/style.css">
		<title>e-commerce</title>
	</head>
	<nav>
		<div class="title">
			<div class="title-text">e-vinyl</div>
		</div>
		<div class="menu">
			<div class="menu-text">home</div>
			<div class="menu-overlay">
				<a href="index.php" class="menu-link">
					<div class="menu-text">home</div>
				</a>
			</div>
		</div>
		<div class="menu">
			<div class="menu-text">vinyls</div>
			<div class="menu-overlay">
				<a href="vinyls.php" class="menu-link">
					<div class="menu-text">vinyls</div>
				</a>
			</div>
		</div>
		<div class="menu">
			<div class="menu-text">cart</div>
			<div class="menu-overlay">
				<a href="cart.php" class="menu-link">
					<div class="menu-text">cart</div>
				</a>
			</div>
		</div>
		<div class="menu">
			<div class="menu-text">logout</div>
			<div class="menu-overlay">
				<a href="check.php?submit=LOGOUT" class="menu-link">
					<div class="menu-text">logout</div>
				</a>
			</div>
		</div>
	</nav>
	<body>
		<?php
			if ($_SESSION["logged_user"]["rights"] == "user")
			{
		?>
		<div class="box1" style="margin-left:360px;width:1200px;height:auto;">
			<h1>orders</h1>
			<table class="panier-table">
				<?php
					if (isset($_SESSION["logged_user"]) && isset($orders))
					{
						foreach ($orders as $key_order => $tab_order)
						{
							if ($_SESSION["logged_user"]["user_id"] == $tab_order["user_id"])
							{
							?>
					<tr style="height:40px;">
						<td class="panier-elem">
							<?php
									echo '<div class="panier-text" style="font-size: 20px; text-align: center;">'.$tab_order["login"].'</div>';
							?>
						</td>
						<td class="panier-elem" colspan="3">
							<div class="panier-text" style="font-size: 20px; text-align: center;">
								<?php echo "order n*: ".$tab_order["order_id"]; ?>
							</div>
						</td>
					</tr>
					<?php
								$total_price = 0;
								foreach ($tab_order["panier"] as $key_panier => $tab_panier)
								{
									foreach ($products as $key_products => $tab_products)
									{
										if ($tab_products["product_id"] == $tab_panier["product_id"])
										{
										?>
						<tr style="height:80px;">
							<td class="panier-elem">
								<img src=<?php echo $tab_products[ "image"]; ?> style="width:70px; height:70px;"/>
							</td>
							<td class="panier-elem" style="overflow:hidden;width:400px;">
								<?php echo '<div style="font-size:14px;" class="panier-text" style="width:400px;">'.$tab_products["artist"].'</div>'; ?>
								<?php echo '<div style="font-size:14px;" class="panier-text" style="width:400px;">'.$tab_products["album"].'</div>'; ?>
							</td>
							<td class="panier-elem" style="width:200px;">
								<?php 
												echo '<div style="font-size:14px;" class="panier-text">'.$tab_products["price"] * $tab_panier["quantity"].' $</div>';
												$total_price += $tab_products["price"] * $tab_panier["quantity"];
											?>
							</td>
							<td class="panier-elem" style="width:200px;">
								<?php echo '<div style="font-size:14px;" class="panier-text">'.$tab_panier["quantity"].'</div>'; ?>
							</td>
						</tr>
						<?php
										}
									}
								}
								?>
						<tr style="height:10px;">
							<td></td>
							<td></td>
							<td colspan="2" class="panier-elem">
								<?php echo '<div style="font-size:14px;" class="panier-text"> total: '.$total_price.' $</div>'; ?>
							</td>
						</tr>
						<?php
							}
						}
					}
				?>
			</table>
		</div>
		<div class="box1" style="margin-left:860px;width:200px;height:auto;">
			<form action="profil.php">
				<input type="hidden" name="user_id" value=<?php echo $_SESSION["logged_user"]["user_id"];?> />
				<input type="submit" name="delete_user" value="DELETE ACCOUNT" style="width:160px;margin-left:20px; margin-top:10px;" />
			</form>
		</div>
		<?php
			}
		?>
		<?php
			if ($_SESSION["logged_user"]["rights"] == "admin")
			{
		?>
			<div class="box1" style="margin-left:360px;width:1200px;height:auto;">
				<h1>orders</h1>
				<table class="panier-table">
					<?php
						if (isset($_SESSION["logged_user"]) && isset($orders))
						{
							foreach ($orders as $key_order => $tab_order)
							{
								?>
						<tr style="height:40px;">
							<td class="panier-elem">
								<?php
									echo '<div class="panier-text" style="font-size: 20px; text-align: center;">'.$tab_order["login"].'</div>';
								?>
							</td>
							<td class="panier-elem" colspan="3">
								<div class="panier-text" style="font-size: 20px; text-align: center;">
									<?php echo "order n*: ".$tab_order["order_id"]; ?>
								</div>
							</td>
						</tr>
						<?php
									$total_price = 0;
									foreach ($tab_order["panier"] as $key_panier => $tab_panier)
									{
										foreach ($products as $key_products => $tab_products)
										{
											if ($tab_products["product_id"] == $tab_panier["product_id"])
											{
											?>
							<tr style="height:80px;">
								<td class="panier-elem">
									<img src=<?php echo $tab_products[ "image"]; ?> style="width:70px; height:70px;"/>
								</td>
								<td class="panier-elem" style="overflow:hidden;width:400px;">
									<?php echo '<div style="font-size:14px;" class="panier-text" style="width:400px;">'.$tab_products["artist"].'</div>'; ?>
									<?php echo '<div style="font-size:14px;" class="panier-text" style="width:400px;">'.$tab_products["album"].'</div>'; ?>
								</td>
								<td class="panier-elem" style="width:200px;">
									<?php 
													echo '<div style="font-size:14px;" class="panier-text">'.$tab_products["price"] * $tab_panier["quantity"].' $</div>';
													$total_price += $tab_products["price"] * $tab_panier["quantity"];
												?>
								</td>
								<td class="panier-elem" style="width:200px;">
									<?php echo '<div style="font-size:14px;" class="panier-text">'.$tab_panier["quantity"].'</div>'; ?>
								</td>
							</tr>
							<?php
											}
										}
									}
									?>
							<tr style="height:10px;">
								<td></td>
								<td></td>
								<td colspan="2" class="panier-elem">
									<?php echo '<div style="font-size:14px;" class="panier-text"> total: '.$total_price.' $</div>'; ?>
								</td>
							</tr>
							<?php
							}
						}
					?>
				</table>
			</div>

			<div class="box1" style="display:inline-block; margin-left:650px;width:600px;height:auto;">
				<h1>users</h1>
				<table class="panier-table" style="margin-left:50px;width:500px;">
					<?php
						if (isset($accounts))
						{
							foreach ($accounts as $key_accounts => $tab_accounts)
							{
								?>
						<tr style="height:40px;">
							<td class="panier-elem">
								<div class="panier-text" style="font-size:16px; text-align: center;">id</div>
							</td>
							<td class="panier-elem">
								<div class="panier-text" style="font-size:16px; text-align: center;">
									<?php echo $tab_accounts["user_id"]; ?> </div>
							</td>
							<form action="profil.php">
								<td class="panier-elem">
									<input class="input-text" type="text" name="login" value=<?php echo $tab_accounts["login"]; ?> />
								</td>
								<td class="panier-elem">
									<input class="input-text" type="password" name="pwd" value="" />
								</td>
								<td class="panier-elem">
									<select name="rights">
										<?php 
													if ($tab_accounts["rights"] == "admin")
													{
														echo '<option value="admin" selected="selected" >admin</option>';
														echo '<option value="user" >user</option>';
													}
													else
													{
														echo '<option value="admin">admin</option>';
														echo '<option value="user" selected="selected" >user</option>';
													}
												?>
									</select>
								</td>
								<td class="panier-elem">
									<input type="hidden" name="user_id" value=<?php echo $tab_accounts["user_id"];?> />
									<input type="submit" name="modify_user" value="MODIFY" style="margin-left:0px; margin-bottom:0px;" />
									<input type="submit" name="delete_user" value="DELETE" style="margin-left:0px;" />
								</td>
							</form>
						</tr>

						<?php
							}
							?>
						<form action="profil.php">
							<tr style="height:40px;">
								<td></td>
								<td></td>
								<td class="panier-elem">
									<input class="input-text" type="text" name="new_login" value="" />
								</td>
								<td class="panier-elem">
									<input class="input-text" type="text" name="new_pwd" value="" />
								</td>
								<td class="panier-elem">
									<select name="new_rights">
										<option value="admin">admin</option>
										<option value="user">user</option>
									</select>
								</td>
								<td class="panier-elem">
									<input type="submit" name="add_user" value="ADD" style="margin-left:10px; margin-bottom:0px;" />
								</td>
							</tr>
						</form>
						<?php
						}
					?>
				</table>
			</div>

			<div class="box1" style="display:inline-block; margin-left:350px;width:1200px;height:auto;">
				<h1>products</h1>
				<table class="panier-table" style="margin-left:15px;width:auto;">
					<?php
						if (isset($products))
						{
							foreach ($products as $key_products => $tab_products)
							{
								?>
						<tr style="height:40px;">
							<td class="panier-elem">
								<div class="panier-text" style="font-size:16px; text-align: center;">id</div>
							</td>
							<td class="panier-elem">
								<div class="panier-text" style="font-size:16px; text-align: center;">
									<?php echo $tab_products["product_id"]; ?> </div>
							</td>
							<form action="profil.php">
								<td class="panier-elem">
									<input class="input-text" style="width:200px;" type="text" name="artist" value="<?php echo $tab_products["artist"]; ?>"
									/>
								</td>
								<td class="panier-elem">
									<input class="input-text" style="width:200px;" type="text" name="album" value="<?php echo $tab_products["album"]; ?>" />
								</td>
								<td class="panier-elem" style="display:inline-block;width:100px;">
									<?php
											$split = preg_split("/\;/", $tab_products["category_id"]);
											foreach ($categories as $key => $cat)
											{
												if (in_array($cat["category_id"], $split))
													echo '<input type="checkbox" name="category[]" value='.$cat["category_id"].' checked>'.$cat["category_name"].'<br />';
												else
													echo '<input type="checkbox" name="category[]" value='.$cat["category_id"].'>'.$cat["category_name"].'<br />';;
											}
										?>
								</td>
								<td class="panier-elem">
									<input class="input-text" style="width:300px;" type="text" name="image" value="<?php echo $tab_products["image"]; ?>" />
								</td>
								<td class="panier-elem">
									<input class="input-text" style="width:80px;" type="text" name="price" value="<?php echo $tab_products["price"]; ?>" />
								</td>
								<td class="panier-elem">
									<input type="submit" name="modify_product" value="MODIFY" style="margin-left:0px; margin-bottom:0px;" />
									<input type="submit" name="delete_product" value="DELETE" style="margin-left:0px;" />
									<input type="hidden" name="product_id" value=<?php echo $tab_products[ "product_id"];?> />
									<input type="hidden" name="return" value=<?php echo $return;?> />
								</td>
							</form>
						</tr>
						<?php
							}
							?>
						<form action="profil.php">
							<tr style="height:40px;">
								<td></td>
								<td></td>
								<td class="panier-elem">
									<input class="input-text" style="width:200px;" type="text" name="new_artist" value="" />
								</td>
								<td class="panier-elem">
									<input class="input-text" style="width:200px;" type="text" name="new_album" value="" />
								</td>
								<td class="panier-elem" style="display:inline-block;width:100px;">
									<?php
										$split = preg_split("/\;/", $tab_products["category_id"]);
										foreach ($categories as $key => $cat)
										{
											echo '<input type="checkbox" name="new_category[]" value='.$cat["category_id"].'>'.$cat["category_name"].'<br />';
										}
									?>
								</td>
								<td class="panier-elem">
									<input class="input-text" style="width:300px;" type="text" name="new_image" value="" />
								</td>
								<td class="panier-elem">
									<input class="input-text" style="width:80px;" type="text" name="new_price" value="" />
								</td>
								<td class="panier-elem">
									<input type="submit" name="add_product" value="ADD" style="margin-left:40px; margin-bottom:0px;" />
								</td>
							</tr>
						</form>
						<?php
						}
					?>
				</table>
			</div>

			<div class="box1" style="display:inline-block; margin-left:700px;width:500px;height:auto;">
				<h1>category</h1>
				<table class="panier-table" style="margin-left:50px;width:400px;">
					<?php
						if (isset($categories))
						{
							foreach ($categories as $key_category => $tab_category)
							{
								?>
						<tr style="height:40px;">
							<td class="panier-elem">
								<div class="panier-text" style="font-size:16px; text-align: center;">id</div>
							</td>
							<td class="panier-elem">
								<div class="panier-text" style="font-size:16px; text-align: center;">
									<?php echo $tab_category["category_id"]; ?> </div>
							</td>
							<form action="profil.php">
								<td class="panier-elem">
									<input class="input-text" style="width:300px;" type="text" name="category_name" value="<?php echo $tab_category["category_name"]; ?>" />
								</td>
								<td class="panier-elem" style="width:100px;">
									<input type="hidden" name="category_id" value=<?php echo $tab_category["category_id"];?> />
									<input type="submit" name="modify_category" value="MODIFY" style="margin-left:0px; margin-bottom:0px;" />
									<input type="submit" name="delete_category" value="DELETE" style="margin-left:0px;" />
								</td>
							</form>
						</tr>

						<?php
							}
							?>
						<form action="profil.php">
							<tr style="height:40px;">
								<td></td>
								<td></td>
								<td class="panier-elem">
									<input class="input-text" style="width:300px;" type="text" name="new_category_name" value="" />
								</td>
								<td class="panier-elem">
									<input type="submit" name="add_category" value="ADD" style="margin-left:10px; margin-bottom:0px;" />
								</td>
							</tr>
						</form>
						<?php
						}
					?>
				</table>
			</div>
		<?php
			}
		?>
	</body>

	</html>