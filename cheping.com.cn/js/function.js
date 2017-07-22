function searchSubmit(){
  var val=document.getElementById('searchKeyword').value;
  val = $.trim(val);
  if (val =='请输入您要搜索的内容' || val =='请输入搜索内容' || val==""){
    if(oInput){
      oInput.seletedIndex = -1
    }
    return false;
  }
  if(typeof(oInput) == "undefined" || oInput == null || oInput.seletedIndex == -1){
    return true;
  }
  if(oInput && oInput.seletedIndex>=0){ // 回车 进入选中页
    var url = oInput.options[oInput.seletedIndex].firstChild.getAttribute("href");
    $("#keyword_search_form").attr("action", url).attr("target", "_blank").attr("method", "post");
    setTimeout(function(){
      $("#keyword_search_form").attr("action", "http://search.d.cn/list.html").attr("target", "").attr("method", "get");
    }, 100);
    return true;
  }
  return false;
}

function getCookie(name){//取cookies函数
  var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
  if(arr != null) return decodeURI(unescape(arr[2], 'utf-8')); return null;
}

function setCookie(name, value, expiredays){
  var exdate=new Date();
  exdate.setDate(exdate.getDate()+expiredays)
  document.cookie=name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
}

function clearSelectedOptBgColor(target){
    if (target.seletedIndex >= 0){
    removeClass(target.options[target.seletedIndex], "searchTitleHoverLi");
    }
  }
  function setSelectedOptBgColor(target){
    addClass(target.options[target.seletedIndex], "searchTitleHoverLi") ;
  }

  function genNewPage(target){
    if(hasClass(target.options[target.seletedIndex], "searchTitleHoverLi")){
    var url = target.options[target.seletedIndex].firstChild.getAttribute("href");
    window.open(url);
    }
  }

  function hasClass(obj, cls) {
    return obj.className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'));
  }

  function addClass(obj, cls) {
    if (!this.hasClass(obj, cls)) obj.className += " " + cls;
  }

  function removeClass(obj, cls) {
    if (hasClass(obj, cls)) {
    var reg = new RegExp('(\\s|^)' + cls + '(\\s|$)');
    obj.className = obj.className.replace(reg, ' ');
    }
  }

function clearHover(){
    var el=$("#searchKeyword");
    var val=el.val();
    if(val=='' || val=='请输入搜索内容'){
    el.val('请输入搜索内容');
    };
    el.css("color", '#C0C0C0');
}

var shortResultTimeOut ="";

function genshortresult(){
  var el=$("#searchKeyword");
  var val=el.val();
  if(val=='请输入搜索内容'){
   el.val('');
  };
  el.css("color", 'black');
  if(shortResultTimeOut == ""){
    shortResultTimeOut = "aaa";
    setTimeout('shortResultTime()', 100);
  }
}

function shortResultTime(){
  shortResultTimeOut = "";
  var el=$("#searchKeyword");
  var keyWord = el.val();
  if($.trim(keyWord).length > 0){
    var url="search.php?action=GetList";
    $.ajax({
    url:url,
    data:{'title': keyWord},
    dataType:"jsonp",  
    success:function(data) {
      alert(data);
    var html="";
    if(data.RESOURCE && data.RESOURCE.foundCnt>0){
    html = '<div class="searchResultCon"><ul class="resourcesCon">';
    $.each(data.RESOURCE.resultList, function(ind, obj){
        html +='<li><a href="'+obj.url+'" target="_blank" title="'+obj.name+'">'+obj.nameWithHighLight+'&nbsp;';
        $.each(obj.osCategoryIds, function(i, osId){
        if(osId=='2'){
        html +='';
        }else if(osId=='3'){
        html +='';
        } if(osId=='4'){
        html +='';
        }
        });
        html +='</a></li>';
    });
    html +='</ul><div class="clear"></div></div>';
    }
    if(data.MEMBER && data.MEMBER.foundCnt>0){
    /*html +='<div class="searchResultCon"><ul class="resourcesCon userCon">';
    $.each(data.MEMBER.resultList, function(ind, obj){
        html+='<li><a href="'+obj.url+'" target="_blank" title="'+obj.showName+'"><span></span><span>'+obj.showNameWithHighLight+'('+obj.memberIdWithHighLight+')</span></a></li>';
    });*/
    html+='</ul><div class="clear"></div></div>';
    }
    /*if(data.FORUM_AND_NEWS && data.FORUM_AND_NEWS.foundCnt>0){
    html +='<div class="searchResultCon searchResultarticleCon"><ul class="articleCon">';
    $.each(data.FORUM_AND_NEWS.resultList, function(ind, obj){
        html+='<li><a href="'+obj.url+'" target="_blank" title="'+obj.title+'">'+obj.titleWithHighLight+'</a></li>';
    });
    html+='</ul><div class="clear"></div></div>';
    }*/
    var srEl=$("#searchResult");
    $(".searchResultBg", srEl).html(html);
    initSelect();
    if(html!=""){
    srEl.show();
    }else{
    srEl.hide();
    }
    }
    });
  }else{
    $("#searchResult").fadeOut();
    if(typeof(oInput) == "undefined" || oInput == null){
    oInput.seletedIndex = -1
    }
  }
}
var oInput = null;
function initSelect(){
    var upKeyCode = 38;
    var downKeyCode = 40;
    var enterKeyCode = 13;
    oInput = document.getElementById("searchKeyword");
    oInput.options = $("#searchResult li")
    oInput.seletedIndex = -1;

    oInput.focus();
    oInput.onkeyup = function(event){
    if (event == undefined){
    event = window.event;
    }
    switch (event.keyCode){
      case upKeyCode:
        clearSelectedOptBgColor(this);
        this.seletedIndex--;
        if (this.seletedIndex < 0)
        this.seletedIndex = this.options.length - 1;
        setSelectedOptBgColor(this);
        break;

      case downKeyCode:
        clearSelectedOptBgColor(this);
        this.seletedIndex++;
        if (this.seletedIndex >= this.options.length)
        this.seletedIndex = -1;
        setSelectedOptBgColor(this);
        break;

      case enterKeyCode:
        //if(this.seletedIndex!=-1){
        //genNewPage(this); 
        //}
        break;
      default:
        genshortresult();
        clearSelectedOptBgColor(this);
        this.seletedIndex = -1;
        break;
    }
    };
    oInput.onblur = function(){
      clearSelectedOptBgColor(this);
      this.seletedIndex = -1;
      clearHover();
    };
}
function hideshortresult(){
    $("#searchResult").fadeOut()
}

function stopEvent(event){
   event.stopPropagation();
}