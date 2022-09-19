<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Article $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="article-view">

    <?php if(! Yii::$app->user->isGuest ) : ?>
    <p>
        <?= Html::a('Update', ['update', 'slug' => $model->slug], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'slug' => $model->slug], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
           <h1><?= Html::encode($this->title) ?></h1> 
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-10">
                   <?= $model->getEncodedBody() ?> 
                </div>
                <div class="col-2">
                    <p class="text-muted">
                        <small>
                            Created: <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?> </strong>
                        </small>
                    </p>
                    <p class="text-muted">
                        By : <strong><?= $model->createdBy->username ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
