֯���޸� URL: xxx.com/tagId1

	1. �޸ı�����ռվ��
	2. ����
	3. �����ļ�
����� ��}��ǰ����������ݣ���дα��̬������ʽ����

# Nginx ���� 

	location / {
	    rewrite ^/tag/(.*) /tags.php?/$1/;
		rewrite ^/tag/(.*)(?:(\?.*))* /tags.php?\/$1;
		rewrite ^/tag/(.*)\/(?:(\?.*))*  /tags.php?\/$1\/;
		rewrite ^/([0-9]+)$ /tags.php?\/$1\/$2;
		rewrite ^/([0-9])\/(?:(\?.*))*  /tags.php?\/$1\/$2\/;
	}

 # Apache ����

<IfModule mod_rewrite.c>
 RewriteEngine on
 RewriteRule ^/tag/(.*) /tags.php?/$1/;
 RewriteRule ^/tag/(.*)(?:(\?.*))* /tags.php?\/$1;
 RewriteRule ^/tag/(.*)\/(?:(\?.*))*  /tags.php?\/$1\/;
 RewriteRule ^/([0-9]+)$ /tags.php?\/$1\/$2;
 RewriteRule ^/([0-9])\/(?:(\?.*))*  /tags.php?\/$1\/$2\/;
</IfModule>

# ������Ҫ�޸��ļ���
/tags.php
/include/taglib/tag.lib.php

