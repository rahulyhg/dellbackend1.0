<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
	
		
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                College Details <a class="btn btn-round pull-right mdm"  href="<?php echo site_url('site/createcollege'); ?>"><i class="icon-plus"></i></a> 
            </header>
			<div class="drawchintantable">
                <?php $this->chintantable->createsearch("");?>
                <table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0" >
                <thead>
                    <tr>
                        <th data-field="id">Id</th>
                        <th data-field="name">Name</th>
                        <th data-field="address">Address</th>
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
                
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.name + "</td><td>" + resultrow.address + "</td><td><a class='btn btn-round btn-xs' href='<?php echo site_url('site/editcollege?id=');?>"+resultrow.id +"'><i class='icon-pencil'></i></a><a class='btn btn-round btn-xs' href='<?php echo site_url('site/deletecollege?id='); ?>"+resultrow.id +"'><i class='icon-trash '></i></a></td><tr>";
            }
            generatejquery('<?php echo $base_url;?>');
        </script>
	</div>
</div>