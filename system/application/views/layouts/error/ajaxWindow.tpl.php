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
    <?php elseif($params['action'] == 'showPartnerInventory'): ?>
        var output = $('#showPartnerInventory');
        var titleText = "<?= $lang['showPartnerInventory'] ?>";
    <?php elseif($params['action'] == 'reapConfirm'): ?>
        var output = $('#reapConfirm');
        var titleText = "<?= $lang['reapConfirm']['title'] ?>";
    <?php endif; ?>
    new Boxy(output, {title: titleText,modal: true , closeText:"<img src=\"<?= $base_img ?>/popup/boxy/farmBoxy/close.gif\" />"<?php if($params['action'] == 'reapConfirm'): ?>,afterHide: function() {
                                                                                                                                                                                                      <?php if(!$params['details']['endGame']): ?>
                                                                                                                                                                                                            location.reload();
                                                                                                                                                                                                      <?php else: ?>
                                                                                                                                                                                                            window.location.replace("<?php echo base_url().$params['details']['path']; ?>");
                                                                                                                                                                                                      <?php endif; ?>
                                                                                                                                                                                                      }<?php endif; ?>});
</script>

<?php if($params['action'] == 'mission'): ?>
<script>
$('#plantCategory div').click(function(){
    $('.plantHolder').hide();
    var idx = $(this).attr('id');
    $('.category').css('background-position','0 0');
    $(this).css('background-position','0 -17px');
    $('#plantHolder-'+idx).fadeIn();
})
</script>
<div id="mission">
    <div id="missionBoxHolder">
        <div class="levelHolder">
            <?= $lang['farmLevel'].": ".convert_number($params['mission']['level']) ?>
        </div>
        <div class="missionDetailsHolder">
            <?= $params['mission']['description'] ?>
        </div>
        <?php
        $firstLoopChecker = TRUE;
        foreach($params['mission']['plant'] AS $plant): ?>
        <div class="plantHolder" id="plantHolder-<?= $plant['name'] ?>" <?php if($firstLoopChecker){echo "style=\"display:block\"";$firstLoopChecker = FALSE;} ?>>
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
                //echo "<span class=\"detailsTitle\">".$lang['firstPrice'].": </span>".convert_number($plant['price']).$lang['yummyMoneyUnit']."<br/>";
                //echo "<span class=\"detailsTitle\">".$lang['lastPrice'].": </span>".convert_number($plant['sellPrice']).$lang['yummyMoneyUnit']."<br/>";

                
                echo "<span class=\"detailsTitle\">".$lang['weightInSection'].": </span>".convert_number($plant['weight']).$lang['kilogram']."<br/>";
                
                if($plant['resource'][1] == 0.25)
                    $plant['resource'][1] = $lang['oneQuerter'];
                elseif($plant['resource'][1] == 0.5)
                    $plant['resource'][1] = $lang['half'];
                else
                    $plant['resource'][1] = convert_number($plant['resource'][1]);
                
                if($plant['resource'][2] == 0.25)
                    $plant['resource'][2] = $lang['oneQuerter'];
                elseif($plant['resource'][2] == 0.5)
                    $plant['resource'][2] = $lang['half'];
                else
                    $plant['resource'][2] = convert_number($plant['resource'][2]);

                echo "<span class=\"detailsTitle\">".$lang['waterConsume'].": </span>".str_replace(__HOUR__,$plant['resource'][1] , $lang['usagePerHour'])."<br/>";
                echo "<span class=\"detailsTitle\">".$lang['muckConsume'].": </span>".str_replace(__HOUR__,$plant['resource'][2] , $lang['usagePerHour'])."<br/>";
                //echo "<span class=\"detailsTitle\">".$lang['totalPrice'].": </span>".convert_number($plant['price'])."x".convert_number($plant['weight'])."=<b style=\"font-size:15px\">".convert_number((string)($plant['weight']*$plant['price']))."</b><br/><br/>";
                echo str_replace(array(__TYPE__,__TOTALPRICE__),array("<span class=\"detailsTitle\">".$lang[$plant['name']]."</span>","<span class=\"detailsTitle\">".($plant['weight']*$plant['price']*$params['mission']['section'])."</span>"), $lang['totalPrice'])."<br/>";
                echo str_replace(array(__LASTPRICE__),array("<span class=\"detailsTitle\">".($plant['weight']*$plant['sellPrice']*$params['mission']['section'])."</span>"), $lang['lastPrice'])."<br/>";
                
                if($params['mission']['accessories'])
                {
                    echo "<span class=\"detailsTitle\">$lang[neededAccessories]: </span>";
                    foreach ($params['mission']['accessories'] as $acc)
                        echo $lang[$acc];
                }
                
                ?>
            </div>
        </div>
        <?php endforeach; ?>
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
                <span style="margin: 23px 0 0 0;display: block"><?= $lang['haventEquipmentForThisLevel'] ?></span>
            <?php endif; ?>
        </div>
    </div>
    <div id="ajaxAlertBox"></div>
    <div id="plantCategory">
        <?php
        if(count($params['mission']['plant']) > 1):
            $firstLoopChecker = TRUE;
            foreach($params['mission']['plant'] AS $plantName): ?>
            <div class="category" id="<?= $plantName[name] ?>" <?php if($firstLoopChecker){echo "style=\"background-position:0 -17px\"";$firstLoopChecker = FALSE;} ?>><?= $lang[$plantName['name']] ?></div>
        <?php
              endforeach;
              endif;
        ?>
    </div>
