<?php


	一．hasMany 模式  适合主表关联附表，实现一对多查询

		hasMany('关联模型',['外键','主键']); 
			
		public function profile()
    	{
    	    return $this->hasMany('Profile', 'user_id','id');
    	}

		关联模型（必须）：模型名或者模型类名 
		外键：关联模型外键，默认的外键名规则是当前模型名+_id 
		主键：当前模型主键，一般会自动获取也可以指定传入

	
	1、查询

	 	$user = User::get(19);
        dump($user->profile);


	2、使用->profile()方法模式，进行数据的筛选； 

	 	$user = User::get(19);
        dump($user->profile()->where([['id','>',10]])->select());

	
	3、使用 has()方法，查询关联附表的主表内容，		比如附表中大于等于 2 条的主表记录； 

		dump(User::has('profile','>=',2)->select());

	
	4、使用 hasWhere()方法，查询关联附表筛选后记录，	比如兴趣审核通过的主表记录； 

		dump(User::hasWhere('profile',['status'=>1])->select());


	5、使用 save()和 saveAll()进行关联新增和批量关联新增 

		$user = UserModel::get(19); 
		$res = $user ->profile()->save(['hobby'=>'测试新增']);
        dump($res);  
		
        $user = UserModel::get(19); 
		$res = $user->profile()->saveAll([
            ['hobby'=>'测试喜好', 'status'=>1],
            ['hobby'=>'测试喜好', 'status'=>1]]);
        dump($res);

	
	6、使用 together()方法，可以删除主表内容时，将附表关联的内容全部删除；

		$user = User::get(225, 'profile');
        $res = $user->together('profile')->delete();
        dump($res); // true