saisai.controller.NavigationController = jqx.createController(saisai.controller.BaseSaisaiController, {
	
	init: function(initObj){
		this._super(initObj);
	},

	items : function(){
		// call parent
		saisai.controller.BaseSaisaiController.prototype.items.call(this);
		//saisai.controller.BaseSaisaiController.prototype.items();
		var _this = this;
		
		$('.ico_navigation_download').click(function(e){
			e.preventDefault();
			$('#form').attr('action', $(this).attr('href')).attr('method', 'post').submit();
		})
	},
	
	add_edit : function(){
		// call parent
		//saisai.controller.BaseSaisaiController.prototype.add_edit.call(this);
		this._super();
		//this._super.
		var origParentId = $('#parent_id').val();
		var id = $('#id').val();
		$('#group_id').change(function(e){
			var parentId = ($('#parent_id').val() != '') ? $('#parent_id').val() : origParentId;
			var path = jqx.config.saisaiPath + '/navigation/parents/' + $('#group_id').val() + '/' + parentId + '/' + id;
			$('#parent_id').parent().load(path, {}, function(){
				$('#parent_id').val(parentId);
				$.changeChecksaveValue('#parent_id', origParentId);
			});
		});
	},
	
	upload : function(){
		this.notifications();
		//this._initAddEditInline($('#form'));
	}
	
	
});