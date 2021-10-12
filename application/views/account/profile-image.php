<div id="crop-avatar">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading text-center">
				<i class="fa fa-image"></i>&nbsp; <strong>Foto Profil</strong>
			</div>
			<div class="panel-body">
				<div class="avatar avatar-view">
					<img width="150" class="profile-user-img img-responsive img-circle center-block" src="<?php echo auth_user_image(); ?>" alt="User profile picture">

					<h3 class="profile-username text-center"><?php echo $profile->fullname; ?></h3>

					<p class="text-muted text-center"><?php echo auth_user_roles(); ?></p>

					<ul class="list-group list-group-unbordered">
						<li class="list-group-item">
							<b>Bergabung Sejak</b> <a class="pull-right"><?php echo auth_join_date(); ?></a>
						</li>
						<li class="list-group-item">
							<b>Login Terakhir</b> <a class="pull-right"><?php echo auth_last_login(); ?></a>
						</li>
						<li class="list-group-item">
							<b>Alamat IP</b> <a class="pull-right"><?php echo $user->ip_address; ?></a>
						</li>
					</ul>

					<a href="javascript:void(0);" class="btn btn-default btn-block" data-toggle='tooltip' data-placement='top'  data-original-title='Upload Foto'>
						<b>
							<i class="fa fa-upload"></i>&nbsp;Ubah Foto Profil
						</b>
					</a>

				</div>
			</div>
		</div>
	</div>

	<div class="modal fade"  id="avatar-modal" aria-labelledby="avatar-modal-label" >
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">
							<i class="fa fa-picture-o"></i>&nbsp;Upload Foto Profil
						</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<?php echo form_open("api/common/upload_user", array("class"=> "avatar-form", "id"=> "avatar-form", "role"=> "form", "enctype"=>"multipart/form-data")); ?>
							<div class="avatar-body">
								<!-- Upload image and data -->
								<div class="avatar-upload text-left">
									<input type="hidden" class="avatar-src" name="avatar_src">
									<input type="hidden" class="avatar-data" name="avatar_data">
									<input type="file" class="avatar-input file-input" id="avatarInput" name="avatar_file" accept="image/x-png,image/gif,image/jpeg">
									<p></p>
								</div>
								<!-- Crop and preview -->
								
								<div class="row">
									<div class="col-md-9">
										<div class="avatar-wrapper"></div>
									</div>
									<div class="col-md-3">
										<div class="avatar-preview preview-lg"></div>
										<div class="avatar-preview preview-md"></div>
										<div class="avatar-preview preview-sm"></div>
									</div>
								</div>
								<div class="row avatar-btns">
									<div class="col-md-9 text-left">
										<div class="btn-group">
											<button type="button" class="btn btn-default btn-sm" data-method="rotate" data-option="-90" title="Rotate -90 degrees">Rotate Left</button>
											<button type="button" class="btn btn-default btn-sm" data-method="rotate" data-option="-15">-15deg</button>
											<button type="button" class="btn btn-default btn-sm" data-method="rotate" data-option="-30">-30deg</button>
											<button type="button" class="btn btn-default btn-sm" data-method="rotate" data-option="-45">-45deg</button>
										</div>
										<div class="btn-group">
											<button type="button" class="btn btn-default btn-sm" data-method="rotate" data-option="90" title="Rotate 90 degrees">Rotate Right</button>
											<button type="button" class="btn btn-default btn-sm" data-method="rotate" data-option="15">15deg</button>
											<button type="button" class="btn btn-default btn-sm" data-method="rotate" data-option="30">30deg</button>
											<button type="button" class="btn btn-default btn-sm" data-method="rotate" data-option="45">45deg</button>
										</div>
									</div>
									<div class="col-md-3">
										<button type="submit" class="btn btn-default btn-block avatar-save btn-sm">
											<i class="fa fa-check"></i>&nbsp;Selesai dan Simpan
										</button>
									</div>
								</div>
							</div>
						<?php echo form_close(); ?>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

		<div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>

</div>
