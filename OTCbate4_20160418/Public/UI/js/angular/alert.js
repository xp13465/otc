;(function(window){
	var alerts = function(){};
	alerts.prototype.show = function(data){
		var temp = '';
		temp += '	<div class="alerts">';
		temp += '		<div class="bg"></div>';
		temp += '		<div class="con groupCon">';
		temp += '			<div class="tit moveTitle">';
		temp += '				<p>'+ data +'</p>';
		temp += '			</div>';
		temp += '			<div class="bt">';
		temp += '				<a href="javascript:;" class="btnOk">确定</a>';
		temp += '			</div>';
		temp += '		</div>';
		temp += '	</div>';
		var template = $(temp);
		$('body').append(template);
		$('.btnOk').on('click',function(){ 
			$(template).remove();
		})
		setTimeout(function(){
			$(template).remove();
		},5000)
	}
	window.alerts = new alerts;
})(window)
;(function(window){
	var confirms = function(){};
	confirms.prototype.show = function(data,callback){
		var temp = '';
		temp += '	<div class="confirms ">';
		temp += '		<div class="bg"></div>';
		temp += '		<div class="con groupCon">';
		temp += '			<div class="tit moveTitle">';
		temp += '				<p>'+ data +'</p>';
		temp += '			</div>';
		temp += '			<div class="bt">';
		temp += '				<a href="javascript:;" class="ok btnOk">确定</a>';
		temp += '				<a href="javascript:;" class="off btnReset">取消</a>';
		temp += '			</div>';
		temp += '		</div>';
		temp += '	</div>';
		var template = $(temp);
		$('body').append(template);
		$('.btnOk').on('click',function(){
			callback(true);
			$(template).remove();
		})
		$('.btnReset').on('click',function(){
			callback(false);
			$(template).remove();
		})
		// setTimeout(function(){
		// 	$(template).remove();
		// },2000)
	}
	window.confirms = new confirms;
})(window)
	var ix,iy;
	$(function(){
		var dragFlag = false;
		$('body').on('mousedown','.moveTitle',function(e){
			dragFlag = true;
			var innerL = $(this).parents('.groupCon')[0].offsetLeft;
			var innerT = $(this).parents('.groupCon')[0].offsetTop;
			ix = e.pageX  - innerL;
			iy = e.pageY  - innerT;
			$(this).addClass('curMove');
		});
		$('body').on('mousemove','.moveTitle',function(e){
			if(dragFlag){
				var marL = Math.abs(parseInt($(this).parents('.groupCon').css('marginLeft')));
				var marT =Math.abs(parseInt($(this).parents('.groupCon').css('marginTop')));
				var innerL = $(this).parents('.groupCon')[0].offsetLeft;
				var innerT = $(this).parents('.groupCon')[0].offsetTop;
				$(this).parents('.groupCon').css({
					left:e.pageX - ix + marL,
					top:e.pageY - iy + marT
				})
			}
		});
		$('body').on('mouseup','.moveTitle',function(e){
			dragFlag = false;
			$(this).removeClass('curMove');
		})
		window.dragFlag = dragFlag;
	})