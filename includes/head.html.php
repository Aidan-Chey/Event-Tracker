<!DOCTYPE html>
<html>
<head lang="en">
	<title><?php echo $pageTitle; ?> | Event Tracker</title>
	<meta charset="utf-8">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="Author" content="Aidan Dunn">
	<meta name="Description" content="Event Tracker Mockup">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php //Adds an auto refresh command to page if refresh variable set
	if (!empty($refresh)) {
		if (is_numeric($refresh)) {
			echo "<meta http-equiv='refresh' content='$refresh' >";
		}else{
			$error = 'Refresh variable set but not numeric, page will not auto-refresh. ';
			include $_SERVER['DOCUMENT_ROOT'].'/includes/error.html.php';
		}
	} ?>
	<link rel="stylesheet" type="text/css" href="/css/base.css">
	<link rel="shortcut icon" href="/images/Favicon.png" />
	<noscript>
		<style>.reqJava{ display:none; }</style>
	</noscript>
	<?php if(!empty($links)){ foreach($links as $link){
		echo '<link rel="stylesheet" type="text/css" href="/css/'.$link.'.css" />';
	}} ?>
	<?php if(!empty($javas)){foreach($javas as $java){
		echo '<script src="/js/'.$java.'.js" async></script>';
	}} ?>
</head>
<body>
<div id="header">
	<div id="head">
		<!-- <a id="logo" href="profile.aidancheyd.info" style="background-image:url('images/Favicon.png');"></a> -->
		<a href="/">
			<h1>Event Tracker</h1>
		</a>
	</div>
	<span class="clearfix"></span>
</div>
<?php if (!empty($_SESSION['loggedIn'])){
	echo '<script type="text/javascript">var logged_in=true;</script>';
}else{
	echo '<script type="text/javascript">var logged_in=false;</script>';
}?>