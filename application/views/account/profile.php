 <!-- Page Heading/Breadcrumbs -->
 <div class="row">
 	<div class="col-lg-12">
 		<ol class="breadcrumb">
 			<li><a href="<?php echo base_url();?>"><i class="fa fa-home"></i>&nbsp;Home</a></li>
			<li><a href="javascript:void(0);">Akun</a></li>
 			<li class="active">Biodata</li>
 		</ol>
 	</div>
 </div>
 <!-- /.row -->
<div class="row">
	<?php $this->load->view('account/profile-image'); ?>

	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading text-center">
				<div class="clearfix">
					 <div class="pull-right">
					 	<i class="fa fa-pencil"></i>&nbsp; <strong>Silahkan lengkapi form dibawah ini</strong>
					 </div>
					 <div class="pull-left">
					 	<i class="fa fa-edit"></i>&nbsp; <strong>Form Biodata</strong>
					 </div>
				 </div>
			</div>
			<?php echo form_open("account/profile/update", ["id"=> "form-submit", "class"=> "form-horizontal", "autocomplete"=> "off", "method"=>"POST"]); ?>
			<div class="panel-body">
				<?php $this->load->view('layouts/alert'); ?>

				<div class="form-group">
					<label for="" class="col-sm-3 control-label">Username <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="username" id="username" required="required"
							value="<?php echo $user->username; ?>" />
					</div>
				</div>

				<div class="form-group">
					<label for="" class="col-sm-3 control-label">Email <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input type="email" class="form-control" name="email" id="email" required="required"
							value="<?php echo $user->email; ?>" />
					</div>
				</div>

				<div class="form-group">
					<label for="" class="col-sm-3 control-label">Telepon </label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="phone" id="phone"
							value="<?php echo $user->phone; ?>" />
					</div>
				</div>

				<div class="form-group">
					<label for="" class="col-sm-3 control-label">Nama Lengkap <span class="text-danger">*</span>
					</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="fullname" id="fullname" required="required"
							value="<?php echo $profile->fullname; ?>" />
					</div>
				</div>

				<div class="form-group">
					<label for="" class="col-sm-3 control-label">Nama Panggilan </label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="nickname" id="nickname"
							value="<?php echo $profile->nickname; ?>" />
					</div>
				</div>

				<div class="form-group">
					<label for="" class="col-sm-3 control-label">Jenis Kelamin </label>
					<div class="col-sm-9">
						<label class="radio-inline">
							<input type="radio" name="gender" class="i-radio" id="radioSuccess1" value="1"
								<?php echo (int) $profile->gender == 1 ? 'checked' : ''; ?>>
							Pria
						</label>
						<label class="radio-inline">
							<input type="radio" name="gender" class="i-radio" id="radioSuccess2" value="2"
								<?php echo (int) $profile->gender == 2 ? 'checked' : ''; ?>>
							Wanita
						</label>
					</div>
				</div>

				<div class="form-group">
					<label for="" class="col-sm-3 control-label">Tempat Lahir </label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="birth_place" id="birth_place"
							value="<?php echo $profile->birth_place; ?>" />
					</div>
				</div>

				<div class="form-group">
					<label for="" class="col-sm-3 control-label">Tanggal Lahir </label>
					<div class="col-sm-9">
						<input type="text" class="form-control input-datepicker" name="birth_date" id="birth_date"
							value="<?php echo $profile->birth_date; ?>" />
					</div>
				</div>

				<div class="form-group">
					<label for="" class="col-sm-3 control-label">Kode Pos </label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="postal_code" id="postal_code"
							value="<?php echo $profile->postal_code; ?>" />
					</div>
				</div>

				<div class="form-group">
					<label for="" class="col-sm-3 control-label">Tentang Saya </label>
					<div class="col-sm-9">
						<textarea class="form-control" rows="6" name="about_me"
							id="about_me"><?php echo $profile->about_me;?></textarea>
					</div>
				</div>

				<div class="form-group">
					<label for="" class="col-sm-3 control-label">Catatan </label>
					<div class="col-sm-9">
						<textarea class="form-control" rows="6" name="notes"
							id="notes"><?php echo $profile->notes;?></textarea>
					</div>
				</div>

			</div>
			<div class="panel-footer">
				<button type="reset" data-toggle="tooltip" title="Reset Form" class="btn btn-default">
					<i class="fa fa-refresh"></i>&nbsp;Reset
				</button>
				<button type="submit" data-toggle="tooltip" title="Simpan Data" class="btn btn-default pull-right">
					<i class="fa fa-save"></i>&nbsp;Simpan
				</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>

</div>
