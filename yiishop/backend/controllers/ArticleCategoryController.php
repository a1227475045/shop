<?php

namespace backend\controllers;

use backend\models\ArticleCategory;

class ArticleCategoryController extends \yii\web\Controller
{
    /**
     * 分类列表
     * @return string
     */
    public function actionIndex()
    {
        //处理数据
        $categorys=ArticleCategory::find()->all();
        /*echo "<pre>";
        var_dump($categorys);exit();*/
        //显示视图
        return $this->render('index',['categorys'=>$categorys]);

    }

    /**
     * 文章分类信息添加
     * @return string|\yii\web\Response
     */
    public function actionAdd(){
            //创建模型对象
            $article=new ArticleCategory();
            //创建http请求对象
            $request=\Yii::$app->request;
            //判断是不是post提交
        if ($request->isPost){
            //绑定数据 验证数据
            if ($article->load($request->post()) && $article->validate()){
                //数据保存
                $article->save();
                //开启session验证
                \Yii::$app->session->setFlash('success',"添加成功");
                //页面跳转
                return $this->redirect('index');
            }
        }
            $article->status=1;
            $article->is_help=1;
            //显示视图
            return $this->render('add',['article'=>$article]);
    }

    /**
     * 文章分类信息修改
     * @param $id 修改数据的id
     * @return string|\yii\web\Response
     */
    public function actionEdit($id){
        //创建模型对象
        $article=ArticleCategory::findOne($id);
        //创建http请求对象
        $request=\Yii::$app->request;
        //判断是不是post提交
        if ($request->isPost){
            //绑定数据 验证数据
            if ($article->load($request->post()) && $article->validate()){
                //数据保存
                $article->save();
                //开启session验证
                \Yii::$app->session->setFlash('success',"修改成功");
                //页面跳转
                return $this->redirect('index');
            }
        }
        //显示视图
        return $this->render('edit',['article'=>$article]);
    }

    public function actionDel($id){
        //找到这条数据
        $article=ArticleCategory::findOne($id);
        //删除
        if ($article->delete()){
            //session验证
            \Yii::$app->session->setFlash('danger',"删除成功");
            //页面跳转
            $this->redirect('index');
        }



    }
}
