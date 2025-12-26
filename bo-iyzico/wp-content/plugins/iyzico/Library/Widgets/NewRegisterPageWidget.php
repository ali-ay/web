<?php
/**
 * Created by PhpStorm.
 * User: harun.akgun
 * Date: 11.10.2016
 * Time: 17:12
 */
use Iyzico\Application\Services\FrontendServices;
use Iyzico\Library\Utils;
use Iyzico\Library\Messages;

// Creating the widget
class NewRegisterPageWidget extends \WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'NewRegisterPageWidget', __('New Register Page Widget', 'iyzico'), array('description' => __('Redesigned Register Form At The Register Page', 'iyzico'))
        );
    }

    public function xssafe($data,$encoding='UTF-8'){
        return htmlspecialchars($data,ENT_QUOTES | ENT_HTML401,$encoding);
    }
    public function xecho($data){
       echo $this->xssafe($data);
    }
    public function getFields(){
        return array(
            'headlineText'      => array(
                "type"      => "textarea",
                "default"   => "Online satışa kolayca başlamak ve dünyanın her yerinden ödeme almak için ilk adımı atın.",
                "label"     => "Headline"
            ),
            'headlineSecondText'      => array(
                "type"      => "textarea",
                "default"   => "Hemen iyzico hesabı oluşturun.",
                "label"     => "Second Headline"
            ),
            'emailPlaceholder'  => array(
                "type"      => "input",
                "default"   => "E-posta Adresiniz",
                "label"     => "Email Placeholder"
            ),
            'phoneNumberPlaceholder'  => array(
                "type"      => "input",
                "default"   => "Telefon",
                "label"     => "Telefon Placeholder"
            ),
            'websitePlaceholder'  => array(
                "type"      => "input",
                "default"   => "İnternet Siteniz",
                "label"     => "İnternet Sitesi Placeholder"
            ),
            'passwordPlaceholder'      => array(
                "type"      => "input",
                "default"   => "Şifre",
                "label"     => "Şifre Placeholder"
            ),
            'passwordRepeatPlaceholder'      => array(
                "type"      => "input",
                "default"   => "Şifre Tekrarı",
                "label"     => "Şifre Tekrarı Placeholder"
            ),
            'registerButtonText' => array(
                "type"      => "input",
                "default"   => "Üyeliğimi Başlat",
                "label"     => "Üyeliğimi Başlat text"
            ),
            'loginButtonText' => array(
                "type"      => "input",
                "default"   => "Zaten üye misiniz? Giriş yapın.",
                "label"     => "Giriş Yap text"
            ),
            'subsectionHeadline'      => array(
                "type"      => "textarea",
                "default"   => "Ödeme altyapınız güvenli ellerde",
                "label"     => "Sub Section Headline"
            ),
            'subsectionText'      => array(
                "type"      => "textarea",
                "default"   => "Tüm dünyada {merchantCount} işletme, ödemelerini iyzico üzerinden alıyor. iyzico, kurulduğu günden bu yana, iş ortaklarının başarısına katkı sağlamaya devam ediyor.",
                "label"     => "Sub Section Text"
            ),
        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget($args, $instance)
    {
        $toolbox = new Utils();

        global $wp;
        $current_url = home_url( $wp->request );

        $fields = $this->getFields();
        foreach($fields as $fieldName=>$fieldObject) {
            $fields[$fieldName]['value'] = $instance[$fieldName];
            if (function_exists ( 'icl_translate' )){
                $fields[$fieldName]['value']    = icl_translate('Widgets', 'New Register Page -'.$fieldName, $instance[$fieldName]);
            }
        }
        wp_enqueue_script( 'jquery-validate', get_template_directory_uri() . '/js/jquery.validate.new.min.js', array(), '1.0.1', true );
        wp_enqueue_script( 'jquery-validate-additional', get_template_directory_uri() . '/js/jquery.validate.additional.min.js', array(), '1.0.1', true );
        wp_enqueue_script( 'bootstrap-notify', get_template_directory_uri() . '/js/bootstrap-notify.min.js', array(), '1.0.0', true );
        if (ICL_LANGUAGE_CODE == "tr") {
            wp_enqueue_script( 'jquery-validate-localisation', get_template_directory_uri() . '/js/localization/messages_tr.min.js', array(), '1.0.0', true );
        }
        $partner_logos = array(
            'zara.png',
            'massimodutti.png',
            'sahibinden.png',
            'ciceksepeti.png',
            'vivense.png',
            'decatlon.png',
            'armud.png',
            'apsiyon.png',
            'modacruz.png',
            'kapgel.png',
            'evidea.png',
            'tatilbudur.png',
            'hobium.png',
            'grupfoni.png',
            'babilcom.png',
            'derimod.png',
            'bionluk.png',
            'zebramo.png',
            'arabamcom.png',
            'zet.png',
            'grupanya.png',
            'parca-deposu.png',
            'parasut.png',
            'shopier.png',
            'bidolubaski.png',
            'dekopasaj.png',
            'fotopazar.png',
            'babymall.png',
            'group-4.png',
            'kariyernet.png'
        )
        ?>
        <style type="text/css">
            body{
                min-width:300px;
            }
            .gradient-holder{
                background-color:#22d3ce;
                background-image: linear-gradient(31deg, #22d3ce, #4ebcd1);
            }
            .new-register-page{
                width: 100%;
                min-height: 660px;
                background:url('<?php echo get_template_directory_uri()?>/img/texture.png') repeat transparent;
            }
            .new-register-page .container{
                position: relative;
            }
            .register-text-holder{
                float:left;
                width: 57%;
            }
            .register-text-holder h3{
                margin-top:40px;
                margin-bottom:10px;
                font-family: 'Open Sans', sans-serif;
                font-style: normal;
                color: #444444;
                font-size: 24px;
                font-weight: 300;
            }
            .register-text-holder h2{
                font-family: 'Open Sans', sans-serif;
                font-style: normal;
                color: #444444;
                font-size: 64px;
                font-weight: 300;
            }
            .register-form-holder{
                float:right;
                width: 34%;
                background-image: linear-gradient(to bottom, #edf8fa, #edf8fa);
                box-shadow: 0 10px 10px 0 rgba(0, 0, 0, 0.1);
                padding:40px;
                text-align: center;
                margin-bottom:40px;
            }
            .register-form-holder.extra-margin{
                margin-top: 100px !important;
                margin-bottom: 100px !important; 
            }
            .register-form-holder input{
                border-radius: 6px;
                background-color: #ffffff;
                border: solid 1px #e6e6e6;
                width:100%;
                padding-left:12px;
                padding-top:12px;
                padding-bottom:11px;
                padding-right:10px;
                margin-bottom:15px;
                font-size: 13px;
            }
            .register-form-holder input::-webkit-input-placeholder { /* Chrome/Opera/Safari */
                font-stretch: normal;
                font-family: 'Open Sans', sans-serif;
                font-style: normal;
                color: #909090;
                font-size: 13px;
                font-weight: normal;
            }
            .register-form-holder input::-moz-placeholder { /* Firefox 19+ */
                font-stretch: normal;
                font-family: 'Open Sans', sans-serif;
                font-style: normal;
                color: #909090;
                font-size: 13px;
                font-weight: normal;
            }
            .register-form-holder input:-ms-input-placeholder { /* IE 10+ */
                font-stretch: normal;
                font-family: 'Open Sans', sans-serif;
                font-style: normal;
                color: #909090;
                font-size: 13px;
                font-weight: normal;
            }
            .register-form-holder input:-moz-placeholder { /* Firefox 18- */
                font-stretch: normal;
                font-family: 'Open Sans', sans-serif;
                font-style: normal;
                color: #909090;
                font-size: 13px;
                font-weight: normal;
            }
            .register-section-holder{
                margin-top:40px;
            }
            button.start-button{
                border-radius: 100px;
                font-family: 'Open Sans', sans-serif;
                background-image: linear-gradient(279deg, #00e676, #15d477);
                box-shadow: 0 10px 10px 0 rgba(0, 0, 0, 0.1);
                letter-spacing: 0.9px;
                font-style: normal;
                text-align: center;
                color: #ffffff;
                font-size: 18px;
                font-weight: bold;
                padding-top:13px;
                padding-bottom:13px;
                width: 100%;
                margin-top:15px;
                margin-bottom:30px;
                border:none;
            }
            textarea, input { outline: none; }
            a.already-member{
                font-family: 'Open Sans', sans-serif;
                display: inline-block;
                text-align: center;
                font-style: normal;
                color: #0091ea;
                font-size: 14px;
                font-weight: normal;
            }
            .white_bg{
                padding-top:70px;
            }
            .sub-title{
                font-family: 'Open Sans', sans-serif;
                padding-bottom:17px;
                text-align: center;
                font-style: normal;
                color: #444444;
                font-size: 48px;
                font-weight: 300;
            }
            .sub-explanation{
                font-family: 'Open Sans', sans-serif;
                text-align: center;
                font-style: normal;
                line-height: 24px;
                color: #444444;
                font-size: 16px;
                font-weight: normal;
                max-width:750px;
                margin:0 auto;
                padding-bottom:70px;
            }
            .banking-logos{
                position:absolute;
                bottom:50px;
                left:20px;
            }
            .banking-logos img{
                float:left;
                margin-right: 20px;
            }
            .partner-item{
                height: 50px;
                margin-bottom:40px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .partner-logo-holder{
                padding-bottom: 30px;
            }
            .login-button{
                float:right;
                border-radius: 100px;
                background-color: #47adc1;
                box-shadow: inset 0 1px 3px 0 rgba(0, 0, 0, 0.1);
                padding:9px 23px;
                position:relative;
                top:-4px;
                font-style: normal;
                color: #ffffff;
                font-size: 14px!important;
                line-height: 1.42857143;
                font-weight: 600;
                margin-left:25px;
            }
            .login-button:hover{
                color:#fff;
                text-decoration: none;
            }
           label.error{
                margin-top: -9px;
                margin-bottom: 9px;
                color:#ff2d55;
                font-weight: 400;
                display: block
           }
           .password-field-holder{
            position: relative;
           }
           .password-field-holder .tooltiptext {
                display: none;
                font-family: 'Open Sans', sans-serif;
                width: 160px;
                text-align: center;
                padding: 10px 10px;
                border-radius: 6px;
                /* Position the tooltip text - see examples below! */
                position: absolute;
                z-index: 1;
                top: -20px;
                left: 105%;
                -webkit-backdrop-filter: blur(10px);
                backdrop-filter: blur(10px);
                background-color: rgba(38, 39, 40, 0.8);

                color: #ffffff;
                font-size: 11px;
                font-weight: normal;
            }
            .password-field-holder .tooltiptext span{
                display: block;
                text-align: left;
            }
            .password-field-holder .tooltiptext span.dashed{
                text-decoration: line-through;
            }
            .password-field-holder .tooltiptext::after {
                content: " ";
                position: absolute;
                top: 50%;
                right: 100%; /* To the left of the tooltip */
                margin-top: -5px;
                border-width: 5px;
                border-style: solid;
                border-color: transparent black transparent transparent;
            }
            .col-xs-15,
            .col-sm-15,
            .col-md-15,
            .col-lg-15 {
                position: relative;
                min-height: 1px;
                padding-right: 10px;
                padding-left: 10px;
            }
            .col-xs-15 {
                width: 20%;
                float: left;
            }
            @media (min-width: 768px) {
            .col-sm-15 {
                    width: 20%;
                    float: left;
                }
            }
            @media (min-width: 992px) {
                .col-md-15 {
                    width: 20%;
                    float: left;
                }
            }
            @media (min-width: 1200px) {
                .col-lg-15 {
                    width: 20%;
                    float: left;
                }
            }
            @media (max-width: 992px) {
                .register-text-holder{
                    float:none;
                    width: 100%;
                }
                .register-text-holder h3{
                    margin-top:40px;
                    margin-bottom:10px;
                    font-family: 'Open Sans', sans-serif;
                    text-align: center;
                    font-style: normal;
                    color: #444444;
                    font-size: 14px;
                    font-weight: normal;
                }
                .register-text-holder h2{
                    font-family: 'Open Sans', sans-serif;
                    text-align: center;
                    font-style: normal;
                    color: #444444;
                    font-size: 34px;
                    font-weight: 300;
                }
                 .register-form-holder{
                    float:none;
                    width: auto;
                    max-width: 570px;
                    min-width: 300px;
                    background-image: linear-gradient(to bottom, #edf8fa, #edf8fa);
                    box-shadow: 0 10px 10px 0 rgba(0, 0, 0, 0.1);
                    padding:40px;
                    text-align: center;
                    margin:30px auto;
                }
                .banking-logos{
                    position:initial;
                    margin:30px auto;
                    width: 310px;
                }

            }
            @media (max-width: 370px) {
                .hidden-xxs{
                    display: none;
                }
            }
            @media (max-width: 1100px){
                .password-field-holder .tooltiptext::after {
                    content: " ";
                    position: absolute;
                    top: auto; /* At the bottom of the tooltip */
                    bottom:-10px;
                    left: 50%;
                    margin-left: -5px;
                    border-width: 5px;
                    border-style: solid;
                    border-color: black transparent transparent transparent;
                }
                .password-field-holder .tooltiptext {
                    width: 160px;
                    bottom: auto;
                    left: auto;
                    right:0px; 
                    top:-90px;
                }
            }
            button:focus {outline:0;}
            .overall-error{
                margin-bottom: 9px;
                color: #ff2d55;
                font-weight: 400;
                display: block
            }
            .success-message-register{
                font-family: 'Open Sans', sans-serif;
                line-height: 24px;
                color: #46494A;
                font-size: 13px;
                font-weight: normal;
                margin-top: 20px;
            }
        </style>
        <div class="gradient-holder">
            <div class="new-register-page">
                 <div class="container">
                    <a class="logo" href="<?php echo icl_get_home_url(); ?>" style="background:url('<?php echo get_template_directory_uri()?>/img/smalllogo.png') no-repeat left center"></a>
                    <div class="nav selectNone minimal-top-menu">
                        <?php echo(iyzi_nav('minimalTopMenu','horizontal')); ?>
                        <a href="https://merchant.iyzipay.com/login?lang=<?php echo ICL_LANGUAGE_CODE; ?>" class="login-button hidden-xxs">
                              <?php echo(__("GİRİŞ YAP",'iyzico')) ?>
                        </a>
                        <div class="langandsocial-top hidden-xs">
                            <?php getLanguageSelector(); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="register-section-holder">
                        <div class="register-text-holder">
                            <h3><?php echo($fields['headlineText']['value']); ?></h3>
                            <h2><?php echo($fields['headlineSecondText']['value']); ?></h2>
                        </div>
                        <?php
                            $msg = new Messages();
                            $successMessage = $msg->flash('success-register');
                            $errorMessage = $msg->flash('error-register');
                        ?>
                        <div class="register-form-holder <?php  if ($successMessage) { ?>extra-margin<?php } ?>">
                            <?php
                            if (!$successMessage) {
                                $email = "";
                                $phone = "";
                                $website = "";
                                if (isset($_POST['email'])) $email = $_POST['email'];
                                if (isset($_POST['phone'])) $phone = $_POST['phone'];
                                if (isset($_POST['webiste'])) $website = $_POST['website'];
                                ?>
                                 <form action="<?php echo $current_url;?>/" method="post" id="register-form">
                                    <input type="hidden" name="csrf" value="<?php echo $toolbox->getCSRFToken(); ?>">
                                    <input autocomplete="off" type="email" id="email" name="email" placeholder="<?php echo($fields['emailPlaceholder']['value']); ?>" value="<?php $this->xecho($email) ?>"/>
                                    <input autocomplete="off" maxlength="20" id="phone" name="phone" type="tel" value="<?php $this->xecho($phone) ?>" placeholder="<?php echo($fields['phoneNumberPlaceholder']['value']); ?>">
                                    <input autocomplete="off" maxlength="100" id="website" name="website" type="website" value="<?php $this->xecho($website) ?>" placeholder="<?php echo($fields['websitePlaceholder']['value']); ?>">
                                    <div class="password-field-holder">
                                    <input id="register-password" class="password" id="password1" autocomplete="off" maxlength="40" name="password1" size="20" type="password" placeholder="<?php echo($fields['passwordPlaceholder']['value']); ?>"  />
                                        <div class="tooltiptext">
                                            <span class="pass-length"><?php echo(__("En az 8 karakter",'iyzico')) ?></span>
                                            <span class="pass-lower"><?php echo(__("En az 1 küçük harf",'iyzico')) ?></span>
                                            <span class="pass-upper"><?php echo(__("En az 1 büyük harf",'iyzico')) ?></span>
                                            <span class="pass-number"><?php echo(__("En az 1 rakam",'iyzico')) ?></span>
                                        </div>
                                    </div>
                                    <input autocomplete="off" class="required" id="password2" equalto=".password" maxlength="40" name="password2" size="20" type="password" placeholder="<?php echo($fields['passwordRepeatPlaceholder']['value']); ?>" />

                                    <?php if ($errorMessage) {?>
                                    <div class="overall-error">
                                        <?php echo($errorMessage); ?>
                                    </div>
                                    <?php } ?>
                                    <input name="register-submit" value="1" type="hidden"/>
                                    <button name="register-submit-button" class="start-button"><?php echo($fields['registerButtonText']['value']); ?></button>

                                    <a href="https://merchant.iyzipay.com/login?lang=<?php echo ICL_LANGUAGE_CODE; ?>" class="already-member"><?php echo($fields['loginButtonText']['value']); ?></a>
                            </form>
                            <?php } else {?>
                                <img class="check-mark" src="<?php echo get_template_directory_uri()?>/img/check.png">
                                <p class="success-message-register">
                                    <?php echo(__("Kayıt işleminiz başarıyla tamamlandı! Ödeme almaya başlayabilmeniz için eposta adresinize gönderilen link üzerinden başvuru formumuzu doldurunuz.",'iyzico')) ?>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="banking-logos">
                        <img src="<?php echo get_template_directory_uri()?>/img/bddk_new.png" />
                        <img src="<?php echo get_template_directory_uri()?>/img/ifc_new.png" />
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                 </div>
            </div>
        </div>
        <?php 
        $merchantCount = "<span style='font-weight:bold;'>".FrontendServices::getRegisteredMerchantCount()."</span>";
        $subExplanation = str_replace('{merchantCount}', $merchantCount , $fields['subsectionText']['value']);
        ?>
        <div class="white_bg">
            <div class="container">
                <h3 class="sub-title"><?php echo($fields['subsectionHeadline']['value']); ?></h3>
                <p class="sub-explanation"><?php echo($subExplanation); ?></p>
                <div class="partner-logo-holder row">
                    <?php
                        foreach ($partner_logos as $id => $value) {?>
                            <div class="col-md-15 col-sm-3 col-xs-4">
                                <div class="partner-item">
                                    <img src="<?php echo get_template_directory_uri()?>/img/partner-logos/<?php echo $value;?>">
                                </div>
                            </div>
                        <?php }
                    ?>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        $(document).ready(function(){
            $('#register-password').focus(function() {
               $('.tooltiptext').show();
            });
            $('#register-password').blur(function() {
               $('.tooltiptext').hide();
            });
            $('#register-password').keyup(function(){
                value = $(this).val();
                $('.tooltiptext').find('span').each(function(){
                    $(this).removeClass('dashed')  
                })
                var hasUpperCase = /[A-Z]/.test(value);
                var hasLowerCase = /[a-z]/.test(value);
                var hasNumbers = /\d/.test(value);

                if (hasUpperCase) $('.tooltiptext').find('.pass-upper').addClass('dashed');
                if (hasLowerCase) $('.tooltiptext').find('.pass-lower').addClass('dashed');
                if (hasNumbers) $('.tooltiptext').find('.pass-number').addClass('dashed');

                if (!(value.length < 8) ) {
                    $('.tooltiptext').find('.pass-length').addClass('dashed');
                }

            });
            $.validator.addMethod("passwordRegex", function(value, element, regexpr) {

                if (!(value.length < 8) ) {
                    var hasUpperCase = /[A-Z]/.test(value);
                    var hasLowerCase = /[a-z]/.test(value);
                    var hasNumbers = /\d/.test(value);
                    if (hasUpperCase + hasLowerCase + hasNumbers == 3) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }, "");

            $( "#register-form" ).validate({
              rules: {
                email:{
                    required:true,
                },
                phone: {
                  required: true,
                  phoneUS: true
                },
                password1: {
                    required: true,
                    passwordRegex: /[a-z]/
                },
                password2:{
                    required:true,
                }
              }
            });
        });
        </script>
        <?php
        if ($successMessage || $errorMessage) {
            $type = "danger" ;
            $icon = "glyphicon glyphicon-remove-sign";
            $message = $errorMessage;
            if ($successMessage) {

                $type="success";
                $icon = "glyphicon glyphicons-ok-sign";
                $message = $successMessage;
            }
            ?>

            <script>
                $(document).ready(function(){
                    <?php if ($type=="success") {?>
                        analytics_send('pageview','/uyelik_kaydi_basarili');
                    <?php } else { ?>
                        analytics_send('pageview','/uyelik_kaydi_basarisiz');
                    <?php }?>
                });
            </script>
        <?php }
    }

    // Widget Backend
    public function form($instance)
    {

        foreach(self::getFields() as $fieldName=>$fieldOptions) {

            wp_enqueue_script('jquery');
            wp_enqueue_media();

            if (isset($instance[$fieldName])) {
                $fieldValue = $instance[$fieldName];
            } else {
                $fieldValue = __($fieldOptions['default'], 'iyzico');
            } ?>

            <p>
                <label for="<?php echo $this->get_field_id($fieldName); ?>"><?php _e($fieldOptions['label']); ?></label>
                <?php if ($fieldOptions['type'] == "input") {?>
                    <input type="text" class="widefat" id="<?php echo $this->get_field_id($fieldName); ?>" name="<?php echo $this->get_field_name($fieldName); ?>" value="<?php echo $fieldValue; ?>"/>
                <?php } else if ($fieldOptions['type'] == "textarea") {?>
                    <textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id($fieldName); ?>" name="<?php echo $this->get_field_name($fieldName); ?>"><?php echo $fieldValue; ?></textarea>
                <?php } else if ($fieldOptions['type'] == "image"){?>
                    <br/><input style="width:300px" class="<?php echo $fieldName;?>" type="text" id="<?php echo $this->get_field_id($fieldName); ?>" name="<?php echo $this->get_field_name($fieldName); ?>" value="<?php echo $fieldValue; ?>" class="regular-text">
                    <input type="button" name="upload-btn" id="upload-btn" class="button-secondary upload-btn" value="İmaj Yükle" style="float:right" data-target="<?php echo $fieldName;?>">
                <?php }?>
            </p>
            <?php
        }?>
        <script type="text/javascript">
            if (typeof(isParallaxActivated) == "undefined") {
                isParallaxActivated = true;
                jQuery(document).ready(function($){
                    $(document).on('click','.upload-btn',function(e) {
                        var targetElement = $('.'+$(this).data('target'));
                        e.preventDefault();
                        var image = wp.media({
                            title: 'Upload Image',
                            // mutiple: true if you want to upload multiple files at once
                            multiple: false
                        }).open()
                            .on('select', function(e){
                                // This will return the selected image from the Media Uploader, the result is an object
                                var uploaded_image = image.state().get('selection').first();
                                // We convert uploaded_image to a JSON object to make accessing it easier
                                // Output to the console uploaded_image
                                var image_url = uploaded_image.toJSON().url;
                                // Let's assign the url value to the input field
                                targetElement.val(image_url);
                            });
                    });
                });
            }

        </script>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        foreach(self::getFields() as $fieldName=>$fieldOptions) {
            $instance[$fieldName] = (!empty($new_instance[$fieldName])) ? $new_instance[$fieldName] : '';
            if (function_exists ( 'icl_register_string' )){
                icl_register_string('Widgets', 'New Register Page -'.$fieldName, $instance[$fieldName]);
            }
        }
        return $instance;
    }

    // Register and load the widget
    public function load_widget()
    {
        register_widget('NewRegisterPageWidget');
    }
}