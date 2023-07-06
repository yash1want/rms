<?php ?>

<div class="container-fluid banner-container">
	<div class="row">
		<div class="col-lg-4">
		</div>
		<div class="col-lg-8 banner-text-wrapper">
			<div class="banner-text-div">
				<div class="banner-text text-right">
					<span class="banner-text-one text-right">IBM</span>
					<span class="banner-text-two text-right">Returns Management System</span>
					<span class="banner-text-three text-right">Welcome to Online submission of Returns under Rule 45 of MCDR 2017</span>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 row login-div-wrap">
			
			<div class="col-lg-2 pr-0 pl-0">
				<a href="https://ibmreg.nic.in/Login.aspx" class="external_site_url">
					<div class="login-div login-div-four">
						<div class="login-div-icon login-div-icon-four">
						</div>
						<div class="login-div-text">
							<br>
							<strong>IBM Registration</strong>
						</div>
					</div>
				</a>
			</div>
			
			<div class="col-lg-2 pr-0 pl-0">
				<a href="users/authuser">
					<div class="login-div login-div-one">
						<div class="login-div-icon login-div-icon-one">
						</div>
						<div class="login-div-text">
							File Returns<br>
							<strong>Miners</strong>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-2 pr-0 pl-0" title="Trader/Exporter/Stockist/End User">
				<a href="users/enduser">
					<div class="login-div login-div-two">
						<div class="login-div-icon login-div-icon-two">
						</div>
						<div class="login-div-text">
							File Returns<br>
							<strong>Others</strong>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-2 pr-0 pl-0">
				<a href="users/mmsuser">
					<div class="login-div login-div-three">
						<div class="login-div-icon login-div-icon-three">
						</div>
						<div class="login-div-text">
							<br>
							Login by <strong>IBM</strong>
						</div>
					</div>
				</a>
			</div>
			<div class="col-lg-2 pr-0 pl-0" title="Primary User">
				<a href="users/primaryuser">
					<div class="login-div login-div-four">
						<div class="login-div-icon login-div-icon-four">
						</div>
						<div class="login-div-text">
							<br>
							<strong>Mine Owner</strong>
						</div>
					</div>
				</a>
			</div>
			
			
			
		</div>
	</div>
</div>

