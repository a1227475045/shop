<?php
/**
 * Created by PhpStorm.
 * User: x1c
 * Date: 2017/11/3
 * Time: 15:36
 */

namespace backend\controllers;


use backend\models\Brands;
use flyok666\qiniu\Qiniu;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;
use xj\uploadify\UploadAction;


class BrandController extends Controller
{



    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/images',
                'baseUrl' => '@web/images',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    $action->output['fileUrl'] = $action->getWebUrl();
                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                },
            ],
        ];
    }

    //处理数据
    public function actionIndex(){
        //分页
        //1.总条数
        $count=Brands::find()->count();
        //2.每页显示的条数
        $pagesize=5;
        $page=new Pagination([
            'pagesize'=>$pagesize,
            'totalCount'=>$count,
        ]);
        //3.创建分页对象
        //处理数据
        $brands=Brands::find()->limit($page->limit)->offset($page->offset)->all();
        //显示视图
        return $this->render("index",['brands'=>$brands,'page'=>$page]);
    }

    /**
     * 数据添加
     * @return string|\yii\web\Response
     */
    public function actionAdd(){
       //创建模型对象
        $brand=new Brands();
        //创建request对象
       $request=new Request();
            //绑定数据
            if ($brand->load($request->post())){
                //验证之前实例化文件上传
               // $brand->imgfile=UploadedFile::getInstance($brand,'imgfile');
                //后台验证
                if ($brand->validate()){
                //给图片设置保存的地址
                       // $filepath="images/".time().".".$brand->imgfile->extension;
                        //文件保存
                      //  $brand->imgfile->saveAs($filepath,false);
                        //数据保存
                     //   $brand->logo=$filepath;

                    //保存数据
                    $brand->save();
                    //开启session验证
                    $session=\Yii::$app->session;
                    $session->setFlash('success',"添加成功");
                    //页面跳转
                    return $this->redirect('index');
                }
            }


      $brand->status=1;
        //显示视图
      return $this->render('add',['brand'=>$brand]);
    }

    /**
     * 数据修改
     * @param $id 要修改数据的id
     * @return string|\yii\web\Response
     */
    public function actionEdit($id){
        //找到这条数据
        $brand=Brands::findOne($id);
        //创建request对象
        $request=new Request();
            //绑定数据
            if ($brand->load($request->post())){
                //验证之前实例化文件上传
               // $brand->imgfile=UploadedFile::getInstance($brand,'imgfile');
                //后台验证
                if ($brand->validate()){
                 //给图片设置保存的地址
                  //      $filepath="images/".time().".".$brand->imgfile->extension;
                        //文件保存
                 //       $brand->imgfile->saveAs($filepath,false);
                        //数据保存
                  //      $brand->logo=$filepath;

                    //保存数据
                    $brand->save();
                    //开启session验证
                    $session=\Yii::$app->session;
                    $session->setFlash('success',"修改成功");
                    //页面跳转
                    return $this->redirect('index');
                }
            }
        $brand->status=1;
        //显示视图
        return $this->render('edit',['brand'=>$brand]);
    }

    public function actionDel($id){
        //找到要删除的数据
        $brand=Brands::findOne($id);
        //删除
        $brand->delete();
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