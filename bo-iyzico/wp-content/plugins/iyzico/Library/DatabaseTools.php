<?php
/**
 * Created by PhpStorm.
 * User: HarunAkgun
 * Date: 18.12.2014
 * Time: 13:53
 */

namespace Iyzico\Library;


/**
 * Class DatabaseTools
 * @package Iyzico\Library
 */
class DatabaseTools {
    /**
     * @var bool
     */
    private $iyzicoDatabase = false;
    /**
     * @var bool
     */
    private $legacyDatabase = false;

    private $cacheSettings = false;

    private $iyziMinifyDetails = false;

    private $iyziLazyDetails = false;
    /**
     * @return bool
     */
    public function getIyzicoDatabase(){
        global $wpdb;

        if ( !$this->iyzicoDatabase )
        {
            //$this->iyzicoDatabase = new $wpdb(get_option('iyzico_dbuser'),get_option('iyzico_dbpwd'), get_option('iyzico_dbname'), get_option('iyzico_dbhost'));
            $this->iyzicoDatabase = new $wpdb(DB_USER,DB_PASSWORD, DB_NAME, DB_HOST);
            $this->iyzicoDatabase->show_errors();
        }
        return $this->iyzicoDatabase;
    }

    /**
     * @return bool
     */
    public function getLegacyDatabase(){
        global $wpdb;

        if ( !$this->legacyDatabase )
        {
            $this->legacyDatabase = new $wpdb(DB_USER,DB_PASSWORD, DB_NAME, DB_HOST);
            $this->legacyDatabase->show_errors();
        }
        return $this->legacyDatabase;
    }

