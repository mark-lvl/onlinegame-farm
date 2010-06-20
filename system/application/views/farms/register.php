<style>
  #centerContainer {
    background: #2b3b09;
    height: 395px;
    width: 464px;
    display: block;
    margin-top: 2px;
}
#centerColumn
{
     margin-bottom: 8px !important;
}
</style>
<script>
    $(document).ready(function(){
        $("#step1").removeClass('wizardContentContainer');

        $('.pager a').click(function()
        {
            $('#wizardWrapper > div').hide();
            $('#step'+$(this).attr('class')).fadeIn();
            if($(this).attr('class') == 5 )
            {
                $('.wizardInput').removeAttr("disabled");
                $('.wizardInput').attr("value","");
                $('.wizardSubmit').removeAttr("disabled");
                $('#wizardFinal').fadeIn();
            }
        });
        $('.wizardSubmit').click(function(){
            if($('.wizardInput').val() == "")
            {
                $('.wizardInput').css('border','1px red solid');
                return false;
            }
        });
    })
    
</script>

<div id="centerContainer">
    <div id="profileWizard">
        <div id="wizardWrapper">
            <div id="step1" class="wizardContentContainer">
                <div class="wizardStep">
                    <div class="wizardIcon">
                        <img src="<?= $base_img ?>profile/wizard-icon-step1.png" />
                    </div>
                    <div class="wizardPic">
                        <img src="<?= $base_img ?>profile/wizard-pic-step1.png" />
                    </div>
                    <div class="wizardHeader">
                        <?= $lang['createFarm'] ?>
                    </div>
                    <div class="wizardDescription">
                        <?= $lang['createFarmDescription'] ?>
                    </div>
                    <div class="wizardNextStep pager">
                        <a class="2"></a>
                    </div>
                </div>
            </div>
            <div id="step2" class="wizardContentContainer">
                <div class="wizardStep">
                    <div class="wizardIcon">
                        <img src="<?= $base_img ?>profile/wizard-icon-step2.png" />
                    </div>
                    <div class="wizardPic">
                        <img src="<?= $base_img ?>profile/wizard-pic-step2.png" />
                    </div>
                    <div class="wizardHeader">
                        <?= $lang['plowFarm'] ?>
                    </div>
                    <div class="wizardDescription">
                        <?= $lang['plowFarmDescription'] ?>
                    </div>
                    <div class="wizardNextStep pager">
                        <a class="3"></a>
                    </div>
                    <div class="wizardPreviousStep pager">
                        <a class="1"></a>
                    </div>
                </div>
            </div>
            <div id="step3" class="wizardContentContainer">
                <div class="wizardStep">
                    <div class="wizardIcon">
                        <img src="<?= $base_img ?>profile/wizard-icon-step3.png" />
                    </div>
                    <div class="wizardPic">
                        <img src="<?= $base_img ?>profile/wizard-pic-step3.png" />
                    </div>
                    <div class="wizardHeader">
                        <?= $lang['plantToFarm'] ?>
                    </div>
                    <div class="wizardDescription">
                        <?= $lang['plantToFarmDescription'] ?>
                    </div>
                    <div class="wizardNextStep pager">
                        <a class="4"></a>
                    </div>
                    <div class="wizardPreviousStep pager">
                        <a class="2"></a>
                    </div>
                </div>
            </div>
            <div id="step4" class="wizardContentContainer">
                <div class="wizardStep">
                    <div class="wizardIcon">
                        <img src="<?= $base_img ?>profile/wizard-icon-step4.png" />
                    </div>
                    <div class="wizardPic">
                        <img src="<?= $base_img ?>profile/wizard-pic-step4.png" />
                    </div>
                    <div class="wizardHeader">
                        <?= $lang['careFarm'] ?>
                    </div>
                    <div class="wizardDescription">
                        <?= $lang['careFarmDescription'] ?>
                    </div>
                    <div class="wizardNextStep pager">
                        <a class="5"></a>
                    </div>
                    <div class="wizardPreviousStep pager">
                        <a class="3"></a>
                    </div>
                </div>
            </div>
            <div id="step5" class="wizardContentContainer">
                <div class="wizardStep">
                    <div class="wizardIcon">
                        <img src="<?= $base_img ?>profile/wizard-icon-step5.png" />
                    </div>
                    <div class="wizardPic">
                        <img src="<?= $base_img ?>profile/wizard-pic-step5.png" />
                    </div>
                    <div class="wizardHeader">
                        <?= $lang['reapFarm'] ?>
                    </div>
                    <div class="wizardDescription">
                        <?= $lang['reapFarmDescription'] ?>
                    </div>
                    <div class="wizardPreviousStep pager">
                        <a class="4"></a>
                    </div>
                </div>
            </div>
        </div>
        <div id="wizardFormWrapper">
            <div id="wizardFormContainer">
                <div class="createFarmHeader">
                    <?= $lang['farmNaming'] ?>
                </div>
                <div class="createFarmDescription">
                    <?= $lang['farmNamingDescription'] ?>
                </div>
                <div class="createFarmFrom">
                    <form action="<?= base_url() ?>farms/register"  method="post">
                        <input type="text" name="name" class="wizardInput" value="<?= $lang['firstReadHelp'] ?>" maxlength="40" disabled/>
                        <input type="submit" value=" " class="wizardSubmit" disabled/>
                    </form>
                </div>
            </div>
        </div>
        <div id="wizardFinal"></div>
    </div>
</div>
