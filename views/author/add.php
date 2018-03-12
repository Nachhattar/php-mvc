<div class="page-content-wrap">
	<div class="row">
		<div class="col-12">
			<div class="card card-dark ">
				<div class="card-header"><span class="fa fa-user-circle-o"></span><?php echo $title; ?></div>
				<div class="card-body">
					<div class="row justify-content-md-center form-inner">
						<div class="col-sm-10">
						<form method="post" enctype="multipart/form-data" id="addAuthorForm">
							<input type="hidden" name="id" id="hidden"  value="<?php if(!empty($authorData)){echo $authorData->id;} ?>"  />
							 <div class="form-group">
								<label for="name">Name</label>
								<input type="text" class="form-control" id="name"   name="name" value="<?php if(!empty($authorData)){echo $authorData->name;} ?>" placeholder="Enter Name">
							  </div>
							  <div class="form-group">
								<label for="slug">Slug</label>
								<input type="text" class="form-control" id="slug"  name="slug"  value="<?php if(!empty($authorData)){echo $authorData->slug;} ?>"  placeholder="Enter slug">
							  </div>
							   <div class="row">
							  <div class="form-group col-sm-5">
								<label for="date_joined">Date Joined</label>
								<input type="text"  value="<?php if(!empty($authorData)){echo date("m-d-Y",strtotime($authorData->date_joined));}else{echo date("m-d-Y",strtotime('today'));} ?>"  class="form-control" id="date_joined" name="date_joined" >
							  </div>
							  <div class="form-group col-sm-5">
									<label for="author_type_id">Author Type</label>
									 <select class="custom-select form-control" id="author_type_id" name="author_type_id">
										 <?php
											foreach($author_types as $type)
											{
												?>
												<option value="<?php echo $type->id ?>" <?php if(!empty($authorData)){if($type->id == $authorData->author_type_id){ echo 'selected';}} ?>><?php echo $type->name ?></option>
												<?php
											}
										 ?>
									  </select>
								  </div>
							</div>
							  <div class="form-group">
								<label for="content">Content</label>
								<textarea  class="form-control" id="content" name="content"><?php if(!empty($authorData)){echo $authorData->content;} ?></textarea>
							  </div>
							  <div class="form-group">
								<label for="preview_text">Preview Text</label>
								<textarea  class="form-control" id="preview_text" name="preview_text"><?php if(!empty($authorData)){echo $authorData->preview_text;} ?></textarea>
							  </div>
							  <div class="form-group">
								<button id="metaFields" name="metaFields" class="btn btn-primary">Advanced Meta Fields</button>
							  </div>
							  <div id="advancedMeta" style="display:none;">
								  <div class="form-group">
									<label for="meta_title">Meta Title</label>
									<input type="text" class="form-control" id="meta_title"   name="meta_title"  value="<?php if(!empty($authorData)){echo $authorData->meta_title;} ?>"   placeholder="Enter slug">
								  </div>
								   <div class="form-group">
									<label for="meta_description">Meta Description</label>
									<textarea class="form-control" id="meta_description" name="meta_description"><?php if(!empty($authorData)){echo $authorData->meta_description;} ?></textarea>
								  </div>
								  <div class="form-group">
									<label for="meta_keywords">Meta Keywords</label>
									<textarea class="form-control" id="meta_keywords" name="meta_keywords"><?php if(!empty($authorData)){echo $authorData->meta_keywords;} ?></textarea>
								  </div>
								   <div class="form-group">
									<label for="og_title">OG Title</label>
									<input type="text" class="form-control" id="og_title"   name="og_title"    value="<?php if(!empty($authorData)){echo $authorData->og_title;} ?>" placeholder="Enter OG Title">
								  </div>
								   <div class="form-group">
									<label for="og_description">OG Description</label>
									<textarea class="form-control" id="og_description" name="og_description"><?php if(!empty($authorData)){echo $authorData->name;} ?></textarea>
								  </div>
								   <div class="form-group">
									<label for="twitter_title">Twitter Title</label>
									<input type="text"  value="<?php if(!empty($authorData)){echo $authorData->twitter_title;} ?>"  class="form-control" id="twitter_title"   name="twitter_title"   placeholder="Enter Twitter Title">
								  </div>
								   <div class="form-group">
									<label for="twitter_description">Twitter Description</label>
									<textarea class="form-control" id="twitter_description" name="twitter_description"><?php if(!empty($authorData)){echo $authorData->twitter_description;} ?></textarea>
								  </div>
								</div>
							  <div class="row">
								  <div class="col-sm-5 form-group">
									  <label for="main_media">Main Media</label>
									  <input type="file" class="form-control"  name="main_media" id="main_media" />
								  </div>
								  <div class="col-sm-5 form-group">
									  <label for="preview_media">Preview Media</label>
									  <input type="file" class="form-control"  name="preview_media" id="preview_media" />
								  </div>
							  </div>
							  <button type="submit" class="btn btn-primary btn-lg" name="save"><?php echo $buttonTitle; ?></button>
							  <button type="submit" class="btn btn-success btn-lg" name="close">Close</button>
						</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$("#metaFields").click(function(e){
			e.preventDefault(e);
			$("#advancedMeta").slideToggle();
		});
	
			
	});
</script>
