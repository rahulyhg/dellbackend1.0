


	    	    <section class="panel">
		    <header class="panel-heading">
				 User Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/editusersubmit');?>" enctype= "multipart/form-data">
				<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Email</label>
				  <div class="col-sm-4">
					<?php echo $before->email; ?>
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name',$before->name);?>">
				  </div>
				</div>
				
				<div class=" form-group" style="display:none;">
				  <label class="col-sm-2 control-label" for="normal-field">Email</label>
				  <div class="col-sm-4">
					<input type="email" id="normal-field" class="form-control" name="email" value="<?php echo set_value('email',$before->email);?>">
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="description-field">Password</label>
				  <div class="col-sm-4">
					<input type="password" id="description-field" class="form-control" name="password" value="">
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="description-field">Confirm Password</label>
				  <div class="col-sm-4">
					<input type="password" id="description-field" class="form-control" name="confirmpassword" value="">
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Contact</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="contact" value="<?php echo set_value('contact',$before->contact);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">city</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="city" style="text-transform: capitalize;" value="<?php echo set_value('city',$before->city);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Date of Birth</label>
				  <div class="col-sm-4">
					<input type="date" id="d" class="form-control" name="dob" value="<?php echo set_value('dob',$before->dob);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">facebook Id</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control facebookvalue" name="facebookid" value="<?php echo set_value('facebookid',$before->facebookid);?>" readonly>
				  </div>
				  
				  <div class="col-sm-2">
				    <a class="btn btn-primary pull-right facebookidbutton">Clear</a>
				  </div>
				</div>
				
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">twitter Id</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control twittervalue" name="twitterid" value="<?php echo set_value('twitterid',$before->twitterid);?>" readonly>
				  </div>
				  
				  <div class="col-sm-2">
				    <a class="btn btn-primary pull-right twitteridbutton">Clear</a>
				  </div>
				</div>
				
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">instagram Id</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control instagramvalue" name="instagramid" value="<?php echo set_value('instagramid',$before->instagramid);?>" readonly>
				  </div>
				  
				  <div class="col-sm-2">
				    <a class="btn btn-primary pull-right instagramidbutton">Clear</a>
				  </div>
				</div>
				
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Gender</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('sex',$sex,set_value('sex',$before->sex),'class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."');
					?>
				  </div>
				</div>
				<div class=" form-group" style="display:none;">
				  <label class="col-sm-2 control-label">Status</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('status',$status,set_value('status',$before->status),'class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">college</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('college',$college,set_value('college',$before->college),'class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select Accesslevel</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('accesslevel',$accesslevel,set_value('accesslevel',$before->accesslevel),'id="accesslevelid" onchange="operatorcategories()" class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."');
					?>
				  </div>
				</div>
				
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewusers'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>
	
<script>
    $(".facebookidbutton").click(function () {
        console.log($( ".facebookvalue" ).text());
        
                $('.facebookvalue').val('');
    });
    $(".twitteridbutton").click(function () {
        console.log($( ".twittervalue" ).text());
        
                $('.twittervalue').val('');
    });
    $(".instagramidbutton").click(function () {
        console.log($( ".instagramvalue" ).text());
        
                $('.instagramvalue').val('');
    });
</script>