<div class="main-content-outer"> 
	
	<div class="slide-container">
		<div id="carouselIndicators1" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner" role="listbox">
			  <!-- Slide One - Set the background image for this slide in the line below -->
				<div class="carousel-item active">
					<div class='col-md-12 homepage_slide'>
						<div class='col-md-3 col-sm-2 col-xs-1 m-0 p-0'>
							<div class="service f1">	
								<h1 class='slide-h1 homepage_slide_text'>F</h1>
								<h4 class='slide-h4 homepage_slide_text'><?php echo $f_returns_received_total; ?></h4>
							</div>
						</div>
						<div class='col-md-8 col-sm-12 f2-box-8'>
							<div class='col-md-12 f2-box-12'>
								<div class='col-md-4 col-sm-1 col-xs-1 f2-box-8'>
									<div class="chrt-div">
										<div id="chrt-1" data-dimension="200" data-text="F1" data-fontsize="36" data-percent="<?php echo $f1_count_per; ?>" data-fgcolor="#08eafe" data-bgcolor="#eee" data-width="15" data-bordersize="15" data-animationstep="2"><span class="homepage_stat_c"><?php echo $f1_count; ?></span></div>
									</div>
								</div>	
								<div class='col-md-4 col-sm-1 col-xs-1 f2-box-8'>
									<div class="chrt-div">
										<div id="chrt-2" data-dimension="200" data-text="F2" data-fontsize="36" data-percent="<?php echo $f2_count_per; ?>" data-fgcolor="#ff4b66" data-bgcolor="#eee" data-width="15" data-bordersize="15" data-animationstep="2"><span class="homepage_stat_c"><?php echo $f2_count; ?></span></div>
									</div>
								</div>
								<div class='col-md-4 col-sm-1 col-xs-1 f2-box-8'>
									<div class="chrt-div">
										<div id="chrt-3" data-dimension="200" data-text="F3" data-fontsize="36" data-percent="<?php echo $f3_count_per; ?>" data-fgcolor="#27bd81" data-bgcolor="#eee" data-width="15" data-bordersize="15" data-animationstep="2"><span class="homepage_stat_c"><?php echo $f3_count; ?></span></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="carousel-item">
					<div class='col-md-12 homepage_slide'>
						<div class='col-md-3 col-sm-2 col-xs-1 m-0 p-0'>
							<div class="service f1">	
								<h1 class='slide-h1 homepage_slide_text'>G</h1>
								<h4 class='slide-h4 homepage_slide_text'><?php echo $h_returns_received_total; ?></h4>
							</div>
						</div>
						<div class='col-md-8 col-sm-12 f2-box-8'>
							<div class='col-md-12 f2-box-12'>
								<div class='col-md-4 col-sm-1 col-xs-1 f2-box-8'>
									<div class="chrt-div">
										<div id="chrt-4" data-dimension="200" data-text="G1" data-fontsize="36" data-percent="65" data-fgcolor="#08eafe" data-bgcolor="#eee" data-width="15" data-bordersize="15" data-animationstep="2"><span class="homepage_stat_c"><?php echo $h1_count; ?></span></div>
									</div>
								</div>	
								<div class='col-md-4 col-sm-1 col-xs-1 f2-box-8'>
									<div class="chrt-div">
										<div id="chrt-5" data-dimension="200" data-text="G2" data-fontsize="36" data-percent="65" data-fgcolor="#ff4b66" data-bgcolor="#eee" data-width="15" data-bordersize="15" data-animationstep="2"><span class="homepage_stat_c"><?php echo $h2_count; ?></span></div>
									</div>
								</div>
								<div class='col-md-4 col-sm-1 col-xs-1 f2-box-8'>
									<div class="chrt-div">
										<div id="chrt-6" data-dimension="200" data-text="G3" data-fontsize="36" data-percent="65" data-fgcolor="#27bd81" data-bgcolor="#eee" data-width="15" data-bordersize="15" data-animationstep="2"><span class="homepage_stat_c"><?php echo $h3_count; ?></span></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="carousel-item">
					<div class='col-md-12 homepage_slide'>
						<div class='col-md-12 col-sm-12 f2-box-12'>
							<div class='col-md-12 f2-box-12'>
								<div class='col-md-3 col-sm-1 col-xs-1 f2-box-8'>
									<div class="service f1">	
										<h1 class='slide-h1 homepage_slide_text mt03'>L</h1>
										<!-- <h4 class='slide-h4 homepage_slide_text'>4561</h4> -->
									</div>
								</div>	
								<div class='col-md-3 col-sm-1 col-xs-1 f2-box-8'>
									<div class="chrt-div">
										<div id="chrt-7" data-dimension="200" data-text="L" data-fontsize="36" data-percent="65" data-fgcolor="#08eafe" data-bgcolor="#eee" data-width="15" data-bordersize="15" data-animationstep="2"><span class="homepage_stat_c"><?= $l_count_per; ?></span></div>
									</div>
								</div>	
								<div class='col-md-3 col-sm-1 col-xs-1 f2-box-8'>
									<div class="service f1">	
										<h1 class='slide-h1 homepage_slide_text mt03'>M</h1>
										<!-- <h4 class='slide-h4 homepage_slide_text'>455</h4> -->
									</div>
								</div>	
								<div class='col-md-3 col-sm-1 col-xs-1 f2-box-8'>
									<div class="chrt-div">
										<div id="chrt-8" data-dimension="200" data-text="M" data-fontsize="36" data-percent="65" data-fgcolor="#ff4b66" data-bgcolor="#eee" data-width="15" data-bordersize="15" data-animationstep="2"><span class="homepage_stat_c"><?= $m_count_per; ?></span></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				
				
				<div class="carousel-item">
					<div class='col-md-12 homepage_slide'>
						<div class='col-md-3 col-sm-2 col-xs-1 m-0 p-0'>
							<div class="service f1">	
								<h1 class='slide-h1 homepage_slide_text'>K</h1>
								<h4 class='slide-h4 homepage_slide_text'><?php echo $totalreg; ?></h4>
							</div>
						</div>
						<div class='col-md-8 col-sm-12 f2-box-8'>
							<div class='col-md-12 f2-box-12'>
								<div class='col-md-4 col-sm-1 col-xs-1 f2-box-8'>
									<div class="chrt-div">
										<div id="chrt-9" data-dimension="200" data-text="Issued" data-fontsize="36" data-percent="65" data-fgcolor="#08eafe" data-bgcolor="#eee" data-width="15" data-bordersize="15" data-animationstep="2"><span class="homepage_stat_c"><?php echo $issued; ?></span></div>
									</div>
								</div>	
								<div class='col-md-4 col-sm-1 col-xs-1 f2-box-8'>
									<div class="chrt-div">
										<div id="chrt-10" data-dimension="200" data-text="Junked" data-fontsize="36" data-percent="65" data-fgcolor="#ff4b66" data-bgcolor="#eee" data-width="15" data-bordersize="15" data-animationstep="2"><span class="homepage_stat_c"><?php echo $junked; ?></span></div>
									</div>
								</div>
								<div class='col-md-4 col-sm-1 col-xs-1 f2-box-8'>
									<div class="chrt-div">
										<div id="chrt-11" data-dimension="200" data-text="Suspend" data-fontsize="36" data-percent="65" data-fgcolor="#27bd81" data-bgcolor="#eee" data-width="15" data-bordersize="15" data-animationstep="2"><span class="homepage_stat_c"><?php echo $suspended; ?></span></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
			<a class="carousel-control-prev" href="#carouselIndicators1" role="button" data-slide="prev">
				  <span class="carousel-control-prev-iconn glyphicon glyphicon-chevron-left mt-2" aria-hidden="true"></span>
				  <span class="sr-only">Previous</span>
				</a>
			<a class="carousel-control-next" href="#carouselIndicators1" role="button" data-slide="next">
				  <span class="carousel-control-next-iconn glyphicon glyphicon-chevron-right mt-2" aria-hidden="true"></span>
				  <span class="sr-only">Next</span>
				</a>
		</div>
	</div>	
</div> 
