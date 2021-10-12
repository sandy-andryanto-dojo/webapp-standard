<?php if (validation_errors()): ?>
<div class="alert alert-warning alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-warning"></i> Validasi Gagal!</h4>
	<?php echo validation_errors('<li>', '</li>'); ?>
</div>
<?php EndIf; ?>

<?php if ($this->session->flashdata('message')): ?>
<div class="alert alert-warning alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<?php echo $this->session->flashdata('message'); ?>
</div>
<?php EndIf; ?>


<?php if ($this->session->flashdata('alert_type') && $this->session->flashdata('alert_message') && $this->session->flashdata('alert_icon') && $this->session->flashdata('alert_title')): ?>

<div class="alert alert-<?php echo $this->session->flashdata('alert_type'); ?> alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa <?php echo $this->session->flashdata('alert_icon'); ?>"></i> <?php echo $this->session->flashdata('alert_title'); ?></h4>
	<p><?php echo $this->session->flashdata('alert_message'); ?></p>
</div>

<?php EndIf; ?>
