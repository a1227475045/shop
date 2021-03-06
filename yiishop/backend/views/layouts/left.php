<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?=$directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?=Yii::$app->user->identity->username?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" readonly="readonly" placeholder="今夕后台管理模块" style="text-align: center"/>
              <span class="input-group-btn">
                <!--<button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>-->
                  </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->id,null, function($menu){
                    $data = json_decode($menu['data'], true);
                    $items = $menu['children'];
                    $return = [
                        'label' => $menu['name'],
                        'url' => [$menu['route']],
                    ];
                    //处理我们的配置
                    if ($data) {
                        //visible
                        isset($data['visible']) && $return['visible'] = $data['visible'];
                        //icon
                        isset($data['icon']) && $data['icon'] && $return['icon'] = $data['icon'];
                        //other attribute e.g. class...
                        $return['options'] = $data;
                    }
                    //没配置图标的显示默认图标，默认图标大家可以自己随便修改
                    (!isset($return['icon']) || !$return['icon']) && $return['icon'] = 'fa fa-address-book';
                    $items && $return['items'] = $items;
                    return $return;
                }),
            ]
        ) ?>

    </section>

</aside>
