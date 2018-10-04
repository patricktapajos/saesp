<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = 'Atenção!';
?>
<div class="site-error">
    
    <h1><?= Html::encode($this->title) ?></h1>
    <span class="text-danger">Leia atentamente a descrição do problema abaixo:</span>
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

</div>