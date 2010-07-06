<script type="text/javascript">
    jQuery.easing['BounceEaseOut'] = function(p, t, b, c, d) {
    if ((t/=d) < (1/2.75)) {
    return c*(7.5625*t*t) + b;
    } else if (t < (2/2.75)) {
    return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
    } else if (t < (2.5/2.75)) {
    return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
    } else {
    return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
    }
    };

    jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
    easing: 'BounceEaseOut',
    animation: 1000,
    scroll:2
    });
    
    jQuery('#transactionHolder').jcarousel({
    vertical :true,
    animation: 'slow',
    scroll:2
    });
    });
</script>
<script type="text/javascript" >
    $(function()
    {
        $(".delete").click(function(){
            var element = $(this);
            var I = element.attr("id");
            $('li#list'+I).fadeOut('slow', function() {$(this).remove();});
            return false;
        });
    });
</script>
<?php if($userFarm->id): ?>
<script>
$(document).ready(function() {

    //tooltip handler for badges and etc
    $(".endGameBadge").ezpz_tooltip({contentId:"endGameBadgeTooltip"});
    $(".highLevelBadge").ezpz_tooltip({contentId:"highLevelBadgeTooltip"});
    $(".bestDeffencerBadge").ezpz_tooltip({contentId:"bestDeffencerBadgeTooltip"});
    $(".bestStrikerBadge").ezpz_tooltip({contentId:"bestStrikerBadgeTooltip"});
    $(".goldenShovelBadge").ezpz_tooltip({contentId:"goldenShovelBadgeTooltip"});
    $(".goldenSickleBadge").ezpz_tooltip({contentId:"goldenSickleBadgeTooltip"});
    $(".goldenClockBadge").ezpz_tooltip({contentId:"goldenClockBadgeTooltip"});
    $(".goldenTomatoBadge").ezpz_tooltip({contentId:"goldenTomatoBadgeTooltip"});
    $(".goldenGrasshopperBadge").ezpz_tooltip({contentId:"goldenGrasshopperBadgeTooltip"});
    $(".famousFarmerBadge").ezpz_tooltip({contentId:"famousFarmerBadgeTooltip"});
    $(".haveFarmBadge").ezpz_tooltip({contentId:"haveFarmBadgeTooltip"});
    $("#dangerBar").ezpz_tooltip({contentId:"dangerBarTooltip"});
    $("#secureBar").ezpz_tooltip({contentId:"secureBarTooltip"});
    $("#helpBar").ezpz_tooltip({contentId:"helpBarTooltip"});


    $("#dangerBar").progressBar(<?= $bars['attackBar'] ?>,{
	boxImage		: '<?= $base_img ?>profile/progressbar/progressbar.gif',
	barImage		: {
		0:  '<?= $base_img ?>profile/progressbar/progressbg_red.gif',
		30: '<?= $base_img ?>profile/progressbar/progressbg_orange.gif',
		70: '<?= $base_img ?>profile/progressbar/progressbg_green.gif'
	}
    });
    $("#secureBar").progressBar(<?= $bars['deffenceBar'] ?>,{
	boxImage		: '<?= $base_img ?>profile/progressbar/progressbar.gif',
	barImage		: {
		0:  '<?= $base_img ?>profile/progressbar/progressbg_red.gif',
		30: '<?= $base_img ?>profile/progressbar/progressbg_orange.gif',
		70: '<?= $base_img ?>profile/progressbar/progressbg_green.gif'
	}
    });
    $("#helpBar").progressBar(<?= $bars['helpBar'] ?>,{
	boxImage		: '<?= $base_img ?>profile/progressbar/progressbar.gif',
	barImage		: {
		0:  '<?= $base_img ?>profile/progressbar/progressbg_red.gif',
		30: '<?= $base_img ?>profile/progressbar/progressbg_orange.gif',
		70: '<?= $base_img ?>profile/progressbar/progressbg_green.gif'
	}
    });
});
</script>
<?php endif; ?>
<script>
function ajax_request(handler, url, params ,callback) {

        if(handler == '#ajaxHolder')
        {
            $('#ajaxHolder').css('top',($(window).height()/2)-50);
            $('#ajaxHolder').css('right',($(window).width()/2)-50);
            $('#ajaxHolder').show();
        }
        else if(handler == '#centerContainer')
        {
            $('#centerContainer').hide();
            $('#centerContainerSecondLayer').show();
            handler = '#centerContainerSecondLayer';
        }
       var height = $(handler).height();
       var width = $(handler).width();
       $(handler).verboseLoad("<div style=\"width:"+width+"px;height:"+height+"px;display:block;background:url(<?= $base_img ?>popup/boxy/farmBoxy/content.png);\"><img src=<?= $base_img ?>ajax-loader.gif style=\"display:block;margin:0 auto;padding-top:"+((height/2)-5)+"px\" /></div>",url, params,callback);
}
function seeAllFriends(user_id)
{
        var params = {};
        params['user_id'] = user_id;

        ajax_request('#ajaxHolder', '<?= base_url() ?>profile/seeAllFriends', params);
}
function inbox()
{
    ajax_request('#centerContainer','<?= base_url() ?>profile/inbox');
}
function history()
{
    ajax_request('#centerContainer','<?= base_url() ?>profile/history');
}
function editProfile()
{
    var params = {};
    params['user_id'] = <?= $user_profile->id ?>;
    //$("#changeProfile").html("<?= $lang['profile_set'] ?>");
    ajax_request('#centerContainer','<?= base_url() ?>profile/edit',params);
}
function avatar()
{
    ajax_request('#centerContainer','<?= base_url() ?>profile/avatar');
}
function addToFriend(id)
{
    var params = {};
    params['id'] = id;
    ajax_request('#ajaxHolder','<?= base_url() ?>profile/addToFriend',params);
}
function deleteFriendConfirm(id,user_id)
    {
        Boxy.confirm('<?= $lang['areYouSureDeleteFriend'] ?>', deleteFriend,{title:'<?= $lang['becareful'] ?>'});
    }
