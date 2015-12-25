<html lang="zh-CN">
	<head>
		<meta charset="UTF-8">
		<meta name="robots" content="none">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
		<link rel="Bookmark" href="/res/soup/favicon.ico" />
        <link rel="shortcut icon" href="/res/soup/favicon.ico" />
		<title>开放创想 - Setin.cn</title>
		<style>
			body{font: normal 14px/24px "Microsoft Yahei","冬青黑体简体中文 w3","宋体";color:#666;margin:30px}
		</style>
	</head>
	<body>
		<h1>开放创想 - SETIN</h1>
		<hr>
		<h2>微信公众号自动回复接口</h2>
		<p>
			地址：http://api.setin.cn/weixin.html <br>
			令牌：yixin <br>
		</p>
		<p>
			<b>使用</b><br>
			使用非常简单，只需要开启微信公众号的开发者模式，然后再URL中填写 http://api.setin.cn/weixin.html ， TOKEN中填写 yixin 即可。（注意消息加密方式使用明文方式）<br>
		</p>
		<p>
			<b>示例</b><br>
			可以关注微信号 atool-org即可看到。或者搜索公众号“在线工具”。
		</p>
		<hr>
		<h2>二维码API</h2>
		<p>
			地址：http://api.setin.cn/qrcode.png <br>
			方式：GET <br>
			参数：data（内容），level（容错率 <b>L</b> 7% <b>M</b> 15% <b>Q</b> 25% <b>H</b> 30% ，默认是 <b>L</b> ），size（1~10）
		</p>
		<p>为什么没有尺寸设置而且显示最大的？因为这个API主要是用来作网址二维码的，就算是最大的尺寸图片也是极小的（一般1kb左右，比其他网站小4~5倍），缩小尺寸也小不了太多，所以干脆显示最大尺寸，调用时缩放即可。</p><p></p> 
		<p>
			<b>例子</b><br>
			简洁：http://api.setin.cn/qrcode.png?data=http://www.setin.cn/ <br>
		</p>
		<hr>
		<h2>三姑六婆API</h2>
		<p>
			地址：http://api.setin.cn/3g6p.html <br>
			方式：GET <br>
			参数：text（关系文本），type（返回消息格式，json / jsonp / text，默认为json）
		</p>
		<p>它可以帮助用户轻松知道各个亲戚的具体称呼，只要你知道对方是谁，避免碰到亲戚串门而不知如果称呼的尴尬。</p><p></p> 
		<p>
			<b>例子</b><br>
			简洁：http://api.setin.cn/3g6p.html?text=母亲的父亲的哥哥&type=jsonp <br>
		</p>
		<hr>
		<p>感谢新浪云(SAE)提供云服务器，更多想法正在在路上...</p>
	</body>
</html>