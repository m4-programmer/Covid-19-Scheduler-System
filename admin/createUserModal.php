<!-- We handle the users registration here -->
<?php 

if (isset($_POST['create_users'])) {
  extract($_POST);
  

$sql = "INSERT INTO users (id,firstname,lastname,username,password,location,avatar,type) VALUES ('','$fname','$lname','$uname','$pword','$location','uploads/1624240500_avatar.png',$type) ";
$save = $conn->query($sql);

redirect('admin/?page=users');
}

 ?>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationServer01">First name</label>
              <input type="text" class="form-control" name="fname" id="validationServer01" placeholder="First name" value="" required>
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="validationServer02">Last name</label>
              <input type="text" class="form-control" name="lname" id="validationServer02" placeholder="Last name" value="" required>
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="username">Username:</label>
              <input type="text" class="form-control" name="uname" id="username" placeholder="Username" value="" required>
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="password">Password: </label>
              <input type="text" class="form-control" name="pword" id="password" placeholder="Password" value="" required>
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
          </div>
          


          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Location:</label>
            <select class="form-control" name="location" >
              <option>Select User Location</option>
             <?php $qry = $conn->query("SELECT location from `location`   ");
            while($row = $qry->fetch_assoc()): ?>
              <option value="<?php echo $row['location'] ?>"><?php echo $row['location'] ?></option>
            <?php endwhile; ?>
            </select>
          </div>
         <div class="form-group">
            <label for="recipient-name" class="col-form-label">User Type:</label>
            <select class="form-control" name="type"  >
              <option value="0">User</option>
              <option value="1">Admin</option>
            </select>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="create_users">Create User</button>
      </div>
      </form>
    </div>
  </div>
</div>