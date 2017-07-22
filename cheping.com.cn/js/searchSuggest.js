// JavaScript Document

$(function(){
		//����ʱ��������li
		$("#suggest_ul").hide(0);
});


//Ajax ��̬��ȡ�ؼ���
$(function(){
					 
	//�����ı�������仯
	$("#suggest_input").keyup(function(){
		//����ajax������
		function createLink(){
			if(window.ActiveXObject){
				var newRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}else{
				var newRequest = new XMLHttpRequest();
			}
			return newRequest;
		}
		
		//����ı���Ϊ�գ�����������
		if($("#suggest_input").val().length==0){
			$("#suggest_ul").hide(0);
			return;
		}
		//��������
		http_request = createLink();//����һ��ajax����
		if(http_request){
			var sid = $("#suggest_input").val();
			var url = "/search.php?action=GetList";
			var data = "keywords="+sid;
			//alert(data)
			http_request.open("post",url,true);
			http_request.setRequestHeader("content-type","application/x-www-form-urlencoded");
			
			//ָ��һ������������ӷ��������صĽ��
			http_request.onreadystatechange = dealresult; //�˺�����Ҫ����
			//��������
			http_request.send(data);
		}
		
		//�����ؽ��
		function dealresult(){
		if(http_request.readyState==4){
			//����200��ʾ�ɹ�
			//alert("aa");
			if(http_request.status==200){
				if(http_request.responseText=="no"){
					$("#suggest_ul").hide(0);
					return;
					
				}
				$("#suggest_ul").show(0);//alert(http_request.responseText);
				var res = eval("("+http_request.responseText+")");
				//alert(http_request.responseText);
				var contents="";
				for(var i=0;i<res.length;i++){
					var keywords = res[i].keywords;
					//alert(skey);
					contents=contents+"<li class='suggest_li"+(i+1)+"'>"+keywords+"</li>";
						
				}
				//alert(contents);
				$("#suggest_ul").html(contents);
				//$("#suggest_ul").empty();
				//$("#suggest_ul").append(contents);
			}
		}
	}
		
		
	});
	
	
	//���
$(function(){
		
	//���°�����300������ʾ������ʾ
	$("#suggest_input").keyup(function(){
		setInterval(changehover,300);
		function changehover(){
			$("#suggest_ul li").hover(function(){ $(this).css("background","#eee");},function(){ $(this).css("background","#fff");});
			
			$("#suggest_ul li").click(function(){ $("#suggest_input").val($(this).html());});
			$("#suggest_ul li").click(function(){ $("#suggest_form").submit();});
		}
	});
	
});

});