<?php 

	include 'redirect_login.php';
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
	/*$employee_sql="select count(user_Id) as employee_count from tbl_login";
		$result_employee_sql=$con->query($employee_sql);
		$employee_check=$result_employee_sql->fetch_assoc();
		$emp_count=$employee_check['employee_count'];*/
		

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!--<meta http-equiv="refresh" content="10;url=<?php echo base_url()?>logout" />-->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Neon Admin Panel" />
	<meta name="author" content="" />

	<link rel="icon" href="<?php echo asset_url();?>images/favicon.png">

	<title>DMS | Home</title>

	<link rel="stylesheet" href="<?php echo asset_url();?>js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/neon-core.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/neon-theme.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/neon-forms.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>css/skins/yellow.css">

	<script src="<?php echo asset_url();?>js/jquery-1.11.3.min.js"></script>

	<!--[if lt IE 9]><script src="<?php echo asset_url();?>js/ie8-responsive-file-warning.js"></script><![endif]-->
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->


</head>
<body class="page-body  page-left-in" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
	
	<?php include 'side_bar.php';?>

	<div class="main-content">
				
		<?php include 'top_bar.php';?>
		
		<hr />
		
		
		<div class="well">
				<h2>Welcome to Document Management System,<strong><?php echo $this->session->userdata('empname');?></strong></h2>
		</div>
		
		<hr />

		
		<div class="row">
		
			<a href="<?php echo base_url();?>inbox">						
			<div class="col-md-4 col-sm-4">
					<div class="tile-stats tile-red dashboard-first-tile text-center">
						<div class="icon">
							<i class="entypo-download"></i>
						</div>
						<div class="num f-sz-35">Inwards</div>
						<br>
						<div class="rightalign">
							<div class="num">
								<font id="divTotalCount"><?php echo $inward; ?></font>
							</div>
						</div>
					</div>
			</div></a>

			<a href="<?php echo base_url();?>outbox">
			<div class="col-md-4 col-sm-4">
					<div class="tile-stats tile-green dashboard-first-tile text-center">
						<div class="icon">
							<i class="entypo-upload"></i>
						</div>
						<div class="num f-sz-35">Outwards</div>
						<br>
						<div class="rightalign">
							<div class="num">
								<font id="divTotalCount"><?php echo $outward;?></font>
							</div>
						</div>
					</div>
			</div></a>


			<a href="<?php echo base_url();?>designation">
			<div class="col-md-4 col-sm-4">
					<div class="tile-stats tile-blue dashboard-first-tile text-center">
						<div class="icon">
							<i class="entypo-upload-cloud"></i>
						</div>
						<div class="num f-sz-35">Drafts</div>
						<br>
						<div class="rightalign">
							<div class="num">
								<font id="divTotalCount"><?php echo $draft;?></font>
							</div>
						</div>
					</div>
			</div></a>

			
			
					
		<hr />

		
		
	</div>
	<?php include 'footer.php';?>
</div>
		
	


	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="<?php echo asset_url();?>js/jvectormap/jquery-jvectormap-1.2.2.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>js/rickshaw/rickshaw.min.css">

	<!-- Bottom scripts (common) -->
	<script src="<?php echo asset_url();?>js/gsap/TweenMax.min.js"></script>
	<script src="<?php echo asset_url();?>js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="<?php echo asset_url();?>js/bootstrap.js"></script>
	<script src="<?php echo asset_url();?>js/joinable.js"></script>
	<script src="<?php echo asset_url();?>js/resizeable.js"></script>
	<script src="<?php echo asset_url();?>js/neon-api.js"></script>
	<script src="<?php echo asset_url();?>js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>


	<!-- Imported scripts on this page -->
	<script src="<?php echo asset_url();?>js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
	<script src="<?php echo asset_url();?>js/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="<?php echo asset_url();?>js/jquery.sparkline.min.js"></script>
	<script src="<?php echo asset_url();?>js/rickshaw/vendor/d3.v3.js"></script>
	<script src="<?php echo asset_url();?>js/rickshaw/rickshaw.min.js"></script>
	<script src="<?php echo asset_url();?>js/neon-chat.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="<?php echo asset_url();?>js/neon-custom.js"></script>


	<!-- Demo Settings -->
	<script src="<?php echo asset_url();?>js/neon-demo.js"></script>

</body>
</html>