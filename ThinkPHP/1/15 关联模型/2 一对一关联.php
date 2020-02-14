<?php


	一、hasOne模式		适合主表关联附表

		hasOne('关联模型',['外键','主键']);

		public function profile()
    	{
    	    //hasOne表示一对一关联，参数一表示附表，参数二外键，默认 _id
    	    return $this->hasOne('Profile','user_id','id');
    	}

		关联模型（必须）：关联的模型名或者类名
		外键：默认的外键规则是当前模型名（不含命名空间，下同）+_id ，例如user_id
		主键：当前模型主键，默认会自动获取也可以指定传入


	1、查询

		$user = UserModel::get(21);
		return $user->profile->hobby;


	2、修改

		$user = User::get(19);
        $res = $user->profile->save(['hobby'=>'酷爱小姐姐']);  //true


	3、新增

		$user = User::get(19);
        $res = $user->profile()->save(['hobby'=>'不喜欢吃青椒']);  //新增后的数组对象 


		注意：
			->profile 属性方式可以修改数据      ->profile()方法方式可以新增数据
			
			新增和修改一般是主表






	二．belongsTo 模式  	适合附表关联主表


		belongsTo('关联模型',['外键','关联主键']); 

		public function user()
   		{
   		    return $this->belongsTo('User');
   		}
		关联模型（必须）：模型名或者模型类名 
		外键：当前模型外键，默认的外键名规则是关联模型名+_id 
		关联主键：关联模型主键，一般会自动获取也可以指定传入 



	1、查询

		$profile = Profile::get(1);
        return $profile->user->email;



	2、根据关联数据查询       使用 hasOne()也能模拟 belongsTo()来进行查询；

	 	//参数一表示的是 User 模型类的 profile 方法，而非 Profile 模型类
		$user = User::hasWhere('profile', ['id'=>2])->find();  //根据附表id，找主表
        return $user->email;



		//采用闭包，这里是两张表操作，会导致 id 识别模糊，需要指明表 
		$user = User::hasWhere('profile', function ($query) {
            $query->where('profile.id', 2);
        })->find();
		return json($user);