    public function getCacheSettings(){
        if ( !$this->cacheSettings ) {
            $this->cacheSettings = $this->getCacheDetails();
        }
        return $this->cacheSettings;
    }
    public function getStaticServerSettings(){
        if ( !$this->staticServerSettings ) {
            $this->staticServerSettings = $this->getStaticServerDetails();
        }
        return $this->cacheSettings;
    }
    public function createTables(){
        $databaseStructure = array(
            'I13n'=>'CREATE TABLE IF NOT EXISTS `I13n` (`ID` int(16) unsigned NOT NULL AUTO_INCREMENT,`Language` varchar(5) NOT NULL,`IsDefault` tinyint(2) NOT NULL DEFAULT "0",PRIMARY KEY (`ID`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;',
            'SupportCategory'=>'CREATE TABLE IF NOT EXISTS `SupportCategory` (`ID` int(16) unsigned NOT NULL AUTO_INCREMENT,`Parent` int(16) unsigned NOT NULL,`Rank` smallint(3) NOT NULL DEFAULT "0",`Status` smallint(3) NOT NULL DEFAULT "1",PRIMARY KEY (`ID`),KEY `parent` (`Parent`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;',
            'SupportCategoryTranslation'=>'CREATE TABLE IF NOT EXISTS `SupportCategoryTranslation` (`ID` int(16) unsigned NOT NULL AUTO_INCREMENT,`CategoryId` int(16) unsigned NOT NULL,`Name` varchar(250) NOT NULL,`Slug` varchar(250) NOT NULL,`Language` varchar(5) NOT NULL,`IsDefaultLanguage` tinyint(1) NOT NULL,PRIMARY KEY (`ID`),KEY `CategoryId` (`CategoryId`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;',
            'SupportQuestion'=> 'CREATE TABLE IF NOT EXISTS `SupportQuestion` (`ID` int(16) unsigned NOT NULL AUTO_INCREMENT,`Parent` int(16) unsigned NOT NULL,`Rank` tinyint(3) NOT NULL,`Status` tinyint(2) NOT NULL,PRIMARY KEY (`ID`),KEY `Parent` (`Parent`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;',
            'SupportQuestionTranslation'=>'CREATE TABLE IF NOT EXISTS `SupportQuestionTranslation` (`ID` int(16) unsigned NOT NULL AUTO_INCREMENT,`QuestionId` int(16) unsigned NOT NULL,`Question` text NOT NULL,`Answer` text NOT NULL,`Slug` varchar(250) NOT NULL,`Language` varchar(5) NOT NULL,`IsDefaultLanguage` tinyint(2) NOT NULL DEFAULT "0",PRIMARY KEY (`ID`),KEY `QuestionId` (`QuestionId`),KEY `Language` (`Language`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;',
        );
        $I13nRows = array(
            "Truncate `I13n`",
            "INSERT INTO `I13n` (`ID`, `Language`, `IsDefault`) VALUES ('1', 'Tr', '1');",
            "INSERT INTO `I13n` (`ID`, `Language`, `IsDefault`) VALUES ('2', 'En', '0');"
        );
        $databaseReference = $this->getIyzicoDatabase();
        foreach($databaseStructure as $tableName=>$tableCreateSql) {
            $result = $databaseReference->get_results($tableCreateSql);
        }
        foreach($I13nRows as $index=>$insertSql) {
            $result = $databaseReference->get_results($insertSql);
        }
    }
    /**
     * @param $query
     * @param $dataType
     * @param bool $single
     * @param bool $forceCache
     * @param int $cacheTime
     * @param bool $cacheKey
     * @param bool $legacy
     * @return bool
     */
    public function getData($query, $dataType=ARRAY_A, $single=false, $forceCache=false, $cacheTime=0, $cacheKey=false, $legacy=false)
    {
        global $queryDebug;
        $qDebugInfo = array();

        $startProcess = explode(' ', microtime());
        $startProcess = $startProcess[1] * 1000 + round($startProcess[0] * 1000);

        $qDebugInfo['query'] = $query;
        $cacheSettings = $this->getCacheSettings();
        $from = "db";

        if ( !$cacheSettings['cache_status'] ) {
            $forceCache = false;
            $qDebugInfo['master_cache_override'] = false;
        } else {

            if ( $cacheTime == 0 ) $cacheTime = (int)$cacheSettings['cache_timeout'];

            if (!$cacheKey) {
                $cacheKey = md5($query . $cacheSettings['cache_salt']);
            } else {
                $cacheKey = $cacheKey . $cacheSettings['cache_salt'];
            }
            $qDebugInfo['master_cache_override'] = true;
            $qDebugInfo['master_cache_timeout'] = (int)$cacheSettings['cache_timeout'];
            $qDebugInfo['actual_cache_timeout'] = $cacheTime;
            $qDebugInfo['master_cache_key'] = $cacheKey;
        }

        if ( !$legacy ) {
            $databaseReference = $this->getIyzicoDatabase();
        } else {
            $databaseReference = $this->getLegacyDatabase();
        }



        if ($forceCache) {
            $cachedData = get_transient($cacheKey);

            if ($cachedData) {
                $data = $cachedData;
                $qDebugInfo['datasource'] = 'cache';
                $qDebugInfo['cache_status'] = 'Successfully Read';
                $qDebugInfo['returned_row_count'] = count($data);
            } else {
                if (!$single) {
                    $data = $databaseReference->get_results($query, $dataType);
                } else {
                    $data = $databaseReference->get_row($query, $dataType, 0);
                }
                if ($data) {
                    set_transient($cacheKey, $data, $cacheTime);
                    $qDebugInfo['datasource'] = 'db->cache';
                    $qDebugInfo['cache_status'] = 'Successfully Written';
                    $qDebugInfo['returned_row_count'] = $databaseReference->num_rows;
                }
            }
        } else {

            if (!$single) {
                $data = $databaseReference->get_results($query, $dataType);
            } else {
                $data = $databaseReference->get_row($query, $dataType, 0);
            }
            $qDebugInfo['cache_force'] = false;
            $qDebugInfo['datasource'] = 'db';
            $qDebugInfo['cache_status'] = 'Not Cached';
            $qDebugInfo['returned_row_count'] = $databaseReference->num_rows;
        }

        $endProcess = explode(' ', microtime());
        $endProcess = $endProcess[1] * 1000 + round($endProcess[0] * 1000);

        $timeDiff = $endProcess - $startProcess;

        if ($databaseReference->last_error) {
            $qDebugInfo['error'] = $databaseReference->last_error;
            $qDebugInfo['precessed_in'] = $timeDiff.' ms.';
            array_push($queryDebug,$qDebugInfo);
            return false;
        }
        $qDebugInfo['precessed_in'] = $timeDiff.' ms.';
        array_push($queryDebug,$qDebugInfo);
        return $data;
    }


