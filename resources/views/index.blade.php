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
		<table id="products_table" class="table table-bordered table-hover table-striped table-responsive" width="100%">
			<thead>
		      	<tr>
		          	<th>Name</th>
		          	<th>Vendor</th>
		      	</tr>
		  	</thead>
		  	<tbody>

		  	</tbody>
		  	<tfoot>
		      	<tr>
		          	<th>Name</th>
		          	<th>Vendor</th>
		      	</tr>
		  	</tfoot>
		</table>
	</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#products_table').DataTable({
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
	});
</script>
</body>
</html>
