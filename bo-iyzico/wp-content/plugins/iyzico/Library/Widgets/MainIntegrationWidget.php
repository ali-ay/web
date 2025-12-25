<?php
/**
 * Created by PhpStorm.
 * User: harun.akgun
 * Date: 11.11.2015
 * Time: 17:12
 */

use Iyzico\Library\Utils;
// Creating the widget
class MainIntegrationWidget extends \WP_Widget
{

    const WIDGET_NAME = 'MainIntegrationWidget';
    const WIDGET_TITLE = 'Main Integration Widget';
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
                "default"   => "",
                "label"     => "Başlık"
            ),
            'tabOneTitle'  => array(
                "type"      => "input",
                "default"   => "Hazır Altyapı",
                "label"     => "tab #1 Title"
            ),
            'tabOneDescription'  => array(
                "type"      => "textarea",
                "default"   => "",
                "label"     => "tab #1 Description"
            ),
            'tabOneImage'  => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "tab #1 Image"
            ),
            'tabOneLinkOneText' => array(
                "type"      => "input",
                "default"   => "İş Ortaklarımızı Gör",
                "label"     => "tab #1 Link #1 Text"
            ),
            'tabOneLinkOneUrl' => array(
                "type"      => "input",
                "default"   => "#",
                "label"     => "tab #1 Link #1 URL"
            ),
            'tabOneLinkTwoText' => array(
                "type"      => "input",
                "default"   => "Developer Sayfasına Git",
                "label"     => "tab #1 Link #2 Text"
            ),
            'tabOneLinkTwoUrl' => array(
                "type"      => "input",
                "default"   => "#",
                "label"     => "tab #1 Link #2 URL"
            ),
            'tabTwoTitle'  => array(
                "type"      => "input",
                "default"   => "Açık Kaynak",
                "label"     => "tab #2 Title"
            ),
            'tabTwoDescription'  => array(
                "type"      => "textarea",
                "default"   => "",
                "label"     => "tab #2 Description"
            ),
            'tabTwoImage'  => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "tab #2 Image"
            ),
            'tabTwoLinkOneText' => array(
                "type"      => "input",
                "default"   => "Açık Kaynaklı Altyapılar",
                "label"     => "tab #2 Link #1 Text"
            ),
            'tabTwoLinkOneUrl' => array(
                "type"      => "input",
                "default"   => "#",
                "label"     => "tab #2 Link #2 URL"
            ),
            'tabTwoLinkTwoText' => array(
                "type"      => "input",
                "default"   => "Developer Sayfasına Git",
                "label"     => "tab #2 Link #2 Text"
            ),
            'tabTwoLinkTwoUrl' => array(
                "type"      => "input",
                "default"   => "#",
                "label"     => "tab #2 Link #2 URL"
            ),
            'tabThreeTitle'  => array(
                "type"      => "input",
                "default"   => "API",
                "label"     => "tab #3 Title"
            ),
            'tabThreeDescription'  => array(
                "type"      => "textarea",
                "default"   => "",
                "label"     => "tab #3 Description"
            ),
            'tabThreeImage'  => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "tab #3 Image"
            ),
            'tabThreeLinkOneText' => array(
                "type"      => "input",
                "default"   => "Developer Sayfasına Git",
                "label"     => "tab #3 Link #1 Text"
            ),
            'tabThreeLinkOneUrl' => array(
                "type"      => "input",
                "default"   => "#",
                "label"     => "tab #3 Link #2 URL"
            ),
            'tabThreeLinkTwoText' => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "tab #3 Link #2 Text"
            ),
            'tabThreeLinkTwoUrl' => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "tab #3 Link #2 URL"
            )
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