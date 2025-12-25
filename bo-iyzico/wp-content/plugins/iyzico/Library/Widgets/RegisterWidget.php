<?php
/**
 * Created by PhpStorm.
 * User: harun.akgun
 * Date: 11.11.2015
 * Time: 17:12
 */

// Creating the widget
class RegisterWidget extends \WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'RegisterWidget', __('Homepage Register Widget', 'iyzico'), array('description' => __('The Register Form At The Bottom', 'iyzico'))
        );
    }

    public function getFields(){
        return array(
            'title'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Kayıt Formu Başlığı"
            ),
            'registerContent'  => array(
                "type"      => "textarea",
                "default"   => "",
                "label"     => "Kayıt Formu Açıklama Yazısı"
            ),
            'nameSurnamePlaceholder'      => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Ad - Soyad İpucu"
            ),
            'emailPlaceholder'      => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "E-posta İpucu"
            ),
            'telephonePlaceholder'      => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Telefon İpucu"
            ),
            'websitePlaceholder'      => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Web Sitesi İpucu"
            ),
            'sendButtonText'      => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Gönder Buttonu Yazısı"
            ),
            'newsIcons'      => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Haberler Logoları"
            ),
            'techcrunchLink'      => array(
                "type"      => "input",
                "default"   => "#",
                "label"     => "TechCrunch Link"
            ),
            'webrazziLink'      => array(
                "type"      => "input",
                "default"   => "#",
                "label"     => "TechCrunch Link"
            ),
            'turkishtimeLink'      => array(
                "type"      => "input",
                "default"   => "#",
                "label"     => "TurkishTime Link"
            ),
            'theWallStreetJournalLink'      => array(
                "type"      => "input",
                "default"   => "#",
                "label"     => "The Wall Street Journal Link"
            ),
            'chipOnlineLink'      => array(
                "type"      => "input",
                "default"   => "#",
                "label"     => "ChipOnline Link"
            ),
            'bloombergBusinessWeekLink'      => array(
                "type"      => "input",
                "default"   => "#",
                "label"     => "Bloomberg Businessweek Link"
            )
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
                $fields[$fieldName]['value']    = icl_translate('Widgets', 'Homepage Register -'.$fieldName, $instance[$fieldName]);
            }
        }
        wp_enqueue_script( 'jquery-validate', get_template_directory_uri() . '/js/jquery.validate.min.js', array(), '1.0.0', true );
        if (ICL_LANGUAGE_CODE == "tr") {
            wp_enqueue_script( 'jquery-validate-localisation', get_template_directory_uri() . '/js/localization/messages_tr.min.js', array(), '1.0.0', true );
        }
        wp_enqueue_script( 'bootstrap-notify', get_template_directory_uri() . '/js/bootstrap-notify.min.js', array(), '1.0.0', true );
        ?>

        <div class="container" id="call-me-section">
            <div class="homeRegisterForm">
                <div class="title"><?php echo($fields['title']['value']) ?></div>
                <?php echo($fields['registerContent']['value']) ?>
                <form id="call-me-form" validate="validate">
                    <input type="hidden" name="from-single-price" value="false" id="from-single-price">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <input class="name-input" id="name-input" type="text" autocomplete="off" name="name" required placeholder="<?php echo($fields['nameSurnamePlaceholder']['value']) ?>"/>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input class="email-input" type="email" class="errorFormInput" required autocomplete="off" name="email" placeholder="<?php echo($fields['emailPlaceholder']['value']) ?>"/>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input class="phone-input" type="text" required autocomplete="off" name="phone" placeholder="<?php echo($fields['telephonePlaceholder']['value']) ?>"/>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input class="website-input" type="text" required autocomplete="off" name="website" placeholder="<?php echo($fields['websitePlaceholder']['value']) ?>"/>
                        </div>
                    </div>
                    <button class="t1 call-me-submit"><?php echo($fields['sendButtonText']['value']) ?></button>
                </form>
                <div id="success" class="returnText" style="display:none;"><i class="successIcon"></i><span class="message"></span></div>
                <div id="fail" class="returnText" style="display:none;"><i class="errorIcon"></i><span class="message"></span></div>
            </div>
        </div>
        <div class="white_bg">
            <div class="container newsImg">
                <img class="blockCenter" src="<?php echo($fields['newsIcons']['value']) ?>" alt="" usemap="#Map"/>
                <map name="Map" id="Map">
                    <?php if ($fields['techcrunchLink']['value'] != "#") { ?>
                    <area alt="TechCrunch" target="_blank" href="<?php echo($fields['techcrunchLink']['value']) ?>" shape="poly" coords="0,14,87,13,84,60,3,61" />
                    <?php } ?>
                    <?php if ($fields['webrazziLink']['value'] != "#") { ?>
                    <area alt="Webrazzi" target="_blank" href="<?php echo($fields['webrazziLink']['value']) ?>" shape="poly" coords="109,19,107,54,263,59,271,18" />
                    <?php } ?>
                    <?php if ($fields['turkishtimeLink']['value'] != "#") { ?>
                    <area alt="TurkishTime" target="_blank" href="<?php echo($fields['turkishtimeLink']['value']) ?>" shape="poly" coords="291,16,291,62,427,59,424,18" />
                    <?php } ?>
                    <?php if ($fields['theWallStreetJournalLink']['value'] != "#") { ?>
                    <area alt="The Wall Street Journal" target="_blank" href="<?php echo($fields['theWallStreetJournalLink']['value']) ?>" shape="poly" coords="457,12,461,75,551,71,562,50,558,23,551,9" />
                    <?php } ?>
                    <?php if ($fields['chipOnlineLink']['value'] != "#") { ?>
                    <area alt="Chip Online" target="_blank" href="<?php echo($fields['chipOnlineLink']['value']) ?>" shape="poly" coords="587,12,587,67,704,65,702,11" />
                    <?php } ?>
                    <?php if ($fields['bloombergBusinessWeekLink']['value'] != "#") { ?>
                    <area alt="Bloomberg Businessweek" target="_blank" href="<?php echo($fields['bloombergBusinessWeekLink']['value']) ?>" shape="poly" coords="724,11,725,65,905,67,904,15" />
                    <?php } ?>
                </map>
            </div>
        </div>
        <script type="text/javascript">
            var ajaxUrl = "<?php echo admin_url('admin-ajax.php'); ?>";
            var successMessage = "<?php esc_html_e( 'Talebiniz bize ulaştı, sizi en kısa zamanda arayacağız.', 'iyzico' )?>";
            var errorMessage = "<?php esc_html_e( 'Ne yazık ki şu anda işleminizi gerçekleştiremiyoruz. Lütfen daha sonra tekrar deneyiniz.', 'iyzico' )?>";
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
                icl_register_string('Widgets', 'Homepage Register -'.$fieldName, $instance[$fieldName]);
            }
        }
        return $instance;
    }

    // Register and load the widget
    public function load_widget()
    {
        register_widget('RegisterWidget');
    }
}