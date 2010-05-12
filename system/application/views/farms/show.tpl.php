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

        $('.plow-botton-on').removeClass('plow-botton-on').addClass('plow-botton-off').removeAttr('href');

        ajax_request('.unPlow:empty', '<?= base_url() ?>farms/plow', params ,moneyCalculate)
    }
    function spraying(farm)
    {
        var params = {};
        params['farm'] = farm;

        ajax_request('#farmSpraying', '<?= base_url() ?>farmtransactions/spraying', params);
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
    function deffenceWithGun(farm_id)
    {
        var params = {};
        params['farm_id'] = farm_id;

        ajax_request('#farmSection', '<?= base_url() ?>farmtransactions/deffenceWithGun', params)
    }
    function deleteNotification(id)
    {
        $("#notification-"+id).fadeOut("slow");

        var params = {};
        params['not_id'] = id;

        ajax_request('#farmSection', '<?= base_url() ?>farms/deleteNotification', params)
    }
    function syncNotification()
    {
        var params = {};
        params['farm_id'] = <?= $farm->id ?>;
        ajax_request('#notification','<?= base_url() ?>farms/syncNotification',params);
    }
    function resetConfirm1()
    {
        Boxy.confirm('<?= $lang['resetFarmConfirm-1'] ?>', resetConfirm2);
    }
    function resetConfirm2()
    {
        Boxy.confirm('<?= $lang['resetFarmConfirm-2'] ?>', resetConfirm3);
    }
    function resetConfirm3()
    {
        Boxy.confirm('<?= $lang['resetFarmConfirm-3'] ?>', resetFarm);
    }
    function resetFarm()
    {
        var params = {};
        params['farm_id'] = <?= $farm->id ?>;
        ajax_request('#reset', '<?= base_url() ?>farms/resetFarm', params);
    }
    $(document).ready(function() {
        var timeHolder = <?= rand(50000, 500000); ?>;
        var t=setTimeout('disasters(<?= $farm->id ?>)',timeHolder);
    });
</script>
<div id="farmWrapper">
    <div id="ajaxHolder"></div>
    <div id="base">
        <div id="farm">
            <div id="section-1" class="<?= ($farm->plow)?"plow":"unPlow" ?>"></div>
            <div id="section-2" class="<?= ($farm->section <2)?"unPlow":(($farm->plow)?"plow":"unPlow") ?>"><?php if($farm->section <2): ?><span class="section-2-off"></span><?php endif; ?></div>
            <div id="section-3" class="<?= ($farm->section <3)?"unPlow":(($farm->plow)?"plow":"unPlow") ?>"><?php if($farm->section <3): ?><span class="section-3-off"></span><?php endif; ?></div>
            <div id="section-4" class="<?= ($farm->section <4)?"unPlow":(($farm->plow)?"plow":"unPlow") ?>"><?php if($farm->section <4): ?><span class="section-4-off"></span><?php endif; ?></div>
            <div id="accessoryPlaceTop"></div>
            <div id="accessoryPlaceDown"></div>
            <div id="farmAction">
                <?php
                if(!$farm->plow)
                    echo anchor("farms/plow/$farm->id",
                               " ",
                               array('onclick'=>"plow(".$farm->id.");return false;",'class'=>'plow-botton-on'));
                else
                    echo "<a class=\"plow-botton-off\"></a>";

                if($farm->level == 1)
                    echo "<a class=\"spray-botton-off\"></a>";
                else
                    echo anchor("farmtransactions/spraying/$farm->id",
                                " ",
                                array('onclick'=>"reset(".$farm->id.");return false;",'class'=>'spray-botton-on'));
                if(!$plant->id || $plant->growth > 0)
                    echo "<a class=\"reap-botton-off\"></a>";
                else
                    echo anchor("farms/reap/$plant->id",
                                " ",
                                array('onclick'=>"reap(".$plant->id.");return false;",'class'=>'reap-botton-on'))
                ?>
            </div>
        </div>
        <div id="sidebar">
            <div id="farmInformation">
                <div id="farmInformationDetails">
                    <span class="farmInfoItem"><?= $lang['farm'] ?>:<span class="infoValue"><?= $farm->name ?></span></span>
                    <span class="farmInfoItem"><?= $lang['farmMoney'] ?>:<span class="infoValue"><?= $farm->money ?></span></span>
                    <span class="farmInfoItem"><?= $lang['farmLevel'] ?>:<span class="infoValue"><?= $farm->level ?></span></span>
                </div>
            </div>
            <div id="farmStatistic">
                <?php if($plant->id): ?>
                    <div class="farmStatisticOn">

                    </div>
                <?php else: ?>
                    <div class="farmStatisticOff">
                        <span>
                            <?= $lang['haventPlant'] ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>
            <div id="farmTime"></div>
            <div id="farmStatus"></div>
        </div>
    </div>
    <div id="panel">
        <div id="farmInventory"></div>
        <div id="farmAccessory"></div>
        <div id="farmResource"></div>
        <div id="farmMission">
            <div class="active">
                <span><?= $missionBox->description ?><br/>
                      <?= anchor("farms/mission/$missionBox->id",$lang['gotoMission'],array('onClick'=>"mission($missionBox->id)")) ?>
                </span>
            </div>
        </div>
        <div id="farmEquipment"></div>
    </div>
    <div id="bar"></div>
</div>