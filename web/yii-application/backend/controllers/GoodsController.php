<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\ArticleCategory;
use backend\models\Brands;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use backend\models\SearchForm;
use flyok666\qiniu\Qiniu;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class GoodsController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
    }

    /**
     * 商品列表
     * @return string
     */
    public function actionIndex()
    {
        //构造查询对象
        $query=Goods::find();
        $request=\Yii::$app->request;
       //var_dump($request->get());exit();
        //接受变量
        $keyword=$request->get('keyword');
        $minPrice=$request->get('minPrice');
        $maxPrice=$request->get('maxPrice');

        //判断条件
        if ($minPrice>0){
            //构造查询条件
            $query->andWhere("shop_price >= {$minPrice}");
        }
        if ($maxPrice>0){
            $query->andWhere("shop_price <= {$maxPrice}");
        }
        if (isset($keyword)){
            $query->andWhere("name like '%{$keyword}%' or sn like '%{$keyword}%'");
    }
        //var_dump($request->get('keyword'));exit();
        //分页
        //1.总条数
        $count=$query->count();
        //创建搜索模型对象
        $search=new SearchForm();
        //2.每页显示的条数
        $pagesize=5;
        $page=new Pagination([
            'pagesize'=>$pagesize,
            'totalCount'=>$count,
        ]);

        //处理数据
        $goods=$query->limit($page->limit)->offset($page->offset)->all();
       /*echo "<pre>";
        var_dump($goods);exit;*/
       return $this->render('index',['goods'=>$goods,'page'=>$page,'search'=>$search]);
        //return $this->render('index',compact("page",    "goods","search"));
    }

    /**
     * 商品数据添加
     * @return string|\yii\web\Response
     */
    public function actionAdd()
    {
        $model = new Goods();
        $intro = new GoodsIntro();
        $photo = new GoodsGallery();



        $b_cate = Brands::find()->all();
        $g_cate = GoodsCategory::find()->where(['depth'=>2])->all();

        $request = \Yii::$app->request;
        if ($request->isPost){

            if ($model->load($request->post()) && $model->validate()){

                //echo "<pre>";
//                         var_dump($request->post()['GoodsGallery']['path']);exit;

                //商品货号
                $goodsCount=GoodsDayCount::findOne(['day'=>date('Ymd',time())]);
                //判断当天有没有添加过商品
                if (empty($goodsCount)){
                    $goodsCount=new GoodsDayCount();
                    $goodsCount->count=1;
                    $goodsCount->day=date('Ymd',time());
                    $goodsCount->save();
                }else{
                    $count=$goodsCount->count;
                    $goodsCount->count=$count+1;
                    $goodsCount->save();


                }

                $model->sn=date('Ymd',time()).(substr('00000'.$goodsCount->count,-5));
                $model->save();

                //商品相册
                $p=$request->post()['GoodsGallery']['path'];
                foreach ( $p as $imgfile) {
                    $photo = new GoodsGallery();
                    $photo->goods_id = $model->id;
                    $photo->path= $imgfile;
//                    var_dump($photo->path);exit;
                    $photo->save();


                }
              /*  echo "<pre>";
                var_dump($model->sn);exit();*/
//var_dump($request->post());exit;
            //商品详情
                if ($intro->load($request->post()) && $intro->validate()){
                    $intro->goods_id = $model->id;
                    $intro->save();

                        \Yii::$app->session->setFlash('success','添加商品成功');
                        return $this->redirect(['index']);

                    }
                }

            }

        $options = [
            ArrayHelper::map($b_cate,'id','name'),
            ArrayHelper::map($g_cate,'id','name')
        ];


        $model->sort=100;
        $model->status=1;
        $model->is_on_sale=0;
        return $this->render('add',['model'=>$model,'intro'=>$intro,'photo'=>$photo,'options'=>$options]);

    }


    public function actionEdit($id,$goods_id)
    {
       /* $model = new Goods();
        $intro = new GoodsIntro();
        $photo = new GoodsGallery();*/
       $model=Goods::findOne($id);
       $intro=GoodsIntro::findOne($goods_id);
       $photo=new GoodsGallery();

        $b_cate = Brands::find()->all();
        $g_cate = GoodsCategory::find()->where(['depth'=>1])->all();

        $request = \Yii::$app->request;
        if ($request->isPost){

            if ($model->load($request->post()) && $model->validate()){

               // echo "<pre>";
//                         var_dump($request->post()['GoodsGallery']['path']);exit;
                //商品货号
                $goodsCount=GoodsDayCount::findOne(['day'=>date('Ymd',time())]);
                //判断当天有没有添加过商品
                if (empty($goodsCount)){
                    $goodsCount=new GoodsDayCount();
                    $goodsCount->count=1;
                    $goodsCount->day=date('Ymd',time());
                    $goodsCount->save();
                }else{
                    //$count=$goodsCount->count;
                    //$goodsCount->count=$count+1;
                    $goodsCount->save();


                }

                $model->sn=date('Ymd',time()).(substr('00000'.$goodsCount->count,-5));
                $model->save();

                //商品相册
                $p=$request->post()['GoodsGallery']['imgFile'];
                foreach ( $p as $imgfile) {
                    $photo = new GoodsGallery();
                    $photo->goods_id = $model->id;
                    $photo->path= $imgfile;
//                    var_dump($photo->path);exit;
                    $photo->save();


                }
//var_dump($request->post());exit;
                //商品详情
                if ($intro->load($request->post()) && $intro->validate()){
                    $intro->goods_id = $model->id;
                    $intro->save();

                    \Yii::$app->session->setFlash('success','修改商品成功');
                    return $this->redirect(['index']);

                }
            }
        }
        $options = [
            ArrayHelper::map($b_cate,'id','name'),
            ArrayHelper::map($g_cate,'id','name')
        ];

        $path=GoodsGallery::find()->where(['goods_id'=>$id])->all();
        //var_dump($path);exit();
        foreach ($path as $v){
            $photo->imgFile[]=$v->path;
        }

        return $this->render('edit',['model'=>$model,'intro'=>$intro,'photo'=>$photo,'options'=>$options]);

    }


    /**
     * 商品信息删除
     * @param $id
     */
    public function actionDel($id){
        //找到这条数据
        $good=Goods::findOne($id);
        $intro=GoodsIntro::findOne($id);
        $photo=GoodsGallery::findOne($id);
        //删除
        $good->delete();
        $intro->delete();
        $photo->delete();
        //删除商品详情信息

        //session验证
        \Yii::$app->session->setFlash('success','删除成功');
        //页面跳转
        $this->redirect('index');
    }

    public function actionCreate(){
        //创建模型对象
        $user=new Admin();
        //创建http请求对象
        $request=\Yii::$app->request;
        //判断是不是post提交
        if ($request->isPost){
            //绑定数据 数据验证
            if ($user->load($request->post()) && $user->validate()){
                //数据保存
                $user->save();
                //session验证
                \Yii::$app->session->setFlash('success','注册成功，请登录');
                //页面跳转
                return $this->redirect('goods/login');
            }
        }
        //显示视图
        return $this->render('create',['user'=>$user]);
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
        $key = uniqid();
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
