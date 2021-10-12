<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-sign-in"></i>&nbsp; <strong>Silahkan lengkapi form dibawah ini</strong></h3>
				</div>
				<div class="panel-body">
					<?php $this->load->view('layouts/alert'); ?> 
					<?php echo form_open("auth/login", ["autocomplete"=> "off", "id"=>"form-auth"]);?>
						<fieldset>
							<div class="form-group">
								<label for="name">Username Atau Email</label>
								<?php echo form_input($identity);?>
							</div>
							<div class="form-group">
								<label for="password">Kata Sandi</label>
								<?php echo form_input($password);?>
							</div>
							<div class="form-group">
								<label for="captcha">Kode Captcha</label>
								<?php 
									$botdetectCaptcha = array(
										'name'        => 'CaptchaCode',
										'id'          => 'CaptchaCode',
										'value'       => '',
										'maxlength'   => '100',
										'size'        => '50',
										'class'		  => 'form-control',
										'placeholder' => 'CAPTCHA'
									);
									echo form_input($botdetectCaptcha);
								?>
								<div id="captcha-section" class="text-center">
									<?php echo $captchaHtml; ?>
								</div>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="remember" > Ingatkan Saya
								</label>
							</div>
							<!-- Change this to a button or input when using this as a form -->
							<button type="submit" class="btn btn-default btn-block" data-toggle='tooltip'  data-placement='top'  data-original-title='Masuk Aplikasi'>
								<i class="fa fa-sign-in"></i>&nbsp;Masuk
							</button>
							<h1></h1>
							<div class="text-center">
								<strong><a href="<?php echo base_url('auth/forgot_password');?>">Lupa Kata Sandi ?</a></strong>
							</div>
						</fieldset>
					<?php echo form_close();?>
				</div>
			</div>
		</div>
	</div>
</div>
