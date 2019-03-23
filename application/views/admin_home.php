<?php 

	include 'redirect_login.php';
	include("db_connect.php");

	$employee_sql="select count(emp_id) as employee_count from employee where username!='admin' and is_deleted=0";
		$result_employee_sql=$con->query($employee_sql);
		$employee_check=$result_employee_sql->fetch_assoc();
		$emp_count=$employee_check['employee_count'];

	$dept_sql="select count(dept_Id) as dept_count from department where is_deleted=0";
		$result_dept_sql=$con->query($dept_sql);
		$dept_check=$result_dept_sql->fetch_assoc();
		$dept_count=$dept_check['dept_count'];

	$desig_sql="select count(desig_id) as desig_count from designation where is_deleted=0";
		$result_desig_sql=$con->query($desig_sql);
		$desig_check=$result_desig_sql->fetch_assoc();
		$desig_count=$desig_check['desig_count'];

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
				<h2>Welcome to Document Management System,<strong>Admin</strong></h2>
		</div>
		
		<hr />

		
		<div class="row">
		
			<a href="<?php echo base_url();?>employee">						
			<div class="col-md-4 col-sm-4">
					<div class="tile-stats tile-red dashboard-first-tile text-center">
						<div class="icon">
							<i class="entypo-users"></i>
						</div>
						<div class="num f-sz-35">Employee</div>
						<br>
						<div class="rightalign">
							<div class="num">
								<font id="divTotalCount"><?php echo (isset($emp_count))?$emp_count:0; ?></font>
							</div>
						</div>
					</div>
			</div></a>

			<a href="<?php echo base_url();?>department">
			<div class="col-md-4 col-sm-4">
					<div class="tile-stats tile-green dashboard-first-tile text-center">
						<div class="icon">
							<i class="entypo-rocket"></i>
						</div>
						<div class="num f-sz-35">Department</div>
						<br>
						<div class="rightalign">
							<div class="num">
								<font id="divTotalCount"><?php echo (isset($dept_count))?$dept_count:0; ?></font>
							</div>
						</div>
					</div>
			</div></a>

			
			<a href="<?php echo base_url();?>designation">
			<div class="col-md-4 col-sm-4">
					<div class="tile-stats tile-blue dashboard-first-tile text-center">
						<div class="icon">
							<i class="entypo-suitcase"></i>
						</div>
						<div class="num f-sz-35">Designation</div>
						<br>
						<div class="rightalign">
							<div class="num">
								<font id="divTotalCount"><?php echo (isset($desig_count))?$desig_count:0; ?></font>
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