 <!-- Page Heading/Breadcrumbs -->
 <div class="row">
 	<div class="col-lg-12">
 		<ol class="breadcrumb">
 			<li><a href="<?php echo base_url();?>"><i class="fa fa-home"></i>&nbsp;Home</a></li>
 			<li><a href="javascript:void(0);">Pengaturan</a></li>
 			<li class="active">Umum</li>
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
 						<i class="fa fa-edit"></i>&nbsp; <strong>Form Pengaturan</strong>
 					</div>
 				</div>
 			</div>
 			<?php echo form_open("setting/application/update", ["id"=> "form-submit", "class"=> "form-horizontal", "autocomplete"=> "off", "method"=>"POST"]); ?>
 			<div class="panel-body">
 				<?php $this->load->view('layouts/alert'); ?>

				 <div class="form-group">
 					<label for="name" class="col-sm-2 control-label">Mac Address </label>
 					<div class="col-sm-10">
						 <label class="radio-inline">
							<input type="radio" name="mac-address" class="i-radio" id="radioSuccess1" value="1"
								<?php echo (int) app_config('mac-address') == 1 ? 'checked' : ''; ?>>
							Ya
						</label>
						<label class="radio-inline">
							<input type="radio" name="mac-address" class="i-radio" id="radioSuccess2" value="2"
								<?php echo (int) app_config('mac-address') == 2 ? 'checked' : ''; ?>>
							Tidak
						</label>
 					</div>
 				</div>

 				<div class="form-group">
 					<label for="name" class="col-sm-2 control-label">Nama Website </label>
 					<div class="col-sm-10">
 						<input type="text" class="form-control" name="web-site-name" id="web-site-name"
 							value="<?php echo app_config('web-site-name'); ?>" />
 					</div>
 				</div>

 				<div class="form-group">
 					<label for="currency" class="col-sm-2 control-label">Mata Uang </label>
 					<div class="col-sm-10">
 						<select name="currency-code" id="currency-code" class="select2 form-control"
 							style="width:100%;">
 							<option disabled selected>-- Pilih Mata Uang --</option>
 							<?php foreach($currencies as $row => $key): ?>
 							<?php $selected = $row == app_config('currency-code') ? "selected" : ""; ?>
 							<option <?php echo $selected; ?> value="<?php echo $row; ?>"><?php echo $row." - ".$key; ?>
 							</option>
 							<?php EndForeach; ?>
 						</select>
 					</div>
 				</div>

 				<div class="form-group">
 					<label for="timezone" class="col-sm-2 control-label">Zona Waktu </label>
 					<div class="col-sm-10">
 						<select name="timezone" id="timezone" class="select2 form-control" style="width:100%;">
 							<option disabled selected>-- Pilih Zona Waktu --</option>
 							<?php foreach($timezones as $row): ?>
 							<?php $selected = $row["text"] == app_config('timezone') ? "selected" : ""; ?>
 							<option <?php echo $selected; ?> value="<?php echo $row["text"]; ?>">
 								<?php echo $row["text"]; ?></option>
 							<?php EndForeach; ?>
 						</select>
 					</div>
 				</div>

 				<div class="form-group">
 					<label for="header-invoic" class="col-sm-2 control-label">Header Invoice </label>
 					<div class="col-sm-10">
 						<textrea name="header-invoice" id="header-invoice" class="ckeditor">
 							<?php echo app_config('header-invoice'); ?></textrea>
 					</div>
 				</div>

 				<div class="form-group">
 					<label for="footer-invoice" class="col-sm-2 control-label">Footer Invoice </label>
 					<div class="col-sm-10">
 						<textrea name="footer-invoice" id="footer-invoice" class="ckeditor">
 							<?php echo app_config('footer-invoice'); ?></textrea>
 					</div>
 				</div>


 				<div class="form-group">
 					<label for="name" class="col-sm-2 control-label">Mail Driver </label>
 					<div class="col-sm-10">
 						<input type="text" class="form-control" name="mail-driver" id="mail-driver"
 							value="<?php echo app_config('mail-driver'); ?>" />
 					</div>
 				</div>

 				<div class="form-group">
 					<label for="name" class="col-sm-2 control-label">Mail Host </label>
 					<div class="col-sm-10">
 						<input type="text" class="form-control" name="mail-host" id="mail-host"
 							value="<?php echo app_config('mail-host'); ?>" />
 					</div>
 				</div>

 				<div class="form-group">
 					<label for="name" class="col-sm-2 control-label">Mail Port </label>
 					<div class="col-sm-10">
 						<input type="text" class="form-control" name="mail-port" id="mail-port"
 							value="<?php echo app_config('mail-port'); ?>" />
 					</div>
 				</div>

 				<div class="form-group">
 					<label for="name" class="col-sm-2 control-label">Mail Username </label>
 					<div class="col-sm-10">
 						<input type="text" class="form-control" name="mail-username" id="mail-username"
 							value="<?php echo app_config('mail-username'); ?>" />
 					</div>
 				</div>

 				<div class="form-group">
 					<label for="name" class="col-sm-2 control-label">Mail Password </label>
 					<div class="col-sm-10">
 						<input type="text" class="form-control" name="mail-password" id="mail-password"
 							value="<?php echo app_config('mail-password'); ?>" />
 					</div>
 				</div>

 				<div class="form-group">
 					<label for="name" class="col-sm-2 control-label">Mail Encryption </label>
 					<div class="col-sm-10">
 						<input type="text" class="form-control" name="mail-encryption" id="mail-encryption"
 							value="<?php echo app_config('mail-encryption'); ?>" />
 					</div>
 				</div>

 				<div class="form-group">
 					<label for="name" class="col-sm-2 control-label">Mail Address </label>
 					<div class="col-sm-10">
 						<input type="email" class="form-control" name="mail-address" id="mail-address"
 							value="<?php echo app_config('mail-address'); ?>" />
 					</div>
 				</div>

 				<div class="form-group">
 					<label for="name" class="col-sm-2 control-label">Mail Name </label>
 					<div class="col-sm-10">
 						<input type="text" class="form-control" name="mail-name" id="mail-name"
 							value="<?php echo app_config('mail-name'); ?>" />
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
