<div class="row state-overview"  >
    <div class="col-lg-3 col-sm-3">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-user"></i>
            </div>
            <div class="value">
               <p><b>Total No of Campassador</b> </p>
                <h1><?php  echo ($totalcompassadors); ?></h1>
                
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-3">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-check-circle"></i>
            </div>
            <div class="value">
               <p><b>Action Performed</b> </p>
                <h1><?php echo $admindash->score; ?></h1>
                
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-3">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-facebook-square"></i>
            </div>
            <div class="value">
               <p><b>Facebook</b></p>
                Likes: <?php echo $admindash->totallikes; ?><br>
                <?php if($admindash->totalshare>1) {?>Share: <?php echo $admindash->totalshare; ?><br><?php } ?>
                Comments: <?php echo $admindash->totalcomment; ?><br>
                
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-3">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-twitter"></i>
            </div>
            <div class="value">
               <p><b>Twitter</b></p>
                Favourites: <?php echo $admindash->totalfavourites; ?><br>
                Retweets: <?php echo $admindash->totalretweet; ?><br>
                
            </div>
        </section>
    </div>
</div>



<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<div class="drawchintantable">
                <?php $this->chintantable->createsearch("Leaderboard");?>
                <table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0" >
                <thead>
                    <tr>
<!--                        <th data-field="id">Id</th>-->
                        <th data-field="rank">rank</th>
                        <th data-field="name">Name</th>
                        <th data-field="college">college</th>
                        <th data-field="facebook">facebook</th>
                        <th data-field="twitter">twitter</th>
                        <th data-field="score">score</th>
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
                
                return "<tr><td>" + resultrow.rank + "</td><td><a href='<?php echo site_url('site/editadminnormaluser?id=');?>"+resultrow.id +"'>" + resultrow.name + "</a></td><td>" + resultrow.college + "</td><td>" + resultrow.facebook + "</td><td>" + resultrow.twitter + "</td><td>" + resultrow.score + "</td><tr>";
            }
            generatejquery('<?php echo $base_url;?>');
        </script>
	</div>
</div>

