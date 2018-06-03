<?

function accounts_init()
{
	$accounts = array(array("user_id" => 0, "login" => "root", "pwd" => hash('whirlpool', "root"), "rights" => "admin"),
					array("user_id" => 1, "login" => "user1", "pwd" => hash('whirlpool', "456123"), "rights" => "user"),
					array("user_id" => 2, "login" => "user2", "pwd" => hash('whirlpool', "abcdef"), "rights" => "user"),
					array("user_id" => 3, "login" => "user3", "pwd" => hash('whirlpool', "defabc"), "rights" => "user"));
	$accounts_serialize = serialize($accounts);
	file_put_contents("./database/accounts", $accounts_serialize);
}

function get_accounts()
{
	$file = file_get_contents("./database/accounts");
	$accounts = unserialize($file);
	return ($accounts);
}

function set_accounts($mod_accounts)
{
	$accounts_serialize = serialize($mod_accounts);
	file_put_contents("./database/accounts", $accounts_serialize);
}

function products_init()
{
	$products = array(array("product_id" => 0, "artist" => "Beyonce", "album" => "Lemonade", "image" => "cover/beyonce_lemonade.png", "price" => 20, "category_id" => "0;3", "hot" => true),
		array("product_id" => 1, "artist" => "Beyonce", "album" => "I am Sasha Fierce", "image" => "cover/beyonce_sasha.jpg", "price" => 25, "category_id" => "0;3", "hot" => true),
		array("product_id" => 2, "artist" => "Booba", "album" => "Trone", "image" => "cover/booba_trone.jpg", "price" => 10, "category_id" => "0;1", "hot" => true),
		array("product_id" => 3, "artist" => "Britney Spears", "album" => "In The Zone", "image" => "cover/britney_spears_inthezone.png", "price" => 20, "category_id" => "0;3", "hot" => false),
		array("product_id" => 4, "artist" => "Bruce Springsteen", "album" => "Born In The Usa", "image" => "cover/bruce_springsteen_born.jpg", "price" => 25, "category_id" => "0;7", "hot" => false),
		array("product_id" => 5, "artist" => "Celine Dion", "album" => "The Show Must Go On", "image" => "cover/celine_dion_show.jpg", "price" => 20, "category_id" => "0;3;5", "hot" => false),
		array("product_id" => 6, "artist" => "Drake", "album" => "Best Of", "image" => "cover/drake_album.jpg", "price" => 20, "category_id" => "0;1;3", "hot" => false),
		array("product_id" => 7, "artist" => "Earth Wind and Fire", "album" => "Jupiter", "image" => "cover/earth_wind_fire_jupiter.jpg", "price" => 20, "category_id" => "0;6", "hot" => false),
		array("product_id" => 8, "artist" => "Eminem", "album" => "Best Of", "image" => "cover/eminem_compil.jpg", "price" => 40, "category_id" => "0;1", "hot" => false),
		array("product_id" => 9, "artist" => "IAM", "album" => "Le Mia", "image" => "cover/iam_mia.jpg", "price" => 20, "category_id" => "0;1;6", "hot" => true),
		array("product_id" => 10, "artist" => "Jamiroquai", "album" => "Traveling", "image" => "cover/jamiroquai_traveling.jpg", "price" => 20, "category_id" => "0;6", "hot" => false),
		array("product_id" => 11, "artist" => "Jenifer Lopez", "album" => "Aint It Funny", "image" => "cover/jenifer_lopez_aintitfunny.jpg", "price" => 20, "category_id" => "0;3", "hot" => true),
		array("product_id" => 12, "artist" => "Johnny Hallyday", "album" => "Best Of", "image" => "cover/johnny_hallyday_bestof.jpg", "price" => 80, "category_id" => "0;4;5", "hot" => false),
		array("product_id" => 13, "artist" => "JUL", "album" => "My World", "image" => "cover/jul_myworld.jpg", "price" => 120, "category_id" => "0;1", "hot" => false),
		array("product_id" => 14, "artist" => "Juliette Armanet", "album" => "Petite Amie", "image" => "cover/juliette_armanet_petiteamie.jpg", "price" => 100, "category_id" => "0;5", "hot" => false),
		array("product_id" => 15, "artist" => "Justin Bieber", "album" => "Purpose", "image" => "cover/justin_bieber_purpose.jpg", "price" => 4, "category_id" => "0;3", "hot" => true),
		array("product_id" => 16, "artist" => "Justin Timberlake", "album" => "Futuresex / Lovesounds", "image" => "cover/justin_timberlake_future.jpg", "price" => 20, "category_id" => "0;3;8", "hot" => false),
		array("product_id" => 17, "artist" => "Kanye West", "album" => "College Dropout", "image" => "cover/kanye_west_dropout.jpg", "price" => 60, "category_id" => "0;1", "hot" => true),
		array("product_id" => 18, "artist" => "Lady Gaga", "album" => "Born This Way", "image" => "cover/lady_gaga_born.jpg", "price" => 30, "category_id" => "0;3", "hot" => true),
		array("product_id" => 19, "artist" => "Michael Jackson", "album" => "Bad", "image" => "cover/michael_jackson_bad.png", "price" => 20, "category_id" => "0;3;8", "hot" => false),
		array("product_id" => 20, "artist" => "Migos", "album" => "Cultre", "image" => "cover/migos_culture.png", "price" => 20, "category_id" => "0;1", "hot" => true),
		array("product_id" => 21, "artist" => "Nina Simone", "album" => "Silk and Soul", "image" => "cover/nina_simone_silksoul.jpg", "price" => 20, "category_id" => "0;2;8", "hot" => true),
		array("product_id" => 22, "artist" => "Patrick Sebastien", "album" => "Baracuda", "image" => "cover/patrick_sebastien_baracuda.jpg", "price" => 2000, "category_id" => "0;5", "hot" => false),
		array("product_id" => 23, "artist" => "Pharrell Williams", "album" => "G.I.R.L", "image" => "cover/pharrell_girl.jpg", "price" => 30, "category_id" => "0;3;8", "hot" => true),
		array("product_id" => 24, "artist" => "PNL", "album" => "Le Monde Chico", "image" => "cover/pnl_lmc.jpg", "price" => 50, "category_id" => "0;1", "hot" => true),
		array("product_id" => 25, "artist" => "Queen", "album" => "Queen II", "image" => "cover/queen_ii.jpg", "price" => 50, "category_id" => "0;4", "hot" => false),
		array("product_id" => 26, "artist" => "Rihanna", "album" => "ANTI", "image" => "cover/rihanna_anti.jpg", "price" => 70, "category_id" => "0;3", "hot" => true),
		array("product_id" => 27, "artist" => "Stevie Wonder", "album" => "Songs in the Key of Life", "image" => "cover/stevie_wonder_songs.jpg", "price" => 200, "category_id" => "0;8", "hot" => false),
		array("product_id" => 28, "artist" => "The Weeknd", "album" => "Starboy", "image" => "cover/the_weeknd_starboy.jpg", "price" => 90, "category_id" => "0;3", "hot" => true));
	$products_serialize = serialize($products);
	file_put_contents("./database/products", $products_serialize);
}