</div>
<?php elseif($params['action'] == 'buyAccessory'): ?>
<script>
$('.buyAccessoryCategory div').click(function(){
    var _ns = $(this).parent().attr('id');
    $('.buyAcc'+_ns).hide();
    var idx = $(this).attr('id');
    $('.buyAccessoryCategory div.buyAccessoryCategoryItem').css('background-position','0 0');
    $('.buyAccessoryCategory div.buyCatDisable').css('background-position','0 -34px');
    $(this).css('background-position','0 -17px');
    $('#buyAcc-'+idx).fadeIn();
})
</script>
<div id="buyAccessory">
    <div  class="inventoryContainer">
        <div class="inventoryTitle">
            <?= $lang['attackAccessory'] ?>
        </div>
        <div class="inventoryVerticalLine"></div>
        <div class="inventoryInner">
            <div class="buyAccessoryDetails">
            <?php
            $firstLoopChecker = TRUE;
            foreach($params['accessories']['attack'] AS $attackTools): ?>
                <div class="buyAccAttack" id="buyAcc-<?= $attackTools->name ?>" <?php if(!$firstLoopChecker): ?> style="display: none;" <?php endif; ?>>
                    <div class="accessoryImg">
                        <img src="<?= $base_img."farm/accessory/".$attackTools->name.".png" ?>" />
                    </div>
                    <div class="accessoryDetail">
                        <span class="accessoryName"><?= $lang[$attackTools->name] ?></span>
                        <div class="accessorySpecific">
                            <span class="title"><?= $lang['farmLevel'] ?>: </span>
                            <span><?= convert_number($attackTools->level) ?></span>
                        </div>
                        <div class="accessorySpecific">
                            <span class="title"><?= $lang['price'] ?>: </span>
                            <span><?= convert_number($attackTools->price)." ".$lang['yummyMoneyUnit'] ?></span>
                        </div>
                        <div class="accessoryDescription">
                            <?= $attackTools->description ?>
                        </div>
                    </div>
                    <div class="buyAccessoryButton">
                        <?php if($params['farm_level'] >= $attackTools->level): ?>
                            <?= anchor(" "," ",array('onclick'=>"addAccessoryToFarm(".$params['farm_id'].",".$attackTools->id.");return false;")); ?>
                        <?php else: ?>
                            <span class="disableBuyButton"></span>
                        <?php endif; ?>
                    </div>
                    <div class="buyAccessoryReport" id="buyAccessoryReport-<?= $attackTools->id ?>">
                        <?php if(key_exists($attackTools->id, $params['farmAccs']))
                                if($params['farmAccs'][$attackTools->id] > 0)
                                   if($params['farmAccs'][$attackTools->id] != 7 || $params['farmAccs'][$attackTools->id] != 8)
                                        echo str_replace(array(__COUNT__,__ACCESSORY__),array(convert_number($params['farmAccs'][$attackTools->id]),$lang[$attackTools->name]), $lang['farmAccCounter']);
                                   else
                                        echo $lang['farmHaveThisAcc'];
                                else
                                        echo $lang['farmHaventThisAcc'];
                              else
                                        echo $lang['farmHaventThisAcc'];
                        ?>
                    </div>
                </div>
            <?php
            $firstLoopChecker = FALSE;
            endforeach; ?>
            </div>
                <div class="buyAccessoryCategory" id="Attack">
                    <?php
                    $firstLoopChecker = TRUE;
                    foreach($params['accessories']['attack'] AS $attackTools): ?>
                        <div id="<?= $attackTools->name ?>" class="<?= ($params['farm_level'] >= $attackTools->level)?'buyAccessoryCategoryItem':'buyCatDisable' ; ?>"<?php if($firstLoopChecker): ?>style="background-position: 0 -17px;"<?php endif; ?>>
                            <?= $lang[$attackTools->name] ?>
                        </div>
                    <?php
                    $firstLoopChecker = FALSE;
                    endforeach; ?>
                </div>
        </div>
    </div>


    <div  class="inventoryContainer">
        <div class="inventoryTitle">
            <?= $lang['deffenceAccessory'] ?>
        </div>
        <div class="inventoryVerticalLine"></div>
        <div class="inventoryInner">
            <div class="buyAccessoryDetails">
            <?php
            $firstLoopChecker = TRUE;
            foreach($params['accessories']['deffence'] AS $deffenceTools): ?>
                <div class="buyAccDeffence" id="buyAcc-<?= $deffenceTools->name ?>" <?php if(!$firstLoopChecker): ?> style="display: none;" <?php endif; ?>>
                    <div class="accessoryImg">
                        <img src="<?= $base_img."farm/accessory/".$deffenceTools->name.".png" ?>" />
                    </div>
                    <div class="accessoryDetail">
                        <span class="accessoryName"><?= $lang[$deffenceTools->name] ?></span>
                        <div class="accessorySpecific">
                            <span class="title"><?= $lang['farmLevel'] ?>: </span>
                            <span><?= convert_number($deffenceTools->level) ?></span>
                        </div>
                        <div class="accessorySpecific">
                            <span class="title"><?= $lang['price'] ?>: </span>
                            <span><?= convert_number($deffenceTools->price)." ".$lang['yummyMoneyUnit'] ?></span>
                        </div>
                        <div class="accessoryDescription">
                            <?= $deffenceTools->description ?>
                        </div>
                    </div>
                    <div class="buyAccessoryButton">
                        <?php if($params['farm_level'] >= $deffenceTools->level): ?>
                            <?= anchor(" "," ",array('onclick'=>"addAccessoryToFarm(".$params['farm_id'].",".$deffenceTools->id.");return false;")); ?>
                        <?php else: ?>
                            <span class="disableBuyButton"></span>
                        <?php endif; ?>
                    </div>
                    <div class="buyAccessoryReport" id="buyAccessoryReport-<?= $deffenceTools->id ?>">
                        <?php if(key_exists($deffenceTools->id, $params['farmAccs']))
                                if($params['farmAccs'][$deffenceTools->id] > 0)
                                   if($deffenceTools->id != 7 && $deffenceTools->id != 8 && $deffenceTools->id != 3)
                                        echo str_replace(array(__COUNT__,__ACCESSORY__),array(convert_number($params['farmAccs'][$deffenceTools->id]),$lang[$deffenceTools->name]), $lang['farmAccCounter']);
                                   else
                                        echo $lang['farmHaveThisAcc'];
                                else
                                        echo $lang['farmHaventThisAcc'];
                              else
                                        echo $lang['farmHaventThisAcc'];
                        ?>
                    </div>
                </div>
            <?php
            $firstLoopChecker = FALSE;
            endforeach; ?>
            </div>
                <div class="buyAccessoryCategory" id="Deffence">
                    <?php
                    $firstLoopChecker = TRUE;
                    foreach($params['accessories']['deffence'] AS $deffenceTools): ?>
                        <div id="<?= $deffenceTools->name ?>" class="<?= ($params['farm_level'] >= $deffenceTools->level)?'buyAccessoryCategoryItem':'buyCatDisable' ; ?>"<?php if($firstLoopChecker): ?>style="background-position: 0 -17px;"<?php endif; ?>>
                            <?= $lang[$deffenceTools->name] ?>
                        </div>
                    <?php
                    $firstLoopChecker = FALSE;
                    endforeach; ?>
                </div>
        </div>
    </div>


    <div  class="inventoryContainer">
        <div class="inventoryTitle">
            <?= $lang['toolAccessory'] ?>
        </div>
        <div class="inventoryVerticalLine"></div>
        <div class="inventoryInner">
            <div class="buyAccessoryDetails">
            <?php
            $firstLoopChecker = TRUE;
            foreach($params['accessories']['tools'] AS $tools): ?>
                <div class="buyAccTools" id="buyAcc-<?= $tools->name ?>" <?php if(!$firstLoopChecker): ?> style="display: none;" <?php endif; ?>>
                    <div class="accessoryImg">
                        <img src="<?= $base_img."farm/accessory/".$tools->name.".png" ?>" />
                    </div>
                    <div class="accessoryDetail">
                        <span class="accessoryName"><?= $lang[$tools->name] ?></span>
                        <div class="accessorySpecific">
                            <span class="title"><?= $lang['farmLevel'] ?>: </span>
                            <span><?= convert_number($tools->level) ?></span>
                        </div>
                        <div class="accessorySpecific">
                            <span class="title"><?= $lang['price'] ?>: </span>
                            <span><?= convert_number($tools->price)." ".$lang['yummyMoneyUnit'] ?></span>
                        </div>
                        <div class="accessoryDescription">
                            <?= $tools->description ?>
                        </div>
                    </div>
                    <div class="buyAccessoryButton">
                        <?php if($params['farm_level'] >= $tools->level): ?>
                            <?= anchor(" "," ",array('onclick'=>"addAccessoryToFarm(".$params['farm_id'].",".$tools->id.");return false;")); ?>
                        <?php else: ?>
                            <span class="disableBuyButton"></span>
                        <?php endif; ?>
                    </div>
                    <div class="buyAccessoryReport" id="buyAccessoryReport-<?= $tools->id ?>">
                        <?php if(key_exists($tools->id, $params['farmAccs']))
                                if($params['farmAccs'][$tools->id] > 0)
                                        echo $lang['farmHaveThisAcc'];
                                else
                                        echo $lang['farmHaventThisAcc'];
                              else
                                        echo $lang['farmHaventThisAcc'];
                        ?>
                    </div>
                </div>
            <?php
            $firstLoopChecker = FALSE;
            endforeach; ?>
            </div>
                <div class="buyAccessoryCategory" id="Tools">
                    <?php
                    $firstLoopChecker = TRUE;
                    foreach($params['accessories']['tools'] AS $tools): ?>
                        <div id="<?= $tools->name ?>" class="<?= ($params['farm_level'] >= $tools->level)?'buyAccessoryCategoryItem':'buyCatDisable' ; ?>"<?php if($firstLoopChecker): ?>style="background-position: 0 -17px;"<?php endif; ?>>
                            <?= $lang[$tools->name] ?>
                        </div>
                    <?php
                    $firstLoopChecker = FALSE;
                    endforeach; ?>
                </div>
        </div>
    </div>


    <div  class="inventoryContainer">
        <div class="inventoryTitle">
            <?= $lang['specialAccessory'] ?>
        </div>
        <div class="inventoryVerticalLine"></div>
        <div class="inventoryInner">
            <div class="buyAccessoryDetails">
            <?php
            $firstLoopChecker = TRUE;
            foreach($params['accessories']['specialTools'] AS $specialTools): ?>
                <div class="buyAccSpecialTools" id="buyAcc-<?= $specialTools->name ?>" <?php if(!$firstLoopChecker): ?> style="display: none;" <?php endif; ?>>
                    <div class="accessoryImg">
                        <img src="<?= $base_img."farm/accessory/".$specialTools->name.".png" ?>" />
                    </div>
                    <div class="accessoryDetail">
                        <span class="accessoryName"><?= $lang[$specialTools->name] ?></span>
                        <div class="accessorySpecific">
                            <span class="title"><?= $lang['farmLevel'] ?>: </span>
                            <span><?= convert_number($specialTools->level) ?></span>
                        </div>
                        <div class="accessorySpecific">
                            <span class="title"><?= $lang['price'] ?>: </span>
                            <span><?= convert_number($specialTools->price)." ".$lang['yummyMoneyUnit'] ?></span>
                        </div>
                        <div class="accessoryDescription">
                            <?= $specialTools->description ?>
                        </div>
                    </div>
                    <div class="buyAccessoryButton">
                        <?php if($params['farm_level'] >= $specialTools->level): ?>
                            <?= anchor(" "," ",array('onclick'=>"addAccessoryToFarm(".$params['farm_id'].",".$specialTools->id.");return false;")); ?>
                        <?php else: ?>
                            <span class="disableBuyButton"></span>
                        <?php endif; ?>
                    </div>
                    <div class="buyAccessoryReport" id="buyAccessoryReport-<?= $specialTools->id ?>">
                        <?php if(key_exists($specialTools->id, $params['farmAccs']))
                                if($params['farmAccs'][$specialTools->id] > 0)
                                    echo $lang['farmHaveThisAcc'];
                                else
                                    echo $lang['farmHaventThisAcc'];
                              else
                                echo $lang['farmHaventThisAcc'];
                        ?>
                    </div>
                </div>
            <?php
            $firstLoopChecker = FALSE;
            endforeach; ?>
            </div>
                <div class="buyAccessoryCategory" id="SpecialTools">
                    <?php
                    $firstLoopChecker = TRUE;
                    foreach($params['accessories']['specialTools'] AS $specialTools): ?>
                        <div id="<?= $specialTools->name ?>" class="<?= ($params['farm_level'] >= $specialTools->level)?'buyAccessoryCategoryItem':'buyCatDisable' ; ?>"<?php if($firstLoopChecker): ?>style="background-position: 0 -17px;"<?php endif; ?>>
                            <?= $lang[$specialTools->name] ?>
                        </div>
                    <?php
                    $firstLoopChecker = FALSE;
                    endforeach; ?>
                </div>
        </div>
    </div>
    

