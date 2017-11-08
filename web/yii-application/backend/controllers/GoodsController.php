<?php

namespace backend\controllers;

use backend\models\ArticleCategory;
use backend\models\Brands;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use flyok666\qiniu\Qiniu;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class GoodsController extends \yii\web\Controller
{
    /**
     * 商品列表
     * @return string
     */
    public function actionIndex()
    {
        //处理数据
        $goods=Goods::find()->all();
        return $this->render('index',['goods'=>$goods]);
    }

    /**
     * 商品添加
     * @return string|\yii\web\Response
     */
    public function actionAdd(){
        //创建商品模型对象
        $model=new Goods();
        //创建商品分类模型
        $cates=new GoodsCategory();
        //创建商品品牌模型
        $brand=new Brands();
        //创建商品详情模型
        $intro=new GoodsIntro();
        //创建商品图片模型
        $gallery=new GoodsGallery();


        $cate=GoodsCategory::find()->where(['depth'=>1])->all();
        $options=ArrayHelper::map($cate,'id','name');

        $brands=ArrayHelper::map(Brands::find()->all(),'id','name');

        //创建http请求对象
        $request=\Yii::$app->request;
        //判断是否post提交
        if ($request->isPost){
            //绑定数据  数据验证
            if ($model->load($request->post()) && $model->validate()){
                if (empty($model->sn)){
                    $day=date('ymd',time());
                    $str=substr('0000',5,6);
                    $aa=$day.$str;
                    var_dump($aa);exit();
                }



                //数据保存
                $model->save();



                $intro->goods_id=$model->id;
                $intro->content=$model->content;
                $intro->save();




                //开启session验证
                \Yii::$app->session->setFlash('success','添加成功');
                //页面跳转
                return $this->redirect('index');
            }
        }
        //显示视图
        return $this->render('add',['model'=>$model,'cates'=>$cates,'options'=>$options,'brands'=>$brands]);
    }

    /**
     * 商品数据修改
     * @param $id 修改数据的id
     * @return string|\yii\web\Response
     */
    public function actionEdit($id){
        //创建模型对象
        //$model=new Goods();
        $model=Goods::findOne($id);
        $goods=new GoodsCategory();
        $brand=new Brands();

        $cate=GoodsCategory::find()->all();
        $options=ArrayHelper::map($cate,'id','name');

        $brands=ArrayHelper::map(Brands::find()->all(),'id','name');

        //创建http请求对象
        $request=\Yii::$app->request;
        //判断是否post提交
        if ($request->isPost){
            //绑定数据  数据验证
            if ($model->load($request->post()) && $model->validate()){
                //数据保存
                $model->save();
                //开启session验证
                \Yii::$app->session->setFlash('success','修改成功');
                //页面跳转
                return $this->redirect('index');
            }
        }
        //显示视图
        return $this->render('edit',['model'=>$model,'goods'=>$goods,'options'=>$options,'brands'=>$brands]);
    }

    public function actionDel($id){
        //找到这条数据
        $good=Goods::findOne($id);
        //删除
        $good->delete();
        //session验证
        \Yii::$app->session->setFlash('success','删除成功');
        //页面跳转
        $this->redirect('index');
    }

    //图片上传
    public function actionUpload(){
//        var_dump($_FILES['file']['tmp_name']);exit;
        //七牛云上传
        //配置
        $config = [
            'accessKey'=>'JEtJWG7aqUIcsjEK738yJwxTsn6LJWFBgNqm-kK5',//ak
            'secretKey'=>'kzcutq77zdftJz-vlQOyNrnDDR9RRu2sAtT8hk4t',//sk
            'domain'=>'http://oz1697rg1.bkt.clouddn.com/',//域名
            'bucket'=>'jinximall',//空间名称
            'area'=>Qiniu::AREA_HUANAN //区域
        ];
        //实例化对象
        $qiniu = new Qiniu($config);
        $key = time();
        //调用上传方法
        $qiniu->uploadFile($_FILES['file']['tmp_name'],$key);
        $url = $qiniu->getLink($key);
        $info=[
            'code'=>0,
            'url'=>$url,
            'attachment'=>$url
        ];

        exit(json_encode($info));
    }
}
