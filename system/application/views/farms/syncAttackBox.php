<?php if(isset($attacksToFarm)): ?>
        <div class="header"></div>
        <div class="details">
            <?php foreach($attacksToFarm as $att): ?>
                <?php switch ($att->accessory_id) {
                                            case 1:
                                                $attImg = "aphid";
                                            break;
                                            case 2:
                                                $attImg = "grasshoppers";
                                            break;
                                            case 4:
                                                $attImg = "mouse";
                                            break;
                                            case 6:
                                                $attImg = "crow";
                                            break;
                                        }
                ?>
            <img src="<?= $base_img."farm/accessory/".$attImg.".png" ?>" title="<?= $lang[$attImg] ?>"/>
            <?php endforeach; ?>
        </div>
        <div class="footer"></div>
<?php endif; ?>