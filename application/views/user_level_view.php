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

	<title>DMS | User-Level</title>

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

		jQuery( document ).ready( function( $ ) {
			var $dtUserLevel = jQuery( '#dtUserLevel' );
			
			// Initialize DataTable
			$dtUserLevel.DataTable( {
				"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"bStateSave": true
			});


			
			// Initalize Select Dropdown after DataTables is created
			$dtUserLevel.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
				minimumResultsForSearch: -1
			});

		} );

		
		function addUserLevel(){

			$('#myModal').modal('show');
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
					<h1>USER LEVEL</h1>
				</div>
		
		<hr />
		
		<div class="row col-xs-12">
				<div class="pull-right">
					<button type="button" class="btn btn-success" onclick="addUserLevel()">Add User Level</button>
				</div>
		</div>
		<div class="clearfix"></div>
		<hr />

		<div class="row">
			<table class="table table-bordered datatable" id="dtUserLevel">
				<thead>
					<tr>
						<th>Name</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
						<tr>
							<td></td>
							<td></td>
						</tr>
				</tbody>
			</table>
		
		</div>
		
		
		
		
		<!-- Footer -->

		<?php include 'footer.php';?>
		
	</div>
			
</div>

	<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
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

	<script src="<?php echo asset_url();?>js/bootstrap.min.js"></script>
	<!-- Demo Settings -->
	<script src="<?php echo asset_url();?>js/neon-demo.js"></script>


</body>
</html>