## 极验geetest
thinkphp5可用的极验扩展

## 安装
> composer require lilwil/geetest

##使用
###参数配置
在配置文件配置geetest配置，需要到官网申请

~~~
//举例
'geetest'               => [
       'captcha_id'=>'40c653bd06de23cece65d180d94b937f',
       'private_key'=>'0c54bad6d2419733de49db4826d83942',
    ],
~~~

###模板里的调用

~~~
<!-- 为使用方便，直接使用jquery.js库 -->
<script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
<!-- 引入封装了failback的接口--initGeetest -->
<script src="http://static.geetest.com/static/tools/gt.js"></script>

<script>
function doOk(){
	//TODO:验证成功，对表单的操作
	// $("#embed-submit").attr("disabled", false);  
	// $("#embed-submit").attr("style", 'background:#fe693e'); 
}
var handlerEmbed = function (captchaObj) {
    // 将验证码加到id为captcha的元素里
    captchaObj.appendTo("#embed-captcha");
    captchaObj.onSuccess(doOk);
    captchaObj.onReady(function () {
        //TODO:页面加载完毕之后执行的方法
        // $("#embed-submit").attr("disabled", true);  
        // $("#embed-submit").attr("style", 'background:#A79995');  
        //$("#wait")[0].className = "hide";
    });
};
$.ajax({
   // 获取id，challenge，success（是否启用failback）
   url: "{:geetest_url()}?t=" + (new Date()).getTime(), // 加随机数防止缓存
   type: "get",
   dataType: "json",
   success: function (data) {
   // 使用initGeetest接口
   // 参数1：配置参数
   // 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
   initGeetest({
        gt: data.gt,
        challenge: data.challenge,
        product: "float", // 产品形式，包括：float，embed，popup。注意只对PC版验证码有效
        offline: !data.success // 表示用户后台检测极验服务器是否宕机，一般不需要关注
      }, handlerEmbed);
   }
});
</script>
~~~
### 控制器里验证
~~~
//需要传入$_POST请求的数据
if(!geetest_check($post)){
 //验证失败
};
~~~