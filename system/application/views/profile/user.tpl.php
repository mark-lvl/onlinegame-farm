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
    $("#changeProfile").html("<?= $lang['profile_set'] ?>");
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
    params['user_id'] = <?= $user->id ?>;
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
</script>
<script type="text/javascript">
$(document).ready(function(){
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
    params['from'] = <?= $user->id ?>;
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
        $('#searchUserByName').val('<?= $lang['must_be_filled'] ?>');
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
        <div id="rightColumn">
                <div id="userThumb">
                        <span id="userPicture">
                                <?php
                                    if($user_profile->photo != "") {
                                ?>
                                <img src="<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=110&nh=110&source=../views/layouts/images/users/<?= $user_profile->photo ?>&stype=jpg&dest=x&type=little&dd=<?= date("Y-m-d H:i:s") ?>" border="0" />
                                <?php
                                    }else{
                                ?>
                                <a href="<?= base_url() ?>profile/user/<?= $user_profile->id ?>" >
                                    <img src="<?= $base_img ?>default.png" />
                                </a>
                                <?php
                                    }
                                ?>
                        </span>
                        <span id="userName">
                                <?= $user_profile->first_name . " " . $user_profile->last_name ?>
                        </span>
                        <span id="userCity">
                                <?= $lang['fromCity'].": ".$user_profile->city ?>
                        </span>
                        <span id="userRegisterDate">
                                <?= $lang['register_date'].": ".convert_number(fa_strftime("%d %B %Y", $user_profile->registration_date . "")) ?>
                        </span>
                        <?php if(!$partner): ?>
                        <span id="changeProfile">
                                <?= anchor("profile/edit/$user_profile->id",
                                           $lang['profile_set'],
                                           array('onclick'=>"editProfile();return false;"));
                                ?>
                        </span>
                        <span id="changeProfile2">
                                <?= anchor("profile/edit/avatar",
                                           "Avatar",
                                           array('onclick'=>"avatar();return false;"));
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
                                <?php if($farmSign['endGame']['accept']): ?>
                                    <span class="rankThumb"><img src="<?= $base_img ?>profile/ranks/complete.png"/></span>
                                    <span class="rankThumbDetails">x<?= $farmSign['endGame']['detail'] ?></span>
                                <?php else: ?>
                                    <span class="rankThumb"><img src="<?= $base_img ?>profile/ranks/complete-off.png"/></span>
                                <?php endif; ?>
                            </li>
                            <li>
                                <?php if($farmSign['topLevel']['accept']): ?>
                                    <span class="topLevel"><?= $farmSign['topLevel']['detail'] ?></span>
                                    <span class="topLevelLabel"><?= $lang['levelLabel'] ?></span>
                                <?php else: ?>
                                    <span class="topLevel">0</span>
                                    <span class="topLevelLabel"><?= $lang['levelLabel'] ?></span>
                                <?php endif; ?>
                            </li>
                            <li>
                                <?php if($farmSign['deffence']['accept']): ?>
                                    <span class="rankThumb"><img src="<?= $base_img ?>profile/ranks/complete.png"/></span>
                                <?php else: ?>
                                    <span class="rankThumb"><img src="<?= $base_img ?>profile/ranks/complete-off.png" title="<?= $farmSign['deffence']['detail'] ?>/20"/></span>
                                <?php endif; ?>
                            </li>
                            <li>
                                <?php if($farmSign['attack']['accept']): ?>
                                    <span class="rankThumb"><img src="<?= $base_img ?>profile/ranks/complete.png"/></span>
                                <?php else: ?>
                                    <span class="rankThumb"><img src="<?= $base_img ?>profile/ranks/complete-off.png" title="<?= $farmSign['attack']['detail'] ?>/5"/></span>
                                <?php endif; ?>
                            </li>
                            <li>
                                <?php if($farmSign['famous']['accept']): ?>
                                    <span class="rankThumb"><img src="<?= $base_img ?>profile/ranks/complete.png"/></span>
                                <?php else: ?>
                                    <span class="rankThumb"><img src="<?= $base_img ?>profile/ranks/complete-off.png" title="<?= $farmSign['famous']['detail'] ?>/50"/></span>
                                <?php endif; ?>
                            </li>
                            <li>
                                <?php if($farmSign['goldenShovel']['accept']): ?>
                                    <span class="rankThumb"><img src="<?= $base_img ?>profile/ranks/complete.png"/></span>
                                <?php else: ?>
                                    <span class="rankThumb"><img src="<?= $base_img ?>profile/ranks/complete-off.png" title="<?= $farmSign['goldenShovel']['detail'] ?>/1"/></span>
                                <?php endif; ?>
                            </li>
                            <li>
                                <?php if($farmSign['goldenSickle']['accept']): ?>
                                    <span class="rankThumb"><img src="<?= $base_img ?>profile/ranks/complete.png"/></span>
                                <?php else: ?>
                                    <span class="rankThumb"><img src="<?= $base_img ?>profile/ranks/complete-off.png" title="<?= $farmSign['goldenSickle']['detail'] ?>/3"/></span>
                                <?php endif; ?>
                            </li>
                            <li>
                                <?php if($farmSign['goldenClock']['accept']): ?>
                                    <span class="rankThumb"><img src="<?= $base_img ?>profile/ranks/complete.png"/></span>
                                <?php else: ?>
                                    <span class="rankThumb"><img src="<?= $base_img ?>profile/ranks/complete-off.png" title="<?= $farmSign['goldenClock']['detail'] ?>/5"/></span>
                                <?php endif; ?>
                            </li>
                            <li>
                                <?php if($farmSign['bigProduct']['accept']): ?>
                                    <span class="rankThumb"><img src="<?= $base_img ?>profile/ranks/complete.png"/></span>
                                <?php else: ?>
                                    <span class="rankThumb"><img src="<?= $base_img ?>profile/ranks/complete-off.png" title="<?= $farmSign['bigProduct']['detail'] ?>/1000"/></span>
                                <?php endif; ?>
                            </li>
                            <li>
                                <?php if($farmSign['grasshoppers']['accept']): ?>
                                    <span class="rankThumb"><img src="<?= $base_img ?>profile/ranks/complete.png"/></span>
                                <?php else: ?>
                                    <span class="rankThumb"><img src="<?= $base_img ?>profile/ranks/complete-off.png" title="<?= $farmSign['grasshoppers']['detail'] ?>/20"/></span>
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
                            </span>
                        <?php endif; ?>
                </div>
        </div>
        <div id="centerColumn">
            <div id="ajaxHolder"></div>
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
                                        <br/>
                                        <?= anchor("",$lang['registerNewFarm'],
                                            array('onclick'=>"registerNewFarm();return false;",'class'=>'solidLink'));
                                        ?>
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
                                                                    echo $lang['farmTransactionHelpToFriend'];
                                                                else
                                                                    echo $lang['havingAnytransaction'];

                                                            echo "<span class=\"transactionDate\">".fa_strftime("%d %B %Y", date("Y-m-d", $transaction->create_date . ""))."</span>";
                                                            ?>
                                                    </span>
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
                                        <img src="<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=62&nh=62&source=../views/layouts/images/users/<?= $friend->photo ?>&stype=jpg&dest=x&type=little&dd=<?= date("Y-m-d H:i:s") ?>" border="0" />
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
                            <form id="sendMessage">
                                <textarea id="privateMess"></textarea>
                                <input type="submit" class="submit" value="" style="margin-top:-5px !important"/>
                            </form>
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
        </div>
        <?php endif; ?>
</div>
