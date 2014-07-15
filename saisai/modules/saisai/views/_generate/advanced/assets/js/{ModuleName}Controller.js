// jqx.load('plugin', 'date');

{ModuleName}Controller = jqx.createController(saisai.controller.BaseSaisaiController, {
	
	init: function(initObj){
		this._super(initObj);
	},

	add_edit : function(){
		var _this = this;
		// do this first so that the fillin is in the checksaved value
		//saisai.controller.BaseSaisaiController.prototype.add_edit.call(this, false);
		this._super();
	}		
});