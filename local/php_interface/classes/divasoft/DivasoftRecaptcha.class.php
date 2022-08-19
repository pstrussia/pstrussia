<?php

//define("RC_KEY", "6LebEsAaAAAAANWD28Yty8F7CqT3QbDNy0W0mXnw");
//define("RC_SECRET", "6LebEsAaAAAAAAcCI899wSNieagiKTlVcoL1O9i8");

if (!defined("DVS_RECAPTCHA") && !defined("ADMIN_SECTION")) {
    \Bitrix\Main\Page\Asset::getInstance()->addString('<script src="https://hcaptcha.com/1/api.js?onload=divaCaptchaRender&render=explicit" async defer></script>', true, \Bitrix\Main\Page\AssetLocation::AFTER_JS);
    \Bitrix\Main\Page\Asset::getInstance()->addString("<script>window.rc = {}; var divaCaptchaRender = function () {
         $('.h-captcha-response').each(function() {
          window.rc[$(this).attr('id')] = grecaptcha.render( this, { 'sitekey': '" .COption::GetOptionString( "askaron.settings", "UF_RC_KEY" ). "', 'callback': $(this).data('callback'), 'size':'invisible' } );
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
        $data = http_build_query([
            'secret' => COption::GetOptionString( "askaron.settings", "UF_RC_SECRET" ),
            'response' => $checkWord
        ]);      
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::URL);
        $headers[] = "Content-type: application/x-www-form-urlencoded";
        $headers[] = "Content-Length: " . strlen($data);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);
        return ($response->success == true);
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