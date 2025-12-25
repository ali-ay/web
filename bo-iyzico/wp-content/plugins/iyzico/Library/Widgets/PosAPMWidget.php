<?php

use Iyzico\Library\Utils;

class PosAPMWidget extends \WP_Widget
{
    const WIDGET_NAME = 'PosAPMWidget';
    const WIDGET_TITLE = 'Pos Alternative Payment Methods Widget';
    const WIDGET_DESCRIPTION = ' ';

    function __construct()
    {
        parent::__construct(
            self::WIDGET_NAME, __(self::WIDGET_TITLE, 'iyzico'), array('description' => __(self::WIDGET_DESCRIPTION, 'iyzico'))
        );
    }

    public function getFields(){
        $fields = array(
            'title'  => array(
                "type"      => "input",
                "default"   => "Alternatif Ödeme Methodları",
                "label"     => "Main Title"
            ),
            'description'  => array(
                "type"      => "textarea",
                "default"   => "Yurtdışına satış yapmak için yalnızca kredi kartı ile ödeme almak zorunda değilsiniz.",
                "label"     => "Main Description"
            )
        );

        for($i=1;$i<5;$i++){
            $fields['apmLine-'.$i] = array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Apm Description Line ".$i
            );
        }
        for($i=1;$i<5;$i++){
            $fields['apmLogo-'.$i] = array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Apm Logo ".$i
            );
            $fields['apmLogoLink-'.$i] =array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Apm Logo Link ".$i
            );
        }
        return $fields;
    }

    public function widget($args, $instance)
    {
        $utils = new Utils();

        $fields = $this->getFields();
        $jsonData = array();
        $linksArray = array('apmLogoLink-1','apmLogoLink-2','apmLogoLink-3','apmLogoLink-4','apmLogoLink-5');
        foreach($fields as $fieldName=>$fieldObject) {
            $fields[$fieldName]['value'] = $instance[$fieldName];
            if (function_exists ( 'icl_translate' )){
                $fields[$fieldName]['value']    = icl_translate('Widgets', self::WIDGET_NAME.' -'.$fieldName, $instance[$fieldName]);
            }
            $jsonData[$fieldName] = $fields[$fieldName]['value'];
            if ($fieldObject['type'] == "image") {
                $jsonData[$fieldName] = $utils->generateMediaUrlObject($jsonData[$fieldName]);
            }

            if (in_array($fieldName,$linksArray)) {
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