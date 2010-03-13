<style>
.smallcounter{height:25px;width:100px;padding:2px;color:#60ABD2}
.healthcounter{height:50px;width:200px}

</style>

<script>
    function ajax_request(handler, url, params ,callback) {
        $(handler).loading({
                            pulse: false,
                            text: 'Loading',
                            align: 'center',
                            img: '<?= $base_img ?>ajax-loader.gif' ,
                            delay: '200',
                            max: '1000',
                            mask: true
                            });
        $(handler).load(url, params,callback);
        
    }

    function liftOff() {
        alert($(this).parent().attr('class')+' Expired');
    }

    function reapTime() {
        location.reload();
    }

    function moneyCalculate()
    {
       ajax_request('#moneyHolder', '<?= base_url() ?>farms/moneyCalc');
    }

    function addResourceToFarm(farm_id , resource_id){
	var params = {};
     	params['farm_id'] = farm_id;
	params['resource_id'] = resource_id;

        ajax_request('#farmResourceHolder', '<?= base_url() ?>farms/addResourceToFarm', params ,moneyCalculate)
    }
    
    function addAccessoryToFarm(farm_id , accessory_id){
	var params = {};
     	params['farm_id'] = farm_id;
	params['accessory_id'] = accessory_id;

        ajax_request('#farmAccessoryHolder', '<?= base_url() ?>farms/addAccessoryToFarm', params ,moneyCalculate)
    }

    function addPlantToFarm(farm_id , type_id){
	var params = {};
     	params['farm_id'] = farm_id;
	params['type_id'] = type_id;

        ajax_request('#plantHolder', '<?= base_url() ?>farms/addPlantToFarm', params)
    }
    function addResourceToPlant(resource_id , plant_id){
	var params = {};
     	params['plant_id'] = plant_id;
	params['resource_id'] = resource_id;

        ajax_request('#plantHolder', '<?= base_url() ?>farms/addResourceToPlant', params)
    }
    function reap(plant_id)
    {
        var params = {};
        params['plant_id'] = plant_id;

        ajax_request('#plantHolder', '<?= base_url() ?>farms/reap', params)
    }
    function plow(farm_id)
    {
        var params = {};
        params['farm_id'] = farm_id;

        ajax_request('#farmPlow', '<?= base_url() ?>farms/plow', params)
    }
    function spraying(farm)
    {
        var params = {};
        params['farm'] = farm;

        ajax_request('#farmSpraying', '<?= base_url() ?>farmtransactions/spraying', params)
    }
    function sync(farm_id)
    {
        var params = {};
        params['farm_id'] = farm_id;

        ajax_request('#healthHolder', '<?= base_url() ?>farms/sync', params)
    }
    function disasters(farm_id)
    {
        var params = {};
        params['farm_id'] = farm_id;

        ajax_request('#test', '<?= base_url() ?>farms/disasters', params)
    }
    function useEquipment(equipment, farm_id)
    {
        var params = {};
        params['equipment'] = equipment;
        params['farm_id'] = farm_id;

        ajax_request('#farmSection', '<?= base_url() ?>farms/useEquipment', params, moneyCalculate)
    }
    $(document).ready(function() {
        var timeHolder = <?= rand(50000, 500000); ?>;
        var t=setTimeout('disasters(<?= $farm->id ?>)',timeHolder);
    });
    
    
</script>
<div id="farmWrapper">
    <div id="farm">
        <h4>Farm Plants</h4>
        PlantType:<?= $plant->typeName ?><br/>
        FarmSection:<span id="farmSection"><?= $farm->section ?></span><br/>
        Plow:<span id="farmPlow"><?= $farm->plow ?></span><br/>

        <?=
        anchor("farms/plow/$farm->id",
                            "Plow Farm",
                             array('onclick'=>"plow(".$farm->id.");return false;"))."<br/>";
        ?>

        Sprying:<span id="farmSpraying"></span><br/>

        <?=
        anchor("farmtransactions/spraying",
                            "Spraying Farm",
                             array('onclick'=>"spraying(".$farm->id.");return false;"))."<br/>";
        ?>
        
        <div id="plantHolder"></div>
        
        
    </div>

    <div id="farmOwner">
        <h4>Farm Owner</h4>
        FarmName:<?= anchor("profile/user/$farm->user_id", $farm->name) ?><br/>
        FarmLevel:<?= $farm->level ?><br/>
            FarmMoney:<span id="moneyHolder"><?= $farm->money ?></span>$
    </div>

    <div id="farmHints">
        <h4>Hints</h4>
        <?= $hints[0] ?>
    </div>

    <div id="farmNotification">
        <h4>Notifications</h4><span id="test"></span>
        <?php
        foreach($notifications AS $not)
            echo $not->details;
        ?>
    </div>

    <div id="health">
        <h4>Plant Health</h4>
        <span id="healthHolder">
        PlantHealth:<?= $plant->health ?>
        <span>
        <?=
            anchor("farms/sync/$farm->id",
                   "<img src=\"".$base_img."sync.png\" />",
                   array('onclick'=>"sync(".$farm->id.");return false;"))."<br/>";
        ?>
            </span>
        <?php if($plant->growth > 0 && $plant->health > 0): ?>
                PlantGrowth:
        
        <div id="plantGrowthHolder" class="healthcounter"></div>
        
        <script>
            $(function () {
                var growthTime = <?= $plant->growth; ?>;
                $('#plantGrowthHolder').countdown({until: growthTime,
                                                   onExpiry: reapTime
                                                 });
            });
        </script>

        <?php elseif($plant->id):
                echo anchor("farms/reap/$plant->id",
                            "REAP",
                             array('onclick'=>"reap(".$plant->id.");return false;"))."<br/>";
              endif;
        ?>
        </span>
    </div>
    
    <div id="farmResource">
        <h4>Farm Resources</h4>
        <span id="farmResourceHolder">
            <?= $farmResources ?>
        </span>
    </div>

    <div id="plantResource">
        <h4>Plant Resources</h4>
        <span id="plantResourceHolder">
        <?php
        if(isset($plant->plantresources))
        foreach($plant->plantresources AS $pltSrc)
        {
                ?>
                <div class="bubbleInfo">
                <?php
                foreach($pltSrc->typeresource AS $typSrc)
                        foreach($typSrc->resource AS $src)
                                echo "<img class=\"trigger\" id=\"download\" src=\"".$base_img."farm/resource/".strtolower($src->name).".png\" height=\"48px\" weidth=\"48px\" /> ";
                ?>

                <table id="dpop" class="popup">
                        <tbody>
                            <tr>
                                    <td id="topleft" class="corner"></td>
                                    <td class="top"></td>
                                    <td id="topright" class="corner"></td>
                            </tr>
                            <tr>
                                    <td class="left"></td>
                                    <td>
                                        <table class="popup-contents">
                                            <tbody>
                                                <tr>
                                                    <th>Time:</th>
                                                    <td class="<?= $src->name ?>">
                                                        <div id="srcRemainTimeHolder<?= $pltSrc->id ?>" class="smallcounter"></div>
                                                        <script>
                                                            $(function () {
                                                                var remainTime = <?= $pltSrc->usedTime; ?>;
                                                                $('#srcRemainTimeHolder<?= $pltSrc->id ?>').countdown({until: remainTime,
                                                                                                                       onExpiry: liftOff ,
                                                                                                                       expiryText: '<div class="over"><?= $src->name ?> Expired</div>'
                                                                                                                       });
                                                            });
                                                        </script>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="right"></td>
                            </tr>
                            <tr>
                                    <td class="corner" id="bottomleft"></td>
                                    <td class="bottom"><img width="30" height="29" alt="popup tail" src="<?= $base_img ?>popup/bubble-tail2.png"/></td>
                                    <td id="bottomright" class="corner"></td>
                            </tr>
                        </tbody>
                </table>
            </div>
        <?php
        }
        ?>
        </span>
    </div>

    <div id="farmAccessories">
        <h4>Farm Accessories</h4>
        <span id="farmAccessoryHolder">
        <?php
        foreach ($farmAcc AS $fAcc)
        {
                echo "Name: ".$fAcc->name." Typ:".$fAcc->type." Cnt:".$fAcc->count."<br/>";
        }
        ?>
        </span>
    </div>

    <div id="accessories">
        <h4>Accessories</h4>

        <?php
        foreach($accessories AS $acc)
                echo anchor("farms/addAccessoryToFarm/$farm->id/$acc->id",
                            "<img src=\"".$base_img."farm/accessory/".strtolower($acc->name).".png\" height=\"48px\" weidth=\"48px\" title=\"$acc->name\"/>",
                             array('onclick'=>"addAccessoryToFarm(".$farm->id.",".$acc->id.");return false;"))."<br/>";
        ?>
    </div>
    
    <div id="equipments">
        <h4>Equipments</h4>
        
        <?php
        foreach($equipments AS $equipment)
                echo anchor("farms/useEquipment/$equipment/$farm->id",
                            "<img src=\"".$base_img."farm/equipment/".strtolower($equipment).".png\" height=\"48px\" weidth=\"48px\" title=\"$equipment\"/>",
                             array('onclick'=>"useEquipment('$equipment',$farm->id);return false;"))."<br/>";
        ?>
    </div>
    
    <div id="resources">
        <h4>Resources</h4>
        <?php
        foreach($resources AS $resource)
                echo anchor("farms/addResourceToFarm/$farm->id/$resource->id",
                            "$resource->name",
                             array('onclick'=>"addResourceToFarm(".$farm->id.",".$resource->id.");return false;"))."<br/>";
        ?>
    </div>


    <div id="plantTypes">
        <h4>Add Plant to Farm</h4>
        <?php
        foreach($types AS $type)
        {
                echo anchor("farms/addPlantToFarm/$farm->id/$type->id",
                            "$type->name",
                             array('onclick'=>"addPlantToFarm(".$farm->id.",".$type->id.");return false;"))."<br/>";
                
                echo "<hr/><span style='font-size:11px'>".str_replace('__CAPACITY__',$type->capacity,$lang['plantCapacity'])."</span>";
                
        }
                ?>
    </div>

    <div id="resourcePlant">
	<h4>Add Resource to Plant</h4>
        <?php
        if(isset($plantSources))
        foreach($plantSources AS $pltSrcName=>$pltSrcItem)
        {
                echo anchor("farms/addResourceToPlant/$pltSrcItem[0]/$pltSrcItem[1]",
                            "$pltSrcName",
                             array('onclick'=>"addResourceToPlant(".$pltSrcItem[0].",".$pltSrcItem[1].");return false;"))."<br/>";
        }
        ?>
    </div>
</div>