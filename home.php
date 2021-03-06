<?php

include "includes/includes.php";

$thisPage = new htmlPage($config);

/*************************************/

if (empty($_GET["oktaCookieSessionID"])) { $header = getHeader("unAuth"); }
else {

	$apiKey = $config["apiKey"];

	// in a production system I would check the oktaCookieSessionID here
	// again to make sure that someone has not messed with the GET request

	$oktaUserID = $_GET["oktaUserID"];

	$url = $config["apiHome"] . "/users/" . $oktaUserID;

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $url,
		CURLOPT_HTTPHEADER => array("Authorization: SSWS $apiKey ", "Accept: application/json", "Content-Type: application/json"),
	));

	$result = curl_exec($curl);

	$user = json_decode($result, TRUE);

	$firstName = $user["profile"]["firstName"];

	$header = getHeader("auth", $_GET["oktaCookieSessionID"], $firstName);

}

/*** Manually add elements here ******/

$thisPage->setTitle($config["name"] . " Home");

// jquery
$thisPage->addElement("jquery");

$thisPage->addElement("mainCSS");

$thisPage->addElement("dates");

$body = file_get_contents("home.html");

$body = str_replace("%HEADER%", $header, $body);

$body = str_replace("%NAME%", $config["name"], $body);

$body = str_replace("%LOGO%", $config["logo"], $body);

$thisPage->addToBody($body);

$thisPage->display();