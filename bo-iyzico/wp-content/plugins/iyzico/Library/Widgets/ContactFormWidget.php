<?php
/**
 * Created by PhpStorm.
 * User: harun.akgun
 * Date: 11.11.2015
 * Time: 17:12
 */
// Creating the widget


class ContactFormWidget extends \WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'ContactFormWidget', __('Contact Form Widget', 'iyzico'), array('description' => __('This is the section that we display the contact form.', 'iyzico'))
        );
    }

    public function getFields()
    {
        return array(
            'title' => array(
                "type" => "input",
                "default" => "",
                "label" => "Contact Form Başlığı"
            ),
            'descriptionText' => array(
                "type" => "textarea",
                "default" => "",
                "label" => "Açıklama Metni"
            ),
            'emailPlaceholder' => array(
                "type" => "input",
                "default" => "",
                "label" => "E-posta İpucu"
            ),
            'namePlaceholder' => array(
                "type" => "input",
                "default" => "",
                "label" => "Ad/Soyad İpucu"
            ),
            'messagePlaceholder' => array(
                "type" => "input",
                "default" => "",
                "label" => "Mesaj İpucu"
            ),
            'sendButtonText' => array(
                "type" => "input",
                "default" => "",
                "label" => "Gönder Butonu Yazısı"
            ),
            'backgroundColor' => array(
                "type" => "input",
                "default" => "",
                "label" => "Fon Rengi"
            ),

        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget($args, $instance)
    {

        $fields = $this->getFields();
        foreach ($fields as $fieldName => $fieldObject) {
            $fields[$fieldName]['value'] = $instance[$fieldName];
            if (function_exists('icl_translate')) {
                $fields[$fieldName]['value'] = icl_translate('Widgets', 'Contact Form -' . $fieldName, $instance[$fieldName]);
            }
        }
        wp_enqueue_script( 'jquery-validate', get_template_directory_uri() . '/js/jquery.validate.min.js', array(), '1.0.0', true );
        if (ICL_LANGUAGE_CODE == "tr") {
            wp_enqueue_script( 'jquery-validate-localisation', get_template_directory_uri() . '/js/localization/messages_tr.min.js', array(), '1.0.0', true );
        }
        wp_enqueue_script( 'bootstrap-notify', get_template_directory_uri() . '/js/bootstrap-notify.min.js', array(), '1.0.0', true );
        ?>
        <div class="contact-form" style="background-color:<?php echo($fields['backgroundColor']['value']); ?>">
            <div class="container">
                <div class="space50">&nbsp;</div>
                <h3><?php echo($fields['title']['value']); ?></h3>
                <div class="space35">&nbsp;</div>
                <p><?php echo($fields['descriptionText']['value']); ?></p>
                <div class="space15">&nbsp;</div>
                <form id="contact-form">
                    <input type="hidden" name="to" id="to" value=""/>
                    <div class="row">
                        <div class="colRow col-lg-6 col-sm-12">
                            <input id="email-input" type="email" autocomplete="off" name="email" required placeholder="<?php echo($fields['emailPlaceholder']['value']); ?>"/>
                        </div>
                        <div class="colRow col-lg-6 col-sm-12">
                            <input id="name-input" type="text" autocomplete="off" name="name" required placeholder="<?php echo($fields['namePlaceholder']['value']); ?>"/>
                        </div>
                    </div>
                    <div class="space35">&nbsp;</div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <textarea id="message-input" name="message" required placeholder="<?php echo($fields['messagePlaceholder']['value']); ?>"></textarea>
                        </div>
                        <div class="col-lg-12">
                            <button class="t1 contactSendButton"><?php echo($fields['sendButtonText']['value']); ?></button>
                        </div>
                    </div>
                </form>
                <div id="success" class="returnText" style="display:none;color:#111;"><i class="successIcon"></i><span class="message"></span></div>
                <div id="fail" class="returnText" style="display:none;color:#111;"><i class="errorIcon"></i><span class="message"></span></div>
                <div class="space100">&nbsp;</div>
            </div>
        </div>
        <script type="text/javascript">
            var ajaxUrl = "<?php echo admin_url('admin-ajax.php'); ?>";
        </script>
    <?php

    }

    // Widget Backend
    public function form($instance)
    {

        foreach (self::getFields() as $fieldName => $fieldOptions) {

            wp_enqueue_script('jquery');
            wp_enqueue_media();

            if (isset($instance[$fieldName])) {
                $fieldValue = $instance[$fieldName];
            } else {
                $fieldValue = __($fieldOptions['default'], 'iyzico');
            } ?>

            <p>
                <label for="<?php echo $this->get_field_id($fieldName); ?>"><?php _e($fieldOptions['label']); ?></label>
                <?php if ($fieldOptions['type'] == "input") { ?>
                    <input type="text" class="widefat" id="<?php echo $this->get_field_id($fieldName); ?>"
                           name="<?php echo $this->get_field_name($fieldName); ?>" value="<?php echo $fieldValue; ?>"/>
                <?php } else if ($fieldOptions['type'] == "textarea") { ?>
                    <textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id($fieldName); ?>"
                              name="<?php echo $this->get_field_name($fieldName); ?>"><?php echo $fieldValue; ?></textarea>
                <?php } else if ($fieldOptions['type'] == "image") { ?>
                    <br/><input style="width:300px" class="<?php echo $fieldName; ?>" type="text"
                                id="<?php echo $this->get_field_id($fieldName); ?>"
                                name="<?php echo $this->get_field_name($fieldName); ?>"
                                value="<?php echo $fieldValue; ?>" class="regular-text">
                    <input type="button" name="upload-btn" id="upload-btn" class="button-secondary upload-btn"
                           value="İmaj Yükle" style="float:right" data-target="<?php echo $fieldName; ?>">
                <?php } ?>
            </p>
        <?php
        }
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        foreach (self::getFields() as $fieldName => $fieldOptions) {
            $instance[$fieldName] = (!empty($new_instance[$fieldName])) ? $new_instance[$fieldName] : '';
            if (function_exists('icl_register_string')) {
                icl_register_string('Widgets', 'Contact Form -' . $fieldName, $instance[$fieldName]);
            }
        }
        return $instance;
    }

    // Register and load the widget
    public function load_widget()
    {
        register_widget('ContactFormWidget');
        add_filter('ContactFormWidget', 'do_shortcode');
    }
}