# Z-BlogPHP大数据采集，更新于：2021年09月24日

## 插件介绍
ONEXIN大数据文章自动批量采集(Onexin BigData，简称OBD)，欢迎体验来自云端的采集器，我们在云端等你哟。
支持自动识别国内的知名站点：论坛，资讯，微信，头条，视频，贴吧，问答，知乎，天涯等， **防采集站点除外** 。

## 采集套餐 
* ONEXIN采集提供七天无理由退款，购买前请确认您需要的套餐，联系我们。
* ONEXIN新手交流QQ群：189610242

## 安装说明：

### 一、安装程序
* 1、先把插件传到插件文件夹，如：/zb_users/plugin/OnexinBigData
* 2、然后，后台安装，
* 3、接下来，请按教程一步一步操作。
* 发布模块名：portal

安装ONEXIN大数据文章采集器图文教程（修订版）
https://www.clocol.com/obd.html

### 二、申请授权
* 申请授权：https://we.onexin.com/?mod=bigdata&do=license
* 申请授权填的网址为 https://你的网站地址/zb_users/plugin/OnexinBigData/api.php
* 大数据插件后台: https://你的网站地址/zb_users/plugin/OnexinBigData/main.php

* 大数据采集通用教程：
* 视频教程：https://www.bilibili.com/video/BV1XP4y1h7W8/
* 图文教程：https://we.onexin.com/?mod=bigdata&do=faq


### 三、触发代码放到主题模板尾部中，oid账号100000替换为自己的。
```
<script src="https://你的网站地址/zb_users/plugin/OnexinBigData/doing.php?oid=100000" async></script>
```
最后，当刷新你的网站或有用户访问时，程序会自动更新文章。

## OBD大数据插件常见问题

**Q：OBD大数据和其它采集器插件的区别是什么？**
* A：OBD大数据采集列表和内容页均在云服务器端预处理，更加节省服务器资源。
* 插件中用户可方便管理需要发布的文章链接，自由选择发或不发。
* 插件接口代码开源，可自定义输出结果，功能可扩展。
* 不需要zend，不受系统环境影响
* 不需要安装软件在电脑上，网站能访问即可自动更新文章。
* 不需要写内容页规则，由云采集自动识别，成千上万的资源可用。

**Q：大数据插件工作流程，第一次配置使用有哪些注意事项？**
* A：首先，安装发布接口插件，填写我们平台的注册账号OID和token。确定设置成功，你就成功了一半。
* 其次，准备开始测试，你可以复制平台上共享的资源，导入中填3到5篇，填好导入分类ID，导入论坛或门户。
* 然后，授权状态中和资源状态一并设置为启动，
* 最后，你的网站有用户访问，就可以自动更新文章了。如有异常请及时联系我们。

**Q：文章的来源信息在哪里管理？**
* A：插件设置内可自定义来源格式。我们建议使用者保留来源出处。我们提供大数据云采集技术服务，内容所产生的所有侵权与ONEXIN无关。

**Q：插件设置内“每多少PV触发一次”填多少？**
* A：PV即网页访问量(Page View)，当用户访问您网站时由js脚本触发云端服务器。设置的数字越大对双方的服务器负载越小。建议填你网站的PV数除以一千得到的数值，比如每天3万PV，建议填30或以上。
理论上，你的用户PV越多，添加的资源越丰富，网站更新频率越高。

**Q：平台上添加资源中的规则如何写呢？**
* A： 默认有两种简单易学易用的写法(副本)，需灵活运用，获取到正确的网址即可
* 第一种：文章网址a标签前面的字符串作为标识，如新浪，腾讯等门户常用“<h3”。（操作方法：用谷歌浏览器，在标题上点右键，再选审查元素，他会自动锁定标题的a标签，我们找到a标签之前的字符串部分照写即可。示例）
* 第二种：文章网址中包含的字符串作为标识，如网址中包含“/item.htm”。(示例)

**Q：平台上导入模块需要怎么填？**
* A：需要和发布接口插件soeasy文件夹下的对应起来，如论坛模块名(forum)，发布文件对应publish.forum.php

**Q：平台上不同运行状态代表的是什么？**
* A：授权查询里面：切换到“等待中”，表示整个推送停止。
* 资源里面：切换到“等待中”，表示不再获取该资源列表

**Q：插件管理中的文章网址可以修改吗？**
* A：如果删除云端推送的网址，30天内将不再推送此网址。你可以手动添加，状态可以选择未发，已发或不发。

**Q：插件管理中的为什么文章状态显示“不发”呢？**
* A：超时，未获取标题或内容的状态标记为“不发”。

**Q：内容页获取不到内容或需要修改，怎么办？**
* A：请在大数据平台，添加资源后，点击在线反馈，等待处理

## 联系我们
如果您在使用中有任何疑问，欢迎您随时与我们取得联系，ONEXIN新手交流QQ群：189610242

* ONEXIN BIGDATA COLLECTION
* ONEXIN大数据云采集

* CLOUD COLLECTION
* https://www.clocol.com
