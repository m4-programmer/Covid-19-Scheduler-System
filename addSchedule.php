<?php 
require_once('config.php');
$location_qry = $conn->query("SELECT * FROM `location` where id = ".$_GET['lid']);
if($location_qry->num_rows > 0){
    foreach($location_qry->fetch_assoc() as $k => $v){
        $meta[$k] = $v;
    }
}
if(isset($meta['description']))
$meta['description'] = stripslashes(html_entity_decode($meta['description']));
?>
<style>
#uni_modal .modal-content>.modal-header,#uni_modal .modal-content>.modal-footer{
    display:none;
}
#uni_modal .modal-body{
    padding-top:0 !important;width: 90%;
}
/*#location_modal{
    direction:rtl !important;
}
#location_modal>*{
    direction:ltr !important;
}*/
</style>
<div class="modal-header border-0">
    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
</div>

<div class="container">
    <div class="row" id="location_modal">
        <div class="col-12" id="frm-field">
            
            <h3>Schedule Form: (<?php echo $_GET['d'] ?>)</h3>
            <hr>
            <form id="schedule_form">
            <input type="hidden" name="lid" value="<?php echo $_GET['lid'] ?>">
            <input type="hidden" id="locations" name="location" value="<?php echo $meta['location'] ?>">
            
            <input type="hidden" name="date_sched" value="<?php echo $_GET['d'] ?>">
                <div class="form-row">
                    <div class="col">
                        <label for="name" class="control-label">Fullname</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    
                    <div class="col">
                        <label for="contact" class="control-label">Contact</label>
                         <input type="text" class="form-control" name="contact" required>
                    </div> 
                </div>
                
                <div class="form-row">
                    <div class="col">
                         <label for="gender" class="control-label">Gender</label>
                        <select type="text" class="custom-select" name="gender" required>
                        <option>Male</option>
                        <option>Female</option>
                        </select>
                    </div>
                    
                    <div class="col">
                       <label for="dob" class="control-label">Date of Birth</label>
                        <input type="date" class="form-control" name="dob" required>
                    </div> 
                </div>

                <div class="form-group">
                    <label for="address" class="control-label">Upload Photo</label>
                    <input type="file" class="custom-file" name="image" id="image"  >
                </div>
                
                <div class="form-group">
                    <label for="address" class="control-label">Address</label>
                    <textarea class="form-control" name="address" rows="3" required></textarea>
                </div>
                <div class="form-group d-flex justify-content-end">
                    <button class="btn-dark btn">Submit Schedule</button>
                </div>
            </form>
        </div>
       <!--  <div class="col-4" id="change">
            <p><b>Location: </b><?php echo $meta['location'] ?></p>
            <hr class="border-primary">
            <div><?php echo $meta['description'] ?></div>
            <div class="image">
                <img id="photo" class="img img-rounded"  src="" style="display: none;width: 100%;height: 40vh;" alt="to put default image holder later" >
            </div>
        </div> -->
    </div>
</div>
<script>
      function printpage() {
       var printButton = document.getElementById("printpagebutton");
       printButton.style.visibility = 'hidden';
        //Print the page content
        window.print()
        printButton.style.visibility = 'visible';
       
    }

$(function(){
    // Image Previewer Script
    $('#image').click(function(){
        
        $(this).change(function(){
            var file = $(this).get(0).files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(){
                    
                    $('#photo').attr('src', reader.result);     
                    $('#photo').css('display', 'block');    
                    
                    
                    }                                                                           
                reader.readAsDataURL(file);
            }
        })
    })
    // End of Image Previewer Script
    // Begining of Scheduler scripts

    $('#schedule_form').submit(function(e){
        e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
            var datum = new FormData($(this)[0]);
            locations = $('#locations').val();
            console.log(datum)
            
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_schedule",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
                    console.log(datum)
                    
                    console.log(resp)
                     
					if(typeof resp =='object' && resp.status == 'success'){
                        var row = "<div class='row' id='forprint'>";
                        var name = "<div class='col-md-8 text-left'><h4><b>Name: "+resp.name+"</b></h4>";
                        var code = "<h3><b>ID: "+resp.code+"</b></h3>";
                        var location = "<h3><b>Location: "+locations+"</b></h3></div>";
                        var img = '<div class="col-md-4 "><img style="width: 100%;height: 100px" src="'+ resp.image+'"></div>'
                        var ins = "<small><i>Copy or take a snapshot of the code below your name. The code will serve as your ticlet number for vaccination schedule. Please bring atleast 1 ID to verify your schedule information.</i></small><br><br></div>";
                        
                         var btn = '<input id="printpagebutton" type="button" onclick="printpage()" class="btn btn-warning btn mt-2" value="Print Visitor Badge" />'
						$('#frm-field').html("<div>"+row+img+name+code+location+ins+btn+"</div>")
                        $('#change').html('this was injected');
                        
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: $('#uni_modal').offset().top }, "fast");
                    }else{
						alert_toast("An error occured",'error');
                        console.log(resp)
					}
						end_loader();
				}
			})
            /*This Script is trigger to print the schedule when the print button is pressed*/
            $('#print').click(function(){
                window.print()
            })
    })
  
    // End of Scheduler Scripts

    // $('#uni_modal').on('hidden.bs.modal', function (e) {
    //     if($('#schedule_form').length <= 0)
    //         location.reload()
    // })
})
</script>


