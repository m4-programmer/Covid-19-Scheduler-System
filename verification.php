<!-- Verification Page -->

<section class="py-5 " style="margin-top: 48px;">
    <div class="container ">
        <div class="card rounded-0">
            <div class="card-body p-5">
                <form style="width: 50%;margin: auto;" action="" method="post">
                	<h2 class="text-center"> Verification Panel</h2>
                	<label class="small text-muted">Welcome to the Verification Panel, Please input your details to verify your candidate for the vaccine.</label>

                    <p class="text-center text-danger"><?php if (isset($err_msg)): ?>
                        <?php echo $err_msg ?>
                    <?php endif ?></p>
                	<div class="form-group">
                		<input type="text" name="uname" value="<?php echo @$uname ?>" placeholder="Enter Username" class="form-control">
                	</div>
                	<div class="form-group">
                		<input type="text" name="pword" placeholder="Enter Password" class="form-control">
                	</div>
                	<div style="margin:auto;width: 25%;">
                	<button class="btn btn-primary btn-sm" name="confirm">Confirm Identity</button>
                	</div>
                </form>
            </div>
        </div>
    </div>
    <div class="space" style="height: 1.5vh">
        
    </div>
</section>

