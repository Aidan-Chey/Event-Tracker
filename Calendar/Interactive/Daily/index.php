<?php
$pageTitle = 'Calendar';
$links = array('calendarDaily');
$javas = array('session_timeout','calendar');

//addons to assist with injection
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/helpers.inc.php';

//functions for access and logging in
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';

include_once $_SERVER['DOCUMENT_ROOT'].'/Calendar/calendar.php';

//Top section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/head.html.php';

include $_SERVER['DOCUMENT_ROOT'].'/Calendar/days/calendarLayout.html.php';

include $_SERVER['DOCUMENT_ROOT'].'/Calendar/calendarFoot.inc.php';