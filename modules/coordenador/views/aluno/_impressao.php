<?php 
    use yii\helpers\Html; 
    use Yii;
    $this->title = 'Carteirinha do Aluno';
?>
<div class="header">
    <img class="logo-prefeitura" src="<?= Yii::getAlias('images') ?>/brasao.png" width="40" height="46">
    <img class="logo-sistema" src="<?= Yii::getAlias('images') ?>/logo.png" width="130" height="50">
    <div class="titulo"><?= Html::encode($this->title) ?></div>
</div>

<div class="divCarteirinha">
    <h3><i class="glyphicon glyphicon-triangle-right"></i>Dados do Aluno(s)</h3>
    <img class="logo-prefeitura" src="<?= Yii::getAlias('images') ?>/carteirinha.jpg">
</div>
<hr>
<div>
    <h3><i class="glyphicon glyphicon-triangle-right"></i>Modalidade(s)</h3>
    <table class="table table-modalidade table-acao table-responsive">
        <thead>
            <tr>
                <th class="field_cross2">CEL</th>
                <th class="field_cross2">Modalidade</th>
                <th class="field_cross_small">Dia(s)</th>
                <th class="field_cross_small">Horário(s)</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($smods as $smod): ?>
                <?php foreach ($smod->modalidadeDataHora as $mdh) : ?>
                    <tr>
                        <td><?php echo $mdh->selecaoModalidade->cel->CEL_NOME; ?></td>
                        <td><?php echo $mdh->selecaoModalidade->modalidade->MOD_NOME; ?></td>
                        <td><?php echo $mdh->getDiasSemana(); ?></td>
                        <td><?php echo $mdh->getHorario(); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>