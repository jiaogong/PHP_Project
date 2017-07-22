$(function() {
    /*Ʒ����ĸ����¼�*/
    $(".ckqtk a").click(function(){
        $(".up").not($(this).prev('a')).not($('.chk')).css('display', '');
        $('.down').not($(this)).not($('.chkd')).css('display', 'none');
        if($(this).attr('class') == 'up') $(this).parent().children("a").toggle();              
        var obj = $(this).parent().next(".table");                
        if(obj.css('display') == 'none'){                        
            $(".table").css({
                display:'none'
            });
            obj.css({
                display:'block'
            });
        }
    });     

    $(".close_quick_compare").click(function(){
        $('.zk_bian').toggle();
        $(".peizhi_itabs").slideUp();
    })
    $(".bian_zhank").click(function(){
        $('.zk_bian').toggle();
        $(".peizhi_itabs").slideDown();
    })        
    $(".ckxx2 a").live('hover', function(){
        $(this).next('span').toggle();
    });    
    $('.ckxx3 a, .ckxx4 a').live('hover', function() {
        $(this).children('span').toggle();
    });
});