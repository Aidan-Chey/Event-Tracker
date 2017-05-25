<main>
	<section>
		<?php if(!empty($_SESSION['messages'])): ?>
		<div class="error"><?php echo $_SESSION['messages']; ?></div>
		<?php endif; ?>
		<h3>Submissions and Searches</h3>
		<div class="category">
			<div class="option">
				<div>
					<a <?php if(userHasRole('')){	echo 'class="button" style="color:red;" href="/?Permission" title="Need to be Verified"';}else{echo 'class="button" href="/Submissions/New/"';}?>>New Event</a>
				</div>
				<div>Log a new event</div>
			</div>
			<div class="option">
				<div>
					<a <?php if(userHasRole('')){echo 'class="button" style="color:red;" href="/?Permission" title="Need to be Verified"';} else{echo 'class="button" href="/Drafts/"';}?>>Drafts</a>
				</div>
				<div>Saved Drafts</div>
			</div>
			<div class="option">
				<div><a class="button" href="/Search">Search</a></div>
				<div>Find, view, change or cancel an event</div>
			</div>
		</div>
	</section>
	<section>
		<h3>Approvals</h3>
		<div class="category">
			<div class="option">
				<div><a class='button' href='/Confirm/'>Operator Confirmation</a></div>
				<?php if(!empty($counts['apply'])) echo "<div><span class='counter'>".$counts['apply']."</span></div>" ?>
				<div>
					Operator's confirm form to allow an event into the system
				</div>
			</div>
			<div class="option">
				<div><a class='button' href='/Approve/' >Manager Approval</a></div>
				<?php if(!empty($counts['confirm'])) echo "<div><span class='counter'>".$counts['confirm']."</span></div>" ?>
				<div>
					Manager's approval form to allow an event to occur
				</div>
			</div>
		</div>
	</section>
	<section>
		<h3>Reports</h3>
		<div class="category">
			<div class="option">
				<div><a class="button" href="/Reports/?Pending">Pending Events</a></div>
				<div>Events waiting for approval</div>
			</div>
			<div class="option">
				<div><a class="button" href="/Reports/?Approved">Approved Events</a></div>
				<div>Approved Events coming up in the next six weeks</div>
			</div>
			<div class="option">
				<div><a class="button" href="/Reports/?Changes">Events Changes</a></div>
				<div>Events that have had changes within the last six weeks</div>
			</div>
			<div class="option">
				<div><a class="button" href="/Reports/?Declined">Declined Events</a></div>
				<div>Events that have been declined</div>
			</div>
			<div class="option">
				<div><a class="button" href="/Reports/?Summary">Summary</a></div>
				<div>Summary of the events that occur between two dates</div>
			</div>
			<div class="option">
				<div><a class="button" href="/Reports/?Length">Approval Length</a></div>
				<div>Amount of time it took for an event to progress through each approval stage</div>
			</div>
		</div>
	</section>
	<section>
		<h3>Miscellaneous</h3>
		<div class="category">
			<div class="option">
				<div><a class="button" href="/Calendar">Calendar</a></div>
				<div>Graphical display of upcoming Events</div>
			</div>
			<div class="option">
				<div><a class="button" href="/Audit">Audit</a></div>
				<div>Audit of actions taken by users</div>
			</div>
			<div class="option">
				<div><a class="button" href="/ChangeLog">Change Log</a></div>
				<div>Chronolologically ordered list of changes to the website</div>
			</div>
		</div>
	</section>
</main>