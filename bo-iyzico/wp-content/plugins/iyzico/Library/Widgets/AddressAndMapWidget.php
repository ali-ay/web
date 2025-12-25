<?php
/**
 * Created by PhpStorm.
 * User: harun.akgun
 * Date: 11.11.2015
 * Time: 17:12
 */
// Creating the widget
class AddressAndMapWidget extends \WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'AddressAndMapWidget', __('Contact Address and Map Widget', 'iyzico'), array('description' => __('This is the section that we list the address and show the map.', 'iyzico'))
        );
    }

    public function getFields()
    {
        return array(
            'title' => array(
                "type" => "input",
                "default" => "",
                "label" => "Başlık"
            ),
            'address' => array(
                "type" => "textarea",
                "default" => "",
                "label" => "Adres"
            ),
            'phoneLabel' => array(
                "type" => "input",
                "default" => "",
                "label" => "Telefon Etiketi"
            ),
            'phoneNumber' => array(
                "type" => "input",
                "default" => "",
                "label" => "Telefon numarası"
            ),
            'emailLabel' => array(
                "type" => "input",
                "default" => "",
                "label" => "E-posta Etiketi"
            ),
            'emailAddress' => array(
                "type" => "input",
                "default" => "",
                "label" => "E-posta Adresi"
            ),
            'webLabel' => array(
                "type" => "input",
                "default" => "",
                "label" => "Web Etiketi"
            ),
            'webAddress' => array(
                "type" => "input",
                "default" => "",
                "label" => "Web Adresi"
            ),
            'registrationLabel' => array(
                "type" => "input",
                "default" => "",
                "label" => "Ticari Sicil No Etiketi"
            ),
            'registrationNumber' => array(
                "type" => "input",
                "default" => "",
                "label" => "Ticari Sicil No"
            ),
            'taxNumberLabel' => array(
                "type" => "input",
                "default" => "",
                "label" => "Vergi No Etiketi"
            ),
            'taxNumber' => array(
                "type" => "input",
                "default" => "",
                "label" => "Vergi No"
            ),
            'mersisNoLabel' => array(
                "type" => "input",
                "default" => "",
                "label" => "Mersis No Etiketi"
            ),
            'mersisNo' => array(
                "type" => "input",
                "default" => "",
                "label" => "Mersis No"
            ),
            'mapLatitude' => array(
                "type" => "input",
                "default" => "",
                "label" => "Harita Enlem"
            ),
            'mapLongitude' => array(
                "type" => "input",
                "default" => "",
                "label" => "Harita Boylam"
            ),
            'mapFromPlaceholder' => array(
                "type" => "input",
                "default" => "",
                "label" => "Harita 'Nereden' İpucu"
            ),
            'mapDirectionsButton' => array(
                "type" => "input",
                "default" => "",
                "label" => "Harita 'Yol Tarifi' Butonu"
            ),
            'branchAdress' => array(
                "type" => "textarea",
                "default" => "",
                "label" => "Branch Adresi"
            ),

        );
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget($args, $instance)
    {

        $fields = $this->getFields();
        foreach ($fields as $fieldName => $fieldObject) {
            $fields[$fieldName]['value'] = $instance[$fieldName];
            if (function_exists('icl_translate')) {
                $fields[$fieldName]['value'] = icl_translate('Widgets', 'Contact Address and Map -' . $fieldName, $instance[$fieldName]);
            }
        }
        ?>
        <div class="container">
            <div class="space50">&nbsp;</div>
            <div class="row">
                <div class="col-md-6 col-lg-6 col-sm-12">
                    <h1 class="entry-title"><?php echo($fields['title']['value']); ?></h1>

                    <div class="space35">&nbsp;</div>
                    <p>
                        <?php echo($fields['address']['value']); ?>
                    </p>
                    <div class="space15">&nbsp;</div>
                    <div class="information-row">
                        <label><?php echo($fields['phoneLabel']['value']); ?> :</label>
                        <span><?php echo($fields['phoneNumber']['value']); ?></<span>
                    </div>
                    <div class="information-row">
                        <label><?php echo($fields['emailLabel']['value']); ?> :</label>
                        <span><?php echo($fields['emailAddress']['value']); ?></<span>
                    </div>
                    <div class="information-row">
                        <label><?php echo($fields['webLabel']['value']); ?> :</label>
                        <span><?php echo($fields['webAddress']['value']); ?></<span>
                    </div>
                    <div class="space15">&nbsp;</div>
                    <div class="information-row">
                        <label><?php echo($fields['registrationLabel']['value']); ?> :</label>
                        <span><?php echo($fields['registrationNumber']['value']); ?></<span>
                    </div>
                    <div class="information-row">
                        <label><?php echo($fields['taxNumberLabel']['value']); ?> :</label>
                        <span><?php echo($fields['taxNumber']['value']); ?></<span>
                    </div>
                    <div class="information-row">
                        <label><?php echo($fields['mersisNoLabel']['value']); ?> :</label>
                        <span><?php echo($fields['mersisNo']['value']); ?></<span>
                    </div>
                    <div class="space35">&nbsp;</div>
                    <?php echo($fields['branchAdress']['value']); ?>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-12">
                    <div class="space35">&nbsp;</div>
                    <?php echo do_shortcode('[get_map searchplaceholder="' . $fields['mapFromPlaceholder']['value'] . '" buttonlabel="' . $fields['mapDirectionsButton']['value'] . '" longitude="' . $fields['mapLongitude']['value'] . '" latitude="' . $fields['mapLatitude']['value'] . '"][/get_map]'); ?>
                </div>
            </div>
            <div class="space50">&nbsp;</div>
        </div>
    <?php

    }

    // Widget Backend
    public function form($instance)
    {

        foreach (self::getFields() as $fieldName => $fieldOptions) {

            wp_enqueue_script('jquery');
            wp_enqueue_media();

            if (isset($instance[$fieldName])) {
                $fieldValue = $instance[$fieldName];
            } else {
                $fieldValue = __($fieldOptions['default'], 'iyzico');
            } ?>

            <p>
                <label for="<?php echo $this->get_field_id($fieldName); ?>"><?php _e($fieldOptions['label']); ?></label>
                <?php if ($fieldOptions['type'] == "input") { ?>
                    <input type="text" class="widefat" id="<?php echo $this->get_field_id($fieldName); ?>"
                           name="<?php echo $this->get_field_name($fieldName); ?>" value="<?php echo $fieldValue; ?>"/>
                <?php } else if ($fieldOptions['type'] == "textarea") { ?>
                    <textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id($fieldName); ?>"
                              name="<?php echo $this->get_field_name($fieldName); ?>"><?php echo $fieldValue; ?></textarea>
                <?php } else if ($fieldOptions['type'] == "image") { ?>
                    <br/><input style="width:300px" class="<?php echo $fieldName; ?>" type="text"
                                id="<?php echo $this->get_field_id($fieldName); ?>"
                                name="<?php echo $this->get_field_name($fieldName); ?>"
                                value="<?php echo $fieldValue; ?>" class="regular-text">
                    <input type="button" name="upload-btn" id="upload-btn" class="button-secondary upload-btn"
                           value="İmaj Yükle" style="float:right" data-target="<?php echo $fieldName; ?>">
                <?php } ?>
            </p>
        <?php
        }
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        foreach (self::getFields() as $fieldName => $fieldOptions) {
            $instance[$fieldName] = (!empty($new_instance[$fieldName])) ? $new_instance[$fieldName] : '';
            if (function_exists('icl_register_string')) {
                icl_register_string('Widgets', 'Contact Address and Map -' . $fieldName, $instance[$fieldName]);
            }
        }
        return $instance;
    }

    // Register and load the widget
    public function load_widget()
    {
        register_widget('AddressAndMapWidget');
        add_filter('AddressAndMapWidget', 'do_shortcode');
    }
}