jqx.load('plugin', 'jquery.placeholder');

saisai.controller.LoginController = jqx.lib.BaseController.extend({
	
	init: function(initObj){
		saisai.controller.BaseSaisaiController.prototype.notifications.call(this);
		$('#user_name').focus();
		$('input').placeholder();
		this._super(initObj);
	}
});