<div class="row" style="padding:1% 0">
	<div class="col-md-12">
		<div class="pull-right">
			<a href="<?php echo site_url('site/viewuserpost?id=').$userid; ?>" class="btn btn-primary pull-right"><i class="icon-long-arrow-left"></i>&nbsp;Back</a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				User Post Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/createuserpostsubmit');?>" enctype= "multipart/form-data">
			  
				<div class="form-group" style="display:none">
				  <label class="col-sm-2 control-label" for="normal-field">user</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="user" value="<?php echo set_value('user',$userid);?>">
					
				  </div>
				</div>
				
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Post</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('post',$post,set_value('post'),'class="chzn-select form-control" 	data-placeholder="Choose a Accesslevel..."');
					?>
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Likes</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="likes" value="<?php echo set_value('likes');?>">
					
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Shares</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="share" value="<?php echo set_value('share');?>">
					
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Comments</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="comment" value="<?php echo set_value('comment');?>">
					
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Favourites</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="favourites" value="<?php echo set_value('favourites');?>">
					
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Retweet</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="retweet" value="<?php echo set_value('retweet');?>">
					
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewuserpost'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>
	</div>
</div>

