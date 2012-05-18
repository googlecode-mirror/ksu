<link href="<?php echo base_url(); ?>application/views/admin/css/reset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>application/views/admin/css/login.css" rel="stylesheet" type="text/css" />
<div id="login_box">
	<script language="javascript">
	  $(document).ready(function(e) {
        $('input[name="password"]').focus().select();
    });
	</script>
	<h1><img src="<?=base_url()."asset/images/icon/Yin-Yang.png";?>" />&nbsp;Create first user as super user</h1>
	<?php
		$attributes = array('name' => 'login_form', 'id' => 'login_form');
		echo form_open('admin/process_userfirst', $attributes);
	?>
		
		
		<p>
			<label for="username">Username:</label>
			<input type="text" name="username" size="20" class="form_field" value="Administrator" readonly/>			
		</p>
		
		<p>
			<label for="password">Password:</label>
			<input type="password" name="password" size="20" class="form_field" value=""/>			
		</p>
		
		<p>
			<input type="submit" name="submit" id="submit" style="width:auto" value="Create User Admin" />
		</p>
	</form>
		<?php 
			$message = $this->session->flashdata('message');
			echo $message == '' ? '' : '<p id="message">' . $message . '</p>';
		?>
		<?php echo form_error('username','<p class="field_error">', '</p>');?>
		<?php echo form_error('password','<p class="field_error">', '</p>');?>
</div>
