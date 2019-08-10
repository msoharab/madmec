var  navSideBarCustom = {
	container:'.mini-submenu',
	closebut:'#slide-submenu',
	itemgrp:'.list-group',
	menuitme:'.list-group-item',
	click:function(){
		var me = this;
		$(me.closebut).on('click', function () {
			$(this).closest(me.itemgrp).toggle();
			$(me.container).show();
		});
		$(me.container).on('click', function () {
			$(this).next(me.itemgrp).toggle();
			$(me.container).hide();
		});
	}
};