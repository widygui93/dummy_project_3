		<footer class="footer">
			<div class="footer-main">
				<div class="footer-links">
					<ul>
						<li><a href="#">Home</a></li>
						<li><a href="#">About</a></li>
						<li><a href="#">FAQ</a></li>
						<li><a href="#">Privacy Policy</a></li>
						<li><a href="#">Term & Conditions</a></li>
					</ul>
				</div>
				<div class="footer-contact">
					<h3>Contact Us</h3>
					<form action="" method="post">
						<input 
							type="text" 
							name="name" 
							id="name-contact" 
							minlength="6" 
							maxlength="12" 
							pattern="^[a-zA-Z0-9]*$" 
							class="form-control" 
							placeholder="Name" 
							autocomplete="off" 
							required
						>
						<input 
							type="email" 
							name="email" 
							id="email-contact" 
							class="form-control" 
							placeholder="Email" 
							autocomplete="off" 
							required
						>
						<input 
							type="text" 
							name="subject" 
							id="subject" 
							minlength="6" 
							maxlength="12" 
							pattern="^[a-zA-Z0-9]*$" 
							class="form-control" 
							placeholder="Subject" 
							autocomplete="off" 
							required
						>
						<textarea id="messages" name="messages" placeholder="Messages..." required></textarea>
						<button type="submit" name="submit">Submit</button>
					</form>
				</div>
			</div>
			<div class="footer-brand">
			    <strong>Tinker Studio</strong>
			    <p><small>Enhancing Your Business</small></p>
			</div>
		</footer>
	</div>
<script src="<?= BASEURL; ?>/js/jquery-3.4.1.min.js"></script>
<script src="<?= BASEURL; ?>/js/script-header.js"></script>
<script src="<?= $data['script'] ?? '' ?>" ></script>
<script src="<?= $data['script-modal-detail-tutorial'] ?? '' ?>" ></script>
</body>
</html>