<div class="centered">
<?php 

if($facebook)
{    ?>
<a href="<?php echo site_url('hauth/login/Facebook');?>" class="btn-social  facebooklogin">
<i class="fa fa-facebook lrg"></i>
<span class="name">Connect with Facebook</span>
</a>
<?php } ?>

<?php 
if($twitter)
{    ?>
<a href="<?php echo site_url('hauth/login/Twitter');?>" class="btn-social twitterlogin">
<i class="fa fa-twitter lrg"></i>
<span class="name">Connect with Twitter</span>
</a>
<?php } ?>
</div>