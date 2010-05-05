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

    var form = "<div id=\"abuseAjax\"><form id=\"abuse\"><input type=\"radio\" name=\"abuseType\" value=\"1\"/> <?= $lang['abuseName'] ?><br/>"+
 			    				  "<input type=\"radio\" name=\"abuseType\" value=\"2\"/> <?= $lang['abuseMessage'] ?><br/>"+
			    				  "<input type=\"radio\" name=\"abuseType\" value=\"3\"/> <?= $lang['abuseOthers'] ?><br/><br/>"+
								  "<input type=\"hidden\" id=\"user_id\" name=\"user_id\" value=\"<?= $id ?>\"/>"+
			    				  "<input type=\"submit\"  value=\"<?= $lang['submit'] ?>\"/>"+
    		   "</form></div>";

    new Boxy(form, {title: "<?= $lang['report_abuse'] ?>",modal: true , closeText:"<img src=\"<?= $base_img ?>/popup/boxy/close.png\" />"});
    
        $("#abuse").submit(function(){
        var paramHolder = {};
        paramHolder['user_id'] = $("#user_id").val();
        paramHolder['abuseType'] = $("#abuse input:checked").val();
        ajax_request('#abuseAjax.boxy-content','<?= base_url() ?>profile/abuseReport',paramHolder);
    	return false;
    	});
</script>