<div class="slide-container2">  
    <footer class='footer-bg'>
        <div class="no-padding">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-black">
                    <h4 class="footer-heading hr text-dark">Quick Link</h4>
                    <div class="clear_b"></div>
                    <br>
                    <ul class="footer-quick-link">
                      <!--  Comment on 27-04-2022 and given hard coded links Shweta Apale
					  <?php if(!empty($top_menus)){ foreach ($top_menus as $tmenu) { ?>
                        <li class="nav-item active">
                        <?php if(empty($tmenu['external_link'])) {  ?>
                            <?php echo $this->Html->link($tmenu['title'], array('controller' => 'pages', 'action'=>'display',$tmenu['slug'])); ?>
                        <?php } else { 
                            $url =  $tmenu['external_link'];
                            $search1 = 'http://' ;
                            $trimmed1 = str_replace($search1, '', $url);
                            $search2 = 'https://' ;
                            $trimmed = str_replace($search2, '', $trimmed1) ;
                            $url ='http://'.$trimmed;

                            echo $this->Html->link($tmenu['title'], $url);
                         } ?>

                        </li>
                    <?php } } ?> -->
					
					 <li class="nav-item active"><a href = "https://ibmreturns.gov.in/">Home</a></li>
					 <li class="nav-item active"><a href = "https://ibmreturns.gov.in/pages/faq">FAQ</a></li>
					 <li class="nav-item active"><a href = "https://ibm.gov.in" class="external_site_url">IBM Website</a></li>
					 <li class="nav-item active"><a href = "https://oldreturns.ibm.gov.in/" class="external_site_url">Old Returns Portal</a></li>
					 <li class="nav-item active"><a href = "https://mines.gov.in" class="external_site_url">Ministry of Mines</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="footer-heading hr text-dark"> Address</h4>
                    <div class="clear_b"></div>
                    <br>
                    <ul>
                        <span class="text-dark">
                            <?= $Fcontact; ?>
                        </span>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <img src="<?php echo $this->request->getAttribute('webroot'); ?>img/home/home-banner2.jpg" width="100%" height="200px">
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </footer>
</div>
<div class="slide-container3">
    <div class='col-md-12'>
        <div class='col-md-6 col-md-offset-1 copyright'>
            <!-- <span class="white">Government of India. © 2019 All rights reserved, Indian Bureau of Mines </span> -->
        </div>
        <div class='col-md-4 p_r_62'>
            <p class="visitor_design">           
                Total Visitors:&nbsp; 
                <?php $count = str_split($fetch_count[0]['visitor']); if(!empty($fetch_count)){ ?>
                <?php foreach($count as $each){  echo '<span class="visitor">'.$each.'</span>'; } } else{ echo '<span class="visitor">00000</span>'; } ?>
                                      
            </p>    
        </div>  
    </div>              
</div>
<div class="">
    <div class='col-md-12 text-center'>
       <p class='text-center'>    Contents Provided by Indian Bureau of Mines (IBM),   Ministry of Mines, Government of India. <br>
        <img src="<?php echo $this->request->getAttribute('webroot'); ?>img/admin/NIC_logo.jpg" alt="NIC" width="120" height="26" longdesc="http://nic.in">    <br>
        Designed, Developed and Maintained by National Informatics Centre.    </p>

    </div>    
</div>