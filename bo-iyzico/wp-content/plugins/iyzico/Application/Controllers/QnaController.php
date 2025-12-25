<?php

namespace Iyzico\Application\Controllers;

use Iyzico\Library\DatabaseTools;
use Iyzico\Application\Services\DatabaseApi;
use Iyzico\Library\Utils;

/**
 * Class QnaController
 * @package Iyzico\Application\Controllers
 */
class QnaController {

	public static function categoriesAction()
	{
		$categoryAdded 	= false;
		$parent 		= false;
		$databaseApi 	= new DatabaseApi();

		if ( isset($_POST['actionType']) && $_POST['actionType'] == 'addItem' ) $categoryAdded = self::addCategoryAction();

		/*
		 * Pagination
		 */
		$pagination["itemsPerPage"] = 10;
        $pagination["itemsPerPage"] = 10;
        $pagination['currentPage'] = 1;
        $pagination['pageCount'] = 1;

		if ( isset($_GET['paged']) ) $pagination["currentPage"] = (int)$_GET['paged'];

		/*
		 * Ordering
		 */
		$order["orderBy"] = "p.id,c.Rank";
		if ( isset($_GET['orderby']) ) {
            $order["orderBy"] = $_GET['orderby'];
        }
		if ( isset($_GET['order']) ) $order["order"] = $_GET['order'];

		if ( isset($_GET['parent']) ) $parent = $_GET['parent'];

		$responsePaged = $databaseApi->getCategories($pagination,$order,$parent);
		$responseAll = $databaseApi->getCategories();
		$languages = $databaseApi->getAllLanguages();

		$pagedCategories = $responsePaged['allCategories'];

		if ( $responsePaged['totalItems'] > $pagination["itemsPerPage"] ) {
			$pagination['pageCount'] = ceil($responsePaged['totalItems']/$pagination["itemsPerPage"]);
		}

		Utils::renderView(
			array(
				"pagedCategories" 	=> $pagedCategories,
				"allCategories"		=> $responseAll['allCategories'],
				"categoryCount" 	=> $responsePaged['totalItems'],
				"pagination" 		=> $pagination,
				"categoryAdded" 	=> $categoryAdded,
				"languages"			=> $languages
			)
		);
	}

