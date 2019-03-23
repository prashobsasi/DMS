<?php include 'redirect_login.php';
	
$log_id=$this->session->userdata('empId');
$emp_desig=$this->session->userdata('desigId');
$emp_desig1=$this->session->userdata('desig_name');
$emp_name=$this->session->userdata('empname');
include("db_connect.php");

$designation_check="select desig_name from designation where desig_id='$emp_desig'";
			$result_desig_check=$con->query($designation_check);
			$desig_check=$result_desig_check->fetch_assoc();

		$inward_sql="select * from doc_remarks where f_status=1 AND status='0'";
		$result_inward_sql=$con->query($inward_sql);
		$toIds="";
		$count=0;
		if ($result_inward_sql->num_rows > 0) {
    			// output data of each row
    			while($row = $result_inward_sql->fetch_assoc()) {
        			$toIds=$row["to_Id"];
        			$toIdsArray = explode(",", $toIds);
        			foreach ($toIdsArray as $toId) {
        				if($toId==$log_id){
        					$count++;
        				}
					}
   		 		}
		} 

		/*echo $count;
		

		return;
		exit();*/

		$inward=$count;
			
		$outward_sql="select count(r_Id) as outward_count from doc_remarks where from_Id='$log_id' AND f_status=1";
		$result_outward_sql=$con->query($outward_sql);
		$outward_check=$result_outward_sql->fetch_assoc();
		$outward=$outward_check['outward_count'];

		$draft_sql="select count(r_Id) as draft_count from doc_remarks where from_Id='$log_id' AND f_status=0 ";
		$result_draft_sql=$con->query($draft_sql);
		$draft_check=$result_draft_sql->fetch_assoc();
		$draft=$draft_check['draft_count'];




?>
	<div class="sidebar-menu">

		<div class="sidebar-menu-inner">
			
			<header class="logo-env">

				<!-- logo -->
				<div class="logo">
					<a href="index.html">
						<img src="<?php echo asset_url();?>images/logo@2x.png" width="120" alt="" />
					</a>
				</div>

				<!-- logo collapse icon -->
				<div class="sidebar-collapse">
					<a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
						<i class="entypo-menu"></i>
					</a>
				</div>

								
				<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
				<div class="sidebar-mobile-menu visible-xs">
					<a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
						<i class="entypo-menu"></i>
					</a>
				</div>

			</header>
			
						<div class="sidebar-user-info">
				<center>
				<div class="sui-normal">
					<a href="#" class="user-link">
						<img src="data:image/jpeg;base64, <?php echo base64_encode($this->session->userdata('image')); ?>" width="100"3 alt="Red dot" class="img-circle"/>
						
					</a>
				</div>
				<a href="#" class="user-link">
				<span>Welcome,<br>
						<strong><?php echo $this->session->userdata('empname'); ?></strong></span>
				</a>
				</center>
				<div class="sui-hover inline-links animate-in"><!-- You can remove "inline-links" class to make links appear vertically, class "animate-in" will make A elements animateable when click on user profile -->
					<center>
					<a href="<?php echo base_url();?>logout">
						<i class="entypo-lock"></i>
						Log Out
					</a>
					</center>

					<span class="close-sui-popup">&times;</span><!-- this is mandatory -->				</div>
			</div>
			
									
			<ul id="main-menu" class="main-menu">
				<!-- add class "multiple-expanded" to allow multiple submenus to open -->
				<!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
				<li class="opened active has-sub">
			
						
						<?php  if($this->session->userdata('empname')=='admin'){ ?>
							<li class="active">
								<a href="<?php echo base_url();?>admin">
									<i class="entypo-gauge"></i>
									<span class="title">Dashboard</span>
								</a>
							</li>
							<li class="active">
								<a href="<?php echo base_url();?>employee">
									<i class="entypo-users"></i>
									<span class="title">Employee</span>
								</a>
							</li>
							<li class="active">
								<a href="<?php echo base_url();?>department">
									<i class="entypo-rocket"></i>
									<span class="title">Department</span>
								</a>
							</li>
							<li class="active">
								<a href="<?php echo base_url();?>designation">
									<i class="entypo-suitcase"></i>
									<span class="title">Designation</span>
								</a>
							</li>
							<li class="active">
								<a href="<?php echo base_url();?>documentType">
									<i class="entypo-docs"></i>
									<span class="title">Document Types</span>
								</a>
							</li>
						<?php }else{ ?>
							<li class="active">
								<a href="<?php echo base_url();?>employee_home">
									<i class="entypo-gauge"></i>
									<span class="title">Dashboard</span>
								</a>
							</li>
							<li class="active">
								<a href="<?php echo base_url();?>employee_profile">
									<i class="entypo-user"></i>
									<span class="title">My Profile</span>
								</a>
							</li>
							<li class="active">
								<a href="<?php echo base_url();?>document_upload">
									<i class="entypo-attach"></i>
									<span class="title">Document Upload</span>
								</a>
							</li>
							<li class="active">
								<a href="<?php echo base_url();?>compose">
									<i class="entypo-mail"></i>
									<span class="title">Compose</span>
								</a>
							</li>
							<li class="active">
								<a href="<?php echo base_url();?>inbox">
									<i class="entypo-download"></i>
									<span class="title">Inwards	(<?php echo $inward;?>)</span>
								</a>
							</li>
							<li class="active">
								<a href="<?php echo base_url();?>outbox">
									<i class="entypo-upload"></i>
									<span class="title">Outwards	(<?php echo $outward;?>)</span>
								</a>
							</li>
							<li class="active">
								<a href="<?php echo base_url();?>drafts">
									<i class="entypo-upload-cloud"></i>
									<span class="title">Drafts	(<?php echo $draft;?>)</span>
								</a>
							</li>
						<?php }?>
			</ul>
			
		</div>

	</div>