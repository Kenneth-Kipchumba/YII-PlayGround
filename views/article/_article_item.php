<?php
 /* @var $model \app\models\Article */

use yii\helpers\StringHelper;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="card card-success mb-3">
	<div class="card-header">
		<div class="row">
			<div class="col">
				<a href="<?= Url::to(['article/view', 'slug' => $model->slug]) ?>">
					<h3><?= \yii\helpers\Html::encode($model->title) ?></h3>
				</a>
			</div>
			<div class="col">
				<p class="text-muted">
					<small>
						Created: <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?> By : <strong><?= $model->createdBy->username ?></strong>
					</small>
				</p>
			</div>
		</div>
	</div>
	<div class="card-body">
		<?= StringHelper::truncateWords($model->getEncodedBody(), 40) ?>
	</div>
</div>