	/**
	 * @return mixed
     */
	public function addCategoryAction(){
		$databaseTools = new DatabaseTools();

		$masterPayload = array(
			"Parent" => $_POST['parentId'],
			"Rank" => $_POST['categoryRank'],
		);
		$insertedCategoryId = $databaseTools->putData($masterPayload,'SupportCategory');

		if ( $insertedCategoryId ) {
			$translationPayload = array(
				"CategoryId" 		=> $insertedCategoryId,
				"Name"				=> $_POST['categoryName'],
				"Slug" 				=> sanitize_title($_POST['categoryName']),
				"Language"			=> $_POST['l13n'],
				"IsDefaultLanguage"	=> 1
			);
			$insertedTranslation = $databaseTools->putData($translationPayload,'SupportCategoryTranslation');
		}

		if ($insertedCategoryId && $insertedTranslation) {

		} else {
			die("Error while adding category OR translation. CatId : ".$insertedCategoryId."  -  TranslationId : ".$insertedTranslation );
		}
	}
	public static function categoryEditAction(){
		$databaseTools = new DatabaseTools();
		$databaseApi= new DatabaseApi();


		$staticPayload = array (
			"Parent" 	=> $_POST['parentSelector'],
			"Rank"		=> $_POST['rank']
		);
		$where = array (
			"ID" 		=> $_POST['itemId'],
		);

		$baseUpdate = $databaseTools->updateData($staticPayload,'SupportCategory',$where);


		//Check translation
		$oldTranslation = $databaseApi->getCategoryTranslation($_POST['itemId'],$_POST['language']);
		if ( $oldTranslation ) {
			$translationPayload = array(
				"Name"	=> $_POST['name'],
				"Slug"	=> sanitize_title($_POST['name'])
			);
			$where = array (
				"ID"	=> $oldTranslation['ID']
			);
			$translationUpdate = $databaseTools->updateData($translationPayload,'SupportCategoryTranslation',$where);

		} else {
			$translationPayload = array(
				"CategoryId"		=> $_POST['itemId'],
				"Name"				=> $_POST['name'],
				"Slug"				=> sanitize_title($_POST['name']),
				"Language"			=> $_POST['language'],
				"IsDefaultLanguage" => 0
			);
			$translationInsert = $databaseTools->putData($translationPayload,'SupportCategoryTranslation');

		}

		if ($baseUpdate || $translationUpdate || $translationInsert) {
			if ( $_POST['parentSelector'] != 0 )
			{
				$databaseApi = new DatabaseApi();
				$parentCategoryInfo = $databaseApi->getSingleCategory($_POST['parentSelector']);
				if ($parentCategoryInfo) {
					$parentCategoryName = $parentCategoryInfo['Name'];
				}

			} else {
				$parentCategoryName = "N/A";
			}

			Utils::renderJson(
				array(
					"success" 	=> "true",
					"message"	=> "Category updated.",
					"data"		=> array(
						"name" 			=> $_POST['name'],
						"parent" 		=> $_POST['parentSelector'],
						"parentName" 	=> $parentCategoryName,
						"rank"			=> $_POST['rank']
					)
				)
			);
		} else {
			Utils::renderJson(
				array(
					"success" 	=> "false",
					"error" 	=> "Ops! Something went wrong, and we couldn't save the data. Please try again."
				)
			);
		}
	}
	public static function deleteCategoryAction(){
		$databaseApi = new DatabaseApi();
		if ( $_POST['itemId'] ) {
			if ( is_array($_POST['itemId']) ) {
				$resultArr = array();
				foreach($_POST['itemId'] as $index=>$categoryId) {
					$resultArr[$categoryId] = $databaseApi->deleteCategory($categoryId);
				}
			} else {
				$result = $databaseApi->deleteCategory($_POST['itemId']);
			}
		}
		Utils::redirect('qna_categories');
	}
	public static function categoryLocalisationAction(){
		$databaseApi = new DatabaseApi();
		$categoryInfo = $databaseApi->getSingleCategory($_POST['itemId']);
		$categoryLocalisation = $databaseApi->getCategoryTranslation($_POST['itemId'],$_POST['language']);
		if ( !$categoryLocalisation ) {
			$categoryLocalisation = $databaseApi->getCategoryTranslation($_POST['itemId'],$_POST['language'],true);
		}
		$categoryObject = array (
			"Name"		=> $categoryLocalisation['Name'],
			"ParentId"	=> $categoryInfo['Parent'],
			"Rank"		=> $categoryInfo['Rank']
		);
		Utils::renderJson(
			array(
				"success"		=> 	"true",
				"data"			=> 	Utils::getCategoryJson($categoryObject)
			)
		);
	}
	public static function listAction(){
		$qnaAdded = false;
		$databaseApi = new DatabaseApi();

		if ( isset ($_POST['actionType']) && $_POST['actionType'] == 'addItem' ) $qnaAdded = self::addQuestionAction();

		/*
		 * Pagination
		 */
		$pagination["itemsPerPage"] = 10;
        $pagination['currentPage'] = 1;
        $pagination['pageCount'] = 1;

		if ( isset($_GET['paged']) ) $pagination["currentPage"] = (int)$_GET['paged'];

		/*
		 * Ordering
		 */
		$order["orderBy"] = "p.id,q.Rank";
        $parent = 0;
		if ( isset($_GET['orderby']) ) $order["orderBy"] = $_GET['orderby'];
		if ( isset($_GET['order']) ) $order["order"] = $_GET['order'];
		if ( isset($_GET['parent']) ) $parent = $_GET['parent'];

		$responsePaged = $databaseApi->getQnAs($pagination,$order,$parent);

		$responseAll = $databaseApi->getCategories();
		$languages = $databaseApi->getAllLanguages();

		$pagedQnAs = $responsePaged['allQnAs'];




		if ( $responsePaged['totalItems'] > $pagination["itemsPerPage"] ) {
			$pagination['pageCount'] = ceil($responsePaged['totalItems']/$pagination["itemsPerPage"]);
		}
		Utils::renderView(
			array(
				"pagedQnAs" 		=> $pagedQnAs,
				"allCategories"		=> $responseAll['allCategories'],
				"qnaCount" 			=> $responsePaged['totalItems'],
				"pagination" 		=> $pagination,
				"qnaAdded" 			=> $qnaAdded,
				"languages"			=> $languages
			)
		);
	}
	public static function addQuestionAction(){
		$databaseTools = new DatabaseTools();
		$masterPayload = array(
			"Parent"		=> $_POST['parentId'],
			"Rank"			=> $_POST['categoryRank'],
		);
		$insertedQuestionId = $databaseTools->putData($masterPayload,'SupportQuestion');

		if ( $insertedQuestionId ) {
			$translationPayload = array(
				"QuestionId" 		=> $insertedQuestionId,
				"Question"			=> $_POST['question'],
				"Answer"			=> $_POST['answer'],
				"Slug" 				=> sanitize_title($_POST['question']),
				"Language"			=> $_POST['l13n'],
				"IsDefaultLanguage"	=> 1,
			);
			$insertedTranslation = $databaseTools->putData($translationPayload,'SupportQuestionTranslation');
		}

		if ($insertedQuestionId && $insertedTranslation) {

		} else {
			die("Error while adding question OR translation. QuestionID : ".$insertedQuestionId."  -  TranslationId : ".$insertedTranslation );
		}
	}
	public static function questionLocalisationAction(){
		$databaseApi = new DatabaseApi();
		$questionInfo = $databaseApi->getSingleQuestion($_POST['itemId']);
		$questionLocalisation = $databaseApi->getQuestionTranslation($_POST['itemId'],$_POST['language']);
		if ( !$questionLocalisation ) {
			$questionLocalisation = $databaseApi->getQuestionTranslation($_POST['itemId'],$_POST['language'],true);
		}
		$questionObject = array (
			"Question"		=> $questionLocalisation['Question'],
			"Answer"		=> $questionLocalisation['Answer'],
			"ParentId"		=> $questionInfo['Parent'],
			"Rank"			=> $questionInfo['Rank']
		);
		Utils::renderJson(
			array(
				"success"		=> 	"true",
				"data"			=> 	Utils::getQuestionJson($questionObject)
			)
		);
	}
	public function questionEditAction(){

		$databaseTools = new DatabaseTools();
		$databaseApi= new DatabaseApi();


		$staticPayload = array (
			"Parent" 	=> $_POST['parentSelector'],
			"Rank"		=> $_POST['rank']
		);
		$where = array (
			"ID" 		=> $_POST['itemId'],
		);

		$baseUpdate = $databaseTools->updateData($staticPayload,'SupportQuestion',$where);

		//Check translation
		$oldTranslation = $databaseApi->getQuestionTranslation($_POST['itemId'],$_POST['language']);
		if ( $oldTranslation ) {
			$translationPayload = array(
				"Question"		=> $_POST['question'],
				"Answer"		=> $_POST['answer'],
				"Slug"	        => sanitize_title($_POST['question']),
			);
			$where = array (
				"ID"	=> $oldTranslation['ID']
			);
			$translationUpdate = $databaseTools->updateData($translationPayload,'SupportQuestionTranslation',$where);

		} else {
			$translationPayload = array(
				"QuestionId"		=> $_POST['itemId'],
				"Question"			=> $_POST['question'],
				"Answer"			=> $_POST['answer'],
				"Slug"				=> sanitize_title($_POST['question']),
				"Language"			=> $_POST['language'],
				"IsDefaultLanguage" => 0
			);
			$translationInsert = $databaseTools->putData($translationPayload,'SupportQuestionTranslation');

		}

		if ($baseUpdate || $translationUpdate || $translationInsert) {
			if ( $_POST['parentSelector'] != 0 )
			{
				$databaseApi = new DatabaseApi();
				$parentCategoryInfo = $databaseApi->getSingleCategory($_POST['parentSelector']);
				if ($parentCategoryInfo) {
					$parentCategoryName = $parentCategoryInfo['Name'];
				}

			} else {
				$parentCategoryName = "N/A";
			}

			Utils::renderJson(
				array(
					"success" 	=> "true",
					"message"	=> "Question updated.",
					"data"		=> array(
						"question" 		=> stripslashes($_POST['question']),
						"answer" 		=> stripslashes($_POST['answer']),
						"parent" 		=> $_POST['parentSelector'],
						"parentName" 	=> $parentCategoryName,
						"rank"			=> $_POST['rank']
					)
				)
			);
		} else {
			Utils::renderJson(
				array(
					"success" 	=> "false",
					"error" 	=> "Ops! Something went wrong, and we couldn't save the data. Please try again."
				)
			);
		}
	}
	public function deleteQuestionAction(){
		$databaseApi = new DatabaseApi();

		if ( $_POST['itemId'] ) {
			if ( is_array($_POST['itemId']) ) {
				$resultArr = array();
				foreach($_POST['itemId'] as $index=>$questionId) {
					$resultArr[$questionId] = $databaseApi->deleteQuestion($questionId);
				}
			} else {
				$result = $databaseApi->deleteQuestion($_POST['itemId']);
			}
		}
		Utils::redirect('qna_list');
	}
	public static function qnaContactCategoriesAction(){
		if ( isset($_POST['parent-category']) &&  $_POST['parent-category'] != "") {
			$databaseApi = new DatabaseApi();
			//Resolve parent Category
			$parentId = $_POST['parent-category'];
			if ( $parentId ) {
				$allSubCategories = $databaseApi->getCategories(false,false,$parentId,true);
				if ( $allSubCategories ) {
					Utils::renderJson(
						array(
							'success' => true,
							'data' => $allSubCategories
						)
					);
				} else {
					Utils::renderJson(
						array(
							'success' => false,
							'message' => "Selected Category does not have any subcategories."
						)
					);
				}
			} else {
				Utils::renderJson(
					array(
						'success' => false,
						'message' => "Can not resolve selected category."
					)
				);
			}
		} else {
			Utils::renderJson(
				array(
					'success' => false,
					'message' => "No parent category selected."
				)
			);
		}

	}
	public static function qnaContactQuestionsAction(){

		if ( isset($_POST['parent']) &&  $_POST['parent'] != "") {
			$databaseApi = new DatabaseApi();


			$allQuestions = $databaseApi->getQuestionsByCategoryId($_POST['parent']);
			if ( $allQuestions ) {
				Utils::renderJson(
					array(
						'success' => true,
						'data' => $allQuestions
					)
				);
			} else {
				Utils::renderJson(
					array(
						'success' => false,
						'message' => "Selected Category does not have any questions."
					)
				);
			}

		} else {
			Utils::renderJson(
				array(
					'success' => false,
					'message' => "No category selected."
				)
			);
		}

	}
    public static function getTopLevelQnaCategoriesWithSubs(){
        $databaseTools = new DatabaseApi();
        $allTopCategories = $databaseTools->getCategories(false,false,0,true);
        $response = array();
        foreach($allTopCategories['allCategories'] as $index => $category){

            if ($databaseTools->getQnASubCategoryCount($category['ID']) > 0) {
                array_push($response,$category);
            }
        }
        return $response;
    }
    public static function getTopLevelQnaCategories(){
        $databaseTools = new DatabaseApi();
        return $databaseTools->getCategories(false,false,0,true);

    }
}