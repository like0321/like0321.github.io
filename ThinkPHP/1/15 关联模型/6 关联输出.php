<?php


	一、关联输出 


	1. 使用 hidden()方法，隐藏主表字段或附属表的字段； 

		$list = UserModel::with('profile')->select(); 
		
		return json($list->hidden(['profile.status']));

		 	或：

		return json($list ->hidden(['username','password','profile'=>['status','id']]));


	2. 使用 visible()方法，只显示相关的字段； 

		  $list->visible(['profile.status']) 

	
	3. 使用 append()方法，添加一个额外字段，比如另一个关联的对象属性； 

		  $list->append(['book.title'])


	