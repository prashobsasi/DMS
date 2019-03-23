<?php include 'redirect_login.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Neon Admin Panel" />
	<meta name="author" content="" />

	<link rel="icon" href="<?php echo asset_url();?>images/favicon.png">

	<title>DMS | My Profile</title>

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
	<script type="text/javascript">

		function changePassword(){
			$(".error-msg").html("");
			$("#curPassword").val("");
			$("#newPassword").val("");
			$("#conNewPassword").val("");
			$('#changePasswordModal').modal('show');
		}

		function onChange(id){

			$(".error-msg").html("");

			current=$("#curPassword").val()
			$f=0;
			if(current==""){
				$f=1;
				$(".error-msg").html("");
			}
			
			if($f==0)
			{
				$.ajax({
        			url : "<?php echo base_url(); ?>employee_profile/curPasswordCheck",
        			type : "POST",
        			dataType : "json",
        			data : {
        						"id" : id,
        						"current" : current,
        					},
        					success : function(status) {

        						if(status==false){
        							$(".error-msg").html("Please Enter Correct Password");
        							$("#curPassword").val()="";
        						}else{
        							$(".error-msg").html("");
        						}

        					},
        					error : function (jqXHR, textStatus, errorThrown) {
            					alert("Failed");
        					}
    					});
			}
		}

		function updatePassword(id){

			current=$("#curPassword").val();
			newPass=$("#newPassword").val();
			confirm=$("#conNewPassword").val();
			$f=0;

			if(confirm==""){
				$f=1;
				$(".error-msg").html("Please Enter Re-Type Password");
			}else if(confirm!=newPass){
				$f=1;
				$(".error-msg").html("Password Does Not Match");
			}

			if(newPass==""){
				$f=1;
				$(".error-msg").html("Please Enter New Password");
			}

			if(current==""){
				$f=1;
				$(".error-msg").html("Please Enter Current Password");
			}

			
			

			if($f==0){
				$(".error-msg").html("");
				$.ajax({
        			url : "<?php echo base_url(); ?>employee_profile/changePassword",
        			type : "POST",
        			dataType : "json",
        			data : {
        				"id" : id,
        				"password" : newPass
        			},
        			success : function(status) {
						
        				if(status){
        					$('#changePasswordModal').modal('hide');
        				}else{

        					$(".error-msg").html("Update Password Failed");

        				}
        			},
        			error : function (jqXHR, textStatus, errorThrown) {
            					console.log(errorThrown);
            					$(".error-msg").html("Update Failed,Please Contact Admin");
        			}
    			});
			}

		}

	</script>


