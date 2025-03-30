<?php
use yii\helpers\Html;
?>
<h1>Customer and Invoice Data</h1>

<?php if (!empty($data)): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <?php foreach (array_keys($data[0]) as $column): ?>
                    <th><?= Html::encode($column) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <?php foreach ($row as $cell): ?>
                        <td><?= Html::encode($cell) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No records found.</p>
<?php endif; ?>
