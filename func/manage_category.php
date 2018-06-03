<?php
session_start();

function create_category($category_name)
{
	$categories = get_categories();
	if (empty($category_name))
		return (-1);
	foreach ($categories as $key_category => $tab_category)
	{
		if ($category_name == $tab_category["category_name"])
			return (-1);
	}
	array_push($categories, array("category_id" => end($categories)["category_id"] + 1, "category_name" => $category_name));
	set_categories($categories);
	return (1);
}

function modify_category($category_id, $category_name)
{
	$categories = get_categories();
	if (empty($category_name))
		return (-1);
	foreach ($categories as $key_category => $tab_category)
	{
		if ($tab_category["category_id"] == $category_id)
		{
			if ($tab_category["category_name"] != $category_name)
				$categories[$key_category]["category_name"] = $category_name;
			set_categories($categories);
			return (1);
		}
	}
}
function delete_category($category_id)
{
	$categories = get_categories();
	if ($category_id == 0)
		return (-1);
	foreach ($categories as $key_category => $tab_category)
	{
		if ($tab_category["category_id"] == $category_id)
		{
			$products = get_products();
			foreach ($products as $key_products => $tab_products)
			{
				$split = preg_split("/;/", $tab_products["category_id"]);
				if (in_array($key_category, $split))
				{
					$pos = array_search($key_category, $split);
					unset($split[$pos]);
					$products[$key_products]["category_id"] = implode(";", $split);
				}

			}
			unset($categories[$key_category]);
			set_categories($categories);
			set_products($products);
			return (1);
		}
	}
}
?>