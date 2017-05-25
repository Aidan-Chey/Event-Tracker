<section id="footer">
	<div>
		<a class="button" href="#header">Back to Top</a>
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
		if(userHasRole('admin')): ?>
		<a class="button" href="/Admin/">Administration Area</a>
		<?php endif; ?>
	</div>
</section>
<?php if(userLoggedIn()){
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/session.inc.html';
} ?>
</body>
</html>

<?php unset($_SESSION['messages']); ?>