function get_products()
{
	$file = file_get_contents("./database/products");
	$products = unserialize($file);
	return ($products);
}

function set_products($mod_products)
{
	$products_serialize = serialize($mod_products);
	file_put_contents("./database/products", $products_serialize);
}

function orders_init()
{
	$orders = array();
	$orders_serialize = serialize($orders);
	file_put_contents("./database/orders", $orders_serialize);
}

function get_orders()
{
	$file = file_get_contents("./database/orders");
	$orders = unserialize($file);
	return ($orders);
}

function set_orders($mod_orders)
{
	$orders_serialize = serialize($mod_orders);
	file_put_contents("./database/orders", $orders_serialize);
}

function categories_init()
{
	$categories = array(array("category_id" => 0, "category_name" => "All Styles"),
					array("category_id" => 1, "category_name" => "Rap"),
					array("category_id" => 2, "category_name" => "Jazz"),
					array("category_id" => 3, "category_name" => "Pop"),
					array("category_id" => 4, "category_name" => "Rock"),
					array("category_id" => 5, "category_name" => "Variete"),
					array("category_id" => 6, "category_name" => "Funk"),
					array("category_id" => 7, "category_name" => "Folk"),
					array("category_id" => 8, "category_name" => "Soul"));
	$categories_serialize = serialize($categories);
	file_put_contents("./database/categories", $categories_serialize);
}

function get_categories()
{
	$file = file_get_contents("./database/categories");
	$categories = unserialize($file);
	return ($categories);
}

function set_categories($mod_categories)
{
	$categories_serialize = serialize($mod_categories);
	file_put_contents("./database/categories", $categories_serialize);
}

if (file_exists("./database") == false)
	mkdir("./database");

if (!file_exists("./database/products"))
	products_init();
if (!file_exists("./database/accounts"))
	accounts_init();
if (!file_exists("./database/orders"))
	orders_init();
if (!file_exists("./database/categories"))
	categories_init();
?>