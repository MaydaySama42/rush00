<?php 
session_start();

function create_product($artist, $album, $image, $price, $category)
{
	$products = get_products();
	if (empty($artist) || empty($album) || empty($image) || empty($price) || empty($category))
		return (-1);
	foreach ($products as $key_product => $tab_product)
	{
		if ($name == $tab_product["artist"] && $description == $tab_product["album"])
			return (-1);
	}
	array_push($products, array("product_id" => end($products)["product_id"] + 1, "artist" => $artist, "album" => $album, "image" => $image, "price" => $price, "category_id" => $category, "hot" => false));
	set_products($products);
	return (1);
}

function modify_product($product_id, $artist, $album, $image, $price, $category)
{
	if (empty($artist) || empty($album) || empty($image) || empty($price) || empty($category))
		return (-1);
	$products = get_products();
	foreach ($products as $key_product => $tab_product)
	{
		if ($tab_product["product_id"] == $product_id)
		{
			if ($tab_product["artist"] != $artist)
				$products[$key_product]["artist"] = $artist;
			if ($tab_product["album"] != $album)
				$products[$key_product]["album"] = $album;
			if ($tab_product["image"] != $image)
				$products[$key_product]["image"] = $image;
			if ($tab_product["price"] != $price)
				$products[$key_product]["price"] = $price;
			if ($tab_product["category_id"] != $category)
				$products[$key_product]["category_id"] = $category;
			set_products($products);
			return (1);
		}
	}
}

function delete_product($product_id)
{
	$products = get_products();
	foreach ($products as $key_products => $tab_products)
	{
		if ($tab_products["product_id"] == $product_id)
		{
			unset($products[$key_products]);
			set_products($products);
			return (1);
		}
	}
	return (-1);
}
?>