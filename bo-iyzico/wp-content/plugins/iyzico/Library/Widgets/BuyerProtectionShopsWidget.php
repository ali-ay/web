<?php

use Iyzico\Library\Utils;
class BuyerProtectionShopsWidget extends \WP_Widget
{
    const WIDGET_NAME = 'BuyerProtectionShopsWidget';
    const WIDGET_TITLE = 'Buyer Protection Shops Widget';
    const WIDGET_DESCRIPTION = ' ';

    function __construct()
    {
        parent::__construct(
            self::WIDGET_NAME, __(self::WIDGET_TITLE, 'iyzico'), array('description' => __(self::WIDGET_DESCRIPTION, 'iyzico'))
        );
    }

    public function getFields(){
        return array(
            'title'  => array(
                "type"      => "input",
                "default"   => "Korumalı Alışveriş Yapabileceğiniz E-Ticaret Siteleri",
                "label"     => "Başlık"
            ),
            'description'  => array(
                "type"      => "textarea",
                "default"   => "",
                "label"     => "İçerik"
            ),
            'buttonText'  => array(
                "type"      => "input",
                "default"   => "Satıcılar için iyzico Korumalı Alışveriş",
                "label"     => "Buton Metni"
            ),
            'buttonUrl'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Buton Url"
            ),            
        );
    }

    public function widget($args, $instance)
    {
        $utils = new Utils();

        $fields = $this->getFields();
        $jsonData = array();
        foreach($fields as $fieldName=>$fieldObject) {
            $fields[$fieldName]['value'] = $instance[$fieldName];
            if (function_exists ( 'icl_translate' )){
                $fields[$fieldName]['value']    = icl_translate('Widgets', self::WIDGET_NAME.' -'.$fieldName, $instance[$fieldName]);
            }
            $jsonData[$fieldName] = $fields[$fieldName]['value'];
            if ($fieldObject['type'] == "image") {
                $jsonData[$fieldName] = $utils->generateMediaUrlObject($jsonData[$fieldName]);
            }
        };

        //get featured references
        $args = array(
            'posts_per_page'   => 8,
            'offset'           => 0,
            'category_name'    => $fields['buyerSss']['value'],
            'orderby'          => 'meta_value',
            'order'            => 'ASC',
            'include'          => '',
            'exclude'          => '',
            'meta_key'         => '_custom_post_order',
            'meta_value'       => '',
            'post_type'        => 'post',
            'post_mime_type'   => '',
            'post_parent'      => '',
            'author'	   => '',
            'author_name'	   => '',
            'post_status'      => 'publish',
            'suppress_filters' => true
        );
        $posts_array = get_posts( $args );
        $jsonData['buyerSss'] = array();
        foreach ($posts_array as $key=>$post){
            array_push($jsonData['buyerSss'],array(
                'name'=>$post->post_title,
                'image'=>$utils->generateMediaUrlObject(wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full')[0]),
                'link'=>$post->post_content
            ));
        }
        echo(json_encode($jsonData,JSON_UNESCAPED_SLASHES));
    }

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
                            multiple: false
                        }).open()
                            .on('select', function(e){
                                var uploaded_image = image.state().get('selection').first();
                                console.log(uploaded_image);
                                var image_url = uploaded_image.toJSON().url;
                                targetElement.val(image_url);
                            });
                    });
                });
            }

        </script>
        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        foreach(self::getFields() as $fieldName=>$fieldOptions) {
            $instance[$fieldName] = (!empty($new_instance[$fieldName])) ? $new_instance[$fieldName] : '';
            if (function_exists ( 'icl_register_string' )){
                icl_register_string('Widgets', self::WIDGET_NAME.' -'.$fieldName, $instance[$fieldName]);
            }
        }
        return $instance;
    }

    public function load_widget()
    {
        register_widget(self::WIDGET_NAME);
    }
}