<style>
.smallcounter{height:25px;width:100px;padding:2px;color:#60ABD2}
.healthcounter{height:50px;width:200px}

</style>

<script>
    function ajax_request(handler, url, params ,callback) {

        if(handler == '#ajaxHolder')
        {
            $('#ajaxHolder').css('top',($(window).height()/2)-50);
            $('#ajaxHolder').css('right',($(window).width()/2)-50);
            $('#ajaxHolder').show();
        }
       var height = $(handler).height();
       var width = $(handler).width();
       $(handler).verboseLoad("<div style=\"width:"+width+"px;height:"+height+"px;display:block;background:url(<?= $base_img ?>popup/boxy/farmBoxy/content.png);\"><img src=<?= $base_img ?>ajax-loader.gif style=\"display:block;margin:0 auto;padding-top:"+((height/2)-5)+"px\" /></div>",url, params,callback);
    }

    function liftOff() {
        alert($(this).parent().attr('class')+' Expired');
    }

    function moneyCalculate()
    {
        var params = {};
     	params['farm_user_id'] = <?= $farm->user_id ?>;
        ajax_request('.farmInfoItem:eq(1)', '<?= base_url() ?>farms/moneyCalc', params);
    }
    function showInventory(farm_id){
	var params = {};
     	params['farm_id'] = farm_id;
     	params['partner'] = 'TRUE';

        ajax_request('#ajaxHolder', '<?= base_url() ?>farms/showInventory', params);
    }

    function showPartnerInventory(){
	var params = {};
     	params['user_id'] = '<?= $viewer->id ?>';

        ajax_request('#partnerFarmInventory', '<?= base_url() ?>farms/showPartnerInventory', params);
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


    function addResourceToPlant(resource_id , plant_id,placeHolder){
	var params = {};
     	params['plant_id'] = plant_id;
	params['resource_id'] = resource_id;
	params['viewer_id'] = '<?= $viewer->id ?>';
	params['viewer_name'] = "<?= $viewer->first_name ?>";
	params['viewer_farm_id'] = "<?= $viewerFarm->id ?>";
	params['placeHolder'] = placeHolder;
   
	

        ajax_request('#ajaxHolder', '<?= base_url() ?>farms/addResourceToPlant', params)
    }
    function spraying(farm)
    {
        var params = {};
        params['action'] = 'spraying';
        params['farm_id'] = farm;
        params['viewer_id'] = '<?= $viewer->id ?>';
	params['viewer_name'] = "<?= $viewer->first_name ?>";
        params['viewer_farm_id'] = "<?= $viewerFarm->id ?>";

        ajax_request('#ajaxHolder', '<?= base_url() ?>farmtransactions/spraying', params);
    }
    function deffenceWithGun(farm_id)
    {
        var params = {};
        params['action'] = 'deffenceWithGun';
        params['farm_id'] = farm_id;
        params['viewer_id'] = '<?= $viewer->id ?>';
	params['viewer_name'] = "<?= $viewer->first_name ?>";
        params['viewer_farm_id'] = "<?= $viewerFarm->id ?>";

        ajax_request('#ajaxHolder', '<?= base_url() ?>farmtransactions/deffenceWithGun', params)
    }
    function reap(plant_id)
    {
        var params = {};
        params['plant_id'] = plant_id;

        ajax_request('#plantHolder', '<?= base_url() ?>farms/reap', params)
    }

    function addtransaction(acc_id,type,details)
    {
	var params = {};
	params['goal_farm'] = <?= $farm->id ?>;
	params['off_farm'] = '<?= $viewerFarm->id ?>';
	params['acc_id'] = acc_id;
	params['user_id'] = <?= $user->id ?>;
	params['type'] = type;
	params['details'] = details;
        if(type == 3)
        {
            ajax_request('#ajaxHolder','<?= base_url() ?>farmtransactions/moneyHelp',params);
        }
        else
            ajax_request('.buyAccessoryReport','<?= base_url() ?>farmtransactions/add',params)
    }

    function syncFarm(farm_id)
    {
        var params = {};
        params['farm_id'] = farm_id;

        ajax_request('.farmStatisticOn', '<?= base_url() ?>farms/sync', params)
        setTimeout("syncFarm("+farm_id+")",300000);
    }

    $(document).ready(function() {

        $('.wizardClose').click(function(){
            $(this).parent().fadeOut();
            parentIdString = $(this).parent().attr('id');
            parentId = parentIdString.substr(7);
            parentId++;
            if($('#wizard-'+parentId))
            {
                $('#wizard-'+parentId).fadeIn();
            }
        })
        <?php if($viewerFarm->level < 4): ?>
        $("#wizard-1").show();
        <?php endif; ?>

        setTimeout("syncFarm("+<?= $farm->id ?>+")",300000);


        //this section holding all tooltip in page
        $("#partnerInventory").ezpz_tooltip({contentId:"partnerInventoryTooltip"});
        $("#partnerFarmInventory").ezpz_tooltip({contentId:"partnerFarmInventoryTooltip"});
        $(".gun-botton-on").ezpz_tooltip({contentId:"gunActiveTooltip"});
        $(".gun-botton-off").ezpz_tooltip({contentId:"gunInactiveTooltip"});
        $(".spray-botton-on").ezpz_tooltip({contentId:"sprayingActiveTooltip"});
        $(".spray-botton-off").ezpz_tooltip({contentId:"sprayingInactiveTooltip"});
        $(".help-botton-on").ezpz_tooltip({contentId:"moneyHelpTooltip"});
        $(".waterSpread").ezpz_tooltip({contentId:"waterSpreadTooltip"});
        $(".muckSpread").ezpz_tooltip({contentId:"muckSpreadTooltip"});
        $(".reapCounter").ezpz_tooltip({contentId:"reapCounterTooltip"});
        $("#resourceCounter1").ezpz_tooltip({contentId:"waterCounterTooltip"});
        $("#resourceCounter2").ezpz_tooltip({contentId:"muckCounterTooltip"});
        $("#farmOwner").ezpz_tooltip({contentId:"farmOwnerTooltip"});



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
                                                                layout: '<div class="image{d10}"></div><div class="image{d1}"></div>' +
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
    <div id="attackHolder" >
        <?php if(isset($attacksToFarm)): ?>
        <div class="header"></div>
        <div class="details">
            <?php foreach($attacksToFarm as $att): ?>
                <?php switch ($att->accessory_id) {
                                            case 1:
                                                $attImg = "aphid";
                                            break;
                                            case 2:
                                                $attImg = "grasshoppers";
                                            break;
                                            case 4:
                                                $attImg = "mouse";
                                            break;
                                            case 6:
                                                $attImg = "crow";
                                            break;
                                        }  ?>
            <img src="<?= $base_img."farm/accessory/".$attImg.".png" ?>" title="<?= $lang[$attImg] ?>"/>
            <?php endforeach; ?>
        </div>
        <div class="footer"></div>
        <?php endif; ?>
    </div>
     <!-- Start tooltipHolder -->
    <div id="partnerInventoryTooltip" class="tooltip"><?= $lang['tooltip']['partnerInventory'] ?></div>
    <div id="partnerFarmInventoryTooltip" class="tooltip"><?= $lang['tooltip']['partnerFarmInventory'] ?></div>
    <div id="gunActiveTooltip" class="tooltip"><?= $lang['tooltip']['partnerGun-active'] ?></div>
    <div id="gunInactiveTooltip" class="tooltip"><?= $lang['tooltip']['partnerGun-inactive'] ?></div>
    <div id="sprayingActiveTooltip" class="tooltip"><?= $lang['tooltip']['partnerSpraying-active'] ?></div>
    <div id="sprayingInactiveTooltip" class="tooltip"><?= $lang['tooltip']['partnerSpraying-inactive'] ?></div>
    <div id="moneyHelpTooltip" class="tooltip"><?= $lang['tooltip']['moneyHelp'] ?></div>
    <div id="waterSpreadTooltip" class="tooltip"><?= $lang['tooltip']['partnerWaterSpread'] ?></div>
    <div id="muckSpreadTooltip" class="tooltip"><?= $lang['tooltip']['partnerMuckSpread'] ?></div>
    <div id="reapCounterTooltip" class="tooltip"><?= $lang['tooltip']['reapCounter'] ?></div>
    <div id="waterCounterTooltip" class="tooltip"><?= $lang['tooltip']['waterCounter'] ?></div>
    <div id="muckCounterTooltip" class="tooltip"><?= $lang['tooltip']['muckCounter'] ?></div>
    <div id="farmOwnerTooltip" class="tooltip"><?= $lang['tooltip']['farmOwner'] ?></div>
    <!-- End tooltipHolder -->


    <!-- Start wizardHolder -->
    <div id="wizard-1" class="wizard" style="top: 418px;right: -6px">
        <div class="wizardClose">X</div>
        <div class="wizardContent">
            <?= $lang['farmWizard']['yourInventory'] ?>
        </div>
    </div>
    <div id="wizard-2" class="wizard" style="top: 433px;right: 104px">
        <div class="wizardClose">X</div>
        <div class="wizardContent">
            <?= $lang['farmWizard']['farmInventory'] ?>
        </div>
    </div>
    <div id="wizard-3" class="wizard" style="top: 433px;right: 280px">
        <div class="wizardClose">X</div>
        <div class="wizardContent">
            <?= $lang['farmWizard']['farmKeeper'] ?>
        </div>
    </div>
    <div id="wizard-4" class="wizard" style="top: 305px;right: 40px">
        <div class="wizardClose">X</div>
        <div class="wizardContent">
            <?= $lang['farmWizard']['partnerAction'] ?>
        </div>
    </div>
    <!-- End wizardHolder -->

    <div id="base">
        <div id="farm">
            <?php
            if($plant->id)
            {
                $plantGrowthTime = $plant->growthTimeHolder * 3600;
                if($plant->growth > ($plantGrowthTime * (2/3)))
                        if($plant->health > 40)
                            $plantPic = "plant-low";
                        else
                            $plantPic = "plant-low-sick";
                elseif($plant->growth > ($plantGrowthTime * (1/3)))
                        if($plant->health > 40)
                            $plantPic = "plant-middle";
                        else
                            $plantPic = "plant-middle-sick";
                else
                        if($plant->health > 40)
                            $plantPic = "plant-high";
                        else
                            $plantPic = "plant-high-sick";

            }
            ?>
            <div id="section-1" class="<?= ($plant->id)?$plantPic." plantGround":(($farm->plow)?"plow":"unPlow") ?>"></div>
            <div id="section-2" class="<?= ($farm->section <2)?"unPlow":(($plant->id)?$plantPic." plantGround":(($farm->plow)?"plow":"unPlow")) ?>"><?php if($farm->section <2): ?><span class="section-2-off"></span><?php endif; ?></div>
            <div id="section-3" class="<?= ($farm->section <3)?"unPlow":(($plant->id)?$plantPic." plantGround":(($farm->plow)?"plow":"unPlow")) ?>"><?php if($farm->section <3): ?><span class="section-3-off"></span><?php endif; ?></div>
            <div id="section-4" class="<?= ($farm->section <4)?"unPlow":(($plant->id)?$plantPic." plantGround":(($farm->plow)?"plow":"unPlow")) ?>"><?php if($farm->section <4): ?><span class="section-4-off"></span><?php endif; ?></div>
            <div id="farmOwner">
                <div class="avatarImg">
                    <a href="<?= base_url() ?>profile/user/<?= $farmOwner->id ?>">
                        <?php if($farmOwner->photo != ""): ?>
                            <img src="<?= css_url() ?>system/application/helpers/fa_image_helper.php?nw=48&nh=48&source=<?= $avatar_img."avatars/".$farmOwner->photo.".png" ?>&stype=png&dest=x&type=little" border="0" />
                        <?php else: ?>
                            <?php if($farmOwner->sex == 0): ?>
                                <img src="<?= css_url() ?>system/application/helpers/fa_image_helper.php?nw=48&nh=48&source=<?= $avatar_img."avatars/default-m.png" ?>&stype=png&dest=x&type=little" border="0" />
                            <?php else: ?>
                                <img src="<?= css_url() ?>system/application/helpers/fa_image_helper.php?nw=48&nh=48&source=<?= $avatar_img."avatars/default-f.png" ?>&stype=png&dest=x&type=little" border="0" />
                            <?php endif; ?>
                        <?php endif; ?>
                    </a>
                </div>
                <div class="avatarName">
                    <a href="<?= base_url() ?>profile/user/<?= $farmOwner->id ?>">
                        <?= $farmOwner->first_name." ".$farmOwner->last_name ?>
                    </a>
                </div>
            </div>
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
                    if(!$user->unAuthenticatedUser)
                        echo anchor(" ",
                                   " ",
                                   array('onclick'=>"deffenceWithGun(".$farm->id.");return false;",'class'=>'gun-botton-on'));
                    else
                        echo "<a class=\"gun-botton-off\"></a>";

                    if($farm->level == 1)
                        echo "<a class=\"spray-botton-off\"></a>";
                    else
                        if(!$user->unAuthenticatedUser)
                        echo anchor("farmtransactions/spraying/$farm->id",
                                    " ",
                                    array('onclick'=>"spraying(".$farm->id.");return false;",'class'=>'spray-botton-on'));
                        else
                            echo "<a class=\"spray-botton-off\"></a>";

                    if(!$user->unAuthenticatedUser)
                        echo anchor(" ",
                                    " ",
                                    array('onclick'=>"addtransaction(0,3,3);return false;",'class'=>'help-botton-on'));
                    else
                        echo "<a class=\"help-botton-off\"></a>";
                ?>
            </div>
        </div>
        <div id="sidebar">
            <div id="farmInformationPartner">
                <div id="farmInformationDetails">
                    <span class="farmInfoItem"><?= $lang['farm'] ?>:<span class="infoValue"><?= $farm->name ?></span></span>
                    <span class="farmInfoItem"><?= $lang['farmMoney'] ?>:<span class="infoValue" id="moneyHolder"><?= $farm->money." ".$lang['yummyMoneyUnit'] ?></span></span>
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
        <?php if(isset($viewer->id))
        echo anchor(""," ",
                   array('onclick'=>"showPartnerInventory();return false;",'id'=>'partnerFarmInventory'));
        else
            echo "<a id='partnerFarmInventory'></a>";
        ?>
        <?= anchor(" ","<span class=\"partnerLink\">$lang[inventory] $lang[farm]<br/>$farm->name</span>",
                   array('onclick'=>"showInventory(".$farm->id.");return false;",'id'=>'partnerInventory')); ?>
        <div id="farmResource">
            <?php
                if(isset($plantSources) && !$user->unAuthenticatedUser)
                        echo anchor("farms/addResourceToPlant/".$plantSources['Water']['0']."/".$plantSources['Water']['1'],
                                    " ",
                                    array('onclick'=>"addResourceToPlant(".$plantSources['Water']['0'].",".$plantSources['Water']['1'].",'1');return false;",'class'=>'waterSpreadIcon'));
            ?>
            <?php
                if(isset($plantSources) && !$user->unAuthenticatedUser)
                        echo anchor("farms/addResourceToPlant/".$plantSources['Muck']['0']."/".$plantSources['Muck']['1'],
                                    " ",
                                    array('onclick'=>"addResourceToPlant(".$plantSources['Muck']['0'].",".$plantSources['Muck']['1'].",'2');return false;",'class'=>'muckSpreadIcon'));
            ?>
            <div class="waterResource">
                <?php
                if(isset($plantSources) && !$user->unAuthenticatedUser)
                        echo anchor("farms/addResourceToPlant/".$plantSources['Water']['0']."/".$plantSources['Water']['1'],
                                    " ",
                                    array('onclick'=>"addResourceToPlant(".$plantSources['Water']['0'].",".$plantSources['Water']['1'].",'1');return false;",'class'=>'waterSpread'));
                ?>
                <div id="waterAmount"><?= $farmResources['Water'] ?></div>

            </div>
            <div class="muckResource">
                <?php
                if(isset($plantSources) && !$user->unAuthenticatedUser)
                        echo anchor("farms/addResourceToPlant/".$plantSources['Muck']['0']."/".$plantSources['Muck']['1'],
                                    " ",
                                    array('onclick'=>"addResourceToPlant(".$plantSources['Muck']['0'].",".$plantSources['Muck']['1'].",'2');return false;",'class'=>'muckSpread'));
                ?>
                <div id="muckAmount"><?= $farmResources['Muck'] ?></div>

            </div>
        </div>
        <div id="partnerHints">
            <div>
                <ul>
                    <?php foreach($partnerHints AS $hint): ?>
                        <li>
                            <?= $hint ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div id="farmTransaction">
            <div class="title"></div>
            <div class="transactions">
                    <?php foreach ($transactions as $transaction) : ?>
                        <div class=<?= $transaction->messageStyle ?>>
                                <div>
                                        <img src="<?= $base_img."profile/".$transaction->messageStyle."Icon.png" ?>">
                                        <?php
                                        if($transaction->type != 3)
                                        {
                                            if($transaction->flag == 0)
                                                    $ns = "";
                                            elseif($transaction->flag == 1)
                                                    $ns = "Done";
                                            elseif($transaction->flag == 2)
                                                    $ns = "Reject";

                                            if($transaction->offset_farm == $farm->id)
                                                    $ns = "Attack";

                                            echo $lang['farmTransaction'.$ns.'-'.$transaction->accessory_id];
                                        }
                                        else
                                            if($transaction->flag != 'newUser')
                                            {
                                                if($transaction->offset_farm == $farm->id)
                                                    echo $lang['farmTransactionHelpToFriend'];
                                                else
                                                    echo $lang['farmTransactionFriendHelpToU'];
                                            }
                                            else
                                                echo $lang['havingAnytransaction'];
                                        ?>
                                </div>
                        </div>
                    <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
