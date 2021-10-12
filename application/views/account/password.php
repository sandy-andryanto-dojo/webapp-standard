 <!-- Page Heading/Breadcrumbs -->
 <div class="row">
 	<div class="col-lg-12">
 		<ol class="breadcrumb">
 			<li><a href="<?php echo base_url();?>"><i class="fa fa-home"></i>&nbsp;Home</a></li>
			<li><a href="javascript:void(0);">Akun</a></li>
 			<li class="active">Ganti Password</li>
 		</ol>
 	</div>
 </div>
 <!-- /.row -->

 <div class="row">
 	

 	<div class="col-md-12">
 		<div class="panel panel-default">
 			<div class="panel-heading">
 				<div class="clearfix">
					 <div class="pull-right">
					 	<i class="fa fa-pencil"></i>&nbsp; <strong>Silahkan lengkapi form dibawah ini</strong>
					 </div>
					 <div class="pull-left">
					 	<i class="fa fa-edit"></i>&nbsp; <strong>Form Ubah Password</strong>
					 </div>
				 </div>
 			</div>
 			<?php echo form_open("account/password/update", ["id"=> "form-submit", "class"=> "form-horizontal", "autocomplete"=> "off", "method"=>"POST"]); ?>
 			<div class="panel-body">
 				<?php $this->load->view('layouts/alert'); ?>
 				<div class="form-group">
 					<label for="old_password" class="col-sm-3 control-label">Password Lama <span
 							class="text-danger">*</span></label>
 					<div class="col-sm-9">
 						<input type="password" class="form-control" id="old_password" name="old_password"
 							required="required">
 					</div>
 				</div>
 				<div class="form-group">
 					<label for="new_password" class="col-sm-3 control-label">Password Baru <span
 							class="text-danger">*</span></label>
 					<div class="col-sm-9">
 						<input type="password" class="form-control" id="new_password" name="new_password"
 							required="required">
 					</div>
 				</div>
 				<div class="form-group">
 					<label for="confirm_password" class="col-sm-3 control-label">Konfirmasi Password Baru <span
 							class="text-danger">*</span></label>
 					<div class="col-sm-9">
 						<input type="password" class="form-control" id="confirm_password" name="confirm_password"
 							required="required">
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
