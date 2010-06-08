<style>
    .boxy-inner{height:400px!important}
    .main-content{height:400px!important}
</style>
<script>
    <?php if($params['action'] == 'mission'): ?>
        var output = $('#mission');
        var titleText = "<?= $lang['yummyRequest'] ?>";
    <?php elseif($params['action'] == 'buyAccessory'): ?>
        var output = $('#buyAccessory');
        var titleText = "<?= $lang['buyAccessory'] ?>";
    <?php elseif($params['action'] == 'showInventory'): ?>
        var output = $('#showInventory');
        var titleText = "<?= $lang['showInventory'] ?>";
    <?php endif; ?>
    new Boxy(output, {title: titleText,modal: true , closeText:"<img src=\"<?= $base_img ?>/popup/boxy/farmBoxy/close.gif\" />"});
</script>

<?php if($params['action'] == 'mission'): ?>
<div id="mission">
    <div id="missionBoxHolder">
        <div class="levelHolder">
            <?= $lang['farmLevel'].": ".convert_number($params['mission']['level']) ?>
        </div>
        <div class="missionDetailsHolder">
            <?= $params['mission']['description'] ?>
        </div>
        <div class="plantHolder">
            <?php foreach($params['mission']['plant'] AS $plant): ?>
            <div class="plantAvatar">
                <img src="<?= $base_img."farm/plant/$plant[name].png" ?>" />
            </div>
            <div class="plantName">
                <?= $lang[$plant['name']] ?>
            </div>
            <div class="addPlant">
                <?php
                if($params['mission']['farm_plow'])
                    echo anchor(" "," ",array('onclick'=>"addPlantToFarm(".$params['mission']['farm_id'].",".$plant['id'].");return false;"));
                else
                    echo $lang['implant']." ".$lang['farmNotPlowed'];
                ?>
            </div>
            <div class="plantDetails">
                <?php
                echo "<span class=\"detailsTitle\">".$lang['growthTime'].": </span>".convert_number($plant['growthTime']).$lang['hour']."<br/>";
                echo "<span class=\"detailsTitle\">".$lang['firstPrice'].": </span>".convert_number($plant['price']).$lang['yummyMoneyUnit']."<br/>";
                echo "<span class=\"detailsTitle\">".$lang['lastPrice'].": </span>".convert_number($plant['sellPrice']).$lang['yummyMoneyUnit']."<br/>";
                echo "<span class=\"detailsTitle\">".$lang['weightInSection'].": </span>".convert_number($plant['weight']).$lang['kilogram']."<br/>";
                echo "<span class=\"detailsTitle\">".$lang['waterConsume'].": </span>".str_replace(__HOUR__,convert_number($plant['resource'][1]) , $lang['usagePerHour'])."<br/>";
                echo "<span class=\"detailsTitle\">".$lang['muckConsume'].": </span>".str_replace(__HOUR__,convert_number($plant['resource'][2]) , $lang['usagePerHour'])."<br/>";
                echo "<span class=\"detailsTitle\">".$lang['totalPrice'].": </span>".convert_number($plant['price'])."x".convert_number($plant['weight'])."=<b style=\"font-size:15px\">".convert_number((string)($plant['weight']*$plant['price']))."</b><br/><br/>";
                
                if($params['mission']['accessories'])
                {
                    echo "<span class=\"detailsTitle\">$lang[neededAccessories]: </span>";
                    foreach ($params['mission']['accessories'] as $acc)
                        echo $lang[$acc];
                }
                
                ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div id="missionEquipment">
        <div class="equipmentTitle">
            <?= $lang['equipment'] ?>
        </div>
        <div class="details">
            <?php 
            if($params['mission']['level'] == 5)
                $equipHolder = "grassCutter";
            elseif($params['mission']['level'] == 7)
                $equipHolder = "waterPump";
            elseif($params['mission']['level'] == 9)
                $equipHolder = "rockBreaker";
            
            if(isset($equipHolder)):
            ?>

            <div class="equipImg">
                <img src="<?= $base_img."farm/equipment/".strtolower($equipHolder).".png" ?>" />
            </div>
            <div class="equipContext">
                <?= $lang["equipment-".$equipHolder] ?>
            </div>
            <?php else: ?>
                <?= $lang['haventEquipment'] ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php elseif($params['action'] == 'buyAccessory'): ?>
