<?php

/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

Lifetype JSON Export

Create a JSON representation of all of the blog posts inside a lifetype
blog, for backups or import to another blog engine

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

// Configuration values: make any changes here!
define('EXPORT_BLOG_ID', 1);


// NO CHANGES SHOULD BE NECESSARY PAST THIS POINT!
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
if (!defined( "PLOG_CLASS_PATH" )) {
	define( "PLOG_CLASS_PATH", dirname(__FILE__)."/");
}

include 'class/object/loader.class.php';
include 'class/dao/articles.class.php';


function FormatCategory($categoryObject) {
	/*
	 * Format a single category's data for JSON export
	 */
	return $categoryObject->getName();
}


function FormatComment($commentObject) {
	/*
	 * Format a single comment's data for JSON export
	 */
	$comment = array();

	$comment['id'] = $commentObject->getId();
	$comment['title'] = $commentObject->getTopic();
	$comment['name'] = $commentObject->getUserName();
	$comment['url'] = $commentObject->getUserUrl();
	$comment['email'] = $commentObject->getUserEmail();
	$comment['date'] = $commentObject->getDate();
	$comment['text'] = $commentObject->getText();

	return $comment;
}


function FormatArticle($articleObject) {
	/*
	 * Format a single article's data for JSON export
	 */
	$article = array();

	$article['id'] = $articleObject->getId();
	$article['title'] = $articleObject->getTopic();
	$article['body'] = $articleObject->getText();
	$article['categories'] = array_map('FormatCategory', $articleObject->getCategories());
	$article['comments'] = array_map('FormatComments', $articleObject->getComments());

	return $article;
}


// Get a collection of all published blog posts
// (For ALL posts, you need to specify POST_STATUS_ALL)
$articlesObject = new Articles();
$articles = array_map('FormatArticle', $articlesObject->getBlogArticles(EXPORT_BLOG_ID));
echo json_encode($articles);

?>
