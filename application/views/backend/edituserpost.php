<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 User Post Details
			</header>
			
			<div class="panel-body">
				<form class="form-horizontal row-fluid" method="post" action="<?php echo site_url('site/edituserpostsubmit');?>" enctype= "multipart/form-data">
				
				<div class="form-group" style="display:none">
				  <label class="col-sm-2 control-label" for="normal-field">user</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="user" value="<?php echo set_value('user',$before->user);?>">
					
				  </div>
				</div>
				<div class="form-group" style="display:none">
				  <label class="col-sm-2 control-label" for="normal-field">userpost</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="userpostid" value="<?php echo set_value('userpostid',$before->id);?>">
					
				  </div>
				</div>
				
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Post</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('post',$post,set_value('post',$before->post),'class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."');
					?>
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Likes</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="likes" value="<?php echo set_value('likes',$before->likes);?>">
					
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Shares</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="share" value="<?php echo set_value('share',$before->share);?>">
					
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Comments</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="comment" value="<?php echo set_value('comment',$before->comment);?>">
					
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Favourites</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="favourites" value="<?php echo set_value('favourites',$before->favourites);?>">
					
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Retweet</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="retweet" value="<?php echo set_value('retweet',$before->retweet);?>">
					
				  </div>
				</div>
				
				
					<div class="form-group">
						<label class="col-sm-2 control-label">&nbsp;</label>
						<div class="col-sm-4">	
							<button type="submit" class="btn btn-info">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</section>
    </div>
</div>
