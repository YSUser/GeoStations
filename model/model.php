<?php
//stores DB_USER && DB_PASSWORD
require_once('../../GeoStations_secure/config.php');
define ("DB_HOST","localhost");
define ("DB_NAME","geostations_san_francisco");

//connect to DB
function db_connect()
{
	$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME;
	
	try
	{
		$dbh = new PDO($dsn,DB_USER,DB_PASSWORD);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); //Development Environment only
	}
	catch (PDOexcpetion $e)
	{
		echo'PDO component failed:<br>'.$e->getMessage();
	}
	catch (Exception $e)
	{
		echo'Unknown component failed:<br>'.$e->getMessage();
	}
	return $dbh;
}

//fetch routes from DB
function get_routes()
{
	$dbh=db_connect();
	
	$sth=$dbh->query("SELECT * FROM routes");
	$routes=array();
	while ($row = $sth->fetch(PDO::FETCH_ASSOC))
		{
			array_push($routes,$row);
		}
			$dbh= NULL;
			return $routes;
}
?>