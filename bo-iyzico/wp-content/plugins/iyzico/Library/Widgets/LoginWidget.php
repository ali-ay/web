<?php
/**
 * Created by PhpStorm.
 * User: harun.akgun
 * Date: 11.11.2015
 * Time: 17:12
 */

// Creating the widget
class LoginWidget extends \WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'LoginWidget', __('Login Widget', 'iyzico'), array('description' => __('Login form widget', 'iyzico'))
        );
    }

    public function getFields(){
        return array(
            'headlineText'      => array(
                "type"      => "textarea",
                "default"   => "iyzico Hesabınla Giriş Yap",
                "label"     => "Headline"
            ),
            'emailPlaceholder'  => array(
                "type"      => "input",
                "default"   => "E-posta Adresiniz",
                "label"     => "Email Placeholder"
            ),
            'passwordPlaceholder'      => array(
                "type"      => "input",
                "default"   => "Şifre",
                "label"     => "Şifre Placeholder"
            ),
            'loginButtonText' => array(
                "type"      => "input",
                "default"   => "Giriş Yap",
                "label"     => "Login Button text"
            ),
            'forgotPasswordText' => array(
                "type"      => "input",
                "default"   => "Şifremi Unuttum",
                "label"     => "Şifremi Unuttum Text"
            ),
            'noAccountText' => array(
                "type"      => "input",
                "default"   => "Hesabın Yok Mu?",
                "label"     => "Yeni Hesap Title"
            ),
            'registerButtonText' => array(
                "type"      => "input",
                "default"   => "KAYIT OL",
                "label"     => "Register Button text"
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

        $fields = $this->getFields();
        foreach($fields as $fieldName=>$fieldObject) {
            $fields[$fieldName]['value'] = $instance[$fieldName];
            if (function_exists ( 'icl_translate' )){
                $fields[$fieldName]['value']    = icl_translate('Widgets', 'Login Widget -'.$fieldName, $instance[$fieldName]);
            }
        }
        ?>
        <div class="homePage slideContent slide parallax_conent" data-bgsize="cover" data-per="50%" data-speed="0.5" data-bgimage="<?php echo($fields['backgroundImage']['value']); ?>">
            <div class="container">
                <div class="space35"></div>
                <a class="logo" href="/" style=".background-image:url(<?php echo(get_option('iyzico_general_settings_logo')); ?>)"></a>
                <div class="nav selectNone minimal-top-menu">
                    <?php wp_nav_menu( array( 'theme_location' => 'minimalTopMenu' ) ); ?>
                </div>
                <div class="clearfix"></div>
                <div class="space50"></div>
                <div class="loginPage">
                    <div class="loginTitle"><?php echo($fields['headlineText']['value']); ?></div>
                    <div class="loginForm">
                        <input type="text" name="username" placeholder="<?php echo($fields['emailPlaceholder']['value']); ?>" />
                        <input type="password" name="password" placeholder="<?php echo($fields['passwordPlaceholder']['value']); ?>" />
                        <button><?php echo($fields['loginButtonText']['value']); ?></button>
                        <!--<div class="returnText"><i class="successIcon"></i>Tebrikler, Hesabınıza Giriş Yapıldı.</div>
                        <div class="returnText"><i class="errorIcon"></i>Üzgünüz, Hesabına Erişiminiz Engellendi.</div>-->
                        <div class="clearfix"></div>
                        <a href="#" class="passForgot"><?php echo($fields['forgotPasswordText']['value']); ?></a>
                        <div class="noUserData"><?php echo($fields['noAccountText']['value']); ?></div>
                        <a class="registerBTN" href="/kayit-ol/"><?php echo($fields['registerButtonText']['value']); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <?php

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
                icl_register_string('Widgets', 'Login Widget -'.$fieldName, $instance[$fieldName]);
            }
        }
        return $instance;
    }

    // Register and load the widget
    public function load_widget()
    {
        register_widget('LoginWidget');
    }
}