<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-sign-in"></i>&nbsp; <strong>Silahkan lengkapi form dibawah ini</strong></h3>
				</div>
				<div class="panel-body">
					<?php $this->load->view('layouts/alert'); ?> 
					<?php echo form_open('auth/reset_password/' . $code, ["autocomplete"=> "off", "id"=>"form-auth"]);?>
						<?php echo form_input($user_id);?>
						<?php echo form_hidden($csrf); ?>
						<fieldset>
							<div class="form-group">
								<label for="name">Kata Sandi Baru</label>
								<?php echo form_input($new_password);?>
							</div>
							<div class="form-group">
								<label for="name">Konfirmasi Kata Sandi Baru</label>
								<?php echo form_input($new_password_confirm);?>
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
							<!-- Change this to a button or input when using this as a form -->
							<button type="submit" class="btn btn-default btn-block" data-toggle='tooltip'  data-placement='top'  data-original-title='Reset Kata Sandi'>
								<i class="fa fa-refresh"></i>&nbsp;Reset Kata Sandi
							</button>
						</fieldset>
					<?php echo form_close();?>
				</div>
			</div>
		</div>
	</div>
</div>
