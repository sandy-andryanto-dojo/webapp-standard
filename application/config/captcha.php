<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// BotDetect PHP Captcha configuration options
// more details here: https://captcha.com/doc/php/captcha-options.html
// ----------------------------------------------------------------------------

$config = array(
    /*
    |--------------------------------------------------------------------------
    | Captcha configuration for login page
    |--------------------------------------------------------------------------
    */
    'DefaultCaptcha' => array(
        'UserInputID' => 'CaptchaCode',
        'CodeLength' => CaptchaRandomization::GetRandomCodeLength(4, 6),
        'ImageStyle' => array(
            ImageStyle::Radar,
            ImageStyle::Collage,
            ImageStyle::Fingerprints,
        ),
		"UseHorizontalIcons"=> true,
    ),

    
);
