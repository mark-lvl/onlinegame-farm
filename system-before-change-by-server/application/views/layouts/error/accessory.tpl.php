<script>
    Boxy.alert("<?php foreach($params['accessories'] AS $acc) echo"$acc<br/>";  ?>",
               null,
               {title : "<?= $lang['accessory']['title'] ?>"});
</script>
