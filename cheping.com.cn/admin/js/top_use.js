function confirm_close()
{
	if(confirm("关闭该窗口？"))
	{
		self.close();
	}
}
function check_email(address) 
{
  if ((address.indexOf ('@') == -1) || (address.indexOf ('.') == -1))
  {
      return false;
  }
  return true;
}
function check_figure(strArg)//验证数字0-9，不可以输入小数和负数
{

  for (var i=0; i < strArg.length; i++)
  {
        var ch=strArg.charAt(i);
        if (ch <'0' || ch>'9')
      {
          return ""
      }
  }
  return strArg;
}
function plusInteger(strArg)//验证数字，不可以输入小数和负数
{
  for (var i=0; i < strArg.length; i++)
  {
        var ch=strArg.charAt(i);
        if (ch <'0' || ch>'9')
      {
          return ""
      }
  }
   return strArg
}
function negativeInteger(strArg)//验证数字，不可以输入小数
{
  if(event.keyCode==9)
  {
    return strArg
  }
  for (var i=0; i < strArg.length; i++)
  {
        var ch=strArg.charAt(i);
        if ((ch <'0' || ch>'9')&&ch!='-')
      {
          return ""
      }
  }
  //this.select()
  return strArg
}
function negativeDecimal(strArg,len)//验证数字，并且可以输入小数和负数
{
  //alert(event.keyCode)

  if(event.keyCode==9)
  {
    return strArg
  }
  var count=0
  var pointLocat=strArg.indexOf(".")//判断小数点后的位数长度
  if(pointLocat!=-1)
  {
    if(len!=0)
    {
      if((strArg.length-1-strArg.indexOf("."))>len)
      {
        //if((strArg.length-strArg.indexOf("."))>len
        //return strArg.substring(0,strArg.length-1)
        return strArg.substring(0,strArg.indexOf(".")+len+1)
      }
    }
  }

  for (var i=0; i < strArg.length; i++)
  {
        var ch=strArg.charAt(i);
       if(i==0)
      {
        if ((ch <'0' || ch>'9')&&ch!='-')
        {
            return ""
        }
      }
      else
      {
        if(ch=='.')
          count++
        if(count>1)
          return ""
        if ((ch <'0' || ch>'9')&&(ch!='.'&&ch!='-'))
        {
            return ""
        }
      }
  }
  return strArg
}
function plusDecimal(strArg,len)//验证数字，并且可以输入小数
{
  var count=0
  var pointLocat=strArg.indexOf(".")//判断小数点后的位数长度
  if(pointLocat!=-1)
  {
    if(len!=0)
    {
      if((strArg.length-1-strArg.indexOf("."))>len)
      {
        //return strArg.substring(0,strArg.length-1)
        return strArg.substring(0,strArg.indexOf(".")+len+1)
      }
    }
  }
  for (var i=0; i < strArg.length; i++)
  {
        var ch=strArg.charAt(i);
        if(i==0)
      {
        if (ch <'0' || ch>'9')
        {
            return ""
        }
      }
      else
      {
        if(ch=='.')
          count++
        if(count>1)
          return ""
        if ((ch <'0' || ch>'9')&&ch!='.')
        {
            return ""
        }
      }
  }
 return strArg
}
function format_floatStr(strArg,len)//取小数位
{
  var pointLocat=strArg.indexOf(".")//判断小数点后的位数长度
  if(pointLocat!=-1)
  {
    if(len!=0)
    {
      if((strArg.length-1-strArg.indexOf("."))>len)
      {
        return strArg.substring(0,strArg.indexOf(".")+len+1)
      }
      else
      {
      	for(var i=0;i<(len-(strArg.length-1-strArg.indexOf(".")));i++)
      	{
      		strArg=strArg+"0";
      	}
      	return strArg;
      }
    }
    else {return strArg.substring(0,strArg.indexOf("."));}
  }
  else
  {
  	if(len == 0) return strArg;
  	else
  	{
	  	strArg=strArg+".";
	  	for(var i=0;i<len;i++)
	      	{
	      		strArg=strArg+"0";
	      	}
	      	return strArg;
      	}
  }
}
function auth4cartypedel(end_id)
{
	var mytime=new Date();
	var res=window.showModalDialog("/Bigeco/pages/com/runmit/pub/include/auth4cartype.jsp?option=CT&end_id="+end_id+"&to_auth=A&mytime="+mytime,"","dialogHeight:150px;dialogWidth:400px;status:no;scroll:no;resizable:yes");
	var undefined;
	if(res!=undefined)
	{
    	  if(res)  {return true;}
	  else	  
	  {
	  	alert("没有该车型的删除权限！"); 
	  	return false;
	  }
	}
}