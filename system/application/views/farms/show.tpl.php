<style>
.asd{height:50px;width:200px}
.highlight {
color:#FF0000;
}
</style>

<script>
    function ajax_request(handler, url, params) {
        $(handler).append('<p><img src="<?= $base_img ?>ajax-loader.gif" width="35" height="35" /></p>');
        $(handler).load(url, params);
    }

    function highlightLast10min(periods) {
        if (periods[5] < 10) {
            $(this).addClass('highlight');
        }
    }

    function liftOff() {
        alert('We have lift off!');
    }

    function addResourceToFarm(farm_id , resource_id){
	var params = {};
     	params['farm_id'] = farm_id;
	params['resource_id'] = resource_id;

        ajax_request('#farmResource', '/farms/addResourceToFarm', params)
    }

    function addPlantToFarm(farm_id , type_id){
	var params = {};
     	params['farm_id'] = farm_id;
	params['type_id'] = type_id;

        ajax_request('#plantHolder', '/farms/addPlantToFarm', params)
    }
    function addResourceToPlant(resource_id , plant_id){
	var params = {};
     	params['plant_id'] = plant_id;
	params['resource_id'] = resource_id;

        ajax_request('#plantHolder', '/farms/addResourceToPlant', params)
    }

    
</script>

<div id="farmDetails">
<fieldset>
	<legend>Farm Details</legend>
FarmName:<?= $farm->name ?><br/>
FarmMoney:<?= $farm->money ?><br/>
FarmSection:<?= $farm->section ?>
<hr/>
<h4>Farm Resources</h4>
<div id="farmResource">
    <?= $farmResources ?>
</div>
<hr/>
<h4>Farm Plants</h4>
PlantHealth:<?= $plant->health ?><br/>
<?php if($plant->growth > 0): ?>
	PlantGrowth:
<div id="plantGrowthHolder" class="asd"></div>
<script>	
    $(function () {
	var growthTime = <?= $plant->growth; ?>;
     	$('#plantGrowthHolder').countdown({until: growthTime, 
					   onExpiry: liftOff ,
        				   onTick: highlightLast10min
        	  		         });
    });
</script>

<?php else: 
	echo anchor("farms/reap/$plant->id","reap");
      endif;
?>
<br/>

PlantType:<?= $plant->typeName ?><br/>
<?php
if(isset($plant->plantresources))
foreach($plant->plantresources AS $pltSrc)
{
	foreach($pltSrc->typeresource AS $typSrc)
		//echo ">>".$ss->minNeed."<br/>";
		foreach($typSrc->resource AS $src)
			echo $src->name.": ";

	echo $pltSrc->current." remainingTime: ";
?>
<div id="srcRemainTimeHolder<?= $pltSrc->id ?>" class="asd"></div>
<script>	
    $(function () {
	var remainTime = <?= $pltSrc->usedTime; ?>;
     	$('#srcRemainTimeHolder<?= $pltSrc->id ?>').countdown({until: remainTime, 
							       onExpiry: liftOff ,
        						       onTick: highlightLast10min
        						       });
    });
</script>
<?php
}
?>
<div id="plantHolder"></div>
<hr/>
<h4>Farm Accessories</h4>
<?php
foreach ($farmAcc AS $fAcc)
{
	echo "Name: ".$fAcc->name." Type:".$fAcc->type."<br/>";
}
?>

</fieldset>
</div>
<div id="accessories">
<fieldset>
	<legend>Add Accessories to farm</legend>
<?php foreach($accessories AS $acc) 
	echo anchor("farms/addAccessoryToFarm/$farm->id/$acc->id","$acc->name")."<br/>";
?>
</fieldset>
</div>
<div id="resource">
<fieldset>
	<legend>Add Resource to farm</legend>
<?php
foreach($resources AS $resource)
	echo anchor("farms/addResourceToFarm/$farm->id/$resource->id", 
                    "$resource->name",
                     array('onclick'=>"addResourceToFarm(".$farm->id.",".$resource->id.");return false;"))."<br/>";
?>
</fieldset>
</div>


<div id="types">
<fieldset>
	<legend>Add Plant to Farm</legend>
<?php
foreach($types AS $type)
        echo anchor("farms/addPlantToFarm/$farm->id/$type->id",
                    "$type->name",
                     array('onclick'=>"addPlantToFarm(".$farm->id.",".$type->id.");return false;"))."<br/>";
?>
</fieldset>

<fieldset>
	<legend>
		Add Resource to Plant
	</legend>
<?php 
if(isset($plantSources))
foreach($plantSources AS $pltSrcName=>$pltSrcItem)
{
        echo anchor("farms/addResourceToPlant/$pltSrcItem[0]/$pltSrcItem[1]",
                    "$pltSrcName",
                     array('onclick'=>"addResourceToPlant(".$pltSrcItem[0].",".$pltSrcItem[1].");return false;"))."<br/>";
}
?>
</fieldset>
</div>

