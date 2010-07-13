<style>
    #content{background: #536229;}
    .helpContainer{width: 210px;}
    .submit{margin-right:70px}
</style>
<div id="homeWrapper">
    <div class="genericPage">
        <div class="genericContainer">
            <div class="helpContainer">
                <div class="helpTitle">
                    <?= $lang['contact'] ?>
                </div>
                <div>
                    <?= $lang['contactDescription'] ?>
                </div>
                <form method="post" action="<?= base_url() ?>home/contact">
                    <table style="margin-top: 20px">
                        <tr>
                            <td>
                                <?= $lang['name'] ?>
                            </td>
                            <td>
                                <input type="text" name="name" id="contactName"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?= $lang['email'] ?>
                            </td>
                            <td>
                                <input type="text" name="email" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?= $lang['body'] ?>
                            </td>
                            <td>
                                <textarea name="body"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
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
    if($('#contactName').val() == ""){
    $('#contactName').css("border","1px solid red");
    return false;
    }
});
</script>
