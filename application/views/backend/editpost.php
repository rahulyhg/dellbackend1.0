	    <section class="panel">
		    <header class="panel-heading">
				Post Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/editpostsubmit');?>" enctype= "multipart/form-data">
				<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Text</label>
				  <div class="col-sm-4">
					
				  <textarea name="text"  class="form-control contenttext"><?php echo set_value('text',$before->text);?></textarea>
				  <div class="onlytwitter">
					    <p>
					        Characters Remaining: <span class="textcharacters">140</span>
					    </p>
					</div>
<!--					<input type="text" id="normal-field" class="form-control" name="text" value="">-->
				  </div>
				</div>
				<div class="form-group onlyfb">
				  <label class="col-sm-2 control-label" for="normal-field">Link</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="link" value="<?php echo set_value('link',$before->link);?>">
					
				    </div>
				</div>
				<div class=" form-group onlyfb">
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
				  <label class="col-sm-2 control-label">Platform</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('posttype',$posttype,set_value('posttype',$before->posttype),'class="chzn-select formplatform form-control" 	data-placeholder="Choose a Accesslevel..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewpost'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>
		<script>
    var maxchars=140;
    function cutstring() {
        var textlength=$(".contenttext").val().length;
        var platform=$(".formplatform").val();
        if(textlength>140 && platform==2)
        {
            var newstring=$(".contenttext").val();
            newstring=newstring.substring(0,140);
            $(".contenttext").val(newstring);
            $(".textcharacters").text(0);
        }
        
    };
    $(document).ready(function() {
        $(".formplatform").change(function() {
            var platform=$(this).val();
            if(platform==1)
            {
                $(".onlyfb").show(100);
                $(".onlytwitter").hide(100);
            }
            else if(platform==2)
            {
                $(".onlyfb").hide(100);
                $(".onlytwitter").show(100);
                cutstring();
            }
        });
        $(".contenttext").keyup(function() {
            var textlength=$(this).val().length;
            
            $(".textcharacters").text(140-textlength);
            var platform=$(".formplatform").val();
            cutstring();
            
        });
        
        $(".formplatform").trigger("change");
        $(".contenttext").trigger("keyup");
    });
   
</script>