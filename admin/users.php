<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<!-- Function that get max users for a particular location -->
<?php 
 function getMax($location)
 {
 	$db = new DBConnection;
	$conn = $db->conn;
 	$qry = $conn->query("SELECT max_a_day from `location` where location = '$location'  ");	
 	$row = $qry->fetch_assoc();
 	return $row['max_a_day'];
 }
 ?>

<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Users</h3>
		<div class="card-tools">
			<button data-toggle="modal" data-target="#exampleModal" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</button>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-stripped">
				<colgroup>
					<col width="5%">
					<col width="30%">
					<col width="35%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Username</th>
						<th>Location</th>
						<th>Max</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT * from `users` where type != 1 ");
						while($row = $qry->fetch_assoc()):
                            // $row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo $row['firstname'] .' '. $row['lastname']?></td>
							<td><?php echo $row['username'] ?></td>
							<td ><p class="truncate-1 m-0"><?php echo $row['location'] ?></p></td>
							<td class="text-center"><?php echo number_format(getMax($row['location'])) ?></td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    
				                   <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>

				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<?php require 'createUserModal.php'; ?>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this location permanently?","delete_location",[$(this).attr('data-id')])
		})
		$('.table').dataTable();
	})
	function delete_location($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_users",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>