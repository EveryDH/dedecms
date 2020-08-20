<item>
<title><![CDATA[[field:title/]]]></title>
<link>[field:arcurl/]</link>
<category>[field:typename/]</category>
<pubdate>[field:pubdate function='strftime("%a,%d%b%Y%H:%M:%S +0800",@me)'/]</pubdate>
<description><![CDATA[[field:array runphp='yes']@me = (strpos(@me['litpic'],'defaultpic') ? "": "<a [email=href='%7B@me[%22arcurl%22]%7D']href='{@me["arcurl"]}'[/email] target='_blank'><img [email=src='%7B@me[%22litpic%22]%7D']src='{@me["litpic"]}'[/email] border='0' /><br />"); [/field:array][field:description function='html2text(@me)'/] ... ]]></description>
</item>