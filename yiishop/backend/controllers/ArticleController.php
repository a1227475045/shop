<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\ArticleDetail;
use yii\data\Pagination;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class ArticleController extends \yii\web\Controller
{
    /**
     * 文章列表
     * @return string
     */
    public function actionIndex()
    {
        //分页
        //1.总页数
        $count=Article::find()->count();
        //2.每页显示的条数
        $pagesize=3;
        //3.创建分页对象
        $page=new Pagination([
            'pagesize'=>$pagesize,
            'totalCount'=>$count,
        ]);
        //处理数据
        //$articles=Article::find()->all('articledetail',['id'=>'article_id']);
     /*   $query=new Query();
        $articles=$query
            ->select('article.*,article_detail.content,article_category.cate_name')
            ->from('article')
            ->leftJoin('article_detail','article.id=article_detail.article_id')
            ->Join('article_category','article.category_id=article_category.id')
            ->limit($page->limit)
            ->offset($page->offset)
            ->all();*/
     $articles=Article::find()->all();
     //echo "<pre>";
         //var_dump($articles);exit();
        //显示视图
        return $this->render('index',['articles'=>$articles,'page'=>$page]);
    }

    /**
     * 文章添加
     * @return string
     */
    public function actionAdd(){
        //创建模型对象
        $article=new Article();
        $article_detaile=new ArticleDetail();

        $cate=ArticleCategory::find()->all();
        $options=ArrayHelper::map($cate,'id','cate_name');
        //创建http请求对象
        $request=\Yii::$app->request;
        //判断是不是post提交
        if ($request->isPost){
            //绑定数据  验证数据
            if ($article->load($request->post()) && $article->validate()){
                //数据保存
                $article->save();
                //文章内容id=文章id
                $article_detaile->article_id=$article->id;
                //文章内容
                $article_detaile->content=$article->content;
                //文章内容保存
                $article_detaile->save();
                //提示
                \Yii::$app->session->setFlash('success','添加成功');
                //页面跳转
                return $this->redirect('index');
            }
        }
        //显示视图
        return $this->render('add',['article'=>$article,'article_detaile'=>$article_detaile,'options'=>$options]);
    }

    /**
     * 文章编辑
     * @param $id数据记录的Id
     * @return string
     */
    public function actionEdit($id){
       //找到需要修改的数据
        $article=Article::findOne($id);
        //文章内容的数据
        $article_detaile=ArticleDetail::findOne($id);
        //创建http请求对象
        $request=\Yii::$app->request;
        //判断是不是post提交
        if ($request->isPost){
          $data = $request->post();
           //var_dump($data);exit;
            //绑定数据  验证数据
            if ($article->load($data) && $article->validate()){
                //数据保存
                $article->save();
                //文章内容=修改后的内容
                $article_detaile->content=$data['ArticleDetail']['content'];
                //文章内容数据保存
                $article_detaile->save();
                //成功提示
                \Yii::$app->session->setFlash('success','修改成功');
                //页面跳转
                $this->redirect('index');
            }
        }
        //显示视图
        return $this->render('edit',['article'=>$article,'article_detaile'=>$article_detaile]);
    }

    public function actionDel($id){
        //找到这条数据
        $article=Article::findOne($id);
        $article_content=ArticleDetail::findOne($id);
        //删除
        $article->delete();
        $article_content->delete();
        //页面跳转
        $this->redirect('index');
    }
}
