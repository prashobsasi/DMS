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

	<title>DMS | Outwards</title>

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

		$(document).ready(function() {
			var responsiveHelper = undefined;
			var breakpointDefinition = {
			tablet : 1024,
			phone : 480
			};
			dtOutbox = $('#dtOutbox');

			dtOutbox.dataTable( {
				"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"bStateSave": true
			});


			
			// Initalize Select Dropdown after DataTables is created
			dtOutbox.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
				minimumResultsForSearch: -1
			});
		});

		
	

	</script>


</head>
<body class="page-body  page-left-in" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
	
	<?php include 'side_bar.php';?>

	<div class="main-content">
				
		<?php include 'top_bar.php';?>
		
		<hr />
		
		
		<div class="well">
					<h1>Outwards</h1>
		</div>
		
		<hr />
		<div class="row">
			<table class="table table-bordered datatable" id="dtOutbox">
				<thead>
					<tr>
						<th>Document Name</th>
						<th>Sent On</th>
						<th>Sent To</th>
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($document_remarks as $doc) { 

								$docId=$doc->doc_Id;
								$doc_name="";
								$sentTo="";
								$remarks=$doc->remark;
								$data['documents'] = $this->compose_model->get__document_name($docId);
								foreach ($data['documents']  as $document) {
								$doc_name=$document->doc;
								}
								$toIds=$doc->to_Id;

							$toIdsArray = explode(",", $toIds);

							if(sizeof($toIdsArray)==1){
								$data['employees'] = $this->employee_model->get_employee_name($toIds);
								foreach ($data['employees']  as $employee) {
									$sentTo=$employee->emp_name;
							}
							}else{

								foreach ($toIdsArray as $toId) {

									$data['employees'] = $this->employee_model->get_employee_name( $toId);
										foreach ($data['employees']  as $employee) {
											$sentTo .= $employee->emp_name." , ";
										}

								}
					
							}
						
										

							$sec = strtotime($doc->time_stamp); 
  
       						$date = date("d-m-Y h:i A", $sec); 
  
    
							$sentOn=$date;




						?>
						<tr>
							<td><?php echo $doc_name;?></td>
							<td><?php echo $sentOn;?></td>
							<td><?php echo $sentTo;?></td>
							<td><?php echo $remarks;?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		
		</div>
		

		
		
		
		
		<!-- Footer -->

		<?php include 'footer.php';?>
		
	</div>
			
</div>



<div class="modal fade" id="departmentModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><strong>Department</strong></h4>
        </div>
        <form name="deptForm" id="deptForm"  enctype='multipart/form-data' method="post">
        	<div class="modal-body">
         		 <input type="text" class="form-control" name="username"
								autofocus="autofocus" id="name"
								autocomplete="off" placeholder="Department Name" />
				<input id="deptHiddenId" name="deptHiddenId" type="hidden" value="">
				<label class="error-msg" style="color: red;"></label>
        	</div>
        	<div class="modal-footer">

        	<button type="button" class="btn btn-success" onclick="saveDepartment()">Save</button>
          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        	</div>
        </form>

      </div>
      
    </div>
</div>	
	
	
	
	




	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="<?php echo asset_url();?>js/datatables/datatables.css">

	<link rel="stylesheet" href="<?php echo asset_url();?>js/select2/select2-bootstrap.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>js/select2/select2.css">
	

	<!-- Bottom scripts (common) -->
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