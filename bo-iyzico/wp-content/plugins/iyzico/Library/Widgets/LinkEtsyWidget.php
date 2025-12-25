<?php

use Iyzico\Library\Utils;

class LinkEtsyWidget extends \WP_Widget
{
    const WIDGET_NAME = 'LinkEtsyWidget';
    const WIDGET_TITLE = 'iyziLink Etsy Widget';
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
                "default"   => "Etsy İle Dünyaya Açılın",
                "label"     => "Main Title"
            ),
            'description'  => array(
                "type"      => "textarea",
                "default"   => "Dünyanın en büyük global pazar yerlerinden biri olan Etsy API ile entegrasyonumuz sayesinde, iyzico kontrol<br>panelindeki Uygulama Mağazası’nda iyziLink hesabınızı Etsy hesabınıza kolayca bağlayabilir dünyanın her yerinden<br>ödeme alabilirsiniz.",
                "label"     => "Main Description"
            ),
            'boxOneTitle'  => array(
                "type"      => "input",
                "default"   => "Başarılı Bir Satış Kanalı",
                "label"     => "Box #1 Title"
            ),
            'boxOneDescription'  => array(
                "type"      => "textarea",
                "default"   => "30 milyondan fazla alıcıya ulaşan Etsy’nin API’sini kullanarak kendinize yeni bir satış kanalı oluşturabilirsiniz.",
                "label"     => "Box #1 Description"
            ),
            'boxTwoTitle'  => array(
                "type"      => "input",
                "default"   => "Eşsiz Ürünler",
                "label"     => "Box #2 Title"
            ),
            'boxTwoDescription'  => array(
                "type"      => "textarea",
                "default"   => "Nostaljik ürünleri, el yapımı ürünleri ve bunları üretebilmek için gerekli olan malzemeleri satabilirsiniz.",
                "label"     => "Box #2 Description"
            ),
            'boxThreeTitle'  => array(
                "type"      => "input",
                "default"   => "Dünyanın Her Yerine Satış",
                "label"     => "Box #3 Title"
            ),
            'boxThreeDescription'  => array(
                "type"      => "textarea",
                "default"   => "Yabancı para birimleriyle dünyanın dört bir yanından ödeme kabul edebilirsiniz.",
                "label"     => "Box #3 Description"
            ),
            'callToAction'  => array(
                "type"      => "input",
                "default"   => "Daha fazla bilgi için destek@iyzico.com üzerinden bizimle iletişime geçebilirsiniz.",
                "label"     => "Call to Action text"
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