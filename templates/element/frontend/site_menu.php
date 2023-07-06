<div class="container-fluid header-menu-container">
    <div class="header-menu-new col-lg-12  bg-light ">
        <nav class="navbar navbar-expand-lg navbar-light float-right header-menu-wrap">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <?php if(!empty($top_menus)){ foreach ($top_menus as $tmenu) { ?>
                        <li class="nav-item active">
                        <?php if($tmenu['link_type']=='page') {  ?>
                            <?php echo $this->Html->link(strtoupper(strtolower($tmenu['title'])), array('controller' => 'pages', 'action'=>'display',$tmenu['slug']), array('class'=>'nav-link')); ?>
                        <?php } else { 
                            $url =  $tmenu['external_link'];
                            $search1 = 'http://' ;
                            $trimmed1 = str_replace($search1, '', $url);
                            $search2 = 'https://' ;
                            $trimmed = str_replace($search2, '', $trimmed1) ;
                            $url ='https://'.$trimmed;

                            echo $this->Html->link(strtoupper(strtolower($tmenu['title'])), $url,array('class'=>'nav-link'));
                         } ?>

                        </li>
                    <?php } } ?>
                </ul>
            </div>
        </nav>
    </div>
</div>

<marquee attribute_name = "attribute_value" class="alert alert-info h4">
    <i class="fa fa-info-circle"></i> For returns upto March 2022, Please go to <a href="https://oldreturns.ibm.gov.in">https://oldreturns.ibm.gov.in</a>
</marquee>