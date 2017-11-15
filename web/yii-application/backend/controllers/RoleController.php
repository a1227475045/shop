<?php

namespace backend\controllers;

use backend\models\AuthItem;
use yii\helpers\ArrayHelper;

class RoleController extends \yii\web\Controller
{
    /**
     * 角色列表
     * @return string
     */
    public function actionIndex()
    {
        //处理数据 实例化RBAC组件
        $authManager=\Yii::$app->authManager;
        //显示角色 查询出所有角色
        $roles=$authManager->getRoles();


        //var_dump($roles);exit();
        return $this->render('index',compact('roles'));
    }

    /**
     * 角色添加
     * @return string|\yii\web\Response
     */
    public function actionAdd(){
        //创建模型对象
        $model=new AuthItem();
        //实例化RBAC组件
        $authManager=\Yii::$app->authManager;
        //创建http请求对象
        $request=\Yii::$app->request;
        //判断是否poast提交
        if ($request->isPost){
            //数据绑定+数据验证
            if ($model->load($request->post()) && $model->validate()){
                //创建角色
                $role=$authManager->createRole($model->name);
                //添加描述
                $role->description=$model->description;

                    //添加角色 把角色添加到数据库
                    if ($authManager->add($role)){
                            //判断是否给角色添加权限
                            if ($model->permissions){
                                //循环权限给角色添加权限
                        foreach ($model->permissions as $permission){
                            //通过权限名称得到权限对象
                            $permission=$authManager->getPermission($permission);
                            //分别把权限添加到角色中
                            $authManager->addChild($role,$permission);
                        }
                    }
                }

                \Yii::$app->session->setFlash('success',"创建".$model->description."成功");

                //页面跳转
                return $this->redirect('index');
            }
        }
        //得到所有权限
        $permissions=$authManager->getPermissions();
        $permissions=ArrayHelper::map($permissions,'name','description');
        //显示视图
        return $this->render('add',compact('model','permissions'));
    }

    /**
     * 角色的修改
     * @param $name 角色数据的主键
     * @return string|\yii\web\Response
     */
    public function actionEdit($name){
        //找到这条数据
        $model=AuthItem::findOne($name);
        //创建http请求对象
        $request=\Yii::$app->request;
        //实例化RBAC组件
        $authManager=\Yii::$app->authManager;
        //得到角色的所有权限
        $RolePermissions=$authManager->getPermissionsByRole($name);
        $model->permissions=array_keys($RolePermissions);
        //判断是否poast提交
        if ($request->isPost){
            //数据绑定+数据验证
            if ($model->load($request->post()) && $model->validate()){
                //找出当前角色
                $role=$authManager->getRole($model->name);
                if ($role){
                    //添加描述
                    $role->description=$model->description;

                    //更新数据库里面的角色数据
                    if ($authManager->update($model->name,$role)){
                        //在修改之前删除当前角色所有的权限
                        $authManager->removeChildren($role);

                        //给用户修改权限
                        if ($model->permissions){
                            foreach ($model->permissions as $permission){
                                //分别把权限添加给对应的角色
                                $authManager->addChild($role,$authManager->getPermission($permission));
                            }
                        }
                    }
                    //session验证
                    \Yii::$app->session->setFlash('success',"修改成功");

                    //页面跳转
                    return $this->redirect('index');
                }else{
                    //session验证
                    \Yii::$app->session->setFlash('danger',"不能修改角色名称");
                    //页面刷新
                    return $this->refresh();
                }

            }
        }
        //得到所有权限
        $permissions=$authManager->getPermissions();
        $permissions=ArrayHelper::map($permissions,'name','description');

        //显示视图
        return $this->render('add',compact('model','permissions'));
    }

    public function actionDel($name){
        //实例化RBAC组件对象
            $auth=\Yii::$app->authManager;
        //找到这条数据
            $role=$auth->getRole($name);
        //删除角色对应的所有权限
        $auth->removeChildren($role);
        //删除角色
            if ($auth->remove($role)){
                \Yii::$app->session->setFlash('success',"删除成功");
                return $this->redirect('index');
            };
    }
}
