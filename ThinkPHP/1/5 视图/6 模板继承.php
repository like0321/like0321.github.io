<?php


	七、模板继承

        模板也可以定义一个基础模板(或者是布局)，并且其中定义相关的区块(block)，

        然后继承(extend)该基础模板的子模板中就可以对基础模板中定义的区块进行重载。

    
    例：
        定义一个基础模板：view/common/base.html
        	<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<title>Document</title>
				{block name="css"}样式{/block}
			 
			</head>
			<body>
				{block name="content"}内容{/block}
				{block name="js"}js{/block}
			</body>
			</html>

        

        继承基础模板：
            
                {extend name="common/base" /}

				 实现占位：想写什么内容就写什么内容
				{block name="css"}{/block}
				
				{block name="content"}你好世界{/block}
				
				{block name="js"}
				    <script></script>
				{/block}
 


        注意：
            在子模板中使用extend标签来继承基础模板

            可以对基础模板中的区块进行重载定义

            子模板中，如果没有重新定义的话，则表示沿用基础模板中的区块定义，
            
            如果定义了一个空的区块，则表示删除基础模板中的该区块内容。
