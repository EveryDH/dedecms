织梦修改 URL: xxx.com/tagId1

	1. 修改宝塔中占站点
	2. 设置
	3. 配置文件
在最后 “}”前添加以下内容（重写伪静态正则表达式规则）

# Nginx 配置 

	location / {
	    rewrite ^/tag/(.*) /tags.php?/$1/;
		rewrite ^/tag/(.*)(?:(\?.*))* /tags.php?\/$1;
		rewrite ^/tag/(.*)\/(?:(\?.*))*  /tags.php?\/$1\/;
		rewrite ^/([0-9]+)$ /tags.php?\/$1\/$2;
		rewrite ^/([0-9])\/(?:(\?.*))*  /tags.php?\/$1\/$2\/;
	}

 # Apache 配置

<IfModule mod_rewrite.c>
 RewriteEngine on
 RewriteRule ^/tag/(.*) /tags.php?/$1/;
 RewriteRule ^/tag/(.*)(?:(\?.*))* /tags.php?\/$1;
 RewriteRule ^/tag/(.*)\/(?:(\?.*))*  /tags.php?\/$1\/;
 RewriteRule ^/([0-9]+)$ /tags.php?\/$1\/$2;
 RewriteRule ^/([0-9])\/(?:(\?.*))*  /tags.php?\/$1\/$2\/;
</IfModule>

# 两个主要修改文件：
/tags.php
/include/taglib/tag.lib.php

