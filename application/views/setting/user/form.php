 <!-- Page Heading/Breadcrumbs -->
 <div class="row">
 	<div class="col-lg-12">
	 	<ol class="breadcrumb">
 			<li><a href="<?php echo base_url();?>"><i class="fa fa-home"></i>&nbsp;Home</a></li>
			<li><a href="javascript:void(0);">Pengaturan</a></li>
			<li><a href="<?php echo $index_url;?>"><?php echo $this->template->title; ?></a></li>
			<li class="active"><?php echo is_null($model->id) ? 'Tambah' : 'Edit'; ?> Data</li>
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
					 	<i class="fa fa-edit"></i>&nbsp; <strong>Form <?php echo $this->template->title; ?></strong>
					 </div>
				 </div>
 			</div>
 			<?php echo form_open(is_null($model->id) ? $create_url : $edit_url, ["id"=> "form-submit", "class"=> "form-horizontal", "autocomplete"=> "off", "method"=>"POST", "enctype"=>"multipart/form-data"]); ?>
 			<div class="panel-body">
 				<?php $this->load->view('layouts/alert'); ?>
 				
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">Username <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="username" name="username" value="<?php echo $model->username;?>"  required="required">
					</div>
				</div>
				<div class="form-group">
					<label for="email" class="col-sm-2 control-label">Email <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<input type="email" class="form-control" id="email" name="email" value="<?php echo $model->email;?>"  required="required">
					</div>
				</div>
				<div class="form-group">
					<label for="phone" class="col-sm-2 control-label">Phone </label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="phone" name="phone" value="<?php echo $model->phone;?>">
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="col-sm-2 control-label">Password <?php echo is_null($model->id) ? '<span class="text-danger">*</span>' : ''; ?></label>
					<div class="col-sm-10">
						<input type="password" class="form-control" id="password" name="password" value="" <?php echo is_null($model->id) ? 'required="required"' : ''; ?>>
					</div>
				</div>
				<div class="form-group">	
					<label for="address" class="col-sm-2 control-label">Hak Akses <span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<?php echo my_dropdown($roles, 'roles[]', '-- Pilih Hak Akses --', $roles_selected, true); ?>
					</div>
				</div>
				

 			</div>
 			<div class="panel-footer">
				<a href="<?php echo $index_url;?>" class="btn btn-default" data-toggle='tooltip' data-placement='top' data-original-title='Kembali'>
					<i class="fa fa-arrow-left"></i>&nbsp;Kembali
				</a>
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