<div id="buyAccessory">

    <?php foreach($params['accessories']['attack'] AS $attackTools): ?>
        <div class="accessoryBuyItem">
            <?= $attackTools->name ?><br/>
            <?= $lang['price']." : ".$attackTools->price ?><br/>
            <?= $lang['farmLevel']." : ".$attackTools->level ?><br/>
            <?= $attackTools->description ?><br/>
            <?php if ($params['farm_level'] >= $attackTools->level)
                    echo anchor(" ","BUY",array('onclick'=>"addAccessoryToFarm(".$params['farm_id'].",".$attackTools->id.");return false;"));
            else
                echo "CantBuy";
            ?>
            <div class="buyAccessoryAjaxHolder<?= $attackTools->id ?>"></div><br/>
        </div>
    <?php endforeach; ?>
    <?= $lang['deffenceAccessory'] ?>
    <hr/>
    <?php foreach($params['accessories']['deffence'] AS $deffenceTools): ?>
        <div class="accessoryBuyItem">
            <?= $deffenceTools->name ?><br/>
            <?= $lang['price']." : ".$deffenceTools->price ?><br/>
            <?= $lang['farmLevel']." : ".$deffenceTools->level ?><br/>
            <?= $deffenceTools->description ?><br/>
            <?php if ($params['farm_level'] >= $deffenceTools->level)
                    echo anchor(" ","BUY",array('onclick'=>"addAccessoryToFarm(".$params['farm_id'].",".$deffenceTools->id.");return false;"));
            else
                echo "CantBuy";
            ?>
            <div class="buyAccessoryAjaxHolder<?= $deffenceTools->id ?>"></div><br/>
        </div>
    <?php endforeach; ?>
    <?= $lang['toolAccessory'] ?>
    <hr/>
    <?php foreach($params['accessories']['tools'] AS $tool): ?>
        <div class="accessoryBuyItem">
            <?= $tool->name ?><br/>
            <?= $lang['price']." : ".$tool->price ?><br/>
            <?= $lang['farmLevel']." : ".$tool->level ?><br/>
            <?= $tool->description ?><br/>
            <?php if ($params['farm_level'] >= $tool->level)
                    echo anchor(" ","BUY",array('onclick'=>"addAccessoryToFarm(".$params['farm_id'].",".$tool->id.");return false;"));
            else
                echo "CantBuy";
            ?>
            <div class="buyAccessoryAjaxHolder<?= $tool->id ?>"></div><br/>
        </div>
    <?php endforeach; ?>
    <?= $lang['specialAccessory'] ?>
    <hr/>
    <?php foreach($params['accessories']['specialTools'] AS $specialTool): ?>
        <div class="accessoryBuyItem">
            <?= $specialTool->name ?><br/>
            <?= $lang['price']." : ".$specialTool->price ?><br/>
            <?= $lang['farmLevel']." : ".$specialTool->level ?><br/>
            <?= $specialTool->description ?><br/>
            <?php if ($params['farm_level'] >= $specialTool->level)
                    echo anchor(" ","BUY",array('onclick'=>"addAccessoryToFarm(".$params['farm_id'].",".$specialTool->id.");return false;"));
            else
                echo "CantBuy";
            ?>
            <div class="buyAccessoryAjaxHolder<?= $specialTool->id ?>"></div><br/>
        </div>
    <?php endforeach; ?>