function deleteFriend()
{
    var params = {};
    params['id'] = <?= $user_profile->id ?>;;
    params['user_id'] = '<?= $user->id ?>';
	$('.removeFromFriend').fadeOut();
    ajax_request('#ajaxHolder','<?= base_url() ?>profile/deleteFriend',params);
}
function abuseReport(id)
{
    var params = {};
    params['id'] = id;
    ajax_request('#ajaxHolder','<?= base_url() ?>profile/abuseReport',params);
}
function registerNewFarm()
{
    ajax_request('#centerContainer','<?= base_url() ?>farms/register');
}
function deleteNotification(id)
{
    var params = {};
    params['not_id'] = id;

    if(id != 'all')
    {
        var elementHeight = $("#notification-"+id).height();
        var totalHeight = $(".subpanel").find("ul").height();

        var liHeightHolder = 0;
        $("#notification").children().each(function() {
            liHeightHolder += $(this).height();
        });

        if(liHeightHolder-elementHeight < totalHeight)
        {
            var heightHolder = liHeightHolder-elementHeight+9;
            $(".subpanel").find("ul").css({ 'height' :heightHolder})
        }
        $("#notification-"+id).remove();
    }
    else
    {
        if(!confirm('<?= $lang['deleteAllNotification'] ?>'))
            return false;
        $("#notification").children().each(function() {
            $(this).remove();
            $(".subpanel").find("ul").css({ 'height' :0})
        });

        params['farm_id'] = '<?= $userFarm->id ?>';
    }

    notificationCounter();
    ajax_request('#farmSection', '<?= base_url() ?>farms/deleteNotification', params);
}
function syncNotification()
{
    var params = {};
    params['farm_id'] = '<?= $userFarm->id ?>';

    ajax_request('#notification','<?= base_url() ?>farms/syncNotification',params,heightFixer);
}
function heightFixer()
{
    var heightHolder = $("#notification").height();

    if(heightHolder > 300)
        $(".subpanel").find("ul").css({ 'height' :300})

    notificationCounter();
}
function notificationCounter()
{
    $('#notificationCounter').html($('#mainpanel li p img').size());
}
</script>
<script type="text/javascript">
$(document).ready(function(){
$('#userPicture').hover(function(){$('#userPicture a div.changeAvatar').fadeIn()});
$('#userPicture').mouseleave(function(){$('#userPicture a div.changeAvatar').fadeOut()});
$('#userPicture a div.changeAvatar').click(function(){avatar();return false;})
$("#inviteEmail").click(function(){$(this).val('');$(this).css("color","black");$(this).css("border","0");});
$("#addFriend").submit(function(){
    $("#inviteEmail").css("border","");
    $("#inviteEmail").css("color","");
    var hasError = false;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

    var emailToVal = $("#inviteEmail").val();
    if(emailToVal == '') {
            $("#inviteEmail").css("border","1px red solid");
            hasError = true;
    } else if(!emailReg.test(emailToVal)) {
            $("#inviteEmail").css("color","red");
            hasError = true;
    }
    if(!hasError)
    {
        var params = {};
        params['email'] = $("#inviteEmail").val();
        params['user'] = <?= $user_profile->id ?>;

        ajax_request('#inviteRequestHolder', '<?= base_url() ?>profile/inviteFriend', params)
    }
    return false;
    });

$("#sendMessage").submit(function(){
    var params = {};
    params['message'] = $("#privateMess").val();
    params['from'] = '<?= $user->id ?>';
    params['to'] = <?= $user_profile->id ?>;
    params['senderName'] = '<?= $user->first_name ?>';
    if(params['message'] == "")
	{
    	$('#privateMess').css("color","red");
        $('#privateMess').val('<?= $lang['must_be_filled_textarea'] ?>');
    }
    else
	{
		$('.messAjaxHolder').fadeIn('slow');
		$("#sendMessage input:submit").hide()
    	ajax_request('.messAjaxHolder', '<?= base_url() ?>profile/sendMessage', params)
	}
	return false;
    });
    $('#privateMess').click(function(){$(this).val('');$(this).css("color","black");});

$("#searchForm").submit(function(){

    var searchHasError = false;
    $("#searchUserByName").css("color","");

    var params = {};
    params['filter'] = $("#searchUserByName").val();
    params['page'] = 0;
    type = $("#searchByType").val();

    if(params['filter'] == "")
    {
        $('#searchUserByName').css("color","red");
        $('#searchUserByName').val('<?= $lang['must_be_filled_textarea'] ?>');
        searchHasError = true;
    }
    if(!searchHasError)
        if(type == 1)
            ajax_request('#centerContainer', '<?= base_url() ?>users/find/', params)
        else if(type == 2)
            ajax_request('#centerContainer', '<?= base_url() ?>farms/find/', params)

    return false;
    });
});
$('#searchUserByName').click(function(){$(this).val('');$(this).css("color","black");});


