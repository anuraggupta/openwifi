<div class="main bg_pic">
	<div style="margin: 5% 0 0 0;">
		<a href="http://iands.com/" target="_blank"><img src="<?php echo base_url();?>assets/img/logo_for_mailer.png"></a>
	</div>
	
	<?php
		$form_att = array('class' => 'form-signin', 'id' => 'form-change'); 
		$input_att = array('class' => 'input-block-level','id' => 'username', 'placeholder' => 'Username', 'name' => 'username');
		$password_att = array('class' => 'input-block-level','id' => 'password', 'placeholder' => 'Password', 'maxlength' => '15', 'name' => 'password');
		$submit_att = array('class' => 'btn btn-large btn-info', 'id' => 'thebtn', 'value' => 'Login');
	
		echo form_open('login/validateCredentials', $form_att);
	?>
		<h2 class="form-signin-heading">SmartWiFi Login</h2>
	<?php
		echo form_input($input_att);
		echo form_password($password_att);
		echo form_submit($submit_att);
		echo form_close();
	?>