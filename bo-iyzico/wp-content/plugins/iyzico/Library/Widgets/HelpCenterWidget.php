<?php
/**
 * Created by PhpStorm.
 * User: harun.akgun
 * Date: 11.11.2015
 * Time: 17:12
 */

// Creating the widget
class HelpCenterWidget extends \WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'HelpCenterWidget', __('Help Center Widget', 'iyzico'), array('description' => __('Help Center Widget', 'iyzico'))
        );
    }

    public function getFields(){
        return array(
            'firstColumnParentId'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "İlk Kolon Qna Kategori Id'si"
            ),
            'firstColumnBackgroundColor'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "İlk Kolon fon rengi"
            ),
            'firstColumnTextColor'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "İlk Kolon font rengi"
            ),
            'firstColumnIcon'      => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "İlk kolon ikonu (25px)"
            ),
            'secondColumnParentId'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "İkinci Kolon Qna Kategori Id'si"
            ),
            'secondColumnBackgroundColor'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "İkinci Kolon fon rengi"
            ),
            'secondColumnTextColor'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "İkinci Kolon font rengi"
            ),
            'secondColumnIcon'      => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "İkinci kolon ikonu (25px)"
            ),

            'thirdColumnParentId'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Üçüncü Kolon Qna Kategori Id'si"
            ),
            'thirdColumnBackgroundColor'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Üçüncü Kolon fon rengi"
            ),
            'thirdColumnTextColor'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Üçüncü Kolon font rengi"
            ),
            'thirdColumnIcon'      => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Üçüncü kolon ikonu (25px)"
            ),


            'forthColumnParentId'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Dördüncü Kolon Qna Kategori Id'si"
            ),
            'forthColumnBackgroundColor'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Dördüncü Kolon fon rengi"
            ),
            'forthColumnTextColor'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Dördüncü Kolon font rengi"
            ),
            'forthColumnIcon'      => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Dördüncü kolon ikonu (25px)"
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
                $fields[$fieldName]['value']    = icl_translate('Widgets', 'Help Center -'.$fieldName, $instance[$fieldName]);
            }
        }
        //GENERATE SHORTCODE
        ob_start();
        ?>
        [help_center_row]
        [help_center_get_sub_pages parent_id="<?php echo($fields['firstColumnParentId']['value']) ?>" background_color="<?php echo($fields['firstColumnBackgroundColor']['value']) ?>" font_color="<?php echo($fields['firstColumnTextColor']['value']) ?>" icon="<?php echo($fields['firstColumnIcon']['value']) ?>" /]
        [help_center_get_sub_pages parent_id="<?php echo($fields['secondColumnParentId']['value']) ?>" background_color="<?php echo($fields['secondColumnBackgroundColor']['value']) ?>" font_color="<?php echo($fields['secondColumnTextColor']['value']) ?>" icon="<?php echo($fields['secondColumnIcon']['value']) ?>" /]
        [help_center_get_sub_pages parent_id="<?php echo($fields['thirdColumnParentId']['value']) ?>" background_color="<?php echo($fields['thirdColumnBackgroundColor']['value']) ?>" font_color="<?php echo($fields['thirdColumnTextColor']['value']) ?>" icon="<?php echo($fields['thirdColumnIcon']['value']) ?>" /]
        [help_center_get_sub_pages parent_id="<?php echo($fields['forthColumnParentId']['value']) ?>" background_color="<?php echo($fields['forthColumnBackgroundColor']['value']) ?>" font_color="<?php echo($fields['forthColumnTextColor']['value']) ?>" icon="<?php echo($fields['forthColumnIcon']['value']) ?>" /]
        [/help_center_row]
        <?php
        $shortcode = do_shortcode(ob_get_contents());
        ob_end_clean();
        echo $shortcode;

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
                icl_register_string('Widgets', 'Help Center -'.$fieldName, $instance[$fieldName]);
            }
        }
        return $instance;
    }

    // Register and load the widget
    public function load_widget()
    {
        register_widget('HelpCenterWidget');
    }
}