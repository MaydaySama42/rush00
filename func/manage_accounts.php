<?php
session_start();

function auth($login, $pwd)
{
	$accounts = get_accounts();
	foreach ($accounts as $key => $account)
	{
		if ($login == $account["login"])
		{
			if (hash("whirlpool", $pwd) == $account["pwd"])
			{
				$_SESSION["logged_user"] = array("user_id" => $account["user_id"], "login" => $login, "pwd" => $account["pwd"], "rights" => $account["rights"]);
				return (1);
			}
			else
			{
				unset($_SESSION["logged_user"]);
				return (0);
			}	
		}
	}
	unset($_SESSION["logged_user"]);
	return (-1);
}

function create_account($login, $pwd, $rights)
{
	$accounts = get_accounts();
	if ($login == "" || $pwd == "")
		return (-2);
	foreach ($accounts as $key => $account)
	{
		if ($login == $account["login"])
			return (-1);
	}
	array_push($accounts, array("user_id" => end($accounts)["user_id"] + 1, "login" => $login, "pwd" => hash("whirlpool", $pwd), "rights" => $rights));
	set_accounts($accounts);
	return (1);
}

function modify_account($user_id, $login, $pwd, $rights)
{
	$accounts = get_accounts();
	if ($user_id == 0)
		return (-1);
	if (empty($login))
		return (-1);
	foreach ($accounts as $key_accounts => $tab_accounts)
	{
		if ($tab_accounts["user_id"] == $user_id)
		{
			if ($tab_accounts["login"] != $login)
				$accounts[$key_accounts]["login"] = $login;
			if ($tab_accounts["pwd"] != hash("whirlpool", $pwd) && !empty($pwd))
				$accounts[$key_accounts]["pwd"] = hash("whirlpool", $pwd);
			if ($tab_accounts["rights"] != $rights)
				$accounts[$key_accounts]["rights"] = $rights;
			set_accounts($accounts);
			return (1);
		}
	}
	return (-1);
}

function delete_account($user_id)
{
	if ($user_id == 0)
		return (-1);
	$accounts = get_accounts();
	foreach ($accounts as $key_accounts => $tab_accounts)
	{
		if ($tab_accounts["user_id"] == $user_id)
		{
			$orders = get_orders();
			foreach ($orders as $key_order => $tab_order)
			{
				if ($tab_order["user_id"] == $tab_accounts["user_id"])
					unset($orders[$key_order]);
			}
			set_orders($orders);
			unset($accounts[$key_accounts]);
		}
	}
	set_accounts($accounts);
	return (1);
}
function redirection($page)
{
	echo '<meta http-equiv="refresh" content="2; URL='.$page.'">';
	echo '<meta name="keywords" content="automatic redirection">';
}

?>