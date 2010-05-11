<script>
    <?php if($params['action'] == 'mission'): ?>
        var output = $('#mission');
    <?php endif; ?>
    new Boxy(output, {title: "<?= $lang['listAllFriends'] ?>",modal: true , closeText:"<img src=\"<?= $base_img ?>/popup/boxy/farmBoxy/close.gif\" />"});
</script>

<?php if($params['action'] == 'mission'): ?>
<div id="mission">
    <span><?php echo($lang['farmLevel'].": ".$params['mission']['level']) ?></span>
    <hr/>
    <span><?php echo($params['mission']['description']) ?></span><br/>
    <?php
    foreach($params['mission']['plant'] AS $plant)
    {
        echo $lang['plant'].": ".$plant['name']."<br/>";
        echo $lang['growthTime'].": ".$plant['growthTime']."<br/>";
        echo $lang['firstPrice'].": ".$plant['price']."<br/>";
        echo $lang['lastPrice'].": ".$plant['sellPrice']."<br/>";
        echo $lang['weightInSection'].": ".$plant['weight']."<br/>";
        echo $lang['waterConsume'].": ".$plant['resource'][1]."<br/>";
        echo $lang['muckConsume'].": ".$plant['resource'][2]."<br/>";

        if($params['mission']['accessories'])
        {
            echo "Needed Accessories: ";
            foreach ($params['mission']['accessories'] as $acc)
                echo $acc;
        }

        echo $lang['totalPrice'].": <br/>";
        echo $plant['price']." x ".$plant['weight']."=".$plant['weight']*$plant['price']."<br/>";
        if($params['mission']['farm_plow'])
            echo anchor(" ",$lang['implant'],array('onclick'=>"addPlantToFarm(".$params['mission']['farm_id'].",".$plant['id'].");return false;"));
        else
            echo $lang['implant']." ".$lang['farmNotPlowed'];
        echo "<hr/><hr/>";
    }
    ?>
</div>
<?php endif; ?>