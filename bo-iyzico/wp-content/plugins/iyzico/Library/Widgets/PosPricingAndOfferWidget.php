<?php

class PosPricingAndOfferWidget extends \WP_Widget
{
    const WIDGET_NAME = 'PosPricingAndOfferWidget';
    const WIDGET_TITLE = 'Pos Pricing And Offer Widget';
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
                "default"   => "Ücretlendirme",
                "label"     => "Genel Başlık"
            ),
            'subTitle'  => array(
                "type"      => "input",
                "default"   => "Fiyat politikamızı aşağıda görebilirsiniz",
                "label"     => "Genel Açıklama"
            ),
            'pricingTitle'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Pricing Alanı Başlığı"
            ),
            'pricingInformation'  => array(
                "type"      => "input",
                "default"   => "%2,5 + 0,25 TL",
                "label"     => "Price Bilgisi"
            ),
            'pricingDescription'  => array(
                "type"      => "input",
                "default"   => "işlem başı komisyon<br>kurulum ve aylık ücret yok!",
                "label"     => "Price İle İlgili Kısa Bilgi"
            ),
            'pricingCallToAction' => array(
                "type"      => "input",
                "default"   => "Hemen Başla",
                "label"     => "Pricing Call To Action"
            ),
            'offerTitle' => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Offer Alanı Başlığı"
            ),
            'offerDescription' => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Offer İle İlgili Kısa Bilgi"
            ),
            'offerCallToAction' => array(
                "type"      => "input",
                "default"   => "Teklif İste",
                "label"     => "Offer Call To Action"
            ),
        );
    }

    public function widget($args, $instance)
    {

        $fields = $this->getFields();
        $jsonData = array();
        foreach($fields as $fieldName=>$fieldObject) {
            $fields[$fieldName]['value'] = $instance[$fieldName];
            if (function_exists ( 'icl_translate' )){
                $fields[$fieldName]['value']    = icl_translate('Widgets', self::WIDGET_NAME.' -'.$fieldName, $instance[$fieldName]);
            }
            $jsonData[$fieldName] = $fields[$fieldName]['value'];
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