 <!-- Page Heading/Breadcrumbs -->
 <div class="row">
 	<div class="col-lg-12">
 		<ol class="breadcrumb">
 			<li><a href="<?php echo base_url();?>"><i class="fa fa-home"></i>&nbsp;Home</a></li>
			<li><a href="javascript:void(0);">Pengaturan</a></li>
 			<li class="active">Audit Trail</li>
 		</ol>
 	</div>
 </div>

<div class="row">

	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading text-center">
				<div class="clearfix">
					<div class="pull-left">
						<i class="fa fa-table"></i>&nbsp; <strong>Data Audit Trail</strong>
					</div>
				</div>
			</div>
			<div class="panel-body table-responsive">
				<?php $this->load->view('layouts/alert'); ?>
				<table id="table-data" class="table  table-striped">
					<thead>
						<tr>
							<th>Foto</th>
							<th>Tanggal & Waktu</th>
							<th>Event</th>
							<th>URL</th>
							<th>IP Address</th>
							<th>Username</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>

</div>
