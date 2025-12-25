<?php
/**
 * Created by PhpStorm.
 * User: harun.akgun
 * Date: 11.11.2015
 * Time: 17:12
 */

// Creating the widget
class SinglePriceWidget extends \WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'SinglePriceWidget', __('Homepage Single Price Widget', 'iyzico'), array('description' => __('This is the Single Price Section', 'iyzico'))
        );
    }

    public function getFields(){
        return array(
            'title'      => array(
                "type"      => "input",
                "default"   => "Online satışa yeni başlıyorsanız:",
                "label"     => "Başlık"
            ),
            'singlePriceImage'   => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Ücretleri Gösteren İmaj"
            ),
            'registerButtonTitle'      => array(
                "type"      => "input",
                "default"   => "Kayıt Ol",
                "label"     => "Kayıt ol button yazısı"
            ),
            'registerButtonLink'      => array(
                "type"      => "input",
                "default"   => icl_get_home_url().'kayit-ol',
                "label"     => "Kayıt ol button linki"
            ),
            'subTitle'      => array(
                "type"      => "input",
                "default"   => "Eğer aylık 20.000 TL'den fazla satış yapıyorsanız:",
                "label"     => "Alt Başlık"
            ),
            'explanation'      => array(
                "type"      => "textarea",
                "default"   => "Size özel teklifimiz için iletişim bilgilerinizi bırakın.",
                "label"     => "Alt Başlık"
            ),
            'letUsCallYou'      => array(
                "type"      => "input",
                "default"   => "Sizi Arayalım",
                "label"     => "Sizi Arayalım button yazısı"
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
                $fields[$fieldName]['value']    = icl_translate('Widgets', 'Homepage SinglePrice -'.$fieldName, $instance[$fieldName]);
            }
        }
        ?>
        <div class="single-price-holder">
            <div class="hTitle"><?php echo($fields['title']['value']); ?></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 single-price">
                        <img src="<?php echo($fields['singlePriceImage']['value']); ?>" alt="tek fiyat!"/>
                    </div>

                    <div class="col-lg-12 single-price" style="margin-top:40px;">
                        <a class="register-link" href="<?php echo($fields['registerButtonLink']['value']); ?>"><?php echo($fields['registerButtonTitle']['value']); ?></a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="hTitle"><?php echo($fields['subTitle']['value']); ?></div>
            <div class="container">
                <p style="width: 300px;margin: 0 auto;font-size: 24px;text-align: center;margin-top: -20px;">
                    <?php echo($fields['explanation']['value']); ?>
                </p>
                <div class="col-lg-12 single-price" style="margin-top:40px;">
                    <a class="register-link" href="#" id="letUsCallyou"><?php echo($fields['letUsCallYou']['value']); ?></a>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#letUsCallyou').click(function(e){
                    e.preventDefault();
                    $('#from-single-price').val('true');
                    
                    $('html,body').animate(
                        { scrollTop: $("#call-me-section").offset().top},
                        300
                    );
                    window.setTimeout(function(){
                        $('#name-input').focus();
                    },300);
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
                icl_register_string('Widgets', 'Homepage SinglePrice -'.$fieldName, $instance[$fieldName]);
            }
        }
        return $instance;
    }

    // Register and load the widget
    public function load_widget()
    {
        register_widget('SinglePriceWidget');
    }
}