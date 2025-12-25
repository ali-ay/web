<?php
/**
 * Created by PhpStorm.
 * User: harun.akgun
 * Date: 11.11.2015
 * Time: 17:12
 */

// Creating the widget
class PartnersWidget extends \WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'PartnersWidget', __('Homepage Partners Widget', 'iyzico'), array('description' => __('The Partner Slider', 'iyzico'))
        );
    }

    public function getFields(){
        return array(
            'title'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Partnerlerimiz Başlığı"
            ),
            'partnerPostCategoryName'      => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Slider'ı Oluşturmak İçin Kullanılacak Kategorinin Slug'ı"
            ),
            'partnerLogos'      => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Partner Logoları"
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
                $fields[$fieldName]['value']    = icl_translate('Widgets', 'Homepage Partner -'.$fieldName, $instance[$fieldName]);
            }
        }
        $idObj = get_category_by_slug($fields['partnerPostCategoryName']['value']);
        $id = $idObj->term_id;

        $cat_posts = new WP_Query(
            "showposts=100" .
            "&cat=" . $id .
            "&orderby=date" .
            "&order=DESC"
        );


            //get_the_content();

        ?>

        <div class="partners">
            <div class="hTitle"><?php echo($fields['title']['value']) ?></div>
            <div class="owl-carousel">
                <?php
                while ( $cat_posts->have_posts() ) {
                    $cat_posts->the_post();
                    $url = wp_get_attachment_url(get_post_thumbnail_id());
                    ?>
                    <div>
                        <img src="<?php echo($url)?>" alt="" />
                        <div class="slideData">
                            <?php echo(get_the_content()) ;?>
                        </div>
                    </div>
                <?php
                }?>
            </div>
        </div>
        <?php if($fields['partnerLogos']['value'] != "") {?>
        <div class="space35"></div>
        <div class="container">
            <div class="partnerImages">
                <?php
                    $allLogos = $fields['partnerLogos']['value'];
                    if (strpos($allLogos, ',') > 0){
                        $logosArr = explode(',', $allLogos);
                    } else {
                        $logosArr = [$allLogos];
                    }

                    if (count($logosArr) > 1){
                ?>
                <div class="owl-carousel">
                    
                <?php
                        foreach ($logosArr as $key => $logo) {
                            ?>
                                <div><img src="<?php echo $logo ?>" alt="partnerler_<?php echo $key?>"/></div>
                            <?php
                        }
                    ?>
                </div>
                <?php } else {?>
                    <img src="<?php echo $logosArr[0] ?>" alt="partnerler_0"/>
                <?php }?>
            </div>
        </div>
        <div class="space35"></div>
        <?php } else { ?>
        <div class="space100"></div>
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
                icl_register_string('Widgets', 'Homepage Partner -'.$fieldName, $instance[$fieldName]);
            }
        }
        return $instance;
    }

    // Register and load the widget
    public function load_widget()
    {
        register_widget('PartnersWidget');
    }
}