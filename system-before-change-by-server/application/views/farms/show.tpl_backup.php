<style>
.asd{height:50px;width:200px}
.highlight {
color:#FF0000;
}
</style>

<script>
    function highlightLast10min(periods) {
        if (periods[5] < 10) {
            $(this).addClass('highlight');
        }
    }

    function liftOff() {
        alert('We have lift off!');
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
<?php foreach($farmResources AS $sourceName=>$sourceCount)
	echo $sourceName.":".$sourceCount."<br/>";
?>
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
	echo anchor("farms/addResourceToFarm/$farm->id/$resource->id", "$resource->name")."<br/>";
?>
</fieldset>
</div>


<div id="types">
<fieldset>
	<legend>Add Plant to Farm</legend>
<?php
foreach($types AS $type)
	echo anchor("farms/addPlantToFarm/$farm->id/$type->id", "$type->name")."<br/>";
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
	echo anchor("farms/addResourceToPlant/$pltSrcItem[0]/$pltSrcItem[1]","$pltSrcName")."<br/>";
}
?>
</fieldset>
</div>

