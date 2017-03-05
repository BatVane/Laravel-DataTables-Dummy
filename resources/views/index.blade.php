<!DOCTYPE html>
<html>
<head>
	<title>Index</title>
	<!-- Styles -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
		<link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- Mainly scripts -->
    <script src="/js/jquery-2.1.1.js"></script>
    <script src="/js/bootstrap.min.js"></script>

    <!-- DATATABLES -->
    <!-- databales common -->
    <script src="/datatables/datatables.min.js"></script>
    <script src="/datatables/dataTables.responsive.min.js"></script>
    <script src="/datatables/dataTables.bootstrap.min.js"></script>
    <link href="/datatables/responsive.dataTables.min.css" rel="stylesheet">
    <link href="/datatables/dataTables.bootstrap.min.css" rel="stylesheet">

    <!-- datables buttons -->
    <script src="/datatables/dataTables.buttons.min.js"></script>
    <script src="/datatables/buttons.flash.min.js"></script>
    <script src="/datatables/jszip.min.js"></script>
    <script src="/datatables/pdfmake.min.js"></script>
    <script src="/datatables/vfs_fonts.js"></script>
    <script src="/datatables/buttons.html5.min.js"></script>
    <script src="/datatables/buttons.print.min.js"></script>
    <script src="/datatables/buttons.bootstrap.min.js"></script>
    <link href="/datatables/buttons.dataTables.min.css" rel="stylesheet">
    <link href="/datatables/buttons.bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<div class="container" style="margin: 30px;">
		@if(session()->has('status'))
			<div class="alert alert-success">
				{{session('status')}}
			</div>
		@endif
		<table id="products_table" class="table table-bordered table-hover table-striped table-responsive" width="100%">
			<thead>
		      	<tr>
		          	<th>Name</th>
		          	<th>Vendor</th>
		          	<th>Action</th>
		      	</tr>
		  	</thead>
		  	<tbody>

		  	</tbody>
		  	<tfoot>
		      	<tr>
		          	<th>Name</th>
		          	<th>Vendor</th>
		          	<th>Action</th>
		      	</tr>
		  	</tfoot>
		</table>
	</div>
<script type="text/javascript">
	$(document).ready(function(){
		var products_grid = $('#products_table').DataTable({
		    "processing": true,
		    "responsive": true,
		    "serverSide": true,
		    "dom": 'lBfrtip',
		    "pageLength": 10,
		    //"iDisplayLength": 10,
		    "deferRender": true,
		    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		    "ajax": {
		        url: "/fetchProducts",
		        type: "POST",
		        dataSrc : 'data',
		        data: {'_token': "{{csrf_token()}}"}
		    },
		    columns: [
		        {
		            data: 'productName'
		        },
		        {
		            data: 'productVendor'
		        },
		        {
		        	"render": function (data, type, full, meta) {
		        		var div_update_button = '<div class="btn-group-vertical btn-block">\n\
                                                <button type="button" class="btn btn-warning btn-xs btn-block" id="update_row_' + 
                                                full.productCode + '_btn"\n\
                                                data-toggle="modal" \n\
                                                data-target="#modal_update_row">Update</button>\n\
                                        </div>';

                        return div_update_button;
                    }
		        }
		    ],
		    buttons: [
		            {
		                text: '<i class="fa fa-md fa-clipboard" data-toggle="tooltip" title="Copy"></i>',
		                extend: 'copy'
		            },
		            {
		                text: '<i class="fa fa-md fa-file-text-o" data-toggle="tooltip" title="Export as CSV"></i>',
		                extend: 'csv',
		                title: 'csv',
		                extension: '.csv'
		            }, {
		                text: '<i class="fa fa-md fa-file-excel-o" data-toggle="tooltip" title="Export as Excel"></i>',
		                extend: 'excel',
		                title: 'excel',
		                extension: '.xls'
		            }, {
		                text: '<i class="fa fa-md fa-file-pdf-o" data-toggle="tooltip" title="Export as PDF"></i>',
		                extend: 'pdf',
		                title: 'pdf',
		                extension: '.pdf'
		            },
		            {
		                text: '<i class="fa fa-md fa-print" data-toggle="tooltip" title="Print"></i>',
		                extend: 'print',
		                title: 'print',
		                extension: '.print'
		            }
		    ]
		});

		$('#products_table tbody').on( 'click', 'button', function () {
			var data = null;

			//check if the row has not gone one line below in case of shrinking the table 
            if(typeof products_grid.row( $(this).closest('tr') ).data() !== 'undefined'){
                data = products_grid.row( $(this).closest('tr') ).data();
            }else{
                data = products_grid.row( $(this).closest('tr').prev() ).data();
            }

            //populate the input fields
            $('#update_product_name').val(data.productName);
            $('#update_product_vendor').val(data.productVendor);
            $('#update_product_code').val(data.productCode);
		});			
	});
</script>

<div id="modal_update_row" class="modal fade" role="dialog">
  	<div class="modal-dialog">
  		<form name="update_product_form" id="update_product_form" action="/updateProduct" method="POST">
  			@php echo csrf_field(); @endphp
	    	<div class="modal-content">
		      	<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal">&times;</button>
		        	<h4 class="modal-title">Update Data</h4>
		      	</div>
			    <div class="modal-body">
			      		<div class="form-group">
			            	<!-- PRODUCT NAME -->
		            	 	<label for="update_product_name" class="col-lg-8 control-label">Product Name</label>
			                <input type="text" name="update_product_name" required id="update_product_name" class="form-control">
			            </div>
			            <div class="form-group">
				            <!-- PRODUCT VENDOR -->
			             	<label for="update_product_vendor" class="col-lg-8 control-label">Product Vendor</label>
			                <input type="text" name="update_product_vendor" id="update_product_vendor" class="form-control" data-track-changes>
			        	</div>
			        	{{-- HIDDEN FIELD WITH THE PRODUCT CODE NECESSARY FOR UPDATING --}}
			        	<input type="hidden" id="update_product_code" name="update_product_code">
		      	</div>
		      	<div class="modal-footer">
		        	<button type="submit" class="btn btn-primary" id="submit_button_id">Update</button>
		          	<button type="button" id="close_button_id" class="btn btn-warning" data-dismiss="modal">Cancel</button>
	      		</div>
	    	</div>
    	</form>
  	</div>
</div>

</body>
</html>