</script>
<style>
    #content
    {
     background: #526329  url(<?= $base_img?>profile/content.gif) repeat-x  center;
    }
</style>
<div id="profile">

        <!-- Start tooltipHolder -->
        <div id="endGameBadgeTooltip" class="tooltip"><?= $lang['tooltip']['badge']['endGame'] ?></div>
        <div id="highLevelBadgeTooltip" class="tooltip"><?= $lang['tooltip']['badge']['highLevel'] ?></div>
        <div id="bestDeffencerBadgeTooltip" class="tooltip"><?= str_replace(array('__RANK__','__NEED__'), array($farmSign['deffence']['detail'],20), $lang['tooltip']['badge']['bestDeffencer']) ?></div>
        <div id="bestStrikerBadgeTooltip" class="tooltip"><?= str_replace(array('__RANK__','__NEED__'), array($farmSign['attack']['detail'],5), $lang['tooltip']['badge']['bestStriker']) ?></div>
        <div id="goldenShovelBadgeTooltip" class="tooltip"><?= str_replace(array('__RANK__','__NEED__'), array($farmSign['goldenShovel']['detail'],1), $lang['tooltip']['badge']['goldenShovel']) ?></div>
        <div id="goldenSickleBadgeTooltip" class="tooltip"><?= str_replace(array('__RANK__','__NEED__'), array($farmSign['goldenSickle']['detail'],3), $lang['tooltip']['badge']['goldenShovel']) ?></div>
        <div id="goldenClockBadgeTooltip" class="tooltip"><?= str_replace(array('__RANK__','__NEED__'), array($farmSign['goldenClock']['detail'],5), $lang['tooltip']['badge']['goldenShovel']) ?></div>
        <div id="goldenTomatoBadgeTooltip" class="tooltip"><?= str_replace(array('__RANK__','__NEED__'), array($farmSign['bigProduct']['detail'],10000), $lang['tooltip']['badge']['goldenTomato']) ?></div>
        <div id="goldenGrasshopperBadgeTooltip" class="tooltip"><?= str_replace(array('__RANK__','__NEED__'), array($farmSign['grasshoppers']['detail'],20), $lang['tooltip']['badge']['goldenGrasshopper']) ?></div>
        <div id="famousFarmerBadgeTooltip" class="tooltip"><?= str_replace(array('__RANK__','__NEED__'), array($farmSign['famous']['detail'],50), $lang['tooltip']['badge']['famousFarmer']) ?></div>
        <div id="haveFarmBadgeTooltip" class="tooltip"><?= $lang['tooltip']['badge']['haveFarm'] ?></div>
        <div id="dangerBarTooltip" class="tooltip"><?= $lang['tooltip']['dangerBar'] ?></div>
        <div id="secureBarTooltip" class="tooltip"><?= $lang['tooltip']['secureBar'] ?></div>
        <div id="helpBarTooltip" class="tooltip"><?= $lang['tooltip']['helpBar'] ?></div>
        <!-- End tooltipHolder -->

        <div id="rightColumn">
                <div id="userThumb">
                        <span id="userPicture">
                                <?php
                                    if($user_profile->photo != "") {
                                ?>
                                <a href="<?= base_url() ?>profile/user/<?= $user_profile->id ?>" >
                                    <img src="<?= css_url() ?>system/application/helpers/fa_image_helper.php?nw=88&nh=88&source=<?= $avatar_img."avatars/".$user_profile->photo.".png" ?>&stype=png&dest=x&type=little" border="0" />
                                    <?php if(!$partner): ?>
                                        <div class="changeAvatar"><?= $lang['changeAvatars'] ?></div>
                                    <?php endif; ?>
                                </a>
                                <?php
                                    }else{
                                ?>
                                <a href="<?= base_url() ?>profile/user/<?= $user_profile->id ?>" >
                                    <?php if($user_profile->sex == 0): ?>
                                        <img src="<?= css_url() ?>system/application/helpers/fa_image_helper.php?nw=88&nh=88&source=<?= $avatar_img."avatars/default-m.png" ?>&stype=png&dest=x&type=little" border="0" />
                                    <?php else: ?>
                                        <img src="<?= css_url() ?>system/application/helpers/fa_image_helper.php?nw=88&nh=88&source=<?= $avatar_img."avatars/default-f.png" ?>&stype=png&dest=x&type=little" border="0" />
                                    <?php endif; ?>
                                    <?php if(!$partner): ?>
                                        <div class="changeAvatar"><?= $lang['changeAvatars'] ?></div>
                                    <?php endif; ?>
                                </a>
                                <?php
                                    }
                                ?>
                        </span>
                        <span id="userName">
                                <?php
                                mb_internal_encoding('UTF-8');
                                echo  mb_substr($user_profile->first_name . " " . $user_profile->last_name, 0, 13)
                                ?>
                        </span>
                        <span id="userCity">
                                <?= $lang['fromCity'].": ".$user_profile->city ?>
                        </span>
                        <span id="userRegisterDate">
                                <?= $lang['register_date'].": ".convert_number(fa_strftime("%d %B %Y", $user_profile->registration_date . "")) ?>
                        </span>
                        <?php if(!$partner): ?>
                        <span id="changeProfile">
                                <img src="<?= $base_img ?>profile/editProfile.png" style="vertical-align: middle"/>
                                <?= anchor("profile/edit/$user_profile->id",
                                           $lang['profile_set'],
                                           array('onclick'=>"editProfile();return false;"));
                                ?>
                        </span>
                        <?php endif; ?>
                </div>
                <div id="userRanks">
                    <div class="jcarousel-skin-tango">
                      <div class="jcarousel-container">
                        <div disabled="disabled" class="jcarousel-prev jcarousel-prev-disabled"></div>
                        <div class="jcarousel-next"></div>
                        <div class="jcarousel-clip">
                          <ul  id="mycarousel" class="jcarousel-list">
                            <li>
                                <?php if($farmSign['haveFarm']['accept']): ?>
                                    <span class="rankThumb haveFarmBadge"><img src="<?= $base_img ?>profile/badges/haveFarm-on.jpg"/></span>
                                <?php else: ?>
                                    <span class="rankThumb haveFarmBadge"><img src="<?= $base_img ?>profile/badges/haveFarm-off.jpg"/></span>
                                <?php endif; ?>
                            </li>
                            <li>
                                <?php if($farmSign['endGame']['accept']): ?>
                                    <span class="rankThumb"><img src="<?= $base_img ?>profile/badges/endGame-on.jpg"/></span>
                                    <span class="endGameDetail endGameBadge">x<?= $farmSign['endGame']['detail'] ?></span>
                                <?php else: ?>
                                    <span class="rankThumb endGameBadge"><img src="<?= $base_img ?>profile/badges/endGame-off.jpg"/></span>
                                <?php endif; ?>
                            </li>
                            <li>
                                <?php if($farmSign['topLevel']['accept']): ?>
                                    <span class="rankThumb highLevelBadge"><img src="<?= $base_img ?>profile/badges/levelComplete-on.jpg"/></span>
                                    <span class="levelCompleteDetail">&nbsp;<?= $farmSign['topLevel']['detail']  ?></span>
                                <?php else: ?>
                                    <span class="rankThumb highLevelBadge"><img src="<?= $base_img ?>profile/badges/levelComplete-off.jpg"/></span>
                                <?php endif; ?>
                            </li>
                            <li>
                                <?php if($farmSign['deffence']['accept']): ?>
                                    <span class="rankThumb bestDeffencerBadge"><img src="<?= $base_img ?>profile/badges/bestDeffencer-on.jpg"/></span>
                                <?php else: ?>
                                    <span class="rankThumb bestDeffencerBadge"><img src="<?= $base_img ?>profile/badges/bestDeffencer-off.jpg" title="<?= $farmSign['deffence']['detail'] ?>/20"/></span>
                                <?php endif; ?>
                            </li>
                            <li>
                                <?php if($farmSign['attack']['accept']): ?>
                                    <span class="rankThumb bestStrikerBadge"><img src="<?= $base_img ?>profile/badges/bestStriker-on.jpg"/></span>
                                <?php else: ?>
                                    <span class="rankThumb bestStrikerBadge"><img src="<?= $base_img ?>profile/badges/bestStriker-off.jpg" title="<?= $farmSign['attack']['detail'] ?>/5"/></span>
                                <?php endif; ?>
                            </li>
                            <li>
                                <?php if($farmSign['famous']['accept']): ?>
                                    <span class="rankThumb famousFarmerBadge"><img src="<?= $base_img ?>profile/badges/bestFarmer-on.jpg"/></span>
                                <?php else: ?>
                                    <span class="rankThumb famousFarmerBadge"><img src="<?= $base_img ?>profile/badges/bestFarmer-off.jpg" title="<?= $farmSign['famous']['detail'] ?>/50"/></span>
                                <?php endif; ?>
                            </li>
                            <li>
                                <?php if($farmSign['goldenShovel']['accept']): ?>
                                    <span class="rankThumb goldenShovelBadge"><img src="<?= $base_img ?>profile/badges/goldenShovel-on.jpg"/></span>
                                <?php else: ?>
                                    <span class="rankThumb goldenShovelBadge"><img src="<?= $base_img ?>profile/badges/goldenShovel-off.jpg" title="<?= $farmSign['goldenShovel']['detail'] ?>/1"/></span>
                                <?php endif; ?>
                            </li>
                            <li>
                                <?php if($farmSign['goldenSickle']['accept']): ?>
                                    <span class="rankThumb goldenSickleBadge"><img src="<?= $base_img ?>profile/badges/goldenSickle-on.jpg"/></span>
                                <?php else: ?>
                                    <span class="rankThumb goldenSickleBadge"><img src="<?= $base_img ?>profile/badges/goldenSickle-off.jpg" title="<?= $farmSign['goldenSickle']['detail'] ?>/3"/></span>
                                <?php endif; ?>
                            </li>
                            <li>
                                <?php if($farmSign['goldenClock']['accept']): ?>
                                    <span class="rankThumb goldenClockBadge"><img src="<?= $base_img ?>profile/badges/goldenClock-on.jpg"/></span>
                                <?php else: ?>
                                    <span class="rankThumb goldenClockBadge"><img src="<?= $base_img ?>profile/badges/goldenClock-off.jpg" title="<?= $farmSign['goldenClock']['detail'] ?>/5"/></span>
                                <?php endif; ?>
                            </li>
                            <li>
                                <?php if($farmSign['bigProduct']['accept']): ?>
                                    <span class="rankThumb goldenTomatoBadge"><img src="<?= $base_img ?>profile/badges/goldenTomato-on.jpg"/></span>
                                <?php else: ?>
                                    <span class="rankThumb goldenTomatoBadge"><img src="<?= $base_img ?>profile/badges/goldenTomato-off.jpg" title="<?= $farmSign['bigProduct']['detail'] ?>/1000"/></span>
                                <?php endif; ?>
                            </li>
                            <li>
                                <?php if($farmSign['grasshoppers']['accept']): ?>
                                    <span class="rankThumb goldenGrasshopperBadge"><img src="<?= $base_img ?>profile/badges/goldenGrasshopper-on.jpg"/></span>
                                <?php else: ?>
                                    <span class="rankThumb goldenGrasshopperBadge"><img src="<?= $base_img ?>profile/badges/goldenGrasshopper-off.jpg" title="<?= $farmSign['grasshoppers']['detail'] ?>/20"/></span>
                                <?php endif; ?>
                            </li>
                            
                          </ul>
                        </div>
                      </div>
                    </div>
                </div>

                <div id="profileHint">
                        <?php if(!$partner): ?>
                            <span class="title"><?= $lang['becareful'] ?></span>
                            <span class="body">
                                <ul id="hints">
                                    <?php
                                    if($hints)
                                    foreach ($hints as $hint){
                                    echo "<li id=\"list$hint->id\">";
                                    ?>
                                    <span class="del"><a href="#" class="delete" id="<?= $hint->id ?>">X</a></span>
                                    <?php
                                    echo $hint->body."<br/><br/><span class=\"date\">".fa_strftime("%H:%M:%S %p %d %B %Y", date("Y-m-d H:i:s", $hint->create_date . ""))."</span></li>";
                                    }?>
                                </ul>
                            </span>
                        <?php else: ?>
                            <span class="userActivity">
                                <br/>
                                <?php if(!$user->unAuthenticatedUser): ?>
                                <?php if(!$user_profile->is_related && !$user_profile->is_blocked): ?>
                                    <span class="addToFriend">
                                        <?= anchor("gateway/addToFriend/".ltrim($user_profile->id, '0'),
                                            $lang['add_to_friend'],
                                            array('onclick'=>"addToFriend(".ltrim($user_profile->id, '0').");return false;"));
                                        ?>
                                    </span>
                                <?php elseif($user_profile->is_related): ?>
                                    <span class="removeFromFriend">
                                        <?= anchor("profile/deleteFriend/".ltrim($user_profile->id, '0')."/".$user->id,
                                            $lang['delete_friend'],
                                            array('onclick'=>"deleteFriendConfirm();return false;"));
                                        ?>
                                    </span>
                                <?php endif; ?>
                                <span class="abuseReport">
                                    <?= anchor("profile/abuseReport/".ltrim($user_profile->id, '0'),
                                            $lang['report_abuse'],
                                            array('onclick'=>"abuseReport(".ltrim($user_profile->id, '0').");return false;"));
                                    ?>
                                </span>
                                <?php else: ?>
                                    <span class="addToFriend">
                                        <?= anchor(base_url(),$lang['enableAfterLogin']) ?>
                                    </span>
                                <?php endif; ?>
                            </span>
                        <?php endif; ?>
                </div>
        </div>
        <div id="centerColumn">
            <div id="ajaxHolder"></div>
            <div id="centerContainerSecondLayer"></div>
            <div id="centerContainer">
                <!-- this div just used for ajax loader position -->
                <?php if($userFarm->id): ?>
                <div id="farmCharts">
                        <div class="barContainer">
                            <span class="title">
                                <?= $lang['farmDangerous'] ?>
                            </span>
                            <span class="bar">
                                <div id="dangerBar" class="progressBar"></div>
                            </span>
                        </div>
                        <div class="barContainer">
                            <span class="title">
                                <?= $lang['farmSecurity'] ?>
                            </span>
                            <span class="bar">
                                <div id="secureBar" class="progressBar"></div>
                            </span>
                        </div>
                        <div class="barContainer">
                            <span class="title">
                                <?= $lang['farmHelp'] ?>
                            </span>
                            <span class="bar">
                                <div id="helpBar" class="progressBar"></div>
                            </span>
                        </div>
                </div>

                
                <div id="farmSnapshot">
                    <?php if($userFarm->disactive == 0): ?>
                    <?php if(!$partner)
                                echo anchor(base_url()."farms/show", " ",array('title'=>$lang['goToFarm']));
                          else
                                echo anchor(base_url()."farms/view/$user_profile->id", " ",array('title'=>$lang['goToFarm']));
                    ?>
                    <?php else: ?>
                    <acronym class="endGame" title="<?= $lang['endGame'] ?>" ></acronym>
                    <?php endif; ?>
                </div>

                <div id="profileFarmDetails">
                        <table>
                                <tr>
                                        <td class="title"><?= $lang['farmArea'] ?></td>
                                        <td><?= ($userFarm->section)." ".$lang['section'] ?></td>
                                </tr>
                                <tr>
                                        <td class="title"><?= $lang['farmMoney'] ?></td>
                                        <td><?= $userFarm->money." ".$lang['yummyMoneyUnit'] ?></td>
                                </tr>
                                <?php if($userFarm->disactive == 0): ?>
                                <tr>
                                        <td class="title"><?= $lang['farmLevel'] ?></td>
                                        <td><?= $lang["level$userFarm->level"] ?></td>
                                </tr>
                                <?php if($userFarm->plantName) : ?>
                                <tr>
                                        <td class="title"><?= $lang['plant'] ?></td>
                                        <td><?= $lang[$userFarm->plantName] ?></td>
                                </tr>
                                <tr>
                                        <td class="title"><?= $lang['health'] ?></td>
                                        <td><?= $userFarm->health ?> %</td>
                                </tr>
                    			<?php endif; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="2" style="text-align: center">
                                        <?php if(!$partner): ?>
                                        <br/>
                                        <?= anchor("",$lang['registerNewFarm'],
                                            array('onclick'=>"registerNewFarm();return false;",'class'=>'solidLink'));
                                        ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endif; ?>
                        </table>
                </div>
                <div id="profileFarmTransactions">
                            <div class="jcarousel-skin-vertical">
                              <div class="jcarousel-container">
                                  <div class="jcarousel-clip">
                                      <ul  id="transactionHolder" class="jcarousel-list">
                                        <?php foreach ($transactions as $transaction) : ?>
                                            <li class=<?= $transaction->messageStyle ?>>
                                                    <span class="container">
                                                            <?php if($transaction->messageStyle != ""): ?>
                                                                <img src="<?= $base_img."profile/".$transaction->messageStyle."Icon.png" ?>">&nbsp;
                                                            <?php endif; ?>
                                                            <?php
                                                            if($transaction->type != 3)
                                                            {
                                                                if($transaction->flag == 0)
                                                                        $ns = "";
                                                                elseif($transaction->flag == 1)
                                                                        $ns = "Done";
                                                                elseif($transaction->flag == 2)
                                                                        $ns = "Reject";

                                                                if($transaction->offset_farm == $userFarm->id)
                                                                        $ns = "Attack";

                                                                echo $lang['farmTransaction'.$ns.'-'.$transaction->accessory_id];
                                                            }
                                                            else
                                                                if($transaction->flag != 'newUser')
                                                                {
                                                                    if($transaction->offset_farm == $userFarm->id)
                                                                        echo $lang['farmTransactionHelpToFriend'];
                                                                    else
                                                                        echo $lang['farmTransactionFriendHelpToU'];
                                                                }
                                                                else
                                                                    echo $lang['havingAnytransaction'];

                                                            
                                                            ?>
                                                    </span>
                                                    <?= "<span class=\"transactionDate\">".fa_strftime("%d %B %Y", date("Y-m-d", $transaction->create_date . ""))."</span>"; ?>
                                            </li>
                                        <?php endforeach; ?>
                                      </ul>
                                  </div>
                              </div>
                            </div>
                </div>
                <?php else: ?>
                <?php echo (!$partner)?$mainFarm:"<span class=\"haventFarm\">".$lang['haventFarm']."</span>"; ?>
                <?php endif; ?>
            </div>
        </div>
        <div id="leftColumn">
                <div id="friendBox">
                        <span class="title"><?= $lang['friends'] ?></span>
                        <?php if(!empty ($friends)): ?>
                        <span class="allFriendsLink">
                            <?= anchor("profile/seeAllFriends/$user_profile->id",
                            $lang['allFriends'],
                             array('onclick'=>"seeAllFriends(".$user_profile->id.");return false;"))."<br/>";
                            ?>
                        </span>
                        <?php endif; ?>
                        <div id="friendAvatars">
                            <?php
                            $i= 0;
                            if(!empty ($friends))
                            foreach($friends as $friend):
                            if($i > 3){break;}else{
                                ?>
                                    <div class="friendAvatarItem">
                                    <?php if($friend->photo != ""): ?>
                                        <a href="<?= base_url() ?>profile/user/<?= $friend->id ?>" >
                                        <img src="<?= css_url() ?>system/application/helpers/fa_image_helper.php?nw=62&nh=62&source=<?= $avatar_img."avatars/".$friend->photo.".png" ?>&stype=png&dest=x&type=little" border="0" />
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url() ?>profile/user/<?= $friend->id ?>" >
                                            <img src="<?= $base_img ?>default.png" />
                                        </a>
                                    <?php endif; ?>
                                        <a href="<?= base_url() ?>profile/user/<?= $friend->id ?>" >
                                            <span><?= $friend->first_name ?></span>
                                        </a>
                                    </div>
                            <?php
                            $i++;
                            }
                            endforeach;
                            else
                            {
                                echo $lang['havingAnyFriend']."<br/><br/>";
                                if(!$partner)
                                    echo $lang['findingFriend'];
                            }
                            ?>
                        </div>
                </div>
                <?php if(!$partner): ?>
                <div id="inviteFriends">
                    <div class="body" ><span id="inviteRequestHolder"><?= $lang['addFriendsToYummy'] ?></span></div>
                    <div class="form">
                        <form id="addFriend">
                            <input type="text" name="inviteEmail" id="inviteEmail"/>
                            <input type="submit" class="submit" id="inviteSubmit" value=""/>
                        </form>
                    </div>
                </div>
                <?php else: ?>
                <div id="privateMessageArea">
                    <span class="title"><?= $lang['sendMessage'] ?></span>
                    <span class="body">
                        <div class="form">
                            <?php if(!$user->unAuthenticatedUser): ?>
                            <form id="sendMessage">
                                <textarea id="privateMess"></textarea>
                                <input type="submit" class="submit" value="" style="margin-top:-5px !important"/>
                            </form>
                            <?php else: ?>
                                <textarea id="privateMess" disabled><?= $lang['enableAfterLogin'] ?></textarea>
                            <?php endif; ?>
                        </div>

                    </span>
                    <span class="messAjaxHolder"></span>
                </div>
                <?php endif; ?>
        </div>
        <?php if(!$partner): ?>
        <div id="bottomBar">
            <?= anchor("profile/inbox",
                       "<span>$userFarm->unreadMess</span>",
                       array('onclick'=>"inbox();return false;",'id'=>"inboxCounter"));
            ?>
            <div id="footpanel">
                <ul id="mainpanel">
                    <li id="alertpanel">
                        <a href="#" class="alerts">
                            <span id="notificationCounter">
                                <?php if($notifications == false)
                                      {
                                            $notifications = null;
                                            echo '0';
                                      }
                                      else
                                      {
                                          $notChecked = 0;
                                          foreach($notifications AS $not)
                                              if($not['checked'] == 0)
                                                  $notChecked++;
                                          echo $notChecked;
                                      }
                                      
                                ?>
                            </span>
                        </a>
                        <div class="subpanel">
                            <h3>
                                <span></span><?= $lang['notifications'] ?>
                                <?php
                                echo anchor("farms/deleteNotification/all","X",array('onclick'=>"deleteNotification('all');return false;",'title'=>$lang['deleteAll']));
                                ?>
                            </h3>
                            <ul id="notification"></ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <?php endif; ?>
</div>

<script type="text/javascript">

$(document).ready(function(){

	//Click event on Chat Panel + Alert Panel
	$("#alertpanel a:first").click(function() {
                $("#notification").removeAttr('style');
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
                $("#notification li").remove();
                $("#notification").removeAttr('style');
		$("#footpanel li a").removeClass('active');
                $('#notificationCounter').html('0');
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
