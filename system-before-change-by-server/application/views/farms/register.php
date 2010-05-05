<style>
  #centerContainer {
    background: #2b3b09 url(<?= $base_img ?>profile/edit_background.gif) no-repeat center;
    height: 395px;
    width: 464px;
    display: block;
}
 #centerColumn
 {
     margin-bottom: 8px !important;
}
</style>

<div id="centerContainer">
<fieldset>
    <legend>
        <?= $lang['addFarm'] ?>
    </legend>
    <form action="<?= base_url() ?>farms/register"  method="post">
        <table>
                <tr>
                    <td>
                        <?= $lang['addFarmName'] ?>
                    </td>
                    <td>
                        <input type="text" name="name" />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center">
                        <input type="submit" value="<?= $lang['submit'] ?>" />
                    </td>
                </tr>
        </table>
    </form>
</fieldset>
</div>
