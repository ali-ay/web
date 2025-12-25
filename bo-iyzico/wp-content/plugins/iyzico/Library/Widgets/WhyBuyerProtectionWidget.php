<?php

use Iyzico\Library\Utils;

class WhyBuyerProtectionWidget extends \WP_Widget
{
    const WIDGET_NAME = 'WhyBuyerProtectionWidget';
    const WIDGET_TITLE = 'Why Buyer Protection Widget';
    const WIDGET_DESCRIPTION = ' ';

    function __construct()
    {
        parent::__construct(
            self::WIDGET_NAME, __(self::WIDGET_TITLE, 'iyzico'), array('description' => __(self::WIDGET_DESCRIPTION, 'iyzico'))
        );
    }

    public function getFields(){
        return array(
            'mainTitle'  => array(
                "type"      => "input",
                "default"   => "İnternetten Alışverişle İlgili Endişelerinizi Unutun",
                "label"     => "Main Title"
            ),            
            'mainDescription'  => array(
                "type"      => "textarea",
                "default"   => "iyzico Korumalı Alışveriş ile size %100 sorunsuz alışveriş deneyimi sunuyoruz. Tamamen ücretsiz yararlanabileceğiniz bu hizmetle; siparişinizin size ulaşmaması, ürünün açıklamasına uymaması, kırık çıkması ya da para iadesi gibi endişeler olmadan alışveriş yapabilirsiniz.",
                "label"     => "Main Description"
            ),       
            'boxOneImage'  => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Box #1 Image"
            ),
            'boxOneTitle'  => array(
                "type"      => "input",
                "default"   => "Alışveriş Öncesi",
                "label"     => "Box #1 Title"
            ),
            'boxOneDescriptionTitle'  => array(
                "type"      => "input",
                "default"   => "İnternetten Güvenli Alışveriş Nasıl Yapılır?",
                "label"     => "Box #1 Description Title"
            ),            
            'boxOneDescription'  => array(
                "type"      => "textarea",
                "default"   => "iyzico Korumalı Alışveriş'e dahil olan e-ticaret sitelerinden rahatça alışveriş yaparken paranızın tam karşılığını alırsınız. Ödemeden teslimata kadar tüm süreçte BDDK lisanslı iyzico güvencesi altındasınız.",
                "label"     => "Box #1 Description"
            ),
            'boxOneButtonText'  => array(
                "type"      => "input",
                "default"   => "iyzico Korumalı Alışveriş Sitelerine Git",
                "label"     => "Box #1 Button Text"
            ),
            'boxOneButtonUrl'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Box #1 Button Url"
            ),
            'boxTwoImage'  => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Box #2 Image"
            ),
            'boxTwoTitle'  => array(
                "type"      => "input",
                "default"   => "Alışveriş Sırası",
                "label"     => "Box #2 Title"
            ),
            'boxTwoDescriptionTitle'  => array(
                "type"      => "input",
                "default"   => "Kredi Kartım Kopyalanır mı?",
                "label"     => "Box #2 Description Title"
            ),            
            'boxTwoDescription'  => array(
                "type"      => "textarea",
                "default"   => "Yapay zeka ve machine learning kullanarak geliştirilen teknolojimiz sayesinde, kişisel verileriniz ve kart bilgileriniz iyzico güvencesinde korunur.",
                "label"     => "Box #2 Description"
            ),
            'boxTwoButtonText'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Box #2 Button Text"
            ),
            'boxTwoButtonUrl'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Box #2 Button Url"
            ),
            'boxThreeImage'  => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Box #3 Image"
            ),
            'boxThreeTitle'  => array(
                "type"      => "input",
                "default"   => "Alışveriş Sonrası",
                "label"     => "Box #3 Title"
            ),
            'boxThreeDescriptionTitle'  => array(
                "type"      => "input",
                "default"   => "Siparişim İstediğim Gibi Gelir mi?",
                "label"     => "Box #3 Description Title"
            ),
            'boxThreeDescription'  => array(
                "type"      => "textarea",
                "default"   => "<ul>
                                    <li>İstediğiniz an kargo takibi yapabilir</li>
                                    <li>7/24 canlı destek hattımıza, siparişinizle ilgili bilgi için ulaşabilir</li>
                                    <li>Ürününüzde bir hasar olması, açıklamasından farklı gelmesi gibi durumlara karşı korunur, para iadesi için yardım alabilirsiniz.</li>
                                </ul>",
                "label"     => "Box #3 Description"
            ),
            'boxThreeButtonText'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Box #3 Button Text"
            ),
            'boxThreeButtonUrl'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Box #3 Button Url"
            ),
            'boxThreeButtonUrl'  => array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Box #3 Button Url"
            ),
            'footerLogo1'  => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Footer Logo"
            ),
            'footerLogo2'  => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Footer Logo2"
            ),
            'footerLogo3'  => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Footer Logo3"
            ),
            'footerLogo4'  => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Footer Logo4"
            ),
            'footerLogo5'  => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Footer Logo5"
            ),
            'footerLogo6'  => array(
                "type"      => "image",
                "default"   => "",
                "label"     => "Footer Logo6"
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