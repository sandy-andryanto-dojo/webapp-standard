 <!-- Page Heading/Breadcrumbs -->
 <div class="row">
 	<div class="col-lg-12">
 		<ol class="breadcrumb">
 			<li><a href="<?php echo base_url();?>"><i class="fa fa-home"></i>&nbsp;Home</a></li>
			<li><a href="javascript:void(0);">Pengaturan</a></li>
 			<li class="active"><?php echo $this->template->title; ?></li>
 		</ol>
 	</div>
 </div>

<div class="row">
	

	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading text-center">
				<div class="clearfix">
					<div class="pull-left">
						<i class="fa fa-table"></i>&nbsp; <strong> <?php echo $this->template->title; ?></strong>
					</div>
				</div>
			</div>
			<div class="panel-body table-responsive">
				<?php $this->load->view('layouts/alert'); ?>
				<?php if($permission["can_create"]): ?>
					<div class="clearfix">
						<div class="pull-right">
							<a href="<?php echo $create_url; ?>" class="btn btn-sm btn-success" data-toggle='tooltip' data-placement='top' data-original-title='Tambah data baru'>
								<i class="fa fa-plus"></i>&nbsp;Tambah Data
							</a>
						</div>
					</div>
					<hr>
				<?php Endif; ?>
				<table id="table-data" class="table  table-striped">
					<thead>
						<tr>
							<th width="20" class="text-center">No</th>
							<th>Foto</th>
							<th>Username</th>
							<th>Email</th>
							<th>Telepon</th>
							<th>Hak Akses</th>
							<th class="text-center" width="150">Aksi</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>

</div>
