<?php if(!empty($session['card'])): ?>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
             <?php foreach($session['card'] as $id => $item):?>
                <tr>
                    <th>Заказ</th><td><?= $item['name']?></td>
                </tr>
                <tr>
                    <th>Номенклатура</th><td><?= $item['nomenklatura']?></td>
               </tr>
                <tr>                    
                    <th>Тираж</th><td><?= $item['tir']?></td>
               </tr>
                <tr>                    
                    <th>Листопрогон</th><td><?= $item['progon']?></td>
               </tr>
                <tr>                    
                    <th>Время печати</th><td><?= $item['timerab']?></td>
               </tr>
                <tr>                    
                    <th>Примечание</th><td><?= $item['comments']?></td>
                </tr>
                <tr>                   
                    <th>Статус</th><td><?= $item['sost']?></td>
                </tr>
            <?php endforeach?>
         </table>
    </div>
<?php else: ?>
    <h3>Задание отсутствует</h3>
<?php endif;?>