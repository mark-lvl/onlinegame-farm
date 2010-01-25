<?php
	$this->load->module('profile_information');
	$this->profile_information->method(array("friends" => $friends, "rank" => $drivers_rank, "driver_profile" => $driver_profile, "driver" => $driver, "lang" => $lang));
?>
<div class="middle_box">
	<div class="message_list">
		<div class="races_desc">
	    	<?= $lang['seletion_hint'] ?>
		</div>
        <?php
            if($lock_stat <= 1) {
                $m1 = "3";
                $m2 = "3";
            }
            else if($lock_stat == 2) {
                $m1 = "1";
                $m2 = "3";
            }
            else {
                $m1 = "1";
                $m2 = "1";
            }
        ?>
	    <div class="races_type1">
	        <div class="rtn race_item11" title="Rookie" id="p11">
	        </div>
	        <div class="rtn race_item2<?= $m1 ?>" title="Hot<?= $m1 ?>" id="p12">
	        </div>
	        <div class="rtn race_item3<?= $m2 ?>" title="TopGear<?= $m2 ?>" id="p13">
	        </div>
	    </div>

	    <div class="races_type2">
	        <div class="rtn race_item11" title="Rookie" id="q21">
	        </div>
	        <div class="rtn race_item2<?= $m1 ?>" title="Hot<?= $m1 ?>" id="q22">
	        </div>
	        <div class="rtn race_item3<?= $m2 ?>" title="TopGear<?= $m2 ?>" id="q23">
	        </div>
	    </div>
	    <div class="races_type3">
	        <div class="rtn race_item11" title="Rookie" id="r31">
	        </div>
	        <div class="rtn race_item2<?= $m1 ?>" title="Hot<?= $m1 ?>" id="r32">
	        </div>
	        <div class="rtn race_item3<?= $m2 ?>" title="TopGear<?= $m2 ?>" id="r33">
	        </div>
	    </div>
	    <div class="races_type4">
	        <div class="rtn race_item11" title="Rookie" id="t41">
	        </div>
	        <div class="rtn race_item2<?= $m1 ?>" title="Hot<?= $m1 ?>" id="t42">
	        </div>
	        <div class="rtn race_item3<?= $m2 ?>" title="TopGear<?= $m2 ?>" id="t43">
	        </div>
	    </div>

	    <?php
	        for($j = 11; $j <= 43; $j++) {
	            if(($j > 13 && $j < 21) || ($j > 23 && $j < 31) || ($j > 33 && $j < 41)) {
	                continue;
	            }
	    ?>
				<div class="combo" id="s<?= $j ?>">
				    <select id="sel<?= $j ?>">
			    <?php
			        for($i = 1; $i <= 3; $i++) {
			            if(($j == 13 || $j == 23 || $j == 33 || $j == 43) && $i > 1) {
			                break;
			            }
			    ?>
				        <option value="<?= $j . $i ?>">
		           			<?php
		           			    $rc = Race::create_race((int)($j . $i));
		           			    echo $rc->name;
		           			?>
				        </option>
				<?php
				    }
				?>
				    </select>
				</div>
		<?php
		}
		?>
        <div class="go">
            <form action="<?= base_url() ?>gateway/assign_race/" method="post" onsubmit="return sbtfrm();">
                <input type="hidden" value="" name="race_type" id="race_type" />
        		<input class="go_button" type="submit" value="<?= $lang['submit'] ?>" />
			</form>
		</div>
	</div>
</div>
<?php
	$this->load->module('profile_left_boxes');
	$this->profile_left_boxes->method(array("friends" => $friends, "driver_profile" => $driver_profile, "drivers_ranks" => $drivers_ranks, "driver" => $driver, "lang" => $lang));
?>
<br style="clear:both" />
<br /><br />
<script>
	$(function(){
	    var selected = false;
	    var f_selected = false;
		$(".rtn").click( function() {
			$(".rtn").each( function() {
				if(this.title == "Rookie") {
					$(this).removeClass();
					$(this).addClass("rtn race_item11");
				}
				else if(this.title == "Hot1") {
					$(this).removeClass();
					$(this).addClass("rtn race_item21");
				}
				else if(this.title == "Hot3") {
					$(this).removeClass();
					$(this).addClass("rtn race_item23");
				}
				else if(this.title == "TopGear1") {
					$(this).removeClass();
					$(this).addClass("rtn race_item31");
				}
				else if(this.title == "TopGear3") {
					$(this).removeClass();
					$(this).addClass("rtn race_item33");
				}
			});
			
		    if(this.title == "Rookie") {
		        $(this).addClass("rtn race_item12");
		    }
		    else if(this.title == "Hot1") {
		        $(this).addClass("rtn race_item22");
		    }
		    else if(this.title == "TopGear1") {
		        $(this).addClass("rtn ?race_item32");
		    }
		    else {
		        return;
		    }
		    
		    selected = this.id.substr(1, 2);
		    $(".combo").css('display', 'none');
		    $("#s" + selected).fadeIn('fast');
		    f_selected = $("#sel" + selected).val();
		    $("#race_type").val(f_selected);
		    $(".go").fadeIn('fast');
		});
		
		$("select").change(function() {
		    f_selected = $(this).val();
		    $("#race_type").val(f_selected);
		});
	});
</script>