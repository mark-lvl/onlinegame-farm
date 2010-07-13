<script>
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
    $('.jcarousel-skin-topuser .jcarousel-container').show();
    jQuery('.<?= $type ?>').jcarousel({
    easing:'BounceEaseOut',
    animation:1000,
    scroll:4
    });
    });
</script>

<div class="userHolder">
    <div class="jcarousel-skin-topuser">
          <div class="jcarousel-container">
              <div disabled="disabled" class="jcarousel-prev jcarousel-prev-disabled"></div>
              <div class="jcarousel-next"></div>
              <div class="jcarousel-clip">
                  <ul  class="<?= $type ?>" class="jcarousel-list">
                    <?php foreach ($users as $user) : ?>
                        <li>
                            <div class="perUserItem">
                                <?php if($user->photo != ""): ?>
                                                    <a href="<?= base_url() ?>profile/user/<?= $user->id ?>">
                                                        <img src="<?= css_url() ?>system/application/helpers/fa_image_helper.php?nw=44&nh=44&source=<?= $avatar_img."avatars/".$user->photo.".png" ?>&stype=png&dest=x&type=little" border="0" />
                                                        <span><?= $user->first_name." ".$user->last_name ?></span>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?= base_url() ?>profile/user/<?= $user->id ?>">
                                                        <?php if($user->sex == 0): ?>
                                                            <img src="<?= css_url() ?>system/application/helpers/fa_image_helper.php?nw=44&nh=44&source=<?= $avatar_img."avatars/default-m.png" ?>&stype=png&dest=x&type=little" border="0" />
                                                        <?php else: ?>
                                                            <img src="<?= css_url() ?>system/application/helpers/fa_image_helper.php?nw=44&nh=44&source=<?= $avatar_img."avatars/default-f.png" ?>&stype=png&dest=x&type=little" border="0" />
                                                        <?php endif; ?>
                                                        <span><?= $user->first_name." ".$user->last_name ?></span>
                                                    </a>
                                                <?php endif; ?>
                        </div>
                        </li>
                    <?php endforeach; ?>
                  </ul>
              </div>
          </div>
        </div>












    
</div>
