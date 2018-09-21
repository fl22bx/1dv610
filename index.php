<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('model/db.php');
require_once('model/UserDbAuthenticator.php');
require_once('controller/ViewController.php');
require_once('model/FeedbackCreator.php');
// start DataBase

	// production
	// $dbServername = "138.68.91.93";
	//$dbUsername = "root";
	//$dbPassword = "rJ4YA3Km";
	// local
	 $dbServername = "localhost";
	$dbUsername = "fredrik";
	$dbPassword = "test";
	$dbName = "user";
	$dataBase = new DatabaseMySQL($dbServername,$dbUsername, $dbPassword, $dbName);

	$dataBase->connect();

// create authenticator
	$UserDbAuthenticator = new UserDbAuthenticator($dataBase->getdbName() , $dataBase->getConnection() );

// feedbackCreator
	$feedback = new FeedbackCreator();

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
	$v = new LoginView();
	$dtv = new DateTimeView();
	$lv = new LayoutView();

// Create Controller
	$Controller = new ViewController($v ,$dtv,$lv ,$UserDbAuthenticator, $feedback );
	$Controller->logInController();