    /**
     * @param $payload
     * @param $table
     * @param bool $legacy
     * @return mixed
     */
    public function putData($payload,$table, $legacy = false){
        if ( !$legacy ) {
            $databaseReference = $this->getIyzicoDatabase();
        } else {
            $databaseReference = $this->getLegacyDatabase();
        }

        $insert = $databaseReference->insert($table,$payload);
        if ($insert) {
            return $databaseReference->insert_id;
        } else {
            echo($databaseReference->last_error);
            die('Can not insert data to DB..');
        }
    }

    /**
     * @param $payload
     * @param $table
     * @param $where
     * @param bool $legacy
     * @return mixed
     */
    public function updateData($payload,$table,$where, $legacy = false){
        if ( !$legacy ) {
            $databaseReference = $this->getIyzicoDatabase();
        } else {
            $databaseReference = $this->getLegacyDatabase();
        }
        $update = $databaseReference->update($table,$payload,$where);
        if ( $update ) {
            return $update;
        } else {
            return $databaseReference->last_error;
        }

    }


    /**
     * @param $table
     * @param $where
     * @param bool $legacy
     * @return mixed
     */
    public function deleteData($table,$where, $legacy = false) {
        if ( !$legacy ) {
            $databaseReference = $this->getIyzicoDatabase();
        } else {
            $databaseReference = $this->getLegacyDatabase();
        }
        return $databaseReference->delete( $table, $where);
    }


    /**
     * @return array
     */
    public static function getConnectionDetails()
    {
        return array(
            "dbhost" => get_option('iyzico_dbhost'),
            "dbname" => get_option('iyzico_dbname'),
            "dbuser" => get_option('iyzico_dbuser'),
            "dbpwd" => get_option('iyzico_dbpwd'),
        );
    }

    /**
     * @param bool $detailsObject
     * @return array|bool
     */
    public static function setConnectionDetails($detailsObject = false)
    {
        if ( $detailsObject['dbhost'] && $detailsObject['dbname'] &&
            $detailsObject['dbuser'])
        {

            update_option('iyzico_dbhost', $detailsObject['dbhost']);
            update_option('iyzico_dbname', $detailsObject['dbname']);
            update_option('iyzico_dbuser', $detailsObject['dbuser']);
            update_option('iyzico_dbpwd', $detailsObject['dbpwd']);

            return array(
                "dbhost" 	=> $detailsObject['dbhost'],
                "dbname" 	=> $detailsObject['dbname'],
                "dbuser" 	=> $detailsObject['dbuser'],
                "dbpwd" 	=> $detailsObject['dbpwd']
            );
        } else {
            return false;
        }
    }

    /**
     * @param bool $detailsObject
     * @return array|bool
     */
    public static function setCacheDetails($detailsObject = false)
    {


        if ( isset($detailsObject['cache_status']) )
        {


            update_option('iyzico_cache_status', $detailsObject['cache_status']);
            update_option('iyzico_cache_salt', $detailsObject['cache_salt']);
            update_option('iyzico_cache_timeout', $detailsObject['cache_timeout']);


            return array(
                "cache_status" 	=> $detailsObject['cache_status'],
                "cache_salt" 	=> $detailsObject['cache_salt'],
                "cache_timeout" 	=> $detailsObject['cache_timeout']
            );
        } else {
            return false;
        }
    }

    public static function getCacheDetails()
    {
        $status     = get_option('iyzico_cache_status');
        $salt       = get_option('iyzico_cache_salt');
        $timeout    = get_option('iyzico_cache_timeout');

        if ( isset($status) && isset($salt) && isset($timeout) )
        {
            return array(
                "cache_status" => $status,
                "cache_salt" => $salt,
                "cache_timeout" => $timeout
            );
        } else {
            return array(
                "cache_status" => 0,
                "cache_salt" => '',
                "cache_timeout" => 0
            );
        }

    }

    public static function setStaticServerDetails($detailsObject = false)
    {


        if ( isset($detailsObject['iyzico_static_status']) )
        {


            update_option('iyzico_static_status', $detailsObject['iyzico_static_status']);
            update_option('static_url_media', $detailsObject['static_url_media']);
            update_option('static_url_scripts', $detailsObject['static_url_scripts']);
            update_option('static_url_css', $detailsObject['static_url_css']);


            return $detailsObject;
        } else {
            return false;
        }
    }