</head>
<body class="page-body  page-left-in" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
	
	<?php include 'side_bar.php';?>

	<div class="main-content">
				
		<?php include 'top_bar.php';?>
		
		<hr />
		
		
		<div class="well">
					<h1>My Profile</h1>
		</div>
		
		<hr />
		
		


				<div class="pull-right">
					
					<button type="button" class="btn btn-info" onclick="changePassword()"><i class="entypo-info"></i>Change Password</button>
					
				</div>
		
		<div class="clearfix"></div>
		<hr />

		<div class="row">
			<table class="table table-striped table-bordered ">
				<tbody id="viewRow">
					<?php foreach ($employees as $employee) { 
						if($employee->emp_name==$this->session->userdata('empname'))
						{
					?>
							<tr>
								<td rowspan='3'><img src="data:image/jpeg;base64, <?php echo base64_encode($employee->image); ?>" width="150"3 alt="No Image Found" class="img-square"/></td>
							</tr>
							<tr>
								<td><strong>Id</strong></td>
								<td><?php echo $employee->emp_id; ?></td>
							</tr>
							<tr>
								<td><strong>Name</strong></td>
								<td><?php echo $employee->emp_name; ?></td>
							</tr>
							<tr>
								<td><strong>Email</strong></td>
								<td colspan='2'><?php echo $employee->email; ?></td>
							</tr>
							<tr>
								<td><strong>Username</strong></td>
								<td colspan='2'><?php echo $employee->username; ?></td>
							</tr>
							<tr>
								<td><strong>Date Of Birth</strong></td>
								<td colspan='2'><?php  $time=strtotime($employee->dob);
        							$day=date("d",$time);
        							$month=date("m",$time);
        							$dobyear=date("Y",$time);
        							$dob = $day."-".$month."-".$dobyear; echo $dob; ?></td>
        					</tr>
        					<tr>
        						<td><strong>Department</strong></td>
        						<td colspan='2'><?php foreach ($departments as $department) { 
										if($department->dept_Id==$employee->department)
										{ 
											echo $department->dept_name;
										}
										}?></td>
							</tr>
							<tr>
								<td><strong>Designation</strong></td>
								<td colspan='2'><?php foreach ($designations as $designation) { 
										if($designation->desig_id==$employee->designation)
										{ 
											echo $designation->desig_name;
										}
									}?></td>
							</tr>
							<tr>
								<td><strong>Date Of Joining</strong></td>
								<td colspan='2'><?php  $time=strtotime($employee->doj);
        								$day=date("d",$time);
        								$month=date("m",$time);
        								$dojyear=date("Y",$time);
        								$doj = $day."-".$month."-".$dojyear; echo $doj; ?></td>
        					</tr>
        					<tr>
        						<td><strong>Phone Number</strong></td>
        						<td colspan='2'><?php echo $employee->phone; ?></td></tr>
        					<tr>
        						<td><strong>Address</strong></td>
        						<td colspan='2'><?php echo $employee->address; ?></td>
        					</tr>
					<?php
							}
						}
					?>
				</tbody>
			</table>
		
		</div>

	<div class="modal fade" id="changePasswordModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><strong>Change Password</strong></h4>
        </div>
        <?php foreach ($employees as $employee) { 
			if($employee->emp_name==$this->session->userdata('empname'))
			{
		?>
        	<div class="modal-body">

        		<div class="modal-body">

						<label>Current Password</label>
						<input type="password" name="password" class="form-control" 
								autofocus="autofocus" id="curPassword"
								autocomplete="off" onchange="onChange(<?php echo $employee->e_id;?>)">
						<br>
						<label>New Password</label>
						<input type="password" name="newPassword" class="form-control" 
								autofocus="autofocus" id="newPassword"
								autocomplete="off">
						<br>
						<label>Re-type Password</label>
						<input type="password" name="conNewPassword" class="form-control" 
								autofocus="autofocus" id="conNewPassword"
								autocomplete="off">
						<br>
						<label class="error-msg" style="color: red;"></label>
				</div>
        	</div>
        	<div class="modal-footer">
        		<button type="button" class="btn btn-success" id="saveEmp" onclick="updatePassword(<?php echo $employee->e_id;?>)">Change</button>
          		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        	</div>
        <?php
        	}

        }
        ?>

     </div>
      
    </div>
</div>	
			
		<!-- Footer -->

		<?php include 'footer.php';?>
		
	</div>
			
	</div>



	<link rel="stylesheet" href="<?php echo asset_url();?>js/datatables/datatables.css">

	<link rel="stylesheet" href="<?php echo asset_url();?>js/select2/select2-bootstrap.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>js/select2/select2.css">	

	<script src="<?php echo asset_url();?>js/gsap/TweenMax.min.js"></script>
	<script src="<?php echo asset_url();?>js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="<?php echo asset_url();?>js/joinable.js"></script>
	<script src="<?php echo asset_url();?>js/resizeable.js"></script>
	<script src="<?php echo asset_url();?>js/neon-api.js"></script>
	<script src="<?php echo asset_url();?>js/jquery.validate.min.js"></script>
	<script src="<?php echo asset_url();?>js/neon-login.js"></script>


	<script src="<?php echo asset_url();?>js/datatables/datatables.js"></script>
	<script src="<?php echo asset_url();?>js/select2/select2.min.js"></script>
	<!-- JavaScripts initializations and stuff -->
	<script src="<?php echo asset_url();?>js/neon-custom.js"></script>


	<script src="<?php echo asset_url();?>js/bootstrap.min.js"></script>
	
	<!-- Demo Settings -->
	<script src="<?php echo asset_url();?>js/neon-demo.js"></script>





</body>
</html>