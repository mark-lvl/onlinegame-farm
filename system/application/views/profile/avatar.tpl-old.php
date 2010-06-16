<style>
  #centerContainer {
    background: #2b3b09 url(<?= $base_img ?>profile/edit_background.gif) no-repeat top center;
    height: 395px;
    width: 464px;
    display: block;
    margin-top: 2px;
}
</style>
<style>
    
    #registerForm
    {
        right: 75px;
        top: 30px;
    }
    .closeButton
    {
    	position: absolute;
    	top:8px;
    	right:8px;
    }
    .closeButton a img
    {
        width:26px;
    	height:26px;
    	display:block;
    }
</style>
<div id="centerContainer">
	<span class="closeButton"><?= anchor("profile/user/$user_profile->id","<img src=\"$base_img"."popup/boxy/close.png\"/>") ?></span>
    <div id="registerForm">
                
                </div>
</div>