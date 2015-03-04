	    	
	<div class=" row" style="padding:1% 0;">
<!--
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createuserpost?id=').$this->input->get('id'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
-->
<div class="user-profile">
   <div class="user-imgnm">
      <div  class="user-img">
       <img src="<?php echo $before->image;?>"><br>
       
       <div class="username">
       <h4><?php echo $before->name;?></h4>
       </div>
       </div>
   </div>
   <div class="userprf-head">
       <h5><?php echo $before->email;?><br></h5>
       <h5><?php if($before->contact==""){ echo "NA";} else{ echo $before->contact; }?><br></h5>
       <h5><?php echo $before->sex;?><br></h5>
       <h5><?php echo "Date of Birth: ".$before->dob;?><br></h5>
       <h5><?php echo "Studied at ".$before->collegename;?><br></h5>
       

   </div>
   <div class="clearfix"></div>
</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Student Post Details 
            </header>
			<table class="table table-striped table-hover  fpTable lcnp" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Id</th>
					<th>User</th>
					<th>Post Text</th>
					<th>Post Type</th>
					<th>Likes</th>
					<th>Shares</th>
					<th>Comments</th>
					<th>Favourites</th>
					<th>Retweet</th>
					<!--  <th>Postid</th> -->
					<th>Timestamp</th>
					<th> Actions </th>
				</tr>
			</thead>
			<tbody>
			   <?php foreach($table as $row) { ?>
					<tr>
						<td><?php echo $row->id;?></td>
						<td><?php echo $row->username;?></td>
						<td><?php echo $row->posttext;?></td>
						<td><?php echo $row->posttypename;?></td>
						<td><?php echo $row->likes;?></td>
						<td><?php echo $row->share;?></td>
						<td><?php echo $row->comment;?></td>
						<td><?php echo $row->favourites;?></td>
						<td><?php echo $row->retweet;?></td>
						<!-- <td><?php echo $row->returnpostid;?></td> -->
						<td><?php echo $row->timestamp;?></td>
						<td>
							<a href="<?php echo site_url('site/edituserpost?id=').$row->user.'&userpostid='.$row->id;?>" class="btn btn-primary btn-xs">
								<i class="icon-pencil"></i>
							</a>
							<a href="<?php echo site_url('site/deleteuserpost?id=').$row->user.'&userpostid='.$row->id; ?>" class="btn btn-danger btn-xs">
								<i class="icon-trash "></i>
							</a> 
							
						</td>
					</tr>
					<?php } ?>
			</tbody>
			</table>
		</section>
        </div>
	</div>

	    <section class="panel">
		    <header class="panel-heading">
				 User Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/editadminnormalusersubmit');?>" enctype= "multipart/form-data">
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
				  <label class="col-sm-2 control-label" for="normal-field">DOB</label>
				  <div class="col-sm-4">
					<input type="date" id="d" class="form-control" name="dob" value="<?php echo set_value('dob',$before->dob);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">facebookid</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control facebookvalue" name="facebookid" value="<?php echo set_value('facebookid',$before->facebookid);?>" readonly>
				  </div>
				  
				  <div class="col-sm-2">
				    <a class="btn btn-primary pull-right facebookidbutton">Clear</a>
				  </div>
				</div>
				
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">twitterid</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control twittervalue" name="twitterid" value="<?php echo set_value('twitterid',$before->twitterid);?>" readonly>
				  </div>
				  
				  <div class="col-sm-2">
				    <a class="btn btn-primary pull-right twitteridbutton">Clear</a>
				  </div>
				</div>
				
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">instagramid</label>
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
				  <a href="<?php echo site_url('site/viewnormalusers'); ?>" class="btn btn-secondary">Cancel</a>
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