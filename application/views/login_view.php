<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title><?php echo $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="<?php echo base_url();?>js/jquery-1.4.4.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/jquery-ui-1.8.10.custom.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/jclock.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/buttons.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/dialogs.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/m2/jquery-ui-1.8.10.custom.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/main.css" type="text/css" media="screen" />

</head>
<body id="login_body">
    <div id="loginpage">
        <div id="erp_login_logo"><img src="<?php echo base_url(); ?>assets/erp_logo_big.png"/></div>
    <p><i>Please enter your credentials to access the application</i></p>
        <?php echo form_open('auth/login'); ?>
        <table>
        	<tr>
        		<td class="label"><?php echo form_label('Username:')?></td>
        		<td align="left"><?php echo form_input('username');?></td>
        	</tr>
        	<tr>
        		<td class="label"><?php echo form_label('Password:')?></td>
        		<td align="left"><?php echo form_password('password');?></td>
        	</tr>
        	<tr>
        		<td>&nbsp;</td>
        		<td align="right"><?php echo form_submit('submit','Login');?></td>
        	</tr>
        </table>
        <?php echo validation_errors(); ?>
        <?php echo form_close(); ?>
    </div>
    
<div id="login_footer">Copyright © 2011 Marko Aleksic. All Rights Reserved.</div>
</body>
</html>


