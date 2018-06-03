<?php
session_start();

function add_to_cart($product_id, $quantity, $erase_quantity)
{
	if (!isset($_SESSION["panier"]))
		$_SESSION["panier"] = array();
	if (isset($_SESSION["panier"]))
	{
		foreach ($_SESSION["panier"] as $key => $panier_tab)
		{
			if ($panier_tab["product_id"] == $product_id)
			{
				if ($erase_quantity == false)
					$_SESSION["panier"][$key]["quantity"] += $quantity;
				else
				$_SESSION["panier"][$key]["quantity"] = $quantity;
				return (1);
			}
		}
	}
	array_push($_SESSION["panier"], array("product_id" => $product_id, "quantity" => (int)$quantity));
	return (2);
}
function delete_from_cart($product_id)
{
	if (isset($_SESSION["panier"]))
	{
		foreach ($_SESSION["panier"] as $key => $panier_tab)
		{
			if ($panier_tab["product_id"] == $product_id)
			{
				unset($_SESSION["panier"][$key]);
				return (1);
			}
		}
	}
}
function check_product_quantity_validity($product_id, $quantity)
{
	$products = get_products();

	if ($quantity < 1 || $quantity > 99)
		return (-2);
	foreach ($products as $key => $tab_products)
	{
		if ($product_id == $tab_products["product_id"])
			return (1);
	}
	return (-1);
}

function valid_cart()
{
	$orders = get_orders();
	if (!isset($_SESSION["logged_user"]))
		return (-1);
	array_push($orders, array("order_id" => time(), "user_id" => $_SESSION["logged_user"]["user_id"], "login" => $_SESSION["logged_user"]["login"], "panier" => $_SESSION["panier"]));
	unset($_SESSION["panier"]);
	set_orders($orders);
	return (1);
}
?>