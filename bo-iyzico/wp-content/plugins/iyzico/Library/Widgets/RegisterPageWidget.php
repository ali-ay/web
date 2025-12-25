<?php
/**
 * Created by PhpStorm.
 * User: harun.akgun
 * Date: 11.11.2015
 * Time: 17:12
 */

use Iyzico\Library\Utils;
use Iyzico\Library\Messages;

// Creating the widget
class RegisterPageWidget extends \WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'RegisterPageWidget', __('Register Page Widget', 'iyzico'), array('description' => __('The Register Form At The Register Page', 'iyzico'))
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
                "default"   => "iyzico Hesabı Oluştur",
                "label"     => "Headline"
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
                "default"   => "Hesabı Oluştur",
                "label"     => "Hesabı Oluştur text"
            ),
            'hasAccountText' => array(
                "type"      => "input",
                "default"   => "Hesabın Var Mı?",
                "label"     => "Hesabın Var Mı Title"
            ),
            'loginButtonText' => array(
                "type"      => "input",
                "default"   => "GİRİŞ YAP",
                "label"     => "Giriş Yap Button text"
            ),
            'backgroundImage' => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Fon İmajı"
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
                $fields[$fieldName]['value']    = icl_translate('Widgets', 'Register Page -'.$fieldName, $instance[$fieldName]);
            }
        }
        wp_enqueue_script( 'jquery-validate', get_template_directory_uri() . '/js/jquery.validate.min.js', array(), '1.0.0', true );
        wp_enqueue_script( 'bootstrap-notify', get_template_directory_uri() . '/js/bootstrap-notify.min.js', array(), '1.0.0', true );
        if (ICL_LANGUAGE_CODE == "tr") {
            wp_enqueue_script( 'jquery-validate-localisation', get_template_directory_uri() . '/js/localization/messages_tr.min.js', array(), '1.0.0', true );
        }
        ?>
        <div class="homePage slideContent slide parallax_conent" data-bgsize="cover" data-per="50%" data-speed="0.5" data-bgimage="<?php echo($fields['backgroundImage']['value']); ?>">
            <div class="container">
                <div class="space35"></div>
                <a class="logo" href="<?php echo icl_get_home_url(); ?>" style="background-image:url(<?php echo(get_option('iyzico_general_settings_logo')); ?>)"></a>
                <div class="nav selectNone minimal-top-menu">
                    <?php echo(iyzi_nav('minimalTopMenu','horizontal')); ?>
                    <div class="langandsocial-top">
                        <?php getLanguageSelector(); ?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="space50"></div>
                <div class="loginPage">
                    <div class="loginTitle"><?php echo($fields['headlineText']['value']); ?></div>
                    <div class="loginForm">
                        <form action="<?php echo $current_url;?>/" method="post" id="register-form">
                            <?php
                                $email = "";
                                $phone = "";
                                if (isset($_POST['email'])) $email = $_POST['email'];
                                if (isset($_POST['phone'])) $phone = $_POST['phone'];
                            ?>
                            <input type="hidden" name="csrf" value="<?php echo $toolbox->getCSRFToken(); ?>">

                            <div class="input-holder">
                                <input autocomplete="off" type="email" name="email" required placeholder="<?php echo($fields['emailPlaceholder']['value']); ?>" value="<?php $this->xecho($email) ?>"/>
                            </div>
                            <div class="input-holder">
                                <input autocomplete="off" maxlength="20" name="phone" type="tel" class="required phone valid" value="<?php $this->xecho($phone) ?>" placeholder="<?php echo($fields['phoneNumberPlaceholder']['value']); ?>">
                            </div>
                            <div class="input-holder">
                                <input id="register-password" autocomplete="off" class="required password tooltipy" title="Şifreniz en az 8 karakterden oluşmalı ve bir adet büyük, bir adet küçük harf ve bir adet rakam içermelidir." maxlength="40" name="password1" size="20" type="password" placeholder="<?php echo($fields['passwordPlaceholder']['value']); ?>"  />
                            </div>
                            <div class="input-holder">
                                <input autocomplete="off" class="required" equalto=".password" maxlength="40" name="password2" size="20" type="password" placeholder="<?php echo($fields['passwordRepeatPlaceholder']['value']); ?>" />
                            </div>
                            <input name="register-submit" value="1" />
                            <button name="register-submit-button"><?php echo($fields['registerButtonText']['value']); ?></button>

                            <div class="clearfix"></div>
                            <div class="noUserData"><?php echo($fields['hasAccountText']['value']); ?></div>
                            <a class="registerBTN" href="https://merchant.iyzipay.com/login?lang=<?php echo ICL_LANGUAGE_CODE; ?>"><?php echo($fields['loginButtonText']['value']); ?></a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $msg = new Messages();
        $successMessage = $msg->flash('success-register');
        $errorMessage = $msg->flash('error-register');
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
                    $.notify({
                        // options
                        icon: '<?php echo $icon; ?>',
                        message: '<?php echo $message; ?>'
                    },{
                        // settings
                        type: '<?php echo $type;?>',
                        placement: {
                            from: "top",
                            align: "center"
                        }
                    });
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
                                console.log(uploaded_image);
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
                icl_register_string('Widgets', 'Register Page -'.$fieldName, $instance[$fieldName]);
            }
        }
        return $instance;
    }

    // Register and load the widget
    public function load_widget()
    {
        register_widget('RegisterPageWidget');
    }
}