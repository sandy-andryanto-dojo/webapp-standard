 <!-- Page Heading/Breadcrumbs -->
 <div class="row">
 	<div class="col-lg-12">
 		<ol class="breadcrumb">
 			<li><a href="<?php echo base_url();?>"><i class="fa fa-home"></i>&nbsp;Home</a></li>
			<li><a href="javascript:void(0);">Pengaturan</a></li>
			<li><a href="<?php echo $index_url;?>"><?php echo $this->template->title; ?></a></li>
 			<li class="active">Detail</li>
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
				<div class="clearfix">
					<div class="pull-right">

						<a href="<?php echo $index_url;?>" class="btn btn-sm btn-default" data-toggle='tooltip' data-placement='top' data-original-title='Kembali'>
							<i class="fa fa-arrow-left"></i>&nbsp;Kembali
						</a>
						<?php if($permission["can_create"]): ?>
							<a href="<?php echo $create_url;?>" class="btn btn-sm btn-success"  data-toggle="tooltip" title="Tambah Data">
								<i class="fa fa-plus"></i>&nbsp;Tambah Baru
							</a>
						<?php Endif; ?>
						<?php if($permission["can_edit"]): ?>
							<a href="<?php echo $edit_url;?>" class="btn btn-sm btn-info"  data-toggle="tooltip" title="Edit Data">
								<i class="fa fa-edit"></i>&nbsp;Edit
							</a>
						<?php Endif; ?>
						<?php if($permission["can_delete"]): ?>
							<a href="<?php echo $delete_url;?>" class="btn btn-sm btn-danger btn-delete-data"  data-toggle="tooltip" title="Delete Data">
								<i class="fa fa-trash"></i>&nbsp;Hapus
							</a>
						<?php Endif; ?>


					</div>
				</div>
				<h1></h1>
				
				<table class="table table-striped">
					<col style="width:10%">
					<col style="width:90%">
					<tr>
						<td>Nama</td>
						<td>:&nbsp;&nbsp;&nbsp;<?php echo $model->name; ?></td>
					</tr>
					<tr>
						<td>Update Terakhir</td>
						<td>:&nbsp;&nbsp;&nbsp;<?php echo $model->updated_at ? $model->updated_at : $model->created_at; ?></td>
					</tr>
				</table>

				<h1></h1>

				<input type="hidden" id="permissions" value='<?php echo json_encode($permissions);?>' />
				<input type="hidden" id="route_id" value='<?php echo $model->id; ?>' />
				<table class="table table-bordered d-none" id="table-show">
					<tr class="text-center">
						<td rowspan="3" class="text-center"><strong>Modul Aplikasi</strong></td>
						<td colspan="4" class="text-center"><strong>Aksi</strong></td>
					</tr>
					<tr class="text-center">
						<td><strong><i class="fa fa-search"></i>&nbsp;Tampil</strong></td>
						<td><strong><i class="fa fa-plus"></i>&nbsp;Tambah</strong></td>
						<td><strong><i class="fa fa-edit"></i>&nbsp;Edit</strong></td>
						<td><strong><i class="fa fa-trash"></i>&nbsp;Hapus</strong></td>
					</tr>
					<tr class="text-center">
						<td><input type="checkbox" class=" view checked-header" id="checked-view"></td>
						<td><input type="checkbox" class=" create checked-header" id="checked-create"></td>
						<td><input type="checkbox" class=" edit checked-header" id="checked-edit"></td>
						<td><input type="checkbox" class=" delete checked-header" id="checked-delete"></td>
					</tr>
					<?php table_permission(); ?>
				</table>

			</div>
		</div>
	</div>

</div>
