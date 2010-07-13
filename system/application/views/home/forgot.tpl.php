<style>
    #content{background: #536229;}
    .submit{margin-right:0px}
</style>
<div id="homeWrapper">
    <div class="genericPage">
        <div class="forgotContainer">
            <div class="helpTitle" style="padding: 15px 125px 0 0">
                <?= $lang['forgotPassword'] ?>
            </div>
            <div class="forgotDescription">
                <?= $lang['forgotPasswordDescription'] ?>
            </div>
            <div class="forgotForm">
                <form method="post" action="<?= base_url() ?>home/forgot">
                    <table>
                        <tr>
                            <td>
                                <input type="text" name="email" id="emailHolder" dir="ltr"/>
                            </td>
                            <td>
                                <input type="submit" class="submit"  value=" " id="submitContact"/>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$("#submitContact").click(function(){
    if($('#emailHolder').val() == ""){
    $('#emailHolder').css("border","1px solid red");
    return false;
    }
});
</script>
