<?php

define("RC_KEY", "16794070-2b52-4234-b16f-76da63d75785");
define("RC_SECRET", "0x342b3762b6a922F77065248cbFE9324EabEB0f0E");

if (!defined("DVS_RECAPTCHA") && !defined("ADMIN_SECTION")) {
    \Bitrix\Main\Page\Asset::getInstance()->addString('<script src="https://hcaptcha.com/1/api.js?onload=divaCaptchaRender&render=explicit" async defer></script>', true, \Bitrix\Main\Page\AssetLocation::AFTER_JS);
    \Bitrix\Main\Page\Asset::getInstance()->addString("<script>window.rc = {}; var divaCaptchaRender = function () {
        $('.h-captcha-response').each(function() {
          window.rc[$(this).attr('id')] = grecaptcha.render( this, { 'sitekey': '" . COption::GetOptionString( "askaron.settings", "UF_RC_KEY" ) . "', 'callback': $(this).data('callback'), 'size':'invisible' } );
        });
    };</script>", true, \Bitrix\Main\Page\AssetLocation::AFTER_JS);
    define("DVS_RECAPTCHA", true);
}

class DivasoftRecaptcha extends Bitrix\Main\Engine\ActionFilter\Base {

    const ERROR_INVALID_RECAPTHCA = 'invalid_recaptcha';
    const REQUEST_VARIABLE_NAME = 'h-captcha-response';
    const URL = 'https://hcaptcha.com/siteverify';

    /**
     * @var bool
     */
    private $enabled;

    public function __construct($enabled = true) {
        $this->enabled = $enabled;
        parent::__construct();
    }

    static function check($checkWord) {
        $data = [
            'secret' => COption::GetOptionString( "askaron.settings", "UF_RC_SECRET" ),
            'response' => $checkWord
        ];
        $options = [
            'http' => [
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        $context = stream_context_create($options);
        $verify = file_get_contents(self::URL, false, $context);
        $captcha_success = json_decode($verify);
        return ($captcha_success->success == true);
    }

    public function onBeforeAction(\Bitrix\Main\Event $event) {
        $checkWord = $this->action->getController()->getRequest()->get(self::REQUEST_VARIABLE_NAME);
        if ($checkWord) {
            if (self::check($checkWord)) {
                return null;
            } else {
                $this->addError(new \Bitrix\Main\Error('Error check recaptcha, ROBOT!', self::ERROR_INVALID_RECAPTHCA));
                return new Bitrix\Main\EventResult(Bitrix\Main\EventResult::ERROR, null, null, $this);
            }
        } else {
            $this->addError(new \Bitrix\Main\Error('Empty recaptcha checkword', self::ERROR_INVALID_RECAPTHCA));
            return new Bitrix\Main\EventResult(Bitrix\Main\EventResult::ERROR, null, null, $this);
        }

        return null;
    }



}
