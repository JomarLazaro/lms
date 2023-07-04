<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h3 id="myModalLabel">Change Avatar</h3>
	</div>
		<div class="modal-body">
					<form method="post" action="teacher_avatar.php" enctype="multipart/form-data">
							<center>	
								<div class="control-group ">
									<div class="controls">
										<input name="image" class="input-file uniform_on alert alert-info" id="fileInput" type="file" accept=".jpeg,.gif,.png,.webp" 
										style="width: 80%"size="600" required >
									</div>
									<div> 
										Allowed files: 
										<span class="badge badge-info">.jpeg</span>
										<span class="badge badge-info">.gif</span> 
										<span class="badge badge-info">.png</span>
										<span class="badge badge-info">.webp</span>
									</div>
								</div>
							</center>			 
					
		</div>
					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i> Close</button>
						<button class="btn btn-info" name="change"><i class="icon-save icon-large"></i> Save</button>
					</div>
					</form>
</div>
<!-- end  Modal -->