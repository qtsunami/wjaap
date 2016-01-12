  RESTful API  
===============

├──Rest
│    ├── lang   lang配置
│    │   ├── zh.inc.php
│    ├── lib  核心处理层
│    │    ├── Headers.php   HTTP HEADER 处理
│    │    ├── Request.php   Request请求处理
│    │    ├── Response.php  Response响应处理
│    ├── util 
│         ├── Util.php 


For Example：
// HTTP GET
URI: http://www.example.com/event/product    获取所有活动
URI: http://www.example.com/event/product?page=3 获取第三页的活动列表
URI: http://www.example.com/event/product/31004  获取id为31004的活动

<?php

class EventController extends BaseController {

	public function product(){
		// 获取URI的参数
		$params = $this->getRequest()->getParams();
		// 实例化Rest接口
		$rest = new Rest();
		// 建议---判断请求方式是否为GET
		// $is_get = $rest->checkMethodType()->isPost();
		// $is_get = $rest->checkMethodType()->isPut();
		// $is_get = $rest->checkMethodType()->isDelete();
		$is_get = $rest->checkMethodType()->isGet();
		if (!$is_get) {
			// 处理结果
		}
		// 获取Request对象
		$request = $rest->processRequest();
		// 获取处理后的数据 ?page=2 Or 其他 
		$data = $request->get();

		// ~~code  
		// 暂时缺少Response 
		return $data;
	}

}
?>

RESTFul 与 HTTP 简单Introduce：
REST ， Representational  State Transfer的简称。

Web 服务三种实现主流方案：Rest 、SOAP和Xml-RPC。  REST 是一种架构，而非协议，相对SOAP与XML-RPC来说，可能简洁一些，自由方便一些。

Rest 是一种设计风格而非标准，而Rest通常基于使用Htpp、URI和xml及Html这些协议和标准。

Rest要点：
1） 资源由URI来指定
2） 对资源的操作包括获取、创建、修改和删除资源。与HTTP协议提供的GET、POST、PUT和DELETE方法。其他包括HEADER、OPTIONS等。
3） 资源的表现形式：XML、HTML或JSON。

注：REST架构可以降低对HTTP连接的重复请求资源消耗。
实现RESTful Api时HTTP请求方法：
HTTP 请求方法在 RESTful API 中的典型应用[1] 
——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
|资源   |  一组资源的URI，比如http://example.com/resources/          |      单个资源的URI，比如http://example.com/resources/142  	 
——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
| GET   |	列出 URI，以及该资源组中每个资源的详细信息（后者可选）。 |获取 指定的资源的详细信息，格式可以自选一个合适的网络媒体类型（比如：XML、JSON等）
——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
| PUT   |			用给定的一组资源替换当前整组资源。				 |替换/创建 指定的资源。并将其追加到相应的资源组中
——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
| POST  |在本组资源中创建/追加一个新的资源，该操作往往返回新资源的URL|把指定的资源当做一个资源组，并在其下创建/追加一个新的元素，使其隶属于当前资源 
——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————
| DELETE|      删除 整组资源										 |     删除 指定的元素。
——————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————————

其中GET方法 是安全幂等的，PUT与DELETE是幂等的。


其他方法 ：HEADER、OPTIONS、TRACE

HEADER：与GET方法大同小异，但服务器在响应中只返回首部，不会返回实体部分。  即允许客户端在未获取实际资源情况下，对资源首部进行检测。
例如：判断资源的类型；通过响应中的status code，检查某对象是否存在；
HEADER 的请求报文：  
HEADER /example/product HTTP/1.1
Host:...
Accept: *
..

响应报文：
HTTP/1.1 200 OK
Content-Type: text/html
Content-Length: 177

OPTIONS：请求服务器告知其支持的功能方法。
TRACE：主要用于诊断，验证请求是否完全穿过请求/响应链。

符合 REST 设计风格的 Web API 称为 RESTful API。它从以下三个方面资源进行定义：

直观简短的资源地址：URI，比如：http://example.com/resources/。
传输的资源：Web服务接受与返回的互联网媒体类型，比如：JSON，XML ，YAML 等。
对资源的操作：Web服务在该资源上所支持的一系列请求方法（比如：POST，GET，PUT或DELETE）。

//GET    例如  列出所有产品
 http://example.com/product       GET /product HTTP/1.1
 列出产品编号为9283的产品    http://example.com/product/9283    GET /product/9283 HTTP/1.1

 // POST 添加某活动
http://example.com/event
起始行：POST /event HTTP/1.1jj
首部: Content-Type: application/json
      Content-Length: 19
      ...
主体：{"a":"event", ...}