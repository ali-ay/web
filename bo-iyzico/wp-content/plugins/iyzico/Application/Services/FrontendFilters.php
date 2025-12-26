<?php
/**
 * Created by PhpStorm.
 * User: HarunAkgun
 * Date: 18.12.2014
 * Time: 14:12
 */

namespace Iyzico\Application\Services;

use Iyzico\Library\Utils;

/**
 * Class FrontendFilters
 * @package Iyzico\Application\Services
 */
class FrontendFilters {
    public function filterSingleNewsItem($content){
        $dom = new \domDocument;
        $dom->loadHTML((mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8')));
        $dom->preserveWhiteSpace = false;
        $images = $dom->getElementsByTagName('img');

        $domElemsToRemove = array();

        foreach($images as $image) {
            $newsItemImage = $image->getAttribute('src');
            $domElemsToRemove[] = $image;
            break;
        }

        $contents = $dom->getElementsByTagName('div');
        $divInnerHtmls = "";
        foreach($contents as $divNode) {
            $divInnerHtmls .= Utils::DOMinnerHTML($divNode);
        }

        foreach($domElemsToRemove as $removeImage) {
            $removeImage->parentNode->removeChild($removeImage);
        }

        if ( $contents ) {
            return "<div class='item'><div class='inner-wrapper'><div class='bordered'><img style='width:100%' src='" . $newsItemImage . "' /><div class='inner-content'>" . $divInnerHtmls . "</div></div></div></div>";
        } else {
            return "";
        }

    }
    public function filterTeamContent($content){
        $dom = new \domDocument;
        $dom->loadHTML((mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8')));
        $dom->preserveWhiteSpace = false;
        $images = $dom->getElementsByTagName('img');
        ob_start();?>
        <div class="team-grid">
            <?php
            $iterator = 1;
            foreach ($images as $image) {
                $extra_class="";
                if ($iterator % 4 === 0) $extra_class="last_column";
                ?>
                <div class="team-item <?=$extra_class?>">
                    <a href="<?=$image->getAttribute('src')?>" rel="prettyPhoto" title="<?=$image->getAttribute('alt')?> - <?=$image->getAttribute('title')?>">
                        <img src="<?=$image->getAttribute('src')?>" />
                    </a>
                    <span class="member_name"><?=$image->getAttribute('alt')?></span><br>
                    <span class="member_title"><?=$image->getAttribute('title')?></span>
                </div>
                <?php
                $iterator++;
            } ?>
            <div class="clear"></div>
        </div>
        <?php

        return ob_get_clean();
    }
    public function filterManagementContent($content){
        $dom = new \domDocument;
        $dom->loadHTML((mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8')));
        $dom->preserveWhiteSpace = false;
        $images = $dom->getElementsByTagName('img');
        ob_start();?>
        <div class="team-grid">
            <?php
            $iterator = 1;
            foreach ($images as $image) {
                $extra_class="";
                if ($iterator % 3 === 0) $extra_class="last_column";
                ?>
                <div class="team-item <?=$extra_class?>">
                    <a href="<?=$image->getAttribute('src')?>" rel="prettyPhoto" title="<?=$image->getAttribute('alt')?> - <?=$image->getAttribute('title')?>">
                        <img src="<?=$image->getAttribute('src')?>" style="max-height: 145px;max-width:200px;"/>
                    </a>
                    <span class="member_name"><?=$image->getAttribute('alt')?></span><br>
                    <span class="member_title"><?=$image->getAttribute('title')?></span>
                </div>
                <?php
                $iterator++;
            } ?>
            <div class="one-third last_column"></div>
            <div class="clear"></div>
        </div>
        <?php

        return ob_get_clean();
    }
}