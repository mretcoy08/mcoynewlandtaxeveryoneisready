<style>
.res_text
{
  font-size: calc(6px + (26 - 14) * ((100vw - 300px) / (1600 - 300)));
}
</style>

<body >
<div class="wrapper ">



<!-- SIDEBAR -->
		<nav id="sidebar">
			<div class="sidebar-header py-2">
				<h3 class="text-center"><strong>

				<!-- LOGO OF RPTAS -->
				<!-- <img src="<?php echo base_url() ?>/assets/img/ubilis.svg" style="height: 100px;" class="p-2"> -->


				</strong></h3>
			</div>
			<ul class="list-unstyled components">
				<div class="text-center ">
					<img src="<?php echo base_url() ?>/assets/img/spclogo.png" style="height: 120px;" class="rounded-circle" alt="hoverable">
					<div class="text-center   pt-2 ">
						<p class="py-0 text-dark"><strong> SAN PABLO CITY</strong></p>
						<p class="text-dark">The city is more popularly known as the "City of Seven Lakes" </p>
					</div>
					<p id = "profile_name" class ="text-dark"></p>
				</div>
				<!-- LIST OF LINKS -->
				<li>
					<a href="<?php echo base_url()?>Dashboard" class="list-group-item list-group-item-action bg-light heavy-rain-gradient"><i class="fas fa-chart-bar "></i> Dashboard</a>
				</li>
				<?php 
				if($this->session->userdata('role') == "Admin"){
						echo '<li>
						<a href="'.base_url("User_management").'" class="list-group-item list-group-item-action bg-light heavy-rain-gradient"><i class="fas fa-user"></i> User Management</a>
					</li>';
				}
				?>	
					
				<li>
					<a href="<?php echo base_url()?>Land_and_owners" class="list-group-item list-group-item-action bg-light heavy-rain-gradient"><i class="fas fa-address-book"></i> Land and Owners</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>Building_and_owners" class="list-group-item list-group-item-action bg-light heavy-rain-gradient"><i class="fas fa-building"></i> Building and Owners</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>Tax_order_assessment" class="list-group-item list-group-item-action bg-light heavy-rain-gradient"><i class="fa fa-gavel"></i> Tax Order Assessment</a>
				</li>
				
				<li>
					<a href="<?php echo base_url()?>Payment" class="list-group-item list-group-item-action bg-light heavy-rain-gradient"><i class="fas fa-money-bill"></i> Payment</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>Compromise" class="list-group-item list-group-item-action bg-light heavy-rain-gradient"><i class="fas fa-handshake"></i> Compromise Payment</a>
				</li>
				<li>
					<a href="<?php echo base_url()?>Clearance" class="list-group-item list-group-item-action bg-light heavy-rain-gradient"><i class="fas fa-file-alt "></i> Clearance</a>
				</li>
				<!-- <li>
					<a href="<?php echo base_url()?>Audit_trail" class="list-group-item list-group-item-action bg-light heavy-rain-gradient"><i class="fas fa-clipboard-list "></i> Audit Trail</a>
				</li> -->
				<!-- END OF LIST -->
			</ul>
		</nav>
		<!-- END OF SIDEBAR -->


		<!-- Page Content  -->
		<!-- NAVBAR -->
		<div id="content" class="py-0 px-0">

			<nav class="navbar navbar-fixed-top sticky-top navbar-expand-lg navbar-light py-1 mb-3">
				<div class="container-fluid">
					<a id="sidebarCollapse" class="btn-sm">
						<i class="text-dark fas fa-bars fa-lg"></i>
					</a>
					<img src="<?php echo base_url() .'assets/img/land_tax.png'?>" height="40px" >
					<h3 class="pt-2 ml-3 font-weight-bold"><strong></strong></h3>
					<h4 class="mt-2"><strong></strong></h4>
					<button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<i class="fas fa-align-justify"></i>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav ml-auto">
							
							
							<li class="nav-item dropdown">
								<a class="nav-link"  id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
									<i class="fas fa-user-circle fa-lg" ></i><?php echo $this->session->userdata['fullname'];?><i class="fas fa-caret-down text-slight"></i></a>
								<div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
									<a class="dropdown-item" href="#" >My account</a>
									<a class="dropdown-item" href="<?php echo base_url('Login/logout')?>">Log out</a>
								</div>
							</li>
							
					</div>
				
			</nav>
			<!-- END OF NAVBAR -->
