$(function(){
	//var nextpic = $("#focusishere").next('li');
	var nowpiclength = $("#focusishere").index();
	var lastpiclength = $(".ckdt_z").length;
	var nexturltype = $("#nexturltype").val().split("-");
	var nextpic = prepic = '#';
	var cpkey = $("#cpkey").val();
	var modelselecthidden = $("#modelselecthidden").val();
	var colorselecthidden = $("#colorselecthidden").val();
	$("#modelselect").val(modelselecthidden);
	$("#colorselect").val(colorselecthidden);
	cpkey = Math.max((cpkey-1),0);
	$('#ss_ul').animate({'margin-top':-cpkey*133+'px'},'slow');	
	var color_id = model_id = times = picindex = 0;
	var pic_length = $('#ss_ul li').length;
	var pic_height = $('#ss_ul').height();
	// 下一张
	$("#right_btn").click(function(){
		if(nowpiclength < lastpiclength-1){
			picindex = nowpiclength + 1;
			nextpic = $(".ckdt_z:eq(" + picindex + ") a").attr('href');
			window.location.href = nextpic;
		}
	});
	// 上一张
	$("#left_btn").click(function(){
		if(nowpiclength+1 > 1){
			picindex = nowpiclength - 1;
			prepic = $(".ckdt_z:eq(" + picindex + ") a").attr('href');
			window.location.href = prepic;
		}
	});

	$('.ckdt_x').click(function(){
                if((pic_length-times+1)<=5){
                    switch(nexturltype[2]){
                                case '1':
                                        nexturltype[2] = 4;
                                        break;
                                case '4':
                                        nexturltype[2] = 2;
                                        break;
                                case '2':
                                        nexturltype[2] = 3;
                                        break;
                                default:
                                        nexturltype[2] = 1;
                        }
                    if($('li.seq'+nexturltype[2]).attr('ct')>1)
                    window.location.href = "bigpic_" + nexturltype[0] + "_" + nexturltype[1] + "_" + nexturltype[2] + "_0.html#bigpicc";
                }else if(times*133<pic_height){
                        times = times+4;
                        $('#ss_ul').animate({'margin-top':-times*133+'px'},'slow');			
                }
                //alert(pic_length+'=='+times);
	})
	
	$('.ckdt_s').click(function(){
            if(times<1){
                switch(nexturltype[2]){
                            case '3':
                                    nexturltype[2] = 2;
                                    break;
                            case '4':
                                    nexturltype[2] = 1;
                                    break;
                            case '2':
                                    nexturltype[2] = 4;
                                    break;
                            default:
                                    nexturltype[2] = 1;
                    }
                    if($('li.seq'+nexturltype[2]).attr('ct')>1)
                    window.location.href = "bigpic_" + nexturltype[0] + "_" + nexturltype[1] + "_" + nexturltype[2] + "_0.html#bigpicc";
            }else{
                times =times-4;
                $('#ss_ul').animate({'margin-top':-times*133+'px'},'slow');
            }
	})

	//选车款跳转
	$("#modelselect").change(function(){
		model_id = $(this).val();
		window.location.href = 'bigpic_' + model_id + '_111111111_1_0.html#bigpicc';
	});

	//选颜色跳转
	$("#colorselect").change(function(){
		color_id = $(this).val();
		model_id = $("#modelselect").val();
		window.location.href = 'bigpic_' + model_id + '_' + color_id + '_1_0.html#bigpicc';
	});

})