</div>
<?php elseif($params['action'] == 'showInventory'): ?>
<div id="showInventory">
    <?php if(count($params['farmAccessories']['attack']) > 0): ?>
    <div class="inventoryContainer">
        <div class="inventoryTitle">
            <span>
                <?= $lang['attackAccessory'] ?>
            </span>
        </div>
        <div class="inventoryInner">
            <?php foreach($params['farmAccessories']['attack'] AS $attackTools): ?>
                <div class="inventorySmallBox">
                    <img src="<?= $base_img."farm/accessory/".$attackTools['name'].".png" ?>" />
                    <span class="inventoryName"><?= $lang[$attackTools['name']] ?></span>
                    <span class="inventoryCounter"><span><?= $attackTools['count'] ?></span></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    <?php if(count($params['farmAccessories']['deffence']) > 0): ?>
    <div class="inventoryContainer">
        <div class="inventoryTitle">
            <span>
                <?= $lang['deffenceAccessory'] ?>
            </span>
        </div>
        <div class="inventoryInner">
            <?php foreach($params['farmAccessories']['deffence'] AS $deffTools): ?>
                <?php if(array_key_exists('count', $deffTools)): ?>
                    <div class="inventorySmallBox">
                        <img src="<?= $base_img."farm/accessory/".$deffTools['name'].".png" ?>" />
                        <span class="inventoryName"><?= $lang[$deffTools['name']] ?></span>
                        <span class="inventoryCounter"><span><?= $deffTools['count'] ?></span></span>
                    </div>
                <?php else: ?>
                    <div class="inventoryBigBox">
                        <img src="<?= $base_img."farm/accessory/".$deffTools['name'].".png" ?>" />
                        <span class="inventoryName"><?= $lang[$deffTools['name']] ?></span>
                        <span class="inventoryCounter"><?= $lang['remainTime'] ?>
                            <span id="<?= $deffTools['name'] ?>exireTimeHolder" class="resourceCounter">
                                <script>
                                    $(function () {
                                    var expire = <?= $deffTools['expire'] ?>;
                                    $('#<?= $deffTools['name'] ?>exireTimeHolder').countdown({until: expire,
                                                                                                       expiryText: '',
                                                                                                       layout: '<div class="image{d10}"></div><div class="image{d1}"></div>' +
                                                                                                        '<div class="imageDay"></div><div class="imageSpace"></div>' +
                                                                                                        '<div class="image{h10}"></div><div class="image{h1}"></div>' +
                                                                                                        '<div class="imageSep"></div>' +
                                                                                                        '<div class="image{m10}"></div><div class="image{m1}"></div>' +
                                                                                                        '<div class="imageSep"></div>' +
                                                                                                        '<div class="image{s10}"></div><div class="image{s1}"></div>'
                                                    });});
                                </script>
                            </span>
                        </span>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    <?php if(count($params['farmAccessories']['tools']) > 0): ?>
    <div class="inventoryContainer">
        <div class="inventoryTitle">
            <span>
                <?= $lang['toolAccessory'] ?>
            </span>
        </div>
        <div class="inventoryInner">
            <?php foreach($params['farmAccessories']['tools'] AS $tool): ?>
                <div class="inventorySmallBox">
                    <img src="<?= $base_img."farm/accessory/".$tool['name'].".png" ?>" />
                    <span class="inventoryNameOnly"><?= $lang[$tool['name']] ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    <?php if(count($params['farmAccessories']['specialTools']) > 0): ?>
    <div class="inventoryContainer">
        <div class="inventoryTitle">
            <span>
                <?= $lang['specialAccessory'] ?>
            </span>
        </div>
        <div class="inventoryInner">
            <?php foreach($params['farmAccessories']['specialTools'] AS $special): ?>
                <div class="inventorySmallBox">
                    <img src="<?= $base_img."farm/accessory/".$special['name'].".png" ?>" />
                    <span class="inventoryNameOnly"><?= $lang[$special['name']] ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

</div>
<?php endif; ?>