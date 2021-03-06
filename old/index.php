<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('model/db.php');

require_once('view/SuperView.php');

require_once('controller/ViewController.php');
require_once('view/RegisterView.php');
require_once('model/FeedbackMessageCreator.php');

// start DataBase
	$dbServername = "localhost";
	$dbUsername = "fredrik";
	$dbPassword = "test";
	$dbName = "user";
	$dataBase = new DatabaseMySQL($dbServername,$dbUsername, $dbPassword, $dbName);

	// $dataBase->connect();

// feedbackCreator
	// $feedback = new FeedbackCreator();
	$feedback = new FeedbackMessageCreator();

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');

// Create Controller
	$Controller = new ViewController($dataBase, $feedback );
	$Controller->logInController();

