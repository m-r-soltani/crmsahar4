$(document).ready(function(){
let file_usage_type=$("#file_usage_type");
file_usage_type.append("<option value='1'>فایل عمومی</option>");
file_usage_type.append("<option value='2'>فایل خصوصی</option>");
file_usage_type.prop("selectedIndex","-1");

});
