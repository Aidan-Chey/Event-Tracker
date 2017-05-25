<label for="options" class="button">Options</label>
<input type="checkbox" name="options" class="hide" id="options" checked>
<div class="options">
	<a class="button" href="/Calendar">New Calendar</a>
	<br>
	<!-- <a class="button" href="?<?php if(!isset($_GET['altAxis'])){ echo 'altAxis'; }?>">Switch Axis</a>
	<br> -->
	<a class='button' onclick="toggleFullScreen();">Fullscreen</a>
	<br>
	<a id="home" class="button" href="/">Home</a>
	<br>
	<?php if(userLoggedIn()): ?>
	<a class="button" href="?logout">Logout</a>
	<?php else: ?>
	<a class="button" href="/Authentication/Login/">Login</a>
	<?php endif; ?>
</div>