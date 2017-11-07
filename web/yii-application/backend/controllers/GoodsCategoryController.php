<?php

namespace backend\controllers;

use backend\models\GoodsCategory;
use yii\helpers\Json;

class GoodsCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $cates=GoodsCategory::find()->orderBy('tree,lft')->all();
        return $this->render('index',['cates'=>$cates]);
    }

    /**
     * 商品分类添加
     */
    public function actionAdd(){
        //创建模型对象
        $good=new GoodsCategory();

        //创建http请求对象
        $request=\Yii::$app->request;
        //判断是不是post提交
        if ($request->isPost){

            //数据绑定
            $good->load($request->post());

            if ($good->validate()){

                //判断父亲Id是不是0 如果是0创建根目录

                if ($good->parent_id==0){
                    //创建根目录
                    $good->makeRoot();
                }else{

                    //创建子分类

                    //1.把父节点找到
                    $cateParent=GoodsCategory::findOne(['id'=>$good->parent_id]);

                    //2. 把当前节点对象添加到父类对象中

                    $good->prependTo($cateParent);

                }
                //页面跳转
                return $this->redirect('index');
                \Yii::$app->session->setFlash("success",'添加目录成功');


            }

        }
        //得到所有的分类
        $cates=GoodsCategory::find()->asArray()->all();
        $cates[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        $cates=Json::encode($cates);


        // var_dump($cates);exit;

        //显示视图
        return $this->render('add',['good'=>$good,'cates'=>$cates]);

    }


    public function actionEdit($id){
        //创建模型对象
        $good=GoodsCategory::findOne($id);

        //创建http请求对象
        $request=\Yii::$app->request;
        //判断是不是post提交
        if ($request->isPost){

            //数据绑定
            $good->load($request->post());

            if ($good->validate()){

                //判断父亲Id是不是0 如果是0创建根目录

                if ($good->parent_id==0){
                    //创建根目录
                    $good->makeRoot();
                }else{

                    //创建子分类

                    //1.把父节点找到
                    $cateParent=GoodsCategory::findOne(['id'=>$good->parent_id]);

                    //2. 把当前节点对象添加到父类对象中

                    //$good->prependTo($cateParent);
                    $good->appendTo($cateParent);

                }
                //页面跳转
                return $this->redirect('index');
                //提示信息 session保存
                \Yii::$app->session->setFlash("success",'修改目录成功');

            }

        }
        //得到所有的分类
        $cates=GoodsCategory::find()->asArray()->all();
        $cates[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        $cates=Json::encode($cates);


        // var_dump($cates);exit;

        //显示视图
        return $this->render('edit',['good'=>$good,'cates'=>$cates]);

    }

    public function actionDel($id){
        $cate=GoodsCategory::findOne($id);


            $cate->delete();
            //页面跳转
            $this->redirect('index');
            \Yii::$app->session->setFlash("success","删除成功");


    }


}
