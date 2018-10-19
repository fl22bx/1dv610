<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');
require_once('view/ExceptionHandlerView.php');
require_once('view/navigatorView.php');
require_once('view/CalendarView.php');
require_once('model/MySqlDataBase.php');
require_once('model/User.php');
require_once('controller/LogInHandler.php');
require_once('controller/Navigator.php');
require_once('controller/calenderHandler.php');
require_once('model/LogInPercistency.php');

require_once('model/Calendar/Calendar.php');
require_once('model/Calendar/CalendarSettings.php');
//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');


// start session
session_start();

// Create DataBase
// put in seperate file and gitignore
	$dbServername = "localhost";
	$dbUsername = "fredrik";
	$dbPassword = "test";
	$dbName = "user";
	$SqlDatabase = new DatabaseMySQL($dbServername,$dbUsername, $dbPassword, $dbName);

	$SqlLogInDatabase = new LogInPercistency($SqlDatabase);

//CREATE OBJECTS OF THE VIEWS
$v = new LoginView();
$navigatorView = new NavigatorView();
$dtv = new DateTimeView();
$lv = new LayoutView($dtv,$navigatorView);
$ehv = new ExceptionHandlerView();
$rv = new RegisterView();
$calendarView = new CalendarView();


//create Claendar
$cal =  new Model\Calendar\Calendar();
$calSett = new Model\Calendar\CalendarSettings();


//CREATE CONTROLLER
$c = new LogInHandler($v, $lv, $SqlLogInDatabase, $ehv, $rv);
$calenderHandler = new Controller\Calender\CalenderHandler($calendarView);
$navigator = new Controller\Navigator($lv,$calenderHandler , $c);

$c->startLogInHandler();


// $lv->render(false, $v, $dtv);

