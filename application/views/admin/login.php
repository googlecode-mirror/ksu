<link href="<?php echo base_url(); ?>application/views/admin/css/reset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>application/views/admin/css/login.css" rel="stylesheet" type="text/css" />
<div id="login_box">
	
	<h1>Login</h1>
	
	<?php
		$attributes = array('name' => 'login_form', 'id' => 'login_form');
		echo form_open('admin/process_login', $attributes);
	?>
		
		
		<p>
			<label for="username">Username:</label>
			<input type="text" name="username" size="20" class="form_field" value="<?php echo set_value('username');?>"/>			
		</p>
		
		<p>
			<label for="password">Password:</label>
			<input type="password" name="password" size="20" class="form_field" value="<?php echo set_value('password');?>"/>			
		</p>
		
		<p>
			<input type="submit" name="submit" id="submit" value="Login" />
		</p>
	</form>
		<?php 
			$message = $this->session->flashdata('message');
			echo $message == '' ? '' : '<p id="message">' . $message . '</p>';
		?>
		<?php echo form_error('username','<p class="field_error">', '</p>');?>
		<?php echo form_error('password','<p class="field_error">', '</p>');?>
</div>
