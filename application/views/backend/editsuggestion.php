	    <section class="panel">
		    <header class="panel-heading">
				suggestion Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/editsuggestionsubmit');?>" enctype= "multipart/form-data">
				<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
				<input type="hidden" id="normal-field" class="form-control" name="user" value="<?php echo set_value('user',$before->user);?>" style="display:none;">
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Text</label>
				  <div class="col-sm-4">
<!--					<input type="text" id="normal-field" class="form-control" name="text" value="<?php echo set_value('text',$before->text);?>">-->
              
              <textarea name="text"  class="form-control"><?php echo set_value('text',$before->text);?></textarea>
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Image</label>
				  <div class="col-sm-4">
					<input type="file" id="normal-field" class="form-control" name="image" value="<?php echo set_value('image',$before->image);?>">
					<?php if($before->image == "")
						 { }
						 else
						 { ?>
							<img src="<?php echo base_url('uploads')."/".$before->image; ?>" width="140px" height="140px">
						<?php }
					?>
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Status</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('suggestionstatus',$suggestionstatus,'Unpublish','class="chzn-select formsuggestion form-control" 	data-placeholder="Choose a Status..."');
					?>
				  </div>
				</div>
			<?php	
//        if($before->suggestionstatus=='Unpublish')
//        {
        ?>
				<div class="form-group suggestionmessage" style="display:none;">
				  <label class="col-sm-2 control-label" for="normal-field">Comment</label>
				  <div class="col-sm-4">
<!--					<input type="text" id="normal-field" class="form-control" name="text" value="<?php echo set_value('text',$before->text);?>">-->
              
              <textarea name="message"  class="form-control"><?php echo set_value('message',$before->adminmessage);?></textarea>
				  </div>
				</div>
<?php 
//} 
                  ?>
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewsuggestion'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>
		<script>
            $(document).ready(function() {
                
                $(".formsuggestion").change(function() {
                    var suggestionstatus=$(this).val();
                    if(suggestionstatus=='Unpublish')
                    {
                        $(".suggestionmessage").show(100);
                    }
                    else if(suggestionstatus=='Publish')
                    {
                        $(".suggestionmessage").hide(100);
                    }
                    else if(suggestionstatus=='Pending')
                    {
                        $(".suggestionmessage").hide(100);
                    }
                });
                $(".formsuggestion").trigger("change");
            });
        </script>