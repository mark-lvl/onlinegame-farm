<script>
    function ajax_request(handler, url, params ,callback) {
        $(handler).loading({
                            pulse: 'fade',
                            text: 'Loading',
                            align: {top:'10px',left:'10px'},
                            img: '<?= $base_img ?>ajax-loader.gif' ,
                            delay: '200',
                            max: '1000',
                            mask: true,
                            maskCss: { position:'absolute', opacity:.15, background:'#333',top:0,left:0,
                            zIndex:101, display:'block', cursor:'wait' }
                            });
       $(handler).load(url, params,callback);
    }

    function resourceExipre2() {
        alert('<?= $lang['resourceExpireMuck'] ?>');
    }
    function resourceExipre1() {
        alert('<?= $lang['resourceExpireWater'] ?>');
    }

    function reapTime() {
        var parentHolder = $('.reap-botton-off').parent();
        $('.reap-botton-off').hide();
        parentHolder.append("<a class=\"reap-botton-on\" onClick=\"reap(<?= $plant->id ?>);return false;\"></a>");
    }

    function moneyCalculate()
    {
       ajax_request('#moneyHolder', '<?= base_url() ?>farms/moneyCalc');
    }

    function addResourceToFarm(farm_id , resource_id){
	var params = {};
     	params['farm_id'] = farm_id;
	params['resource_id'] = resource_id;

        if(resource_id == 1)
            spaceHolder = "#waterAmount";
        else if (resource_id == 2)
            spaceHolder = "#muckAmount";

        ajax_request(spaceHolder, '<?= base_url() ?>farms/addResourceToFarm', params ,moneyCalculate);
    }
    function showInventory(farm_id){
	var params = {};
     	params['farm_id'] = farm_id;

        ajax_request('#ajaxHolder', '<?= base_url() ?>farms/showInventory', params);
    }
    function buyAccessory(farm_id, level){
	var params = {};
     	params['farm_id'] = farm_id;
     	params['farm_level'] = level;

        ajax_request('#ajaxHolder', '<?= base_url() ?>farms/buyAccessory', params);
    }
    function addAccessoryToFarm(farm_id , accessory_id){
	var params = {};
     	params['farm_id'] = farm_id;
	params['accessory_id'] = accessory_id;

        ajax_request('.buyAccessoryAjaxHolder'+accessory_id+':last', '<?= base_url() ?>farms/addAccessoryToFarm', params ,moneyCalculate);
    }

    function addPlantToFarm(farm_id , type_id){
	var params = {};
     	params['farm_id'] = farm_id;
	params['type_id'] = type_id;

        ajax_request('#ajaxHolder', '<?= base_url() ?>farms/addPlantToFarm', params);
    }
    function addResourceToPlant(resource_id , plant_id){
	var params = {};
     	params['plant_id'] = plant_id;
	params['resource_id'] = resource_id;

        ajax_request('#ajaxHolder', '<?= base_url() ?>farms/addResourceToPlant', params);

    }
    function reap(plant_id)
    {
        var params = {};
        params['plant_id'] = plant_id;

        ajax_request('#ajaxHolder', '<?= base_url() ?>farms/reap', params)
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

        ajax_request('#ajaxHolder', '<?= base_url() ?>farmtransactions/spraying', params);
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

        if(equipment == 'grassCutter')
            placeHolder = "#section-2";
        else if(equipment == 'waterPump')
            placeHolder = "#section-3";
        else if(equipment == 'rockBreaker')
            placeHolder = "#section-4";

        if($("#equipmentHolder-"+equipment).next() != "")
        {
            $("#equipmentHolder-"+equipment).hide();
            $("#equipmentHolder-"+equipment).next().fadeIn('fast');
        }


        $(placeHolder).children().fadeOut();

        ajax_request(placeHolder, '<?= base_url() ?>farms/useEquipment', params, moneyCalculate)
    }
    function deffenceWithGun(farm_id)
    {
        var params = {};
        params['farm_id'] = farm_id;

        ajax_request('#farmSection', '<?= base_url() ?>farmtransactions/deffenceWithGun', params)
    }
    function deleteNotification(id)
    {
        var elementHeight = $("#notification-"+id).height();
        var totalHeight = $(".subpanel").find("ul").height();

        var liHeightHolder = 0;
        $(".subpanel").find("ul li").each(function() {
            liHeightHolder += $(this).height;
        });

        alert(liHeightHolder);


        $("#notification-"+id).remove();

        var params = {};
        params['not_id'] = id;

        var heightHolder = totalHeight - elementHeight;
        $(".subpanel").find("ul").css({ 'height' :heightHolder})

        notificationCounter();
        ajax_request('#farmSection', '<?= base_url() ?>farms/deleteNotification', params);
    }
    function syncNotification()
    {
        var params = {};
        params['farm_id'] = <?= $farm->id ?>;

        
        ajax_request('#notification','<?= base_url() ?>farms/syncNotification',params,heightFixer);
        
        
    }
    function heightFixer()
    {
        var heightHolder = $("#notification").height();
        
        if(heightHolder > 600)
            $(".subpanel").find("ul").css({ 'height' :600})

        notificationCounter();
    }
    function notificationCounter()
    {
        $('#notificationCounter').html($('#mainpanel li').size()-1);
    }
    function mission(mission)
    {
       var farmPlow;
       var section = 0;
       var params = {};
       params['mission'] = mission;
       params['farm_id'] = <?= $farm->id ?>;
       if($('#section-1 div').attr('class'))
            ($('#section-1 div').attr('class') == 'plow')?farmPlow = 1:farmPlow = 0;
       else
            ($('#section-1').attr('class') == 'plow')?farmPlow = 1:farmPlow = 0;
       params['farm_plow'] = farmPlow;
       
       for(i=2;i<5;i++)
       {
            if($('.section-'+i+'-off').size())
                section++;
       }
       section = 4-section;
       params['section'] = section;
       ajax_request('#ajaxHolder','<?= base_url() ?>farms/mission',params);
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
    function syncFarm(farm_id)
    {
        var params = {};
        params['farm_id'] = farm_id;
        
        ajax_request('.farmStatisticOn', '<?= base_url() ?>farms/sync', params)
        setTimeout("syncFarm("+farm_id+")",300000);
    }

//    function sync(farm_id)
//    {
//        var params = {};
//        params['farm_id'] = farm_id;
//
//        ajax_request('.farmStatisticOn', '<?= base_url() ?>farms/sync', params)
//    }

    $(document).ready(function() {
        var timeHolder = <?= rand(50000, 500000); ?>;
        var t=setTimeout('disasters(<?= $farm->id ?>)',timeHolder);

        syncFarm(<?= $farm->id ?>);


        <?php if($plant->id): ?>
        $(".expandStatistic").click(function() {
		$('#lessStatistic').hide();
                $('#moreStatistic').fadeIn('fast');
                $("#healthBar").progressBar(<?= $plant->health ?>,{
                    boxImage: '<?= $base_img ?>profile/progressbar/progressbar.gif',
                    barImage: {
                                0:  '<?= $base_img ?>profile/progressbar/progressbg_red.gif',
                                30: '<?= $base_img ?>profile/progressbar/progressbg_orange.gif',
                                70: '<?= $base_img ?>profile/progressbar/progressbg_green.gif'
                    }
                });
	});
        $(".collapseStatistic").click(function() {
		$('#moreStatistic').hide();
                $('#lessStatistic').fadeIn('fast');
                $("#healthBar").progressBar(0,{
                    boxImage: '<?= $base_img ?>profile/progressbar/progressbar.gif',
                    barImage: {
                                0:  '<?= $base_img ?>profile/progressbar/progressbg_red.gif',
                                30: '<?= $base_img ?>profile/progressbar/progressbg_orange.gif',
                                70: '<?= $base_img ?>profile/progressbar/progressbg_green.gif'
                    }
                });
	});

        $(function () {
                var growthTime = <?= $plant->growth; ?>;
                $('#plantGrowthHolder').countdown({until: growthTime,
                                             onExpiry: reapTime,layout: '<div class="image{d10}"></div><div class="image{d1}"></div>' +
                                                                        '<div class="imageDay"></div><div class="imageSpace"></div>' +
                                                                        '<div class="image{h10}"></div><div class="image{h1}"></div>' +
                                                                        '<div class="imageSep"></div>' +
                                                                        '<div class="image{m10}"></div><div class="image{m1}"></div>' +
                                                                        '<div class="imageSep"></div>' +
                                                                        '<div class="image{s10}"></div><div class="image{s1}"></div>'
                                                 });

                <?php
                $resourceCounter = 1;
                if(isset($plant->plantresources))
                    foreach($plant->plantresources AS $pltSrc):
                ?>
                var remainTime = <?= $pltSrc->usedTime; ?>;
                $('#resourceCounter<?= $resourceCounter ?>').countdown({until: remainTime,
                                                                       onExpiry: resourceExipre<?= $resourceCounter ?> ,

                                                                       layout: '<div class="image{d10}"></div><div class="image{d1}"></div>' +
                                                                        '<div class="imageDay"></div><div class="imageSpace"></div>' +
                                                                        '<div class="image{h10}"></div><div class="image{h1}"></div>' +
                                                                        '<div class="imageSep"></div>' +
                                                                        '<div class="image{m10}"></div><div class="image{m1}"></div>' +
                                                                        '<div class="imageSep"></div>' +
                                                                        '<div class="image{s10}"></div><div class="image{s1}"></div>'
                                                                    });

                <?php
                $resourceCounter++;
                endforeach; ?>
            });
        <?php endif; ?>
    });
</script>
<div id="farmWrapper">
    <div id="ajaxHolder"></div>
    <div id="base">
        <div id="farm">
            <div id="section-1" class="<?= ($plant->id)?"plantGround":(($farm->plow)?"plow":"unPlow") ?>"></div>
            <div id="section-2" class="<?= ($farm->section <2)?"unPlow":(($plant->id)?"plantGround":(($farm->plow)?"plow":"unPlow")) ?>"><?php if($farm->section <2): ?><span class="section-2-off"></span><?php endif; ?></div>
            <div id="section-3" class="<?= ($farm->section <3)?"unPlow":(($plant->id)?"plantGround":(($farm->plow)?"plow":"unPlow")) ?>"><?php if($farm->section <3): ?><span class="section-3-off"></span><?php endif; ?></div>
            <div id="section-4" class="<?= ($farm->section <4)?"unPlow":(($plant->id)?"plantGround":(($farm->plow)?"plow":"unPlow")) ?>"><?php if($farm->section <4): ?><span class="section-4-off"></span><?php endif; ?></div>
            <div id="accessoryPlaceTop">
                <?php if(in_array("scarecrow", $farmAcc)): ?>
                <div class="scarecrow"></div>
                <?php endif; ?>
                <?php if(in_array("dog", $farmAcc)): ?>
                <div class="dog"></div>
                <?php endif; ?>
            </div>
            <div id="accessoryPlaceDown">
                <?php if(in_array("silo", $farmAcc)): ?>
                <div class="silo"></div>
                <?php endif; ?>
            </div>
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
                                array('onclick'=>"spraying(".$farm->id.");return false;",'class'=>'spray-botton-on'));
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
                    <span class="farmInfoItem"><?= $lang['farmMoney'] ?>:<span class="infoValue" id="moneyHolder"><?= $farm->money ?></span></span>
                    <span class="farmInfoItem"><?= $lang['farmLevel'] ?>:<span class="infoValue"><?= $farm->level ?></span></span>
                </div>
            </div>
            <div id="farmStatistic">
                <?php if($plant->id): ?>
                    <div class="farmStatisticOn innerStatistic">
                        <div id="lessStatistic">
                            <span class="statisticIcon">
                                <?php $healthHolder = ($plant->health > 80)?"Good":(($plant->health > 60)?"Middle":(($plant->health > 40)?"Bad":"VeryBad")) ?>
                                <span class="health<?= $healthHolder?>"></span>
                            </span>
                            <span class="statisticText">
                            <span class="statisticTextHeader"><?= $lang['healthFarm'] ?></span>
                                <?= str_replace('__HEALTH__', $lang[$healthHolder], $lang['farmStatisticsText']) ?>
                            <span class="expandStatistic"></span>
                            </span>
                        </div>
                        <div id="moreStatistic">
                            <div class="moreDivation">
                                <span class="label"><?= $lang['health'] ?></span>
                                <span class="value"><div id="healthBar" class="progressBar"></div></span>
                            </div>
                            <div class="moreDivation">
                                <span class="label"><?= $lang['weightInFarm'] ?></span>
                                <span class="value"><?= $plant->weight." ".$lang['kilogram'] ?></span>
                            </div>
                            <div class="collapseStatistic"></div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="farmStatisticOff innerStatistic">
                        <span>
                            <?= $lang['haventPlant'] ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>
            <div id="farmTime">
                <?php if($plant->id): ?>
                    <div class="on">
                        <div id="farmTimeHolder">
                            <div class="reapTimeHolder">
                                <div class="label">
                                    <?= $lang['reap'] ?>
                                </div>
                                <div class="time">
                                    <span class="reapCounter">
                                        <span id="plantGrowthHolder"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="resourceTimeHolder">
                                <div class="label">
                                    <?= $lang['water'] ?>
                                </div>
                                <div class="time">
                                    <span class="resourceCounter">
                                        <span id="resourceCounter1"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="resourceTimeHolder">
                                <div class="label">
                                    <?= $lang['muck'] ?>
                                </div>
                                <div class="time">
                                    <span class="resourceCounter">
                                        <span id="resourceCounter2"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="off">
                        <div id="farmTimeHolder">
                            <?= $lang['haventPlant'] ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div id="farmStatus">
                <?php if($statusBox): ?>
                <div class="on">
                    <span class="statusText">
                        <?= $statusBox ?>
                    </span>
                </div>
                <?php else: ?>
                <div class="off">
                    <span class="statusText">
                        <?= $lang['haventStack'] ?>
                    </span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div id="panel">
        <?= anchor("farms/showInventory/$farm->id/"," ",
                   array('onclick'=>"showInventory(".$farm->id.");return false;",'id'=>'farmInventory')); ?>
        <?= anchor("farms/buyAccessory/$farm->id/"," ",
                   array('onclick'=>"buyAccessory(".$farm->id.",".$farm->level.");return false;",'id'=>'farmAccessory')); ?>
        <div id="farmResource">
            <?php
                if(isset($plantSources))
                        echo anchor("farms/addResourceToPlant/".$plantSources['Water']['0']."/".$plantSources['Water']['1'],
                                    " ",
                                    array('onclick'=>"addResourceToPlant(".$plantSources['Water']['0'].",".$plantSources['Water']['1'].");return false;",'class'=>'waterSpreadIcon'));
            ?>
            <?php
                if(isset($plantSources))
                        echo anchor("farms/addResourceToPlant/".$plantSources['Muck']['0']."/".$plantSources['Muck']['1'],
                                    " ",
                                    array('onclick'=>"addResourceToPlant(".$plantSources['Muck']['0'].",".$plantSources['Muck']['1'].");return false;",'class'=>'muckSpreadIcon'));
            ?>
            <div class="waterResource">
                <?php
                if(isset($plantSources))
                        echo anchor("farms/addResourceToPlant/".$plantSources['Water']['0']."/".$plantSources['Water']['1'],
                                    " ",
                                    array('onclick'=>"addResourceToPlant(".$plantSources['Water']['0'].",".$plantSources['Water']['1'].");return false;",'class'=>'waterSpread'));
                ?>
                <div id="waterAmount"><?= $farmResources['Water'] ?></div>
                <?= anchor("farms/addResourceToFarm/$farm->id/".$resources['1']->id,
                           " ",
                           array('onclick'=>"addResourceToFarm(".$farm->id.",".$resources['1']->id.");return false;",'class'=>'waterBuy'));
                ?>
            </div>
            <div class="muckResource">
                <?php
                if(isset($plantSources))
                        echo anchor("farms/addResourceToPlant/".$plantSources['Muck']['0']."/".$plantSources['Muck']['1'],
                                    " ",
                                    array('onclick'=>"addResourceToPlant(".$plantSources['Muck']['0'].",".$plantSources['Muck']['1'].");return false;",'class'=>'muckSpread'));
                ?>
                <div id="muckAmount"><?= $farmResources['Muck'] ?></div>
                <?= anchor("farms/addResourceToFarm/$farm->id/".$resources['2']->id,
                           " ",
                           array('onclick'=>"addResourceToFarm(".$farm->id.",".$resources['2']->id.");return false;",'class'=>'muckBuy'));
                ?>
            </div>
        </div>
        <div id="farmMission">
            <?php if(!$plant->id): ?>
                <div class="on">
                    <span class="title"><?= $lang['yummyRequest'] ?></span>
                    <span class="text"><?= $missionBox->description ."<br/>". anchor("farms/mission/$missionBox->id",$lang['gotoMission'],array('onClick'=>"mission($missionBox->id);return false")) ?>
                    </span>
                </div>
            <?php else: ?>
                <div class="off">
                    <span class="title"><?= $lang['yummyRequest'] ?></span>
                    <span class="text">
                        <?= $lang['haventMission'] ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>
        <div id="farmEquipment">
            <?php if(!$equipments): ?>
                <div class="off">
                    <span class="title"><?= $lang['equipment'] ?></span>
                    <span class="text"><?= $lang['haventEquipment'] ?></span>
                </div>
            <?php else: ?>
                <div class="on">
                    <span class="title"><?= $lang['equipment'] ?></span>
                    <?php
                    $equipCounter = 0;
                    foreach($equipments AS $equipment): ?>
                        <div id="equipmentHolder-<?= $equipment ?>" <?php if($equipCounter > 0) echo "style=\"display:none\"" ?>>
                            <span class="icon">
                                <?=  anchor("farms/useEquipment/".$equipment."/".$farm->id,
                                    "<img src=\"".$base_img."farm/equipment/".strtolower($equipment).".png\"  title=\"".$equipment."\"/>",
                                     array('onclick'=>"useEquipment('".$equipment."',$farm->id);return false;")) ?>
                            </span>
                            <span class="text"><?= $lang["equipment-$equipment"] ?></span>
                        </div>
                    <?php
                    $equipCounter++;
                    endforeach; ?>
                        <div style="display:none">
                            <span class="icon">
                            </span>
                            <span class="text">
                                <?= $lang["haventEquipment"] ?>
                            </span>
                        </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div id="bar">
        <div id="footpanel">
                <ul id="mainpanel">
                    <li id="alertpanel">
                        <a href="#" class="alerts">
                            <span id="notificationCounter">
                                <?php if($notifications == false)
                                            $notifications = null;
                                      echo (count($notifications) == 0)?0:count($notifications)
                                ?>
                            </span>
                            <small><?= $lang['notifications'] ?></small>
                        </a>
                        <div class="subpanel">
                            <h3><span></span><?= $lang['notifications'] ?></h3>
                            <ul id="notification"></ul>
                        </div>
                    </li>

                </ul>

        </div>
    </div>
</div>

<script type="text/javascript">

$(document).ready(function(){

	//Click event on Chat Panel + Alert Panel
	$("#alertpanel a:first").click(function() {
		syncNotification();
                if($(this).next(".subpanel").is(':visible')){
			$(this).next(".subpanel").hide();
			$("#footpanel li a").removeClass('active');
		}
		else {
			$(".subpanel").hide();
			$(this).next(".subpanel").toggle();
			$("#footpanel li a").removeClass('active');
			$(this).toggleClass('active');
		}
		return false;
	});

	//Click event outside of subpanel
	$(document).click(function() {
		$(".subpanel").hide();
                $("#notification").removeAttr('style');
		$("#footpanel li a").removeClass('active');
	});
	$('.subpanel ul').click(function(e) {
		e.stopPropagation();
	});

	//Delete icons on Alert Panel
	$("#alertpanel li").hover(function() {
		$(this).find("a.delete").css({'visibility': 'visible'});
	},function() {
		$(this).find("a.delete").css({'visibility': 'hidden'});
	});


});

</script>