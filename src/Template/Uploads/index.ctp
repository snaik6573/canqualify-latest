<!DOCTYPE html>
<html>
<head>
	<title>List Of Object on S3</title>
</head>
<body>
	<div class="container">
		<table  id="bootstrap-data-table">
		<tbody>
			
		<?php foreach ($listObj as $list): ?>
		<tr>
			<td><? $list ?></td>
		</tr>
		<?php endforeach; ?>
		</table>
		
	</div>
</body>
</html>

<script type="text/javascript">
	$('#bootstrap-data-table, .bootstrap-data-table').DataTable({
        lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
        //responsive:true
    });

  
</script>