<?php

namespace app\views\layouts;

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

$menuItems = [];

if (\Yii::$app->hasModule('user')) {
    if (\Yii::$app->user->isGuest) {
        #$menuItems[] = ['label' => 'Signup', 'url' => ['/user/registration/register']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/user/security/login']];
    } else {
        $menuItems[] = [
            'label' => '<i class="glyphicon glyphicon-user"></i> '.\Yii::$app->user->identity->username,
            'options' => ['id' => 'link-user-menu'],
            'items' => [
                [
                    'label' => '<i class="glyphicon glyphicon-user"></i> Profile',
                    'url' => ['/user/profile/show', 'id' => \Yii::$app->user->id],
                ],
                '<li class="divider"></li>',
                [
                    'label' => '<i class="glyphicon glyphicon-log-out"></i> Logout',
                    'url' => ['/user/security/logout'],
                    'linkOptions' => ['data-method' => 'post', 'id' => 'link-logout'],
                ],
            ],
        ];
        $menuItems[] = [
            'label' => '<i class="glyphicon glyphicon-cog"></i>',
            'url' => ['/backend'],
            'visible' => \Yii::$app->user->can('backend_default_index', ['route' => true]),
        ];
    }
}

NavBar::begin(
    [
        'brandLabel' => getenv('APP_TITLE'),
        'brandUrl' => \Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-default navbar-top',
        ],
    ]
);
echo Nav::widget(
    [
        'options' => ['class' => 'navbar-nav'],
        'encodeLabels' => false,
        'items' => \dmstr\modules\pages\models\Tree::getMenuItems('root_'.\Yii::$app->language),
    ]
);

echo Nav::widget(
    [
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => $menuItems,
    ]
);

NavBar::end();
