<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\LoginForm;
use common\components\Upload;
use phpDocumentor\Reflection\Types\Array_;
use yii\helpers\ArrayHelper;

class AdminController extends \yii\web\Controller
{
    public function actionShouye(){
        //显示视图
        return $this->render('shouye');
    }

    public function actionIndex()
    {
        //处理数据
        $users=Admin::find()->all();

        return $this->render('index',['users'=>$users]);
    }

    /**
     * @return string|\yii\web\Response
     * 管理员添加
     */
    public function actionCreate(){
        //创建模型对象
        $model=new Admin();
        //创建RBAC模型对象
        $auth=\Yii::$app->authManager;
        //创建http请求对象
        $request=\Yii::$app->request;
        //判断是否post提交
        if ($request->isPost){
            //绑定数据+数据验证
            if ($model->load($request->post()) && $model->validate()){
                    $model->password=\Yii::$app->security->generatePasswordHash($model->password);
                    //加密
                    $model->salt=\Yii::$app->security->generateRandomString();
                    //令牌添加
                    $model->token=\Yii::$app->security->generateRandomString();
                   /* echo "<pre>";
                    var_dump($model);exit();*/

                    //数据保存
                    $model->save();

               //判断是否给用户添加角色
                if ($model->role) {
                    //循环权限给角色添加权限
                    foreach ($model->role as $role) {
                        //通过角色名称得到权限对象
                        $role = $auth->getRole($role);
                        //分别把角色添加到用户中
                        $auth->assign($role, $model->id);
                    }
                }
                //页面跳转
                return $this->redirect('index');

                    //session验证
                \Yii::$app->session->setFlash('success',"添加管理员成功");

            }
        }
        //得到所有角色
        $role=ArrayHelper::map($auth->getRoles(),'name','description');
        //var_dump($role);exit;
        //显示视图
        return $this->render('create',['model'=>$model,'role'=>$role]);
    }


    /**
     * @return string|\yii\web\Response
     * 管理员修改
     */
    public function actionEdit($id){
        //找到这条数据
        $model=Admin::findOne($id);
        //创建RBAC模型对象
        $auth=\Yii::$app->authManager;
        //得到用户的所有角色
        $RoleUsers=$auth->getPermissionsByUser($id);
        $model->role=array_keys($RoleUsers);
        //创建http请求对象
        $request=\Yii::$app->request;
        //判断是否post提交
        if ($request->isPost){
            //绑定数据+数据验证

            if ($model->load($request->post()) && $model->validate()){

               if ($model->password !=\Yii::$app->security->generatePasswordHash($model->password)){
                    $model->password=\Yii::$app->security->generatePasswordHash($model->password);
                }else{
                   $model->password=$model->password;
               }


              //var_dump($model->password);exit();
                //加密
                $model->salt=\Yii::$app->security->generateRandomString();
                //令牌添加
                $model->token=\Yii::$app->security->generateRandomString();
                //数据保存
                $model->save();
                /*echo "<pre>";
                var_dump($model);exit();*/
                //找出当前用户
                //更新数据库里面的用户数据

                    $auth->revokeAll($model->id);
                    //给用户添加权限
                    if ($model->role){
                        foreach ($model->role as $role){
                            //分别把角色添加给对应的用户
                            $auth->assign($auth->getRole($role),$model->id);
                        }
                    }

                }

                //session验证
                \Yii::$app->session->setFlash('success',"修改管理员成功");
                //页面跳转
                return $this->redirect('index');
            }
        //得到所有角色
        $role=ArrayHelper::map($auth->getRoles(),'name','description');
        //显示视图
        return $this->render('edit',['model'=>$model,'role'=>$role]);
    }


    public function actionDel($id){
        //找到这条数据并删除
        Admin::findOne($id)->delete();
        //session验证
        \Yii::$app->session->setFlash('danger',"删除成功");
        //页面跳转
        return $this->redirect('index');
    }

    /**
     * 管理员登陆
     * @return string|\yii\web\Response
     */
    public function actionLogin(){
//        echo 1111;exit();
        //判断用户是不是登陆状态
       if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        //实例化登录表单模型
        $model=new LoginForm();
        //创建http请求对象
        $request=\Yii::$app->request;
        //判断是不是post提交
        if ($request->isPost){
            //数据绑定+数据验证
            if ($model->load($request->post()) && $model->validate()){
                //判断有没有用户名存不存在
                $admin=Admin::findOne(['username'=>$model->username]);

                if($admin){
                   // echo 111 ;exit();
                    //存在 判断密码
                  //  if (\Yii::$app->security->validatePassword($model->password,$admin->password)){

                        //密码正确 登陆
                        $admin->last_login_time=time();
                       $admin->last_login_ip=\Yii::$app->request->userIP;

                        $admin->save();

                        \Yii::$app->user->login($admin,$model->rememberMe?3600*24*7:0);
                        //页面跳转
//                        exit('111');
                         $this->redirect(['index']);
                    }else{
                        //密码错误 重新登陆
                       $model->addError('danger',"密码错误，请重新登录");
                    }
                }else{
                    //不存在 提示用户名不存在
                   $model->addError('danger',"用户名不存在或错误");
                }
            }
       // }

        //显示视图
        return $this->render('login',['model'=>$model]);
    }



    /**
     * 退出登录
     * @return \yii\web\Response
     */
    public function actionLogout(){
        //找到要退出的用户
        \Yii::$app->user->logout();
        return $this->redirect('login');
    }



}
