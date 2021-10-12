
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo app_config('web-site-name'); ?>">
    <meta name="author" content="<?php echo app_config('web-site-name'); ?>">
	<meta name="base-url" content="<?php echo base_url();?>">
	<meta name="csrf-token-name" content="<?php echo $this->security->get_csrf_token_name() ?>">
	<meta name="csrf-token-value" content="<?php echo $this->security->get_csrf_hash() ?>">
	<title><?php echo app_config('web-site-name'); ?> | <?php echo $this->template->title->default("Default title"); ?></title>
    <link rel="icon" type="image/png" href="<?php echo site_url('assets/img/logo.png'); ?>" />  
	<?php echo $this->template->meta_permission; ?>
  	<?php $this->load->view('layouts/stylesheet'); ?>
</head>

<body class="">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-left sidebar-menu">
					<?php echo auth_user_menu(); ?>
				</ul>
				<ul class="nav navbar-nav navbar-right sidebar-menu">
					<li class="dropdown" id="menu-pengguna">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user-plus"></i>&nbsp;Menu Pengguna <b class="caret"></b></a>
                        <ul class="dropdown-menu">
							<li class="<?php echo $this->uri->uri_string() == 'account/profile' ? 'active' : ''; ?>">
								<a href="<?php echo base_url('account/profile'); ?>">
									<i class="fa fa-arrow-right"></i>&nbsp;Profil Saya
								</a>
							</li>
							<li class="<?php echo $this->uri->uri_string() == 'account/password' ? 'active' : ''; ?>">
								<a href="<?php echo base_url('account/password'); ?>">
									<i class="fa fa-arrow-right"></i>&nbsp;Ubah Kata Sandi
								</a>
							</li>
							<li class="">
								<a href="<?php echo base_url('auth/logout'); ?>">
									<i class="fa fa-arrow-right"></i>&nbsp;Log Out
								</a>
							</li>
                        </ul>
                    </li>
				</ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

		<?php echo $this->template->content; ?>
        <!-- /.row -->

		<hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; <?php echo app_config('web-site-name'); ?> <?php echo date('Y');?></p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->
	<?php $this->load->view('layouts/script'); ?>
	<?php echo $this->template->script; ?>
</body>

</html>
