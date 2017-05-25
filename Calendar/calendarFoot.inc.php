<section id="calFooter">
	<div>
		<a class="button" href="/Calendar">New Calendar</a>
		<a class='button' onclick="toggleFullScreen();">Fullscreen</a>
		<!-- <a class="button" href="?<?php if(!isset($_GET['altAxis'])){ echo 'altAxis'; }?>">Switch Axis</a>
		<br> -->
		<?php if(userLoggedIn()): ?>
		<a id="home" class="button" href="/">Home</a>
		<?php endif; ?>
	</div>
	<div>
		<?php if(userLoggedIn()): ?>
		<a class="button" href="?logout">Logout</a>
		<?php else: ?>
		<a class="button" href="/Authentication/Login/">Login</a>
		<?php endif;
		if(userHasRole('Admin')): ?>
		<a class="button" href="/Admin/">Administration Area</a>
		<?php endif; ?>
	</div>
</section>
<?php if(userLoggedIn()){
	include $_SERVER['DOCUMENT_ROOT'].'/includes/session.inc.html';
} ?>
</body>
</html>
