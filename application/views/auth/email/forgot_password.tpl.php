<html>
<head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo app_config('web-site-name'); ?> | Pemulihan Akun</title>
</head>
<body
        style="margin: 0pt; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; width: 100% ! important; height: 100%; line-height: 1.6em; background-color: rgb(246, 246, 246);">
<table class="body-wrap"
       style="margin: 0pt; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; width: 100%; background-color: rgb(246, 246, 246);"
       bgcolor="#f6f6f6">
    <tbody>
    <tr
            style="margin: 0pt; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px;">
        <td
                style="margin: 0pt; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top;"
                valign="top"><br>
        </td>
        <td class="container"
            style="margin: 0pt auto; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top; display: block ! important; max-width: 600px ! important; clear: both ! important;"
            valign="top" width="600">
            <div class="content"
                 style="margin: 0pt auto; padding: 20px; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; max-width: 600px; display: block;">
                <table class="main" itemprop="action" itemscope=""
                       itemtype="http://schema.org/ConfirmAction"
                       style="border: medium none ; margin: 0pt; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px;"
                       cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                    <tr
                            style="margin: 0pt; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px;">
                        <td class="content-wrap"
                            style="margin: 0pt; padding: 30px; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top; background-color: rgb(255, 255, 255);"
                            valign="top">
                            <meta itemprop="name" content="Confirm Email"
                                  style="margin: 0pt; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px;">
                            <table
                                    style="margin: 0pt; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px;"
                                    cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                                <tr>
                                    <td style="text-align: center;"><a href="#"
                                                                       style="display: block; margin-bottom: 10px;">
                                        </a> <br>
                                    </td>
                                </tr>
                                <tr
                                        style="margin: 0pt; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px;">
                                    <td class="content-block"
                                        style="margin: 0pt; padding: 0pt 0pt 20px; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top;"
                                        valign="top"> Pemulihan Akun
                                    </td>
                                </tr>
                                <tr
                                        style="margin: 0pt; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px;">
                                    <td class="content-block"
                                        style="margin: 0pt; padding: 0pt 0pt 20px; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top;"
                                        valign="top">
                                        <p>Proses pemulihan , silahkan klik tautan dibawah ini. Kami mungkin perlu mengirimkan anda informasi penting tentang layanan kami dan penting bahwa kami memiliki alamat email yang akurat.</p>
                                    </td>
                                </tr>
                                <tr
                                        style="margin: 0pt; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px;">
                                    <td class="content-block" itemprop="handler"
                                        itemscope="" itemtype="http://schema.org/HttpActionHandler"
                                        style="margin: 0pt; padding: 0pt 0pt 20px; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top;"
                                        valign="top"><a
                                                href="<?php echo base_url('auth/reset_password/'.base64_encode($forgotten_password_code));?>"
                                                class="btn-primary" itemprop="url"
                                                style="border-style: solid; border-color: rgb(240, 100, 59); border-width: 8px 16px; margin: 0pt; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; color: rgb(255, 255, 255); text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; text-transform: capitalize; background-color: rgb(240, 100, 59);">
                                            <?php echo lang('email_forgot_password_link'); ?> </a> <br>
                                    </td>
                                </tr>
                                <tr
                                        style="margin: 0pt; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px;">
                                    <td class="content-block"
                                        style="margin: 0pt; padding: 0pt 0pt 20px; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top;"
                                        valign="top"> ??? <b><?php echo app_config('web-site-name'); ?></b>
                                        -<?php echo $this->config->item('meta_author'); ?> </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="footer"
                     style="margin: 0pt; padding: 20px; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; width: 100%; clear: both; color: rgb(153, 153, 153);">
                    <table
                            style="margin: 0pt; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px;"
                            width="100%">
                        <tbody>
                        <tr
                                style="margin: 0pt; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px;">
                            <td class="aligncenter content-block"
                                style="margin: 0pt; padding: 0pt 0pt 20px; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 12px; vertical-align: top; color: rgb(153, 153, 153); text-align: center;"
                                align="center" valign="top"><a href="#"
                                                               style="margin: 0pt; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 12px; color: rgb(153, 153, 153); text-decoration: underline;">


                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </td>
        <td
                style="margin: 0pt; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; vertical-align: top;"
                valign="top"><br>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>

