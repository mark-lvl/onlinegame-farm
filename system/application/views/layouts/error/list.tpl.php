<style>
    .boxy-inner {height: 310px;overflow:auto;}
    #friendListItem
    {
        width: 150px;
        float: right;
    }
    .imageHolder
    {
        float: right;
        width: 50px;
    }
    .detailHolder
    {
        float: left;
        width: 100px;
    }
    </style>
<script>
    var list = "<?php foreach($params['friends'] AS $friend): ?><div id=\"friendListItem\"><span class=\"imageHolder\"><?php if($friend->photo != ""): ?><img src=\"<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=48&nh=48&source=<?= $avatar_img."avatars/".$friend->photo.".png" ?>&stype=png&dest=x&type=little\" border=\"0\" /><?php else: ?><a href=\"<?= base_url() ?>profile/user/<?= $friend->id ?>\" ><?php if($friend->sex == 0): ?><img src=\"<?= css_url() ?>system/application/helpers/fa_image_helper.php?nw=48&nh=48&source=<?= $avatar_img."avatars/default-m.png" ?>&stype=png&dest=x&type=little\" border=\"0\" /><?php else: ?><img src=\"<?= css_url() ?>system/application/helpers/fa_image_helper.php?nw=48&nh=48&source=<?= $avatar_img."avatars/default-f.png" ?>&stype=png&dest=x&type=little\" border=\"0\" /><?php endif; ?></a><?php endif; ?></span><span class=\"detailHolder\"><div><a href=\"<?= base_url() ?>profile/user/<?= $friend->id ?>\" ><?= $friend->first_name ?></a></div><div><?=  $lang['birthdate'].": ".convert_number(fa_strftime("%d %B %Y", $friend->birthdate . "")) ?></div></span></div><?php endforeach; ?>";

    new Boxy(list, {title: "<?= $lang['listAllFriends'] ?>",modal: true , closeText:"<img src=\"<?= $base_img ?>/popup/boxy/close.png\" />"});
</script>