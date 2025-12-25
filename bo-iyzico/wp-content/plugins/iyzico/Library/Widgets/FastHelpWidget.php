<?php
/**
 * Created by PhpStorm.
 * User: harun.akgun
 * Date: 11.11.2015
 * Time: 17:12
 */
// Creating the widget

use Iyzico\Application\Controllers\QnaController;
use Iyzico\Application\Services\DatabaseApi;

class FastHelpWidget extends \WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'FastHelpWidget', __('Contact Fast Help Widget', 'iyzico'), array('description' => __('This is the section that we list the help center articles in contact page.', 'iyzico'))
        );
    }

    public function getFields()
    {
        $fields = array(
            'title' => array(
                "type" => "input",
                "default" => "",
                "label" => "Başlık"
            ),
            'description' => array(
                "type" => "textarea",
                "default" => "",
                "label" => "Açıklama"
            ),
            'backgroundColor' => array(
                "type" => "input",
                "default" => "",
                "label" => "Fon Rengi"
            ),
            'chooseHelpCategory' => array(
                "type" => "input",
                "default" => "",
                "label" => "Yardım Kategorisi Seçin"
            )

        );
        for($index = 1;$index<7;$index++) {
            $fields['item'.$index.'Slug'] = array(
                "type"      => "input",
                "default"   => "",
                "label"     => " Hızlı yardım kategori ".$index." slug'ı (QnA) Ya da Seçim kutusunda görmek istediğiniz Yazı."
            );
            $fields['item'.$index.'ToAddress'] = array(
                "type"      => "input",
                "default"   => "",
                "label"     => "Hızlı yardım kategori ".$index." gönderi adresi (ex: bilgi,oneri,basvuru,odeme,entegrasyon,sikayet,refund)"
            );
        }
        return $fields;
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget($args, $instance)
    {

        $fields = $this->getFields();
        foreach ($fields as $fieldName => $fieldObject) {
            $fields[$fieldName]['value'] = $instance[$fieldName];
            if (function_exists('icl_translate')) {
                $fields[$fieldName]['value'] = icl_translate('Widgets', 'Contact Fast Help -' . $fieldName, $instance[$fieldName]);
            }
        }

        wp_enqueue_script( 'jquery-ui', get_template_directory_uri().'/js/jquery-ui.min.js', array(), '1', false );
        wp_enqueue_script( 'selectboxit', get_template_directory_uri().'/js/selectboxit.min.js', array(), '1', false );
        wp_enqueue_style( 'selectboxit', get_template_directory_uri().'/css/selectboxit.css', array(), '1')
        ?>
        <div class="fast-help" style="background-color:<?php echo($fields['backgroundColor']['value']); ?>">
            <div class="container">
                <div class="space50">&nbsp;</div>
                <div class="row">
                    <div class="col-lg-12">
                        <h3><?php echo($fields['title']['value']); ?></h3>

                        <div class="space35">&nbsp;</div>
                        <p>
                            <?php echo($fields['description']['value']); ?>
                        </p>
                        <div class="space15">&nbsp;</div>
                        <select name="parent-category" class="selectboxit" id="parentCategory">
                            <option value="0"><?php echo($fields['chooseHelpCategory']['value']); ?></option>
                        <?php
                        $databaseApi = new DatabaseApi();
                        for($index = 1;$index<7;$index++) {
                            if ($fields['item'.$index.'Slug']['value']) {
                                $categoryDetails = $databaseApi->getSingleCategoryDetailsBySlug($fields['item'.$index.'Slug']['value']);
                                if ($categoryDetails) { ?>
                                    <option value="<?php echo $fields['item' . $index . 'ToAddress']['value'] ?>"
                                            data-category-id="<?php echo $categoryDetails['ID'] ?>"><?php echo $categoryDetails['Name'] ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $fields['item' . $index . 'ToAddress']['value'] ?>"><?php echo $fields['item'.$index.'Slug']['value'] ?></option>
                                <?php }

                            }
                        }
                        ?>
                        </select>
                        <div class="space15">&nbsp;</div>
                        <div class="subCategoryHolder">
                            <select name="sub-category" class="selectboxit" id="subCategory"></select>
                        </div>
                        <div class="space35">&nbsp;</div>
                        <div class="questions"></div>
                        <div class="space50">&nbsp;</div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function stripslashes(str) {
                return (str + '')
                    .replace(/\\(.?)/g, function(s, n1) {
                        switch (n1) {
                            case '\\':
                                return '\\';
                            case '0':
                                return '\u0000';
                            case '':
                                return '';
                            default:
                                return n1;
                        }
                    });
            }
            var ajaxHandler = function (url, data, successHandler) {
                $.ajax({
                    url: url,
                    data: data,
                    type: "POST",
                    success: successHandler,
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.error('Ajax Response For ' + url + ' (' + xhr.status + ')');
                        console.error(thrownError);
                    }
                });
            };
           $(document).ready(function(){
               $("select").selectBoxIt({
                   showFirstOption: false,
                   showEffect: "fadeIn",
                   showEffectSpeed: 400,
                   hideEffect: "fadeOut",
                   hideEffectSpeed: 400,
                   autoWidth: false
               });
           });
           $('#parentCategory').change(function(){

               //clear the select
               $("#subCategory").data("selectBox-selectBoxIt").remove();
               $('.questions').html('');
               $("#subCategorySelectBoxIt").hide();

               if ($('#to').length > 0) {
                   $('#to').val($(this).val());
               }
               var categoryID = $(this).find(':selected').data('category-id');
               if (categoryID) {
                   ajaxHandler(
                       '/wp-admin/admin-ajax.php',
                       {
                           'action': 'qna_contact_category',
                           'parent-category': categoryID
                       },
                       function(response){
                           responseJson = JSON.parse(response);
                           $("#subCategorySelectBoxIt").show();
                           $("#subCategory").data("selectBox-selectBoxIt").add({ value: 0, text: '<?php esc_html_e( 'Alt kategori seçin', 'iyzico' )?>' });
                           $.each(responseJson.data.allCategories, function(index,subCategoryObject){
                               $("#subCategory").data("selectBox-selectBoxIt").add({ value: subCategoryObject['ID'], text: stripslashes(subCategoryObject['Name']) });
                           });
                       }
                   );

                   $('.subCategoryHolder').show();
               }

           });
            $('#subCategory').change(function(){
                subCategoryId = $(this).val();
                $('.questions').html('');
                ajaxHandler(
                    '/wp-admin/admin-ajax.php',
                    {
                        'action': 'qna_contact_questions',
                        'parent': subCategoryId
                    },
                    function(response){
                        responseJson = JSON.parse(response);
                        qNas = responseJson.data;
                        if (responseJson.success) {
                            var listHolderObject =  $('<ul class="accordion sssAccordion">');
                            $.each(qNas, function (index, qNa) {
                                listObject = $('<li>');
                                questionObject = $('<div class="accHead"><div class="icons t2"></div>'+stripslashes(qNa['Question'])+'<i class="arrow_icon"></i></div>');
                                answerObject = $('<div class="accDetail" style="display: none;">'+stripslashes(qNa['Answer'])+'</div>');
                                listObject.append([questionObject,answerObject]);
                                listHolderObject.append(listObject);
                            });
                            $('.questions').append(listHolderObject);
                        } else {
                            $('.questions').html(responseJson.message);
                        }
                    }
                );

            });
        </script>
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
                icl_register_string('Widgets', 'Contact Fast Help -' . $fieldName, $instance[$fieldName]);
            }
        }
        return $instance;
    }

    // Register and load the widget
    public function load_widget()
    {
        register_widget('FastHelpWidget');
        add_filter('FastHelpWidget', 'do_shortcode');
    }
}