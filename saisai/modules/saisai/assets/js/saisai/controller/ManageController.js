saisai.controller.ManageController = jqx.createController(saisai.controller.BaseSaisaiController, {
	
	init: function(initObj){
		this.notifications();
		this._submit();
		this._super(initObj);
	},
	
	activity: function(){
		this.tableAjaxURL = jqx.config.saisaiPath + '/manage/activity';
		this.items();
	}
});