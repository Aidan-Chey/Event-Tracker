<?php
$pageTitle = 'Export';

//addons to assist with injection
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/helpers.inc.php';

//functions for access and logging in
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';

if (!userHasRole('Admin')){
	header('Location: /?Permission');
}

//Top section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/head.html.php';

include 'export.html.php';

//Bottom section of master page
include $_SERVER['DOCUMENT_ROOT'].'/includes/foot.html.php';