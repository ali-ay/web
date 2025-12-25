<?php
/**
 * Created by PhpStorm.
 * User: harun.akgun
 * Date: 11.11.2015
 * Time: 17:12
 */

// Creating the widget
class PackagesWidget extends \WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'PackagesWidget', __('Homepage Packages Widget', 'iyzico'), array('description' => __('This are is the packages showcase', 'iyzico'))
        );
    }

    public function getFields(){
        $fields = array(
            'title'      => array(
                "type"      => "input",
                "default"   => "iyzi Market",
                "label"     => "Başlık"
            ),
            'secondTitle'      => array(
                "type"      => "input",
                "default"   => "iyzico’da Paket yok, Her şey size özel!",
                "label"     => "Alt Başlık"
            ),
            'description'      => array(
                "type"      => "textarea",
                "default"   => "iyizcio’da standart paketler yerine artık tamamen işletmenizin ihtiyaçlarına yönelik çözümler var.<br>Hemen İyzico Market’ten ihtiyacınız olan servisleri seçin, işinize yaramayanlara fazladan ücret ödemeyin!",
                "label"     => "Açıklama Yazısı"
            )
        );
        for($index=1;$index<4;$index++){

            $fields['item'.$index.'Title'] = array(
                "type"      => "input",
                "default"   => "",
                "label"     => " Paket ".$index." başlığı"
            );
            $fields['item'.$index.'Icon'] = array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Paket ".$index." Ikon"
            );
            $fields['item'.$index.'PrimaryColor'] = array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Paket ".$index." Ana renk"
            );
            $fields['item'.$index.'SecondaryColor'] = array(
                "type"      => "input",
                "default"   => "",
                "label"     => " Paket ".$index." Gölge rengi"
            );
            $fields['item'.$index.'Link'] = array(
                "type"      => "input",
                "default"   => "",
                "label"     => " Paket ".$index." Linki"
            );

        }

        return $fields;
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget($args, $instance)
    {

        $fields = $this->getFields();
        foreach($fields as $fieldName=>$fieldObject) {
            $fields[$fieldName]['value'] = $instance[$fieldName];
            if (function_exists ( 'icl_translate' )){
                $fields[$fieldName]['value']    = icl_translate('Widgets', 'Homepage Packages -'.$fieldName, $instance[$fieldName]);
            }
        }
        ?>
        <div class="packets">
            <div class="hTitle hTitle_mbox"><?php echo($fields['title']['value']); ?></div>
            <div class="container">
                <div class="line_45435"></div>
                <div class="row">
                    <?php for($index=1;$index<4;$index++){ ?>
                        <div class="col-lg-4 col-sm-4 col-xs-12">
                            <div class="relative m_box_content">
                                <a class="m_box" style="background-color:<?php echo($fields['item'.$index.'PrimaryColor']['value']); ?>" href="<?php echo($fields['item'.$index.'Link']['value']); ?>">
                                    <div class="mbox_image mbox_image_1 block" style="background-image:url(<?php echo($fields['item'.$index.'Icon']['value']); ?>);">
                                        <div class="centered"><?php echo($fields['item'.$index.'Title']['value']); ?></div>
                                    </div>
                                    <div class="inbox_shadow"></div>
                                </a>
                                <div class="shadow_box" style="background-color:<?php echo($fields['item'.$index.'SecondaryColor']['value']); ?>"></div>
                                <div class="mbox_shadow"></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="hTitle hTitle_mbox"><?php echo($fields['secondTitle']['value']); ?></div>
                <p class="text-center">
                    <?php echo($fields['description']['value']); ?>
                </p>
                <div class="clearfix"></div>
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
                icl_register_string('Widgets', 'Homepage Packages -'.$fieldName, $instance[$fieldName]);
            }
        }
        return $instance;
    }

    // Register and load the widget
    public function load_widget()
    {
        register_widget('PackagesWidget');
    }
}