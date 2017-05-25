<?php
$pageTitle = 'Calendar';

//addons to assist with injection
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/helpers.inc.php';

//functions for access and logging in
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/access.inc.php';

if(!empty($_POST['inter']) && !empty($_POST['time'])){
	header("Location: /Calendar/".htmlspecialchars($_POST['inter'])."/".htmlspecialchars($_POST['time'])."/?info=".htmlspecialchars($_POST['info']));
}

include $_SERVER['DOCUMENT_ROOT'].'/includes/head.html.php';

include 'select.html.php'; ?>

<?php if(userLoggedIn()){
	include $_SERVER['DOCUMENT_ROOT'].'/includes/session.inc.html';
} ?>
</body>
</html>