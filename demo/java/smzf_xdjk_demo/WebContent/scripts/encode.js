//获取指定form中的所有的<input>对象    
function getElements(formId) {    
    var form = document.getElementById(formId);    
    var elements = new Array();    
    var tagElements = form.getElementsByTagName('input');    
    for (var j = 0; j < tagElements.length; j++){  
         elements.push(tagElements[j]);  
  
    }  
    return elements;    
}   
  
//获取单个input中的【name,value】数组  
function inputSelector(element) {    
  if (element.checked)    
     return [element.name, element.value];    
}    
      
function input(element) {    
    switch (element.type.toLowerCase()) {    
      case 'submit':    
      case 'hidden':    
      case 'password':    
      case 'text':    
        return [element.name, element.value];    
      case 'checkbox':    
      case 'radio':    
        return inputSelector(element);    
    }    
    return false;    
}    
  
//组合URL  
function serializeElement(element) {    
    var method = element.tagName.toLowerCase();    
    var parameter = input(element);    
    
    if (parameter) {    
      var key = encodeURIComponent(parameter[0]);    
      if (key.length == 0) return;    
    
      if (parameter[1].constructor != Array)    
        parameter[1] = [parameter[1]];    
          
      var values = parameter[1];    
      var results = [];    
      for (var i=0; i<values.length; i++) {
      	if(key=='sign'){
      		continue;
      	}    
        results.push(key + '=' + encodeURIComponent(values[i]));    
      }    
      return results.join('&');    
    }    
 }    
  
//调用方法     
function serializeForm(formId) {    
    var elements = getElements(formId);    
    var queryComponents = new Array();    
    
    for (var i = 0; i < elements.length; i++) {    
      var queryComponent = serializeElement(elements[i]);    
      if (queryComponent)    
        queryComponents.push(queryComponent);    
    }    
    
    return queryComponents.join('&');  
}   


var XMLHttpReq;  
function createXMLHttpRequest() {  
     if(window.XMLHttpRequest){
        XMLHttpReq=new XMLHttpRequest();
        if(XMLHttpReq.overrideMimeType){
            XMLHttpReq.overrideMimeType("text/xml")
        }
     }else if(window.ActiveXObject){
        var activexName=["MSXML2.XMLHTTP","Microsoft.XMLHTTP"];
        for(var i=0;i<activexName.length;i++){
	        try{
	           
	            XMLHttpReq=new ActiveXObject(activexName[i]);
	            break;
	        }catch(e){
	
	        }
        }   
    }
    if(!XMLHttpReq){
        alert("XHR创建失败！");
        return;
    }else{
        alert(XMLHttpReq.readyState);
    }
  
}  
function sendAjaxRequest(url) {  
    createXMLHttpRequest();                                //创建XMLHttpRequest对象  
    XMLHttpReq.open("get", url, true);  
    XMLHttpReq.onreadystatechange = processResponse; //指定响应函数  
    XMLHttpReq.send(null);  
}  
//回调函数  
function processResponse() {  
    if (XMLHttpReq.readyState == 4) {  
        if (XMLHttpReq.status == 200) {  
            var text = XMLHttpReq.responseText;  
            /** 
             *实现回调 
             */  
            text = window.decodeURI(text);  
            var cp = document.getElementsByName("sign");  
            cp[0].value = text;
            document.forms["form_query"].submit();
        }  
    }  
  
}  
  