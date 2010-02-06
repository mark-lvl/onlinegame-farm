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
