<?php
/**
 * Created by PhpStorm.
 * User: HarunAkgun
 * Date: 18.12.2014
 * Time: 14:12
 */

namespace Iyzico\Application\Services;


use Iyzico\Library\DatabaseTools;
use Iyzico\Library\Utils;

/**
 * Class DatabaseApi
 * @package Iyzico\Application\Services
 */
class DatabaseApi {

    public function getAllLanguages(){
        $databaseTools = new DatabaseTools();
        return $databaseTools->getData(
            "SELECT * FROM I13n"
            ,ARRAY_A,false,true,600,'interalisationn'
        );
    }
    public function getQnASubCategoryCount($catId){
        $toolBox = new Utils();
        $databaseTools = new DatabaseTools();
        $totalSubsSql= sprintf("SELECT count(ID) as totalSubs FROM SupportCategory WHERE Parent = %d",$catId);
        $totalSubs = $databaseTools->getData( $totalSubsSql, ARRAY_A, true );
        return $totalSubs['totalSubs'];
    }
    public function getAllQuestions(){
        $allQuestionsSql = "SELECT * FROM SupportQuestionTranslation LIMIT 10000";
        $databaseTools = new DatabaseTools();
        return $databaseTools->getData( $allQuestionsSql, ARRAY_A, false );
    }
    /**
     * @param $pagination
     * @param $order
     * @param $parent
     * @return array|bool|mixed|string
     */
    public function getCategories($pagination = false, $order = false, $parent = false, $isFrontend = false, $language='tr')
    {
        $toolBox = new Utils();
        $databaseTools = new DatabaseTools();

        $whereSentence = "1 = 1";
        if ( $parent !== false ) $whereSentence = sprintf("c.Parent = %d",$parent);

        $totalRecordsSql = "SELECT count(ID) as totalItems FROM SupportCategory";
        if ( $parent !== false ) $totalRecordsSql = sprintf("SELECT count(ID) as totalItems FROM SupportCategory WHERE Parent = %d",$parent);

        $totalRecords = $databaseTools->getData( $totalRecordsSql, ARRAY_A, true );

        if (!$isFrontend) {
            $language = $toolBox->getCurrentLanguage(false);
        }

        if ( $pagination ) {
            if ( !isset($order['order']) ) $order['order'] = "ASC";
            if ( !isset($pagination['currentPage']) ) $pagination['currentPage'] = 1;

            $sql =  sprintf(
                "SELECT
                    c.ID,
                    IFNULL(ctr.Name, dctr.Name) as Name,
                    IFNULL(IFNULL(ptr.Name, dptr.Name),'N/A') as ParentName,
                    IFNULL(p.id,'0') AS ParentId,
                    c.Parent,
                    c.Rank,
                    ( SELECT
                        GROUP_CONCAT(language)
                      FROM
                        SupportCategoryTranslation
                      WHERE
                        CategoryId=c.id
                    ) as AvailableLanguages
                FROM
                    SupportCategory c
                LEFT JOIN
                    SupportCategory p ON c.Parent = p.ID
                LEFT OUTER JOIN
                    SupportCategoryTranslation ctr ON c.ID = ctr.CategoryId AND ctr.Language = '%s'
                LEFT OUTER JOIN
                    SupportCategoryTranslation dctr ON c.ID = dctr.CategoryId AND dctr.IsDefaultLanguage = 1
                LEFT OUTER JOIN
                    SupportCategoryTranslation ptr ON p.ID = ptr.CategoryId AND ptr.Language = '%s'
                LEFT OUTER JOIN
                    SupportCategoryTranslation dptr ON p.ID = dptr.CategoryId AND dptr.IsDefaultLanguage = 1
                WHERE
                    %s
                GROUP BY
                    c.ID
                ORDER BY
                    %s
                    %s
                LIMIT
                    %d,%d"
                , $language
                , $language
                , $whereSentence
                , $order['orderBy']
                , $order['order']
                , ($pagination['currentPage']-1)*$pagination['itemsPerPage']
                , $pagination['itemsPerPage']
            );

        } else {
            $sql = sprintf(
                    "SELECT
                        c.ID,
                        c.Parent,
                        IFNULL(ctr.Slug, dctr.Slug) as Slug,
                        IFNULL(ctr.Name, dctr.Name) as Name
                    FROM
                        SupportCategory c
                    LEFT OUTER JOIN
                        SupportCategoryTranslation ctr ON c.ID = ctr.CategoryId AND ctr.Language = '%s'
                    LEFT OUTER JOIN
                        SupportCategoryTranslation dctr ON c.ID = dctr.CategoryId AND dctr.IsDefaultLanguage = 1
                    WHERE
                        %s
                    "
                    ,$language
                    ,$whereSentence
            );
            if ($order) {
                if ( !isset($order['order']) ) $order['order'] = "ASC";
                $orderSentence = sprintf(' ORDER BY %s %s',$order['orderBy'],$order['order']);
                $sql .= $orderSentence;
            }
        }
        return array(
            "allCategories" => $databaseTools->getData($sql,ARRAY_A,false,false),
            "totalItems" => $totalRecords['totalItems']
        );

    }
    /**
     * @param $categoryId
     * @return array|bool|mixed|string
     */
    public function getSingleCategory($categoryId)
    {
        $databaseTools = new DatabaseTools();
        return $databaseTools->getData(
            sprintf(
                "SELECT
                    *
                FROM
                    SupportCategory
                WHERE
                    ID = %d"
                ,$categoryId
            ),ARRAY_A,true
        );
    }
    /**
     * @param $slug
     * @return array|bool|mixed|string
     */
    public function getSingleCategoryBySlug($slug)
    {
        $databaseTools = new DatabaseTools();
        $sql =  sprintf(
            "SELECT
                    CategoryId
                FROM
                    SupportCategoryTranslation
                WHERE
                    Slug = '%s'
                "
            , $slug
        );
        $foundRow = $databaseTools->getData($sql,ARRAY_A,true);

        if ($foundRow) {
            return $foundRow;
        } else {
            return false;
        }

    }
    /**
     * @param id
     * @return array|bool|mixed|string
     */
    public function getSingleCategoryDetailsBySlug($slug)
    {
        $databaseTools = new DatabaseTools();
        $toolBox = new Utils();
        $categoryId = $this->getSingleCategoryBySlug($slug);
        $sql = sprintf(
            "SELECT
                c.ID,
                c.Parent,
                IFNULL(ctr.Name, dctr.Name) as Name
            FROM
                SupportCategory c
            LEFT OUTER JOIN
                SupportCategoryTranslation ctr ON c.ID = ctr.CategoryId AND ctr.Language = '%s'
            LEFT OUTER JOIN
                SupportCategoryTranslation dctr ON c.ID = dctr.CategoryId AND dctr.IsDefaultLanguage = 1
            WHERE
                c.ID = '%d'"
            ,$toolBox->getCurrentLanguage(true)
            ,$categoryId['CategoryId']
        );
        $foundRow = $databaseTools->getData($sql,ARRAY_A,true);


        if ($foundRow) {
            return $foundRow;
        } else {
            return false;
        }

    }
    public function getQuestionsByCategorySlug($categorySlug) {
        $parentID = self::getSingleCategoryBySlug($categorySlug);
        if ( $parentID['CategoryId'] ) {
            $currentLanguage = icl_get_current_language();
            $databaseTools = new DatabaseTools();

            $sql = sprintf("
                SELECT
                    q.ID,
                    IFNULL(qtr.Question,dqtr.Question) as Question,
                    IFNULL(qtr.Answer,dqtr.Answer) as Answer
                FROM
                    SupportQuestion q
                LEFT JOIN
                    SupportCategory p ON q.Parent = p.ID
                LEFT OUTER JOIN
                    SupportQuestionTranslation qtr ON q.ID = qtr.QuestionId AND qtr.Language = '%s'
                LEFT OUTER JOIN
                    SupportQuestionTranslation dqtr ON q.ID = dqtr.QuestionId AND qtr.IsDefaultLanguage = 1
                WHERE
                    q.Parent = '%d'
                GROUP BY
                    q.ID
                ORDER BY
                  q.Rank ASC
                "
                , $currentLanguage
                , $parentID['CategoryId']
            );
            $allQuestions = $databaseTools->getData($sql,ARRAY_A,false);
            return $allQuestions;
        } else {
            return false;
        }

    }
    public function getAllSubCategoriesOfCategoryById($categoryId) {
        $toolBox = new Utils();
        $databaseTools = new DatabaseTools();

        $sql = sprintf(
            "SELECT
                    c.ID,
                    c.Parent
                FROM
                    SupportCategory c
                WHERE
                    c.Parent = '%d'  
                "
            ,$categoryId
        );

        return $databaseTools->getData($sql,ARRAY_A,false,false);
    }
    public function getQuestionsByCategoryId($parentID,$language=false) {
        if ( $parentID ) {
            $currentLanguage = icl_get_current_language();
            if ($language) $currentLanguage = $language;
            $databaseTools = new DatabaseTools();

            $sql = sprintf("
                SELECT
                    q.ID,
                    IFNULL(qtr.Question,dqtr.Question) as Question,
                    IFNULL(qtr.Answer,dqtr.Answer) as Answer
                FROM
                    SupportQuestion q
                LEFT JOIN
                    SupportCategory p ON q.Parent = p.ID
                LEFT OUTER JOIN
                    SupportQuestionTranslation qtr ON q.ID = qtr.QuestionId AND qtr.Language = '%s'
                LEFT OUTER JOIN
                    SupportQuestionTranslation dqtr ON q.ID = dqtr.QuestionId AND qtr.IsDefaultLanguage = 1
                WHERE
                    q.Parent = '%d'
                GROUP BY
                    q.ID
                ORDER BY
                  q.Rank ASC
                "
                , $currentLanguage
                , $parentID
            );
            $allQuestions = $databaseTools->getData($sql,ARRAY_A,false);
            return $allQuestions;
        } else {
            return false;
        }

    }
    /**
     * @param $categoryId
     * @return bool
     */
    public function deleteCategory($categoryId){
        $databaseTools = new DatabaseTools();
        $subCategories = $databaseTools->getData(
            sprintf(
                "SELECT
                    ID
                FROM
                    SupportCategory
                WHERE
                    Parent = %d",
                $categoryId
            ),ARRAY_A,false,false
        );
        if ( count($subCategories) ) {
            foreach($subCategories as $category) {

                $databaseTools->updateData(
                    array(
                        'Parent' => 0
                    ),
                    'SupportCategory',
                    array(
                        'ID' => $category['ID']
                    )
                );
            }
        }

        //DELETE ALL TRANSLATIONS
        $databaseTools->deleteData(
            'SupportCategoryTranslation',
            array(
                'CategoryId' => $categoryId
            )
        );

        return $databaseTools->deleteData(
            'SupportCategory',
            array(
                'ID' => $categoryId
            )
        );

    }
    public function getCategoryTranslation($itemId,$language,$getDefault = false) {
        $databaseTools = new DatabaseTools();

        if ( $getDefault ) {
            $sql = sprintf("
                SELECT
                    *
                FROM
                    SupportCategoryTranslation
                WHERE
                    CategoryId = %d AND
                    IsDefaultLanguage = 1
                LIMIT 1
                "
                ,$itemId

            );
        } else {
            $sql = sprintf("
                SELECT
                    *
                FROM
                    SupportCategoryTranslation
                WHERE
                    CategoryId = %d AND
                    Language = '%s'
                LIMIT 1
                "
                ,$itemId
                ,$language

            );
        }

        return $databaseTools->getData(
            $sql,ARRAY_A,true
        );
    }
    public function getQnAs($pagination = false, $order = false, $parent = false)
    {
        $toolBox = new Utils();
        $databaseTools = new DatabaseTools();

        $whereSentence = "1 = 1";
        if ( $parent ) $whereSentence = sprintf("q.Parent = %d",$parent);

        $totalRecordsSql = "SELECT count(ID) as totalItems FROM SupportQuestion";
        if ( $parent ) $totalRecordsSql = sprintf("SELECT count(ID) as totalItems FROM SupportQuestion WHERE Parent = %d",$parent);


        $totalRecords = $databaseTools->getData( $totalRecordsSql,ARRAY_A,true );

        if ( $pagination ) {
            if ( !isset($order['order']) ) $order['order'] = "ASC";
            if ( !isset($pagination['currentPage']) ) $pagination['currentPage'] = 1;

            $sql =  sprintf(
                "SELECT
                    q.ID,
                    IFNULL(qtr.Question,dqtr.Question) as Question,
                    IFNULL(qtr.Answer,dqtr.Answer) as Answer,
                    IFNULL(IFNULL(ptr.Name, dptr.Name),'N/A') as ParentName,
                    IFNULL(p.ID,'0') AS ParentId,
                    q.Parent,
                    q.Rank,
                    ( SELECT
                        GROUP_CONCAT(language)
                      FROM
                        SupportQuestionTranslation
                      WHERE
                        QuestionId=q.ID
                    ) as AvailableLanguages
                FROM
                    SupportQuestion q
                LEFT JOIN
                    SupportCategory p ON q.Parent = p.ID
                LEFT OUTER JOIN
                    SupportQuestionTranslation qtr ON q.ID = qtr.QuestionId AND qtr.Language = '%s'
                LEFT OUTER JOIN
                    SupportQuestionTranslation dqtr ON q.ID = dqtr.QuestionId AND qtr.IsDefaultLanguage = 1
                LEFT OUTER JOIN
                    SupportCategoryTranslation ptr ON p.ID = ptr.CategoryId AND ptr.Language = '%s'
                LEFT OUTER JOIN
                    SupportCategoryTranslation dptr ON p.ID = dptr.CategoryId AND dptr.IsDefaultLanguage = 1
                WHERE
                    %s
                GROUP BY
                    q.ID
                ORDER BY
                    %s
                    %s
                LIMIT
                    %d,%d"
                , $toolBox->getCurrentLanguage()
                , $toolBox->getCurrentLanguage()
                , $whereSentence
                , $order['orderBy']
                , $order['order']
                , ($pagination['currentPage']-1)*$pagination['itemsPerPage']
                , $pagination['itemsPerPage']

            );
        }

        return array(
            "allQnAs" => $databaseTools->getData($sql,ARRAY_A,false,false),
            "totalItems" => $totalRecords['totalItems']
        );

    }
    public function getSingleQuestion($questionId)
    {
        $databaseTools = new DatabaseTools();
        return $databaseTools->getData(
            sprintf(
                "SELECT
                    *
                FROM
                    SupportQuestion
                WHERE
                    ID = %d"
                , $questionId
            ),ARRAY_A,true
        );
    }
    public function getQuestionTranslation($itemId,$language,$getDefault = false) {
        $databaseTools = new DatabaseTools();

        if ( $getDefault ) {
            $sql = sprintf("
                SELECT
                    *
                FROM
                    SupportQuestionTranslation
                WHERE
                    QuestionId = %d AND
                    IsDefaultLanguage = 1
                LIMIT 1
                "
                ,$itemId

            );
        } else {
            $sql = sprintf("
                SELECT
                    *
                FROM
                    SupportQuestionTranslation
                WHERE
                    QuestionId = %d AND
                    Language = '%s'
                LIMIT 1
                "
                ,$itemId
                ,$language

            );
        }

        return $databaseTools->getData(
            $sql,ARRAY_A,true
        );
    }
    public function deleteQuestion($questionId){

        $databaseTools = new DatabaseTools();

        //DELETE ALL TRANSLATIONS
        $databaseTools->deleteData(
            'SupportQuestionTranslation',
            array(
                'QuestionId' => $questionId
            )
        );

        return $databaseTools->deleteData(
            'SupportQuestion',
            array(
                'ID' => $questionId
            )
        );

    }

    public function searchQuestion($keywords,$language='tr'){
        $databaseTools = new DatabaseTools();
        $wpdb = $databaseTools->getLegacyDatabase();

        $keywordsStr = mysqli_real_escape_string($wpdb->dbh, implode(' ',$keywords));

        $sql = sprintf("
                SELECT
                    qt.ID,
                    qt.Question,
                    qt.Answer,
                    q.Parent as CategoryId,
                    qc.Parent as RootCategoryId,
                    MATCH (qt.Answer,qt.Question) AGAINST('%s') as relevance
                FROM
                    SupportQuestionTranslation as qt
                LEFT JOIN
                    SupportQuestion as q on qt.QuestionId = q.ID
                LEFT JOIN
                    SupportCategory as qc on q.Parent = qc.ID
                WHERE
                    MATCH (qt.Answer,qt.Question) AGAINST('%s') AND
                    qt.Language = '%s' AND
                    qc.Parent NOT IN (3,31,2) AND 
                    q.Parent NOT IN (3,31,2)
                ORDER BY relevance DESC
                LIMIT 20
                "
            ,$keywordsStr
            ,$keywordsStr
            ,$language
        );
        return $databaseTools->getData($sql,ARRAY_A,false);
    }



}