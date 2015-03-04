<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createuserpost?id=').$this->input->get('id'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                User Post Details 
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
					<th>Postid</th>
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
						<td><?php echo $row->returnpostid;?></td>
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



