<style>
    .boxy-inner {height: 135px!important;overflow:auto;}
    .main-content{height:135px!important}
    .attention{vertical-align: middle;margin-left:10px}
</style>
<script>

    Boxy.confirm("<?= $lang['resetLevelConfirm'] ?>", function() {
        var params = {};
	params['farm_id'] = <?= $params['farm_id'] ?>;
	params['user_id'] = <?= $params['user_id'] ?>;
	params['confirmResetFarm'] = true;
        ajax_request('#ajaxHolder','<?= base_url() ?>farms/resetLevel',params) }, {title: '<?= $lang['becareful'] ?>'});


</script>
