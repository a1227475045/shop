<?php

namespace backend\controllers;

use backend\models\AuthItem;

class PermissionController extends \yii\web\Controller
{
    /**
     * 权限列表
     * @return string
     */
    public function actionIndex()
    {
        //处理数据 实例化RBAC组件
        $authManager=\Yii::$app->authManager;
        //显示权限 查询出所有权限
        $permissions=$authManager->getPermissions();
        //var_dump($permissions);exit();
        return $this->render('index',compact('permissions'));
    }

    /**
     * 权限添加
     * @return string|\yii\web\Response
     */
    public function actionAdd(){
        //创建模型对象
        $model=new AuthItem();
        //创建http请求对象
        $request=\Yii::$app->request;
        //判断是否poast提交
        if ($request->isPost){
            //数据绑定+数据验证
            if ($model->load($request->post()) && $model->validate()){
                //实例化RBAC组件
                $authManager=\Yii::$app->authManager;
                //创建权限
                $permission=$authManager->createPermission($model->name);
                //添加描述
                $permission->description=$model->description;
                //添加权限 把权限添加到数据库
                $authManager->add($permission);

                \Yii::$app->session->setFlash('success',"创建".$model->description."成功");

                //页面跳转
                return $this->redirect('index');
            }
        }

        //显示视图
        return $this->render('add',compact('model'));
    }

    /**
     * 权限的修改
     * @param $name 权限数据的主键
     * @return string|\yii\web\Response
     */
    public function actionEdit($name){
        //找到这条数据
        $model=AuthItem::findOne($name);
        //创建http请求对象
        $request=\Yii::$app->request;
        //判断是否poast提交
        if ($request->isPost){
            //数据绑定+数据验证
            if ($model->load($request->post()) && $model->validate()){
                //实例化RBAC组件
                $authManager=\Yii::$app->authManager;
                //找出当前权限
                $permission=$authManager->getPermission($model->name);
                if ($permission){
                    //添加描述
                    $permission->description=$model->description;
                    //更新数据库里面的权限数据
                    $authManager->update($model->name,$permission);

                    \Yii::$app->session->setFlash('success',"修改成功");

                    //页面跳转
                    return $this->redirect('index');
                }else{
                    //页面舒心
                    \Yii::$app->session->setFlash('danger',"不能修改权限名称");
                    return $this->refresh();
                }

            }
        }

        //显示视图
        return $this->render('add',compact('model'));
    }

    public function actionDel($name){
        //实例化RBAC组件对象
            $auth=\Yii::$app->authManager;
        //找到这条数据
            $permission=$auth->getPermission($name);
        //删除权限
            if ($auth->remove($permission)){
                \Yii::$app->session->setFlash('success',"删除成功");
                return $this->redirect('index');

            };
    }
}
