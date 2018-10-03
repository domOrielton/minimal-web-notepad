<link rel="stylesheet" type="text/css" href="modules/css/modal.min.css">
<div class="modal_password" id="password_modal" style="hidden">
	<div class="modal-content">
		<span class="close-button_password">&times;</span>
		<br>Password for this note<br>
		<span id="inputboxLocation"></span><button class="submit" id="submitpwd" onclick="submitPassword();">Set</button><br>
		<input type="checkbox" id="allowReadOnlyView" name="allowReadOnlyView" value="1" title="Allow readonly viewing without password"> View without password<br>
		<span id="removePassword" style="display:none">
				<br><a onclick='passwordRemove();'>Remove password</a>
				<input type="hidden" id="hdnRemovePassword" name="hdnRemovePassword" value=""><br>
		</span>
		<span id="pwdMessage" style="color: red;"><br></span>
		<br><a onclick='window.open("passwordHelp.html");'>Details on password protection</a>
	</div>
</div>