    public static function getStaticServerDetails()
    {
        $status     = get_option('iyzico_static_status');
        $media      = get_option('static_url_media');
        $scripts    = get_option('static_url_scripts');
        $css        = get_option('static_url_css');

        if ( isset($status) && isset($media) && isset($scripts) && isset($css) )
        {
            return array(
                "iyzico_static_status" => $status,
                "static_url_media" => $media,
                "static_url_scripts" => $scripts,
                "static_url_css" => $css
            );
        } else {
            return array(
                "iyzico_static_status" => 0,
                "static_url_media" => '',
                "static_url_scripts" => '',
                "static_url_css" => ''
            );
        }

    }

    public function setLazyloadDetails($detailsObject = false)
    {

        if ( isset($detailsObject['lazyload_status']) )
        {
            if ( !isset($detailsObject['admin_exception']) ) $detailsObject['admin_exception'] = 0;
            if ( !isset($detailsObject['preview_exception']) ) $detailsObject['preview_exception'] = 0;

            update_option('iyzico_lazyload_status', $detailsObject['lazyload_status']);
            update_option('iyzico_lazyload_admin_exception', $detailsObject['admin_exception']);
            update_option('iyzico_lazyload_preview_exception', $detailsObject['preview_exception']);

            $this->iyziLazyDetails = array(
                "lazyload_status" 	=> $detailsObject['lazyload_status'],
                "admin_exception" 	=> $detailsObject['admin_exception'],
                "preview_exception" 	=> $detailsObject['preview_exception']
            );

            return $this->iyziLazyDetails;
        } else {
            return false;
        }
    }

    public function getLazyloadDetails()
    {

        if ( !$this->iyziLazyDetails ) {
            $status     = get_option('iyzico_lazyload_status');
            $admin      = get_option('iyzico_lazyload_admin_exception');
            $preview    = get_option('iyzico_lazyload_preview_exception');

            if ( isset($status) )
            {
                $this->iyziLazyDetails = array(
                    "lazyload_status"   => $status,
                    "admin_exception" 	=> $admin,
                    "preview_exception" => $preview
                );
            } else {
                $this->iyziLazyDetails = array(
                    "lazyload_status" => 0,
                    "admin_exception" 	=> 0,
                    "preview_exception" => 0
                );
            }
        }

        return  $this->iyziLazyDetails;
    }
    public function purgeCache($all = false) {
        global $wpdb;
        if ( !$all ) {
            $time = isset($_SERVER['REQUEST_TIME']) ? (int) $_SERVER['REQUEST_TIME'] : time();
            $transient = $wpdb->get_col("SELECT option_name FROM wp_options WHERE option_name LIKE '_transient_timeout%' AND option_value < {$time}");
            for( $index = 0; $index<count($transient); $index++ ) {
                if ( isset($transient[$index]) ) {
                    $key = str_replace('_transient_timeout_','', $transient[$index]);
                    delete_transient($key);

                }
            }
        } else {
            $transient = $wpdb->get_col("SELECT option_name FROM wp_options WHERE option_name LIKE '%\_transient\_%'");
            for( $index = 0; $index<count($transient); $index++ ) {
                if ( isset($transient[$index]) ) {
                    $key = str_replace('_transient_','', $transient[$index]);
                    delete_transient($key);

                }
            }
        }
    }

    public function setMinifyDetails($detailsObject = false)
    {

        if ( isset($detailsObject['js_minify_status']) && isset($detailsObject['css_minify_status']) )
        {

            update_option('iyzico_js_minify_status', $detailsObject['js_minify_status']);
            update_option('iyzico_css_minify_status', $detailsObject['css_minify_status']);

            $this->iyziMinifyDetails = array(
                "js_minify_status" 	=> $detailsObject['js_minify_status'],
                "css_minify_status" 	=> $detailsObject['css_minify_status']
            );

            return $this->iyziMinifyDetails;
        } else {
            return false;
        }
    }

    public function getMinifyDetails()
    {

        if ( !$this->iyziMinifyDetails ) {
            $jsStatus     = get_option('iyzico_js_minify_status');
            $cssStatus     = get_option('iyzico_css_minify_status');

            if ( isset($jsStatus) && isset($cssStatus))
            {
                $this->iyziMinifyDetails = array(
                    "js_minify_status"   => $jsStatus,
                    "css_minify_status" 	=> $cssStatus
                );
            } else {
                $this->iyziMinifyDetails = array(
                    "js_minify_status"   => 0,
                    "css_minify_status" 	=> 0
                );
            }
        }
        return $this->iyziMinifyDetails;
    }
}