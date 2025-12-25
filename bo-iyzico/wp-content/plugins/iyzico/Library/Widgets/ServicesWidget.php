<?php
/**
 * Created by PhpStorm.
 * User: harun.akgun
 * Date: 11.11.2015
 * Time: 17:12
 */

// Creating the widget
class ServicesWidget extends \WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'ServicesWidget', __('Homepage Services Widget', 'iyzico'), array('description' => __('This is the section that we give information about our services', 'iyzico'))
        );
    }

    public function getFields(){
        return array(
            'title'      => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Başlık"
            ),
            'detailsButtonText' =>  array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Detaylar Button Yazısı"
            ),
            'compatiblityBadges' =>  array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Uyumluluk İkonları"
            ),
            /***********************/
            'firstItem_content'  => array(
                "type"      => "textarea",
                "default"   => "",
                "label"     => "İlk Madde İçeriği"
            ),
            'firstItem_icon'      => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "İlk Madde İkonu"
            ),
            'firstItem_image'      => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "İlk Madde Görseli"
            ),
            'firstItem_link'      => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "İlk Madde Bağlantısı (http:// ile başlamalı)"
            ),
            /***********************/
            'secondItem_content'  => array(
                "type"      => "textarea",
                "default"   => "",
                "label"     => "İkinci Madde İçeriği"
            ),
            'secondItem_icon'      => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "İkinci Madde İkonu"
            ),
            'secondItem_image'      => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "İkinci Madde Görseli"
            ),
            'secondItem_link'      => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "İkinci Madde Bağlantısı (http:// ile başlamalı)"
            ),
            /***********************/
            'thirdItem_content'  => array(
                "type"      => "textarea",
                "default"   => "",
                "label"     => "Üçüncü Madde İçeriği"
            ),
            'thirdItem_icon'      => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Üçüncü Madde İkonu"
            ),
            'thirdItem_image'      => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Üçüncü Madde Görseli"
            ),
            'thirdItem_link'      => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Üçüncü Madde Bağlantısı (http:// ile başlamalı)"
            ),
            /***********************/
            'forthItem_content'  => array(
                "type"      => "textarea",
                "default"   => "",
                "label"     => "Dördüncü Madde İçeriği"
            ),
            'forthItem_icon'      => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Dördüncü Madde İkonu"
            ),
            'forthItem_image'      => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Dördüncü Madde Görseli"
            ),
            'forthItem_link'      => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Dördüncü Madde Bağlantısı (http:// ile başlamalı)"
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
                $fields[$fieldName]['value']    = icl_translate('Widgets', 'Homepage Services -'.$fieldName, $instance[$fieldName]);
            }
        }
        ?>
        <div class="services">
            <div class="servicesData">
                <div class="container">
                    <div class="cTitle"><?php echo($fields['title']['value']); ?></div>
                </div>
                <div class="cont">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-5 hidden-xs hidden-sm">
                                <div class="iphoneCol">
                                    <div class="iphoneImageCol">
                                        <div class="iphone1 iphones" style="background-image: url(<?php echo($fields['firstItem_image']['value']); ?>);"></div>
                                        <div class="iphone2 iphones bottomIphone" style="background-image: url(<?php echo($fields['secondItem_image']['value']); ?>);"></div>
                                        <div class="iphone3 iphones bottomIphone" style="background-image: url(<?php echo($fields['thirdItem_image']['value']); ?>);"></div>
                                        <div class="iphone4 iphones bottomIphone" style="background-image: url(<?php echo($fields['forthItem_image']['value']); ?>);"></div>
                                    </div>
                                    <img class="iphoneCls" src="<?php echo get_template_directory_uri(); ?>/img/iphone.png" alt=""/>
                                </div>
                            </div>
                            <div class="col-lg-7 col-xs-12 services-items">
                                <ul>
                                    <li class="t1" data-related="iphone1">
                                        <a href="<?php echo($fields['firstItem_link']['value']); ?>">
                                            <i class="t1" style="background-image: url(<?php echo($fields['firstItem_icon']['value']); ?>)"></i>
                                            <?php echo($fields['firstItem_content']['value']); ?>
                                            <div class="detailBtn dt1 t2"><?php echo($fields['detailsButtonText']['value']); ?></div>
                                        </a>
                                    </li>
                                    <li class="t1" data-related="iphone2">
                                        <a href="<?php echo($fields['secondItem_link']['value']); ?>">
                                            <i class="t1" style="background-image: url(<?php echo($fields['secondItem_icon']['value']); ?>)"></i>
                                            <?php echo($fields['secondItem_content']['value']); ?>
                                            <div class="detailBtn dt1 t2"><?php echo($fields['detailsButtonText']['value']); ?></div>
                                        </a>
                                    </li>
                                    <li class="t1" data-related="iphone3">
                                        <a href="<?php echo($fields['thirdItem_link']['value']); ?>">
                                            <i class="t1" style="background-image: url(<?php echo($fields['thirdItem_icon']['value']); ?>)"></i>
                                            <?php echo($fields['thirdItem_content']['value']); ?>
                                            <div class="detailBtn dt1 t2"><?php echo($fields['detailsButtonText']['value']); ?></div>
                                        </a>
                                    </li>
                                    <li class="t1" data-related="iphone4">
                                        <a href="<?php echo($fields['forthItem_link']['value']); ?>">
                                            <i class="t1" style="background-image: url(<?php echo($fields['forthItem_icon']['value']); ?>)"></i>
                                            <?php echo($fields['forthItem_content']['value']); ?>
                                            <div class="detailBtn dt1 t2"><?php echo($fields['detailsButtonText']['value']); ?></div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7  col-xs-12 pull-right">
                            <img class="pcidds_res" src="<?php echo($fields['compatiblityBadges']['value']); ?>" alt=""/>
                        </div>
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
                icl_register_string('Widgets', 'Homepage Services -'.$fieldName, $instance[$fieldName]);
            }
        }
        return $instance;
    }

    // Register and load the widget
    public function load_widget()
    {
        register_widget('ServicesWidget');
    }
}