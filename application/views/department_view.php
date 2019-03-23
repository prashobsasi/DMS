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

	<title>DMS | Department</title>

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
			dtDepartment = $('#dtDepartment');

			dtDepartment.dataTable( {
				"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"bStateSave": true
			});


			
			// Initalize Select Dropdown after DataTables is created
			dtDepartment.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
				minimumResultsForSearch: -1
			});
		});

		
		function addDepartment(){

			
			$('.error-msg').html('');
			document.getElementById("name").value="";
			document.getElementById("deptHiddenId").value="";

			$('#departmentModal').modal('show');
		}

		function editDepartment(id,obj){

			$('.error-msg').html('');
	    	departmentRow = $(obj).closest('tr');

			$.ajax({
        			url : "<?php echo base_url(); ?>department/edit",
        			type : "POST",
        			dataType : "json",
        			data : {"id" : id},
        			success : function(data) {

        				var departments=JSON.stringify(data);

        				var dept_name="";

        				var dept_Id="";

        			

        				for (i=0; i < data.departments.length; i++){

        					dept_name=data.departments[i].dept_name;
        					dept_Id=data.departments[i].dept_Id;

						}

						document.getElementById("name").value=dept_name;
						
						document.getElementById("deptHiddenId").value=dept_Id;

						$('#departmentModal').modal('show');

        			},
        			error : function (jqXHR, textStatus, errorThrown){
            				alert("error");
        			}
    			});

			

		}

		function deleteDepartment(id,obj){


			$.ajax({
        			url : "<?php echo base_url(); ?>department/delete",
        			type : "POST",
        			dataType : "json",
        			data : {"id" : id},
        			success : function(status) {

						if(status){
					// delete row from data table
							var row = $(obj).closest('tr');
							dtDepartment.fnDeleteRow(row[0]);	
						}else{
							alert("failed");
						}
						

        			},
        			error : function (jqXHR, textStatus, errorThrown) {
            				alert("errorThrown");
        			}
    			});

			


	    }

		function saveDepartment(){

				var f=0;

				var dept_name = document.getElementById("name").value;
				var dept_id = document.getElementById("deptHiddenId").value;

				if(dept_name==""){
					f=1;
					$(".error-msg").html("Please Enter Department Name");
				}

				if (f==0) {

					if (dept_id!="") {

						$.ajax({
        					url : "<?php echo base_url(); ?>department/update",
        					type : "POST",
        					dataType : "json",
        					data : {
        						"id" : dept_id,
        						"name" : dept_name
        					},
        					success : function(data) {

        						departmentRow.find("td").eq(0).text(dept_name);

								$('#departmentModal').modal('hide');

        					},
        					error : function (jqXHR, textStatus, errorThrown) {
            					$('#departmentModal').modal('show');
        					}
    					});
						
					}else{

						$.ajax({
        					url : "<?php echo base_url(); ?>department/insert",
        					type : "POST",
        					dataType : "json",
        					data : {
        						"name" : dept_name
        					},
        					success : function(data) {

        						var departments=JSON.stringify(data);

        						for (i=0; i < data.departments.length; i++){

        							dept_Id=data.departments[i].dept_Id;

        							if(dept_name==data.departments[i].dept_name){
        								dtDepartment.fnAddData([dept_name,"<button type='button' class='btn btn-blue' style='width: 105px;'' onclick='editDepartment("+dept_Id+",this)'>Edit</button> <button type='button' class='btn btn-danger' style='width: 105px;'' onclick='deleteDepartment("+dept_Id+",this)'>Delete</button>"]);
        							}
								}

								$('#departmentModal').modal('hide');
								

        					},
        					error : function (jqXHR, textStatus, errorThrown) {
		                		$("#departmentModal").show();
		                		alert(errorThrown);
		            		}
    					});

						//$('#departmentModal').modal('hide');
					}
					
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
					<h1>DEPARTMENT</h1>
		</div>
		
		<hr />
		
		<div class="row col-xs-12">
				<div class="pull-right">
					<button type="button" class="btn btn-success" onclick="addDepartment()">Add Department</button>
				</div>
		</div>
		<div class="clearfix"></div>
		<hr />

		<div class="row">
			<table class="table table-bordered datatable" id="dtDepartment">
				<thead>
					<tr>
						<th>Name</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
						<?php foreach ($departments as $department) { ?>
						<tr>
							<td><?php echo $department->dept_name;?></td>
							<td><button type="button" class="btn btn-blue" style="width: 105px;" onclick="editDepartment(<?php echo $department->dept_Id; ?>,this)">Edit</button>
								<button type="button" class="btn btn-danger" style="width: 105px;" onclick="deleteDepartment(<?php echo $department->dept_Id; ?>,this)">Delete</button>
								<!--<label id="hiddenId" hidden ><?php echo $department->dept_Id; ?></label>-->						
							</td>
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