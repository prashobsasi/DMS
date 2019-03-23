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

	<title>DMS | Designation</title>

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
			dtDesignation = $('#dtDesignation');

			dtDesignation.dataTable( {
				"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"bStateSave": true
			});


			
			// Initalize Select Dropdown after DataTables is created
			dtDesignation.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
				minimumResultsForSearch: -1
			});
		});

		
		function addDesignation(){

			
			$('.error-msg').html('');
			document.getElementById("name").value="";
			document.getElementById("desigHiddenId").value="";

			$('#designationModal').modal('show');
		}

		function editDesignation(id,obj){

			$('.error-msg').html('');
	    	designationRow = $(obj).closest('tr');

			$.ajax({
        			url : "<?php echo base_url(); ?>designation/edit",
        			type : "POST",
        			dataType : "json",
        			data : {"id" : id},
        			success : function(data) {

        				var designations=JSON.stringify(data);

        				var desig_name="";

        				var desig_Id="";

        			

        				for (i=0; i < data.designations.length; i++){

        					desig_name=data.designations[i].desig_name;
        					desig_Id=data.designations[i].desig_id;

						}

						document.getElementById("name").value=desig_name;
						
						document.getElementById("desigHiddenId").value=desig_Id;

						$('#designationModal').modal('show');

        			},
        			error : function (jqXHR, textStatus, errorThrown){
            				alert("error");
        			}
    			});

			

		}

		function deleteDesignation(id,obj){


			$.ajax({
        			url : "<?php echo base_url(); ?>designation/delete",
        			type : "POST",
        			dataType : "json",
        			data : {"id" : id},
        			success : function(status) {

						if(status){
					// delete row from data table
							var row = $(obj).closest('tr');
							dtDesignation.fnDeleteRow(row[0]);	
						}else{
							alert("failed");
						}
						

        			},
        			error : function (jqXHR, textStatus, errorThrown) {
            				alert("errorThrown");
        			}
    			});

			


	    }

		function saveDesignation(){

				var f=0;

				var desig_name = document.getElementById("name").value;
				var desig_Id = document.getElementById("desigHiddenId").value;

				if(desig_name==""){
					f=1;
					$(".error-msg").html("Please Enter Designation Name");
				}

				if (f==0) {

					if (desig_Id!="") {

						$.ajax({
        					url : "<?php echo base_url(); ?>designation/update",
        					type : "POST",
        					dataType : "json",
        					data : {
        						"id" : desig_Id,
        						"name" : desig_name
        					},
        					success : function(data) {

        						designationRow.find("td").eq(0).text(desig_name);

								$('#designationModal').modal('hide');

        					},
        					error : function (jqXHR, textStatus, errorThrown) {
            					$('#designationModal').modal('show');
        					}
    					});
						
					}else{

						$.ajax({
        					url : "<?php echo base_url(); ?>designation/insert",
        					type : "POST",
        					dataType : "json",
        					data : {
        						"name" : desig_name
        					},
        					success : function(data) {

        						var designations=JSON.stringify(data);

        						for (i=0; i < data.designations.length; i++){

        							des_Id=data.designations[i].desig_id;

        							if(desig_name==data.designations[i].desig_name){
        								dtDesignation.fnAddData([desig_name,"<button type='button' class='btn btn-blue' style='width: 105px;'' onclick='editDesignation("+des_Id+",this)'>Edit</button> <button type='button' class='btn btn-danger' style='width: 105px;'' onclick='deleteDesignation("+des_Id+",this)'>Delete</button>"]);
        							}
								}

								$('#designationModal').modal('hide');
								

        					},
        					error : function (jqXHR, textStatus, errorThrown) {
		                		$("#designationModal").show();
		                		alert(errorThrown);
		            		}
    					});

						//$('#designationModal').modal('hide');
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
					<h1>DESIGNATION</h1>
				</div>
		
		<hr />
		<div class="row col-xs-12">
				<div class="pull-right">
					<button type="button" class="btn btn-success" onclick="addDesignation()">Add Designation</button>
				</div>
		</div>
		<div class="clearfix"></div>
		<hr />

		<div class="row">
			<table class="table table-bordered datatable" id="dtDesignation">
				<thead>
					<tr>
						<th>Name</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
						<?php foreach ($designations as $designation) { ?>
						<tr>
							<td><?php echo $designation->desig_name;?></td>
							<td><button type="button" class="btn btn-blue" style="width: 105px;" onclick="editDesignation(<?php echo $designation->desig_id; ?>,this)">Edit</button>
								<button type="button" class="btn btn-danger" style="width: 105px;" onclick="deleteDesignation(<?php echo $designation->desig_id; ?>,this)">Delete</button>
								<!--<label id="hiddenId" hidden ><?php echo $designation->desig_Id; ?></label>-->						
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

	
<div class="modal fade" id="designationModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><strong>Designation</strong></h4>
        </div>
        <form name="desigForm" id="desigForm"  enctype='multipart/form-data' method="post">
        	<div class="modal-body">
         		 <input type="text" class="form-control" name="designationname"
								autofocus="autofocus" id="name"
								autocomplete="off" placeholder="Designation Name" />
				<input id="desigHiddenId" name="desigHiddenId" type="hidden" value="">
				<label class="error-msg" style="color: red;"></label>
        	</div>
        	<div class="modal-footer">

        	<button type="button" class="btn btn-success" onclick="saveDesignation()">Save</button>
          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        	</div>
        </form>

      </div>
      
    </div>
</div>	
	
	
	
	



	<link rel="stylesheet" href="<?php echo asset_url();?>js/datatables/datatables.css">

	<link rel="stylesheet" href="<?php echo asset_url();?>js/select2/select2-bootstrap.css">
	<link rel="stylesheet" href="<?php echo asset_url();?>js/select2/select2.css">
	<!-- Imported styles on this page -->
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

	<script src="<?php echo asset_url();?>js/bootstrap.min.js"></script>-
	<!-- Demo Settings -->
	<script src="<?php echo asset_url();?>js/neon-demo.js"></script>

</body>
</html>