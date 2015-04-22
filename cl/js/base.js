
var baseUrl="http://localhost/iSolution/";
function ap(x,y,isInner) {	if(isInner===true){x=baseUrl+"index.php?"+x;}activeFormActionAp=x;	$("#" + y).load(x,function(data) {console.log(activeFormActionAp,data); });	};//res_checker($("#" + x ).attr("action"))
function app(x,y,isInner) {	if(isInner===true){x=baseUrl+"index.php?"+x;}activeFormActionAp=x;	$("#" + y).append("<div></div>").load(x,function(data) {console.log(activeFormActionAp,data); });	};//res_checker($("#" + x ).attr("action"))
function af(x,y) {$("#" + x ).ajaxForm({target: '#' + y,beforeSubmit: function() { activeFormActionAf=$("#" + x ).attr("action");},success: function() {console.log(activeFormActionAf,'responseText'); }});return false;};
function getJSON(x,y) {activeFormAction=x;callBack={suck:y};$.getJSON(x,function(data){callBack.suck(data);console.log(activeFormAction,data); });};//res_checker(x);
