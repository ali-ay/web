<?php
    if ( isset($queryDebug) && count($queryDebug) > 0 ) {
?>
        <style>
            .language_selector {
                position: absolute;
                right: 10px;
                top: 0px;
                background: #222;
                width: 210px;
                height: 37px;
                padding-left: 10px;
                padding-right: 10px;
                color: #eee;
                font: 400 13px/32px "Open Sans", sans-serif;
            }
             .language_object{
                 margin-left: 5px;
                 margin-right:5px;
             }
            .red {
                color:darkred;
            }
            .green {
                color:darkgreen;
                font-weight: bold;
            }
        </style>
        <input type="button" name="toggle_debug" id="toggle_debug" class="button" value="Show Query Debug" onclick="javascript:jQuery('.debug_box').slideToggle();">
        <div class="debug_box" style="display:none;">
            <?php
            foreach($queryDebug as $index=>$query) {?>
                <pre>
                    <?php print_r($query);?>
                </pre>
            <?php } ?>
        </div>
<?php
}
?>