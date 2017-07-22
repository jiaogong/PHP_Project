======================================================
程序运行环境要求：
======================================================
1、PHP 5.2.4或更新版本
2、MySQL 5.0或更新版本
3、Apache mod_rewrite模块(如果使用伪静态)


======================================================
网站目录框架说明：
======================================================
\action
 所有action/controllor程序存放目录，程序的文件名要求与class名称一样，
 如ArticleAction.php中代码为:class articleaction extends action {}
 所有action都要继承action父类。
 可参考模板admin/action/actionTemplate.php.txt

\admin
 后台程序目录

\attach
 用来存储上传的静态资源文件目录

\css
 网站页面样式存放目录

\data
 临时文件存放目录，如页面临时缓存文件等

\html
 文章静态页面存放目录，其中包含各程序的调用文件，
 前台所有*.php程序，都存放在此目录，访问时直接访问程序即可，不需要html目录
 如，html/article.php,在访问时直接使用http://www.ibuycar.com/article.php即可
 不要有html目录信息

\images
 图片资源文件存放目录

\include
 网站配置文件存放目录，最主要的文件包括config.php，修改相关参数，改此文件即可。

\js
 网站javascript脚本文件存放目录

\lib
 程序基类，功能类存入目录，里面的类文件，禁止修改。
 其中常用的功能类，包括util.class.php,string.class.php等
 
\model
 网站数据表model程序存放目录，关于model中常用到的操作数据库的方法，参考本目录中的其它程序，
 或参考/lib/model.class.php中的方法定义。
 可参考模板admin/model/modelTemplate.php.txt

\ssi
 网站静态页面包含用到的子页面，即ssi方式include到页面里。

\template
 所有模板页面文件存放在该目录下的default目录下，模板写法近似于smarty及discuz系列模板

\tools
 临时功能程序存放地址，暂时无用

\vendor
 第三方插件程序及相关文件存放目录

======================================================
Ajax返回数据说明：
======================================================
1、status/state: 当为负值值表示相应的操作错误或异常
2、message: 当前操作的提示文本
