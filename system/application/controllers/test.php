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
        anchor("farmtransactions/spraying/$farm->id",
                            "Spraying Farm",
                             array('onclick'=>"reset(".$farm->id.");return false;"))."<br/>";
        ?>
        ResetFarm:<span id="reset"></span><br/>
        <?=
            anchor("farms/resetFarm/$farm->id",
                            "Reset Farm",
                             array('onclick'=>"resetConfirm1(".$farm->id.");return false;"))."<br/>";
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

    <div id="health">
        <h4>Plant Details</h4>
        <span id="healthHolder">
        PlantHealth:<?= $plant->health ?><br/>
        PlantWeight:<?= $plant->weight ?>
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
                if($fAcc->accessory_id == 5)
                        echo anchor("farmstransactions/deffenceWithGun/$farm->id",
                            "<img src=\"".$base_img."farm/accessory/".strtolower($fAcc->name).".png\" height=\"48px\" weidth=\"48px\" title=\"$fAcc->name\"/>",
                             array('onclick'=>"deffenceWithGun(".$farm->id.");return false;"))."<br/>";
                else
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

                echo "<hr/><span style='font-size:11px'>".str_replace(array('__CAPACITY__','__GROWTHTIME__'),array($type->capacity,$type->growth_time),$lang['plantCapacity'])."</span>";

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
    <div id="footpanel">
        <ul id="mainpanel">
            <li><a href="<?= base_url() ?>profile/user/<?= $farm->user_id ?>" class="profile">Profile <small>Profile</small></a></li>
            <li><a href="#" class="messages">Messages (10) <small>Messages</small></a></li>
            <li id="alertpanel">
                <a href="#" class="alerts">Alerts<small>Notifications</small></a>
                <div class="subpanel">
                    <h3><span> &ndash; </span>Notifications</h3>
                    <ul id="notification">

                    </ul>
                </div>
            </li>

        </ul>
    </div>
</div>


<script type="text/javascript">

$(document).ready(function(){

	//Adjust panel height
	$.fn.adjustPanel = function(){
		$(this).find("ul, .subpanel").css({ 'height' : 'auto'});

		var windowHeight = $(window).height();
		var panelsub = $(this).find(".subpanel").height();
		var panelAdjust = windowHeight - 100;
		var ulAdjust =  panelAdjust - 25;

		if ( panelsub >= panelAdjust ) {
			$(this).find(".subpanel").css({ 'height' : panelAdjust });
			$(this).find("ul").css({ 'height' : ulAdjust});
		}
		else if ( panelsub < panelAdjust ) {
			$(this).find("ul").css({ 'height' : 'auto'});
		}
	};

	//Execute function on load
	$("#alertpanel").adjustPanel();

	//Each time the viewport is adjusted/resized, execute the function
	$(window).resize(function () {
		$("#chatpanel").adjustPanel();
		$("#alertpanel").adjustPanel();
	});

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