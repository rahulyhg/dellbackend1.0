<div class="row state-overview fit5">
    <div class="col-md-2">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-user"></i>
            </div>
            <div class="value">
                <p>Rank</p>
                <h1><?php  echo $studentdash->rank; ?></h1>

            </div>
        </section>
    </div>
    <div class="col-md-2">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-check-circle"></i>
            </div>
            <div class="value">
                <p>Action Done</p>
                <h1><?php  echo $studentdash->score; ?></h1>

            </div>
        </section>
    </div>

    <div class="col-md-2">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-exclamation-circle"></i>
            </div>
            <div class="value">
                <p>Action Remaining</p>
                <h1><?php  echo $studentdash->remaining; ?></h1>

            </div>
        </section>
    </div>


    <div class="col-md-2">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-facebook-square"></i>
            </div>
            <div class="value">
                <p>Facebook</p>
                Likes:
                <?php echo $studentdash->totallikes; ?>  
                <br>Comments:
                <?php echo $studentdash->totalcomment; ?>
                <br>

            </div>
        </section>
    </div>
    <div class="col-md-2">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-twitter"></i>
            </div>
            <div class="value">
                <p>Twitter</p>
                Favourites:
                <?php echo $studentdash->totalfavourites; ?>
                <br>Retweets:
                <?php echo $studentdash->totalretweet; ?>
                <br>

            </div>
        </section>
    </div>
</div>



<div class="row">
    
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<div class="drawchintantable">
			<?php $this->chintantable->createsearch("","","col-md-8","col-md-4");?>
			<div class="row">
			<div class="col-md-3">
       <h4 class="quickpost">Quick Post</h4>
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->


            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
               
                    <?php foreach($quickposts as $key => $post) { ?>
                    <div class="item <?php if($key==0) {
    echo "active";
}?>">
<?php
    if(strtolower($post->posttypename) == 'twitter')
    {
    }
    else
    {
        ?>
<div class="image"><img class="img-responsive" src="<?php echo base_url("uploads/$post->image"); ?>"></div>
   <?php }?>
<div class="text"><?php echo $post->text;?></div><div class="buttons text-center"><a href="#" class="btn btn-primary" onclick="postsocial('<?php echo $post->id;?>','<?php echo $post->text;?>','<?php echo base_url("uploads/$post->image"); ?>','<?php echo strtolower($post->posttypename);?>','<?php echo $post->link; ?>')">
<?php 
if ( strtolower($post->posttypename) == 'twitter')
 {echo '<i class="fa fa-twitter"></i>&nbsp;Tweet';}
  else 
  {echo '<i class="fa fa-facebook"></i>&nbsp;Post';}?>
</a></div></div>
                
                    <?php } ?>
            </div>
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true" style="color: rgba(64, 168, 214, 0.66);
background: white;
width: 40px;
height: 40px;
line-height: 36px;
border-radius: 100%;left:0;"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" style="color: rgba(64, 168, 214, 0.66);
background: white;
width: 40px;
height: 40px;
line-height: 36px;
border-radius: 100%;left:0;" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
    
    </div>
        </div>
        <div class="col-md-9">
        <h4 class="quickpost">Leader Board</h4>
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
        </div>
			
                
            </div>
		</section>
		<script>
            function drawtable(resultrow) {
                
                return "<tr><td>" + resultrow.rank + "</td><td>" + resultrow.name + "</td><td>" + resultrow.college + "</td><td>" + resultrow.facebook + "</td><td>" + resultrow.twitter + "</td><td>" + resultrow.score + "</td><tr>";
            }
            generatejquery('<?php echo $base_url;?>');
        </script>
	</div>


</div>