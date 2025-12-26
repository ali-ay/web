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
<div class="language_selector">
    <?php $languageData = self::getGlobalLanguages();?>
    <label for="workingLanguage"> Change Entry Language:</label>
    <select name="workingLanguage" id="workingLanguage">
        <?php
            foreach($languageData['allLanguages'] as $index=>$language) {
                ?>
                    <option value="<?=$language['Language']?>" <?php if ($language['Language'] == $languageData['currentLanguage']) { echo('selected'); }?>><?=$language['Language']?></option>
                <?php
            }
        ?>
    </select>
</div>