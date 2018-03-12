<div class="page-content-wrap">
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-dark ">
				<div class="card-header"><span class="fa fa-user-circle-o"></span>Manage Authors</div>
				<div class="card-body">
					<div class="row justify-content-md-center form-inner">
						<div class="col-sm-10">
						<div class="table-responsive">
							<table class="table table-striped DataTables " id="DataTables" cellspacing="0" width="100%">
								<thead>
									<th>Sr.No</th>
									<th>Name</th>
									<th>Slug</th>
									<th>Edit</th>
									<th>Date Joined</th>
									<?php
										if($this->session->userdata('privilege')=='ADMIN'){
									?>
									<th>Delete</th>
									<?php
										}
									?>
								</thead>
								<tbody>
									<?php
										$i=1;
										foreach($authors as $author)
										{
											?>
											<tr>
												<td><?php echo $i; ?></td>
												<td><a href="<?php echo ARTICLE_URL.$author->slug; ?>/"><?php echo $author->name; ?></a></td>
												<td><?php echo $author->slug; ?></td>																	<td><a href="<?php echo base_url().'author/add/'.$author->id ?>"><span class="fa fa-edit"></span></a></td>
												<td><?php echo date("m-d-Y",strtotime($author->date_joined)); ?></td>
												<?php
													if($this->session->userdata('privilege')=='ADMIN'){
												?>
												<td><a href="<?php echo base_url().'author/delete/'.$author->id ?>" onclick="return confirm('Do you want to delete?');"><span class="fa fa-trash"></span></a></td>
												<?php
													}
												?>
											</tr>
											<?php											
											$i++;
										}										
									?>
								</tbody>
							</table>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('#DataTables').DataTable({
			"pageLength": 25
		});
	});
</script>
