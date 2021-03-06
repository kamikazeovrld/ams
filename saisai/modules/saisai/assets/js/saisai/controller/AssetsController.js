saisai.controller.AssetsController = jqx.createController(saisai.controller.BaseSaisaiController, {
	
	init: function(initObj){
		this._super(initObj);
	},

	items : function(){

		// call parent
		//saisai.controller.BaseSaisaiController.prototype.items.call(this);
		this._super();
		
		var _this = this;
		$('#group_id').change(function(e){
			$('#form_actions').submit();
		});
	},
	
	select : function(){
		this.notifications();
		$assetSelect = $('#asset_select');
		$assetPreview = $('#asset_preview');
		var selectedAssetFolder = this.initObj.folder;
		
		var isImg = ($assetSelect.val() && $assetSelect.val().match(/\.jpg$|\.jpeg$|\.gif$|\.png$/));
		if (isImg){
			$assetSelect.change(function(e){
				$assetPreview.html('<img src="' + jqx.config.assetsPath + selectedAssetFolder + '/' + $assetSelect.val() + '" />');
			})
			$assetSelect.keyup(function(e) {
				$assetSelect.change();
				return(false);
			});
			$assetSelect.change();
			$('.img_only').show();
		} else {
			$assetPreview.hide();
			$('.img_only').hide();
		}
		$assetSelect.change();
	},

	add_edit : function(){
		this._super();
		$('#resize_method').change(function(e){
			if ($(this).val() == 'resize_and_crop'){
				$('#master_dim').parents('tr').hide();
			} else {
				$('#master_dim').parents('tr').show();
			}
		})
		$('#resize_method').change();

		$('#back').click(function(e){
			e.preventDefault();
			window.location = $(this).data('url');
		})
	}
	
});