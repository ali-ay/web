<?php
/**
 * Created by PhpStorm.
 * User: harun.akgun
 * Date: 11.11.2015
 * Time: 17:12
 */

use Iyzico\Application\Services\FrontendServices;
use Iyzico\Library\Utils;
use Iyzico\Library\Messages;

// Creating the widget
class ParallaxWidget extends \WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'ParallaxWidget', __('Homepage Parallax Widget', 'iyzico'), array('description' => __('The big image and call to action on top of the homepage', 'iyzico'))
        );
    }

    public function getFields(){
        return array(
            'headlineText'      => array(
                "type"      => "textarea",
                "default"   => "Headline Text/HTML",
                "label"     => "Headline"
            ),
            'emailPlaceholder'  => array(
                "type"      => "input",
                "default"   => "E-posta Adresiniz",
                "label"     => "Email Placeholder"
            ),
            'registerText'      => array(
                "type"      => "input",
                "default"   => "KAYIT OL",
                "label"     => "Kayıt Ol Düğme yazısı"
            ),
            'backgroundImage' => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Fon İmajı"
            ),
            'badgesImage' => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Lisans Logoları"
            )
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
                $fields[$fieldName]['value']    = icl_translate('Widgets', 'Homepage Parallax -'.$fieldName, $instance[$fieldName]);
            }
        }
        ?>

        <div class="homePage slideContent slide parallax_conent" data-bgsize="cover" data-per="50%" data-speed="0.5" data-bgimage="<?php echo($fields['backgroundImage']['value']); ?>">

            <div class="container">
                <div class="space35"></div>
                <a class="logo" href="<?php echo icl_get_home_url(); ?>" style="background-image:url(<?php echo(get_option('iyzico_general_settings_logo')); ?>)"></a>
                <div class="nav selectNone minimal-top-menu">

                    <div class="langandsocial-top">

                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="slideData selectNone">
                    <?php echo($fields['headlineText']['value']); ?>
                    <div class="emailBox">
                        <button class="register-redirect-submit"><?php echo($fields['registerText']['value']); ?></button>
                        <div class="clearfix"></div>
                        <!--<div class="returnText"><i class="successIcon"></i>Teşekkürler, kaydınız başarıyla oluşturuldu.</div>-->
                    </div>
                </div>
                <div class="absoluteContainer">
                    <div class="slideBadges" style="background-image:url(<?php echo($fields['badgesImage']['value']); ?>)"></div>
                    <div class="userCountData">
                        <span><?php esc_html_e( 'Kayıtlı Üye İşyeri', 'iyzico' )?></span>
                        <div class="CountData">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal registerModal fade" id="registerModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="loginForm">
                            <form action="<?php echo site_url( '/kayit-ol/' );?>" method="post" id="register-form" novalidate="novalidate">
                                <input type="hidden" name="csrf" value="<?php echo $toolbox->getCSRFToken(); ?>">
                                <input type="hidden" name="email" id="hidden-email" value="">
                                <div class="input-holder">
                                    <input autocomplete="off" maxlength="14" name="phone" type="text" class="required phone" value="" placeholder="<?php esc_html_e( 'Telefon', 'iyzico' )?>" aria-required="true">
                                </div>
                                <div class="input-holder">
                                    <input autocomplete="off" class="required password tooltipy" title="<?php esc_html_e( 'Şifreniz en az 8 karakterden oluşmalı ve bir adet büyük, bir adet küçük harf ve bir adet rakam içermelidir.', 'iyzico' )?>" maxlength="40" name="password1" size="20" type="password" placeholder="<?php esc_html_e( 'Şifre', 'iyzico' )?>" aria-required="true" style="background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACIUlEQVQ4EX2TOYhTURSG87IMihDsjGghBhFBmHFDHLWwSqcikk4RRKJgk0KL7C8bMpWpZtIqNkEUl1ZCgs0wOo0SxiLMDApWlgOPrH7/5b2QkYwX7jvn/uc//zl3edZ4PPbNGvF4fC4ajR5VrNvt/mo0Gr1ZPOtfgWw2e9Lv9+chX7cs64CS4Oxg3o9GI7tUKv0Q5o1dAiTfCgQCLwnOkfQOu+oSLyJ2A783HA7vIPLGxX0TgVwud4HKn0nc7Pf7N6vV6oZHkkX8FPG3uMfgXC0Wi2vCg/poUKGGcagQI3k7k8mcp5slcGswGDwpl8tfwGJg3xB6Dvey8vz6oH4C3iXcFYjbwiDeo1KafafkC3NjK7iL5ESFGQEUF7Sg+ifZdDp9GnMF/KGmfBdT2HCwZ7TwtrBPC7rQaav6Iv48rqZwg+F+p8hOMBj0IbxfMdMBrW5pAVGV/ztINByENkU0t5BIJEKRSOQ3Aj+Z57iFs1R5NK3EQS6HQqF1zmQdzpFWq3W42WwOTAf1er1PF2USFlC+qxMvFAr3HcexWX+QX6lUvsKpkTyPSEXJkw6MQ4S38Ljdbi8rmM/nY+CvgNcQqdH6U/xrYK9t244jZv6ByUOSiDdIfgBZ12U6dHEHu9TpdIr8F0OP692CtzaW/a6y3y0Wx5kbFHvGuXzkgf0xhKnPzA4UTyaTB8Ph8AvcHi3fnsrZ7Wore02YViqVOrRXXPhfqP8j6MYlawoAAAAASUVORK5CYII=); background-attachment: scroll; background-position: 100% 50%; background-repeat: no-repeat;">
                                </div>
                                <div class="input-holder">
                                    <input autocomplete="off" class="required" equalto=".password" maxlength="40" name="password2" size="20" type="password" placeholder="<?php esc_html_e( 'Şifre Tekrarı', 'iyzico' )?>" aria-required="true" style="background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACIUlEQVQ4EX2TOYhTURSG87IMihDsjGghBhFBmHFDHLWwSqcikk4RRKJgk0KL7C8bMpWpZtIqNkEUl1ZCgs0wOo0SxiLMDApWlgOPrH7/5b2QkYwX7jvn/uc//zl3edZ4PPbNGvF4fC4ajR5VrNvt/mo0Gr1ZPOtfgWw2e9Lv9+chX7cs64CS4Oxg3o9GI7tUKv0Q5o1dAiTfCgQCLwnOkfQOu+oSLyJ2A783HA7vIPLGxX0TgVwud4HKn0nc7Pf7N6vV6oZHkkX8FPG3uMfgXC0Wi2vCg/poUKGGcagQI3k7k8mcp5slcGswGDwpl8tfwGJg3xB6Dvey8vz6oH4C3iXcFYjbwiDeo1KafafkC3NjK7iL5ESFGQEUF7Sg+ifZdDp9GnMF/KGmfBdT2HCwZ7TwtrBPC7rQaav6Iv48rqZwg+F+p8hOMBj0IbxfMdMBrW5pAVGV/ztINByENkU0t5BIJEKRSOQ3Aj+Z57iFs1R5NK3EQS6HQqF1zmQdzpFWq3W42WwOTAf1er1PF2USFlC+qxMvFAr3HcexWX+QX6lUvsKpkTyPSEXJkw6MQ4S38Ljdbi8rmM/nY+CvgNcQqdH6U/xrYK9t244jZv6ByUOSiDdIfgBZ12U6dHEHu9TpdIr8F0OP692CtzaW/a6y3y0Wx5kbFHvGuXzkgf0xhKnPzA4UTyaTB8Ph8AvcHi3fnsrZ7Wore02YViqVOrRXXPhfqP8j6MYlawoAAAAASUVORK5CYII=); background-attachment: scroll; background-position: 100% 50%; background-repeat: no-repeat;">
                                </div>

                                <button name="register-submit" style="margin-bottom:30px"><?php esc_html_e( 'Hesabı Oluştur', 'iyzico' )?></button>

                                <div class="clearfix"></div>
                                <div class="noUserData"><?php esc_html_e( 'Hesabın var mı?', 'iyzico' )?></div>
                                <a class="registerBTN" href="https://merchant.iyzipay.com/login?lang=<?php echo ICL_LANGUAGE_CODE; ?>"><?php esc_html_e( 'Giriş Yap', 'iyzico' )?></a>
                            </form>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <script>
        <?php
            $baseUrl = '/kayit-ol/';
            if (ICL_LANGUAGE_CODE != "tr") $baseUrl = '/en/register/';
        ?>
        $('document').ready(function(){
            var registerUrl = "<?php echo $baseUrl; ?>";
            $('.register-redirect-submit').click(function(){
                window.location.href = registerUrl;
            })
        });
        </script>
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
                icl_register_string('Widgets', 'Homepage Parallax -'.$fieldName, $instance[$fieldName]);
            }
        }
        return $instance;
    }

    // Register and load the widget
    public function load_widget()
    {
        register_widget('ParallaxWidget');
    }
}