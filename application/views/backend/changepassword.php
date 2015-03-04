	    <section class="panel">
		    <header class="panel-heading">
				 Change Password
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/changepasswordsubmit');?>" enctype= "multipart/form-data">
			  
				<input type="text" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$this->session->userdata('id'));?>" style="display:none;">
				
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
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewnormaluserprofile'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>