</div>
<?php elseif($params['action'] == 'showInventory'): ?>
<div id="showInventory">
    <?php if(count($params['farmAccessories']['attack']) < 1 &&
             count($params['farmAccessories']['deffence']) < 1 &&
             count($params['farmAccessories']['specialTools']) < 1 &&
             count($params['farmAccessories']['tools']) < 1)
                 if(!$params['partnerView'])
                    echo "<div class=\"errorMess\">".$lang['haventAnyAccessory']."</div>";
                 else
                    echo "<div class=\"errorMess\">".$lang['thisFarmHaventAnyAccessory']."</div>";
    ?>
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
                        <?php if($deffTools['id'] != 3) :?>
                            <span class="inventoryName"><?= $lang[$deffTools['name']] ?></span>
                            <span class="inventoryCounter"><span><?= $deffTools['count'] ?></span></span>
                        <?php else: ?>
                            <span class="inventoryNameOnly"><?= $lang[$deffTools['name']] ?></span>
                        <?php endif; ?>
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
<?php elseif($params['action'] == 'showPartnerInventory'): ?>
<script>
$('.buyAccessoryCategory div').click(function(){
    var _ns = $(this).parent().attr('id');
    $('.buyAcc'+_ns).hide();
    var idx = $(this).attr('id');
    $('.buyAccessoryCategory div.attackPartnerCategoryItem').css('background-position','0 0');
    $(this).css('background-position','0 -17px');
    $('#buyAcc-'+idx).fadeIn();
})
</script>
<div id="showPartnerInventory">
    <?php if(count($params['farmAccessories']['attack']) < 1 &&
             count($params['farmAccessories']['deffence']) < 1 &&
             count($params['farmAccessories']['specialTools']) < 1 &&
             count($params['farmAccessories']['tools']) < 1):
                echo "<div class=\"errorMess\">".$lang['haventAnyAccessory']."</div>";
         else:
    ?>
    <div  class="inventoryContainer">
        <div class="inventoryTitle">
            <?= $lang['attackAccessory'] ?>
        </div>
        <div class="inventoryVerticalLine"></div>
        <div class="inventoryInner">
            <div class="attackPartnerDetails">
            <?php 
            $firstLoopChecker = TRUE;
            foreach($params['farmAccessories']['attack'] AS $attackTools): ?>
                <div class="buyAccAttack" id="buyAcc-<?= $attackTools['name'] ?>" <?php if(!$firstLoopChecker): ?> style="display: none;" <?php endif; ?>>
                    <div class="accessoryImg">
                        <img src="<?= $base_img."farm/accessory/".$attackTools['name'].".png" ?>" />
                    </div>
                    <div class="accessoryDetail">
                        <span class="accessoryName"><?= $lang[$attackTools['name']] ?></span>
                        
                        <div class="accessoryDescription">
                            <?= $attackTools['description'] ?>
                        </div>
                    </div>
                    <div class="attackPartnerButton">
                            <?= anchor(" "," ",array('onclick'=>"addtransaction(".$attackTools['id'].",".$attackTools['type'].");return false;")); ?>
                    </div>
                    <div class="buyAccessoryReport" id="buyAccessoryReport-<?= $attackTools->id ?>">
                        <?= $lang['harmThisFarm'] ?>
                    </div>
                </div>
            <?php
            $firstLoopChecker = FALSE;
            endforeach; ?>
            </div>
                <div class="buyAccessoryCategory" id="Attack">
                    <?php
                    $firstLoopChecker = TRUE;
                    foreach($params['farmAccessories']['attack'] AS $attackTools): ?>
                        <div id="<?= $attackTools['name'] ?>" class="attackPartnerCategoryItem" <?php if($firstLoopChecker): ?>style="background-position: 0 -17px;"<?php endif; ?>>
                            <?= $lang[$attackTools['name']] ?>
                        </div>
                    <?php
                    $firstLoopChecker = FALSE;
                    endforeach; ?>
                </div>
        </div>
    </div>
