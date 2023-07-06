<?php ?>
<!-- on 23-10-2017, Below noscript tag added to check if browser Scripting is working or not, if not provided steps --> 
<noscript>      
        <?php echo $this->Html->css('noscript'); ?>
        <?php echo $this->element('javascript_disable_msg_box'); ?>
</noscript>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <?php 

        echo $this->Html->meta('keywords',$meta_keyword);
        echo $this->Html->meta('description',$meta_description);  
        echo $this->Html->meta('icon');
        echo $this->Html->charset();
        echo $this->Html->css('home_page.css?version='.$version);
        echo $this->Html->css('login.css?version='.$version);           
        echo $this->Html->css('forms-style.css?version='.$version);
        echo $this->Html->css('bootstrap.min.css?version='.$version);
        echo $this->Html->css('font-awesome.min.css?version='.$version);
        echo $this->Html->css('stack.bootstrap.min.css?version='.$version);
        
        echo $this->Html->script('jquery.min.js?version='.$version); //newly added on 24-08-2020 updated js 
        echo $this->Html->script('bootstrap.min.js?version='.$version);     
        echo $this->Html->script('no_back.js?version='.$version);
        echo $this->Html->script('jquery.ajax.min.js?version='.$version);
        echo $this->Html->script('jquery.base64.js?version='.$version);
        echo $this->Html->script('bootstrap.bundle.min.js?version='.$version);
        echo $this->Html->script('login.js?version='.$version);
        echo $this->Html->script('sha512.min.js?version='.$version);
        echo $this->Html->script('sha512.js?version='.$version);
        echo $this->Html->script('easypiechart.js?version='.$version);
        echo $this->Html->script('easypiechart-data.js?version='.$version);

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>

    <title>IBM Returns Managment Portal</title>
</head>
<body>

<?php echo $this->element('frontend/site_header'); ?>
<?php echo $this->element('frontend/site_menu'); ?>

<div class="col-md-10 col-md-offset-1 mt-4 min-height-300">
    <!-- showing error if page data not available -->
    <?php if(isset($errormsgafterpost)&&!empty($errormsgafterpost)){
        echo "<div><h1 class='text-center'>".$errormsgafterpost."</h1></div>";
    }?>
    <div class="gov_image" style="background: #2c75c2;margin: 0px 0px;color: #ffff;">
        <h1 class="page-heading-h1 hr"><?php echo $pagetitle; ?></h1>
    </div>
  <div>
    <?php echo $pagedata; ?>
  </div>
</div>


<?php echo $this->element('frontend/site_footer'); ?>
<?php

    echo $this->Html->script('home_page.js?version='.$version);

    if (isset($alert_message) && $alert_message != null) {
        echo $this->element('msg_box');
    }

?>

</body>
</html>
