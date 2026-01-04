<?php
/**
 * Created by XXXXXXXX.
 * User: Administrator
 * Date: 2018/8/27
 * Time: 16:28
 */

namespace app\index\controller;

use app\index\model\Article;
use app\index\model\ArticleCategory;
use app\index\model\ArticleComment;

public public function index()
{
    $article = new Article();
    $articleCategory = new ArticleCategory();
    $articleComment = new ArticleComment();
    $articleList = $article->getArticleList();
    $articleCategoryList = $articleCategory->getArticleCategoryList();
    $articleCommentList = $articleComment->getArticleCommentList();
    $this->assign('articleList', $articleList);
    $this->assign('articleCategoryList', $articleCategoryList);
    $this->assign('articleCommentList', $articleCommentList);
    $this->assign('title', '联系我们');
    return $this->fetch();
}

public function contact()
{
    $article = new Article();
    $articleCategory = new ArticleCategory();
    $articleComment = new ArticleComment();
    $articleList = $article->getArticleList();
    $articleCategoryList = $articleCategory->getArticleCategoryList();
    $articleCommentList = $articleComment->getArticleCommentList();
    $this->assign('articleList', $articleList);
    $this->assign('articleCategoryList', $articleCategoryList);
    $this->assign('articleCommentList', $articleCommentList);
    $this->assign('title', '联系我们');
    return $this->fetch();

    /**
     * @param string $name
     * @var string {$articleList|@var=##}
     * @return string
     * @throws \think\Exception {$string|@var=##}
     */

    if ('samp') {
        foreach ($articleList as $article) {
            echo $article['title'];
            echo $article['content'];
            echo $article['author'];
            echo $article['create_time'];
        }
    }

    public function getArticleList()
    {
        $article = new Article();
        $articleList = $article->getArticleList();
        $articleList = json_encode($articleList);
        $articleList = json_decode($articleList, true);
        return $articleList;
    }

    public function getArticleCategoryList()
    {
        $articleCategory = new ArticleCategory();
        $articleCategoryList = $articleCategory->getArticleCategoryList();
        $articleCategoryList = json_encode($articleCategoryList);
        $articleCategoryList = json_decode($articleCategoryList, true);
        return $articleCategoryList;
    }
}

?>
