<div class="user-profile">
   <div class="user-imgnm">
      <div  class="user-img">
       <img src="<?php echo $table->image;?>"><br>
       
       <div class="username">
       <h4><?php echo $table->name;?></h4>
       </div>
       </div>
   </div>
   <div class="userprf-head">
       <h5><?php echo $table->email;?><br></h5>
       <h5><?php if($table->contact==""){ echo "NA";} else{ echo $table->contact; }?><br></h5>
       <h5><?php echo $table->sex;?><br></h5>
       <h5><?php echo "Date of Birth: ".$table->dob;?><br></h5>
       <h5><?php echo "Studied at ".$table->collegename;?><br></h5>
       
<div class=" row" style="padding:1% 0;">
	<div class="col-md-12 text-center">
	
		<a class="btn btn-primary"  href="<?php echo site_url('site/editnormaluser'); ?>">Edit Profile </a> &nbsp;
		<a class="btn btn-primary"  href="<?php echo site_url('site/changepassword'); ?>">Change Password</a> 
	</div>
	
</div>
   </div>
   <div class="clearfix"></div>
</div>


<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
            </header>
			<table class="table table-striped table-hover" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Action</th>
					<th>Platform</th>
					<th>Date</th>
					<th>Reach</th>
				</tr>
			</thead>
			<tbody>
			   <?php foreach($posts as $row) { ?>
					<tr>
						<td><?php echo $row->posttext;?></td>
						<td><?php echo $row->posttypename;?></td>
						<td><?php echo $row->timestamp;?></td>
						<td><?php if($row->posttype==1){
                                echo "Likes: ".$row->likes.", Comments: ".$row->comment.", Shares: ".$row->share;
                                }
                                elseif($row->posttype==2)
                                {
                                echo "Retweets: ".$row->retweet.", Favourites: ".$row->favourites;
                                }
                            ?>
                        </td>
					</tr>
					<?php } ?>
			</tbody>
			</table>
		</section>
        </div>
	</div>