<?php
echo $this->Html->css('sales.css?version='.$version);
// echo $this->Html->css('bootstrap.min.css?version='.$version);
echo $this->Html->css('main.css?version=' . $version);
echo $this->Html->css('reportnext');

echo $this->Html->script('jquery.min.js?version='.$version);
echo $this->Html->script('reportnext');
?>

<!-- <?php echo $this->Html->link('Back', array('controller'=>'reportsnext','action'=>'monthly-filter?title=reportm07'), array('class'=>'btn btn-primary backBtn mb-2')); ?> -->
<!-- <a href="#" class="downloadExcel btn btn-success float-right mb-2">Export to Excel</a> -->
<input type="hidden" value="<?php echo 'M-07'; ?>">



<?php echo $this->fetch('content'); ?>
