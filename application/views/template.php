<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

    <?php $this->load->view('includes/header'); ?>

<div id="wrapper">

    <div id="navigation">
        <?php $this->load->view('includes/navigation');?>
    </div>
    <div id="modnav">
        <?php if(isset($modnav)&&$modnav!=NULL)
        		$this->load->view($modnav);?>
    </div>
    <div id="content">
        <?php $this->load->view($content); ?>
    </div>

</div>

    <?php $this->load->view('includes/footer');?>
    
</html>