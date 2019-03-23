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

	<title>DMS | Document Type</title>

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
			dtDocumentType = $('#dtDocumentType');

			dtDocumentType.dataTable( {
				"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"bStateSave": true
			});


			
			// Initalize Select Dropdown after DataTables is created
			dtDocumentType.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
				minimumResultsForSearch: -1
			});
		});

		
		function addDocumentType(){

			
			$('.error-msg').html('');
			document.getElementById("name").value="";
			document.getElementById("keyword").value="";
			document.getElementById("docTypeHiddenId").value="";

			$('#documentTypeModal').modal('show');
		}

		function editDocumentType(id,obj){

			$('.error-msg').html('');
	    	documentTypeRow = $(obj).closest('tr');

			$.ajax({
        			url : "<?php echo base_url(); ?>documentType/edit",
        			type : "POST",
        			dataType : "json",
        			data : {"id" : id},
        			success : function(data) {

        				var documentTypes=JSON.stringify(data);

        				var doc_type_name="";

        				var file_keyword="";

        				var doc_type_Id="";

        			

        				for (i=0; i < data.documentTypes.length; i++){

        					doc_type_name=data.documentTypes[i].name;
        					file_keyword=data.documentTypes[i].keyword;
        					doc_type_Id=data.documentTypes[i].id;

						}

						document.getElementById("name").value=doc_type_name;

						document.getElementById("keyword").value=file_keyword;
						
						document.getElementById("docTypeHiddenId").value=doc_type_Id;

						$('#documentTypeModal').modal('show');

        			},
        			error : function (jqXHR, textStatus, errorThrown){
            				alert("error");
        			}
    			});

			

		}

		function deleteDocumentType(id,obj){


			$.ajax({
        			url : "<?php echo base_url(); ?>documentType/delete",
        			type : "POST",
        			dataType : "json",
        			data : {"id" : id},
        			success : function(status) {

						if(status){
					// delete row from data table
							var row = $(obj).closest('tr');
							dtDocumentType.fnDeleteRow(row[0]);	
						}else{
							alert("failed");
						}
						

        			},
        			error : function (jqXHR, textStatus, errorThrown) {
            				alert("errorThrown");
        			}
    			});

			


	    }

		function saveDocumentType(){

				var f=0;

				var doc_type_name = document.getElementById("name").value;
				var keyword = document.getElementById("keyword").value;
				var doc_type_id = document.getElementById("docTypeHiddenId").value;

				if(doc_type_name==""){
					f=1;
					$(".error-msg").html("Please Enter Document Type Name");
				}

				if(keyword==""){
					f=1;
					$(".error-msg").html("Please Enter File Keyword");
				}


				if (f==0) {

					if (doc_type_id!="") {

						$.ajax({
        					url : "<?php echo base_url(); ?>documentType/update",
        					type : "POST",
        					dataType : "json",
        					data : {
        						"id" : doc_type_id,
        						"name" : doc_type_name,
        						"keyword" : keyword
        					},
        					success : function(data) {

        						documentTypeRow.find("td").eq(0).text(doc_type_name);
        						documentTypeRow.find("td").eq(1).text(keyword);

								$('#documentTypeModal').modal('hide');

        					},
        					error : function (jqXHR, textStatus, errorThrown) {
            					$('#documentTypeModal').modal('show');
        					}
    					});
						
					}else{

						$.ajax({
        					url : "<?php echo base_url(); ?>documentType/insert",
        					type : "POST",
        					dataType : "json",
        					data : {
        						"name" : doc_type_name,
        						"keyword" : keyword
        					},
        					success : function(data) {

        						var documentTypes=JSON.stringify(data);

        						for (i=0; i < data.documentTypes.length; i++){

        							doc_type_id=data.documentTypes[i].id;
        							keyword=data.documentTypes[i].keyword;
        							if(doc_type_name==data.documentTypes[i].name){
        								dtDocumentType.fnAddData([doc_type_name,keyword,"<button type='button' class='btn btn-blue' style='width: 105px;'' onclick='editDocumentType("+doc_type_id+",this)'>Edit</button> <button type='button' class='btn btn-danger' style='width: 105px;'' onclick='deleteDocumentType("+doc_type_id+",this)'>Delete</button>"]);
        							}
								}

								$('#documentTypeModal').modal('hide');
								

        					},
        					error : function (jqXHR, textStatus, errorThrown) {
		                		$("#documentTypeModal").show();
		                		alert(errorThrown);
		            		}
    					});

						//$('#documentTypeModal').modal('hide');
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
					<h1>DOCUMENT TYPES</h1>
		</div>
		
		<hr />
		
		<div class="row col-xs-12">
				<div class="pull-right">
					<button type="button" class="btn btn-success" onclick="addDocumentType()">Add Document Type</button>
				</div>
		</div>
		<div class="clearfix"></div>
		<hr />

		<div class="row">
			<table class="table table-bordered datatable" id="dtDocumentType">
				<thead>
					<tr>
						<th>Name</th>
						<th>File Name Keyword</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
						<?php foreach ($documentTypes as $documentType) { ?>
						<tr>
							<td><?php echo $documentType->name;?></td>
							<td><?php echo $documentType->keyword;?></td>
							<td><button type="button" class="btn btn-blue" style="width: 105px;" onclick="editDocumentType(<?php echo $documentType->id; ?>,this)">Edit</button>
								<button type="button" class="btn btn-danger" style="width: 105px;" onclick="deleteDocumentType(<?php echo $documentType->id; ?>,this)">Delete</button>
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



<div class="modal fade" id="documentTypeModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><strong>Document Type</strong></h4>
        </div>
        <form name="deptForm" id="deptForm"  enctype='multipart/form-data' method="post">
        	<div class="modal-body">
         		 <input type="text" class="form-control" name="name"
								autofocus="autofocus" id="name"
								autocomplete="off" placeholder="Document Type Name" />
				<input type="text" class="form-control" name="keyword"
								autofocus="autofocus" id="keyword"
								autocomplete="off" placeholder="File Name Keyword" />
				<input id="docTypeHiddenId" name="docTypeHiddenId" type="hidden" value="">
				<label class="error-msg" style="color: red;"></label>
        	</div>
        	<div class="modal-footer">

        	<button type="button" class="btn btn-success" onclick="saveDocumentType()">Save</button>
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