<style>
    .boxy-inner {height: 310px;overflow:auto;}
    .boxy-wrapper .title-bar .close{right:345px;}
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
    var list = "<?php foreach($params['friends'] AS $friend): ?><div id=\"friendListItem\"><span class=\"imageHolder\"><?php if($friend->photo != ""): ?><img src=\"<?= base_url() ?>system/application/helpers/fa_image_helper.php?nw=32&nh=32&source=../views/layouts/images/users/<?= $friend->photo ?>&stype=jpg&dest=x&type=little&dd=<?= date("Y-m-d H:i:s") ?>\"  /><?php else: ?><a href=\"<?= base_url() ?>profile/user/<?= $friend->id ?>\" ><img src=\"<?= $base_img ?>default.png\"  style=\"width:48px;height:48px\"/></a><?php endif; ?></span><span class=\"detailHolder\"><div><a href=\"<?= base_url() ?>profile/user/<?= $friend->id ?>\" ><?= $friend->first_name ?></a></div><div><?=  $lang['birthdate'].": ".convert_number(fa_strftime("%d %B %Y", $friend->birthdate . "")) ?></div></span></div><?php endforeach; ?>";

    new Boxy(list, {title: "<?= $lang['listAllFriends'] ?>",modal: true , closeText:"[ <?= $lang['close'] ?> ]"});
</script>