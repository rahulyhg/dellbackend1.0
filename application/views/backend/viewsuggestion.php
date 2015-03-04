<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createsuggestion'); ?>">Suggest Content</a> 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Suggested Posts
            </header>
			<div class="drawchintantable">
                <?php $this->chintantable->createsearch("");?>
                <table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0" >
                <thead>
                    <tr>
                        <th data-field="id">Id</th>
                        <th data-field="text">text</th>
                        <th data-field="image">image</th>
                        <th data-field="timestamp">Timestamp</th>
                        <th data-field="suggestionstatus">Status</th>
                        <th data-field="feedback">Feedback</th>
<!--                        <th data-field="adminmessage">Admin Message</th>-->
                        
                        <th data-field="action"> Actions </th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
                </table>
                   <?php $this->chintantable->createpagination();?>
            </div>
		</section>
		<script>
            function drawtable(resultrow) {
                if(!resultrow.adminstatus)
                {
                    resultrow.adminstatus="";
                }
                var sociallogo="";
                if(resultrow.posttype==2)
                {
                    sociallogo="<i style='color: #40A8D6;font-size: 25px;'class='fa fa-twitter'></i>";
                }
                else if(resultrow.posttype==1)
                {
                    sociallogo="<i  style='color: #40A8D6;font-size: 25px;'class='fa fa-facebook-square'></i>";
                }
                var status="";
                
                if(resultrow.suggestionstatus=="Publish")
                {
                    status="Approved";
                }
                else if(resultrow.suggestionstatus=="Unpublish")
                {
                    status="Unapproved";
                }
                else
                {
                    status="Pending";
                }
                if(resultrow.image=="")
                {
                    resultrow.image="NA";
                }
                else
                {
                     resultrow.image="<img src='<?php echo base_url('uploads');?>/" + resultrow.image + "' width='100px' height='auto'>";
                }
                if(resultrow.suggestionstatus=="Publish")
                {
                    if(resultrow.posttype==1)
                    {
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.text + "</td><td>"+resultrow.image+"</td><td>" + resultrow.timestamp + "</td><td>"+status+"</td><td>" + resultrow.adminmessage+ "</td><td><a href='#' style='width:80px;' class='btn btn-primary'  onclick=\"postsocial('"+resultrow.id+"','"+resultrow.text+"','" + base_url + "uploads/" + resultrow.image + "','facebook','"+resultrow.link+"')\"><i class='fa fa-facebook'></i> Post</a></td><tr>";
                    }
                    else if(resultrow.posttype==2)
                    {
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.text + "</td><td>"+resultrow.image+"</td><td>" + resultrow.timestamp + "</td><td>"+status+"</td><td>" + resultrow.adminmessage+ "</td><td><a href='#' style='width:80px;' class='btn btn-primary'  onclick=\"postsocial('"+resultrow.id+"','"+resultrow.text+"','" + base_url + "uploads/" + resultrow.image + "','twitter','')\"><i class='fa fa-twitter'></i> Tweet</a></td><tr>";
                    }
                    
                }
                else
                {
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.text + "</td><td>"+resultrow.image+"</td><td>" + resultrow.timestamp + "</td><td>"+status+"</td><td>" + resultrow.adminmessage + "</td><td></td><tr>";
                }
            }
            generatejquery('<?php echo $base_url;?>');
        </script>
	</div>
</div>