<?php endif; ?>
</div>
<?php elseif($params['action'] == 'reapConfirm'): ?>
<div id="reapConfirm">
    <div class="reapDetails">
        <div class="farmTitle">
            <?= $lang['farm']." ".$params['params']['farmName'] ?>
        </div>
        <div class="reapMissionItem">
            <span class="header"><?= $lang['plantType'] ?>:</span>
            <span><?= $lang[$params['details']['typeName']] ?></span>
        </div>
        <div class="reapMissionItem">
            <span class="header"><?= $lang['plantHealth'] ?>:</span>
            <span><?= "%".convert_number((string) $params['details']['health']) ?></span>
        </div>
        <div class="reapMissionItem">
            <span class="header"><?= $lang['farmCapacity'] ?>:</span>
            <span><?= $params['details']['farmCapacity']." ".$lang['kilogram'] ?></span>
        </div>
        <div class="reapMissionItem">
            <span class="header"><?= $lang['amountProduct'] ?>:</span>
            <span><?= (int) $params['details']['amountProduct']." ".$lang['kilogram'] ?></span>
        </div>
        <div class="reapMissionItem">
            <span class="header"><?= $lang['reapTime'] ?>:</span>
            <span><?= convert_number(fa_strftime("%d %B %Y %H:%M:%S", date("Y-m-d H:i:s",$params['details']['reapTime']) . "")) ?></span>
        </div>
        <div class="reapMissionItem">
            <span class="header"><?= $lang['reapIncome'] ?>:</span>
            <span><?= convert_number((string) $params['details']['totalCost'])." ".$lang['yummyMoneyUnit'] ?></span>
        </div>
        <div class="reapMissionItem">
            <span class="header"><?= $lang['reapBonusIncome'] ?>:</span>
            <span>
                <?= ($params['details']['bonus'] != 0)?convert_number((string) $params['details']['bonus'])." ".$lang['yummyMoneyUnit']:'--' ?>
            </span>
        </div>
    </div>
    <div class="truck">
        <?php
        if($params['details']['level'] == 9 || $params['details']['level'] == 10 || $params['details']['level'] == 11)
            $typeName = 'product';
        else
            $typeName = $params['details']['typeName'];
        echo str_replace(array('__TYPENAME__','__NEEDED__','__AMOUNT__'),
                         array("<span style=\"color: #b3e358\">".$lang[$typeName]."</span>","<span style=\"color: #b3e358\">".$params['details']['misAmount']."</span>","<span style=\"color: #b3e358\">".$params['details']['stackAmount']."</span>"),
                         $lang['reapCondition']) ?>
    </div>
    <div class="levelUpgrade">
        <?php if($params['details']['levelUpgrade']): ?>
            <?php if($params['details']['level'] != 11): ?>
                <div class="levelIncrease">
                    <div class="oldLevel"><?= convert_number((string)($params['details']['level']-1)) ?></div>
                    <div class="newLevel"><?= convert_number((string)$params['details']['level']) ?></div>
                </div>
                <div class="levelIncreaseDescription"><?= $lang['levelUpgradeDescription'] ?></div>
            <?php else: ?>
                <div class="levelEnded"><?= $lang['levelEnded'] ?></div>
            <?php endif; ?>
        <?php else: ?>
            <div class="levelEnded"><?= $lang['levelRetry'] ?></div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>