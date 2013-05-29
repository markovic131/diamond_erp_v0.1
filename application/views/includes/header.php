<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo $title; ?></title>
    <script src="<?php echo base_url();?>js/jquery-1.4.4.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/jquery-ui-1.8.10.custom.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/jclock.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/myclock.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/buttons.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/dialogs.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/jeditable.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/jgrowl.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/m2/jquery-ui-1.8.10.custom.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/main.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/ui.jqgrid.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/jgrowl.css" type="text/css" media="screen" />
    <script src="<?php echo base_url();?>js/grid.locale-en.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>js/jquery.jqGrid.min.js" type="text/javascript"></script>
    <?php if ($this->session->flashdata('flash') != ''): ?>
	   <script type="text/javascript">
        	
        	$(document).ready(function() {	
        		$.jGrowl("<?php echo $this->session->flashdata('flash') ?>");	
        	});
        				
	   </script>
    <?php endif; ?>
    
</head>
<body>
    <div id="header">
        <div class="erp"><img src="<?php echo base_url();?>assets/erp_logo.png"/></div>
	        <div class="user_info">
	        	Welcome, <?php echo anchor('auth/profile',$this->session->userdata('name')); ?><br>
	        	<div id="clock"></div>
	        	<?php echo anchor('products',' Master Data'); ?> |
	        	<?php echo anchor('auth/logout','Logout '); ?>
	        </div>
    </div>