<div id="farmDetails">
<fieldset>
	<legend>Farm Details</legend>
FarmName:<?= $farm->name ?><br/>
FarmMoney:<?= $farm->money ?><br/>
FarmSection:<?= $farm->section ?>
<hr/>
<?php foreach($farmResources AS $sourceName=>$sourceCount)
	echo $sourceName.":".$sourceCount."<br/>";
?>
<hr/>
PlantHealth:<?= $plant->health ?><br/>
PlantGrowth:<?= $plant->growth ?><br/>
PlantType:<?= $plant->typeName ?><br/>
</fieldset>
</div>
<div id="accessories">
<fieldset>
	<legend>Add Accessories to farm</legend>
<?php foreach($accessories AS $acc) 
	echo anchor("farms/addAccToFarm/$farm->id/$acc->id","$acc->name");
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
</div>
