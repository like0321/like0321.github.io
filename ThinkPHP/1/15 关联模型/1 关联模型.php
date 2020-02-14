<?php
	


	一、关联模型

		tp_user表，主键为：id
		
		附属表：tp_profile，有两个字段：user_id和hobby，外键是user_id


		1、User 模型端，需要关联 Profile

			namespace app\common\model;

			use think\Model;
			
			class User extends Model
			{
			    public function profile()
			    {
			        //hasOne表示一对一关联，参数一表示附表，参数二外键，默认 _id
			        return $this->hasOne('Profile', 'user_id');
			    }
			}

			注意：
				一个模型可以定义多个不同的关联，增加不同的关联方法即可
				
				一般来说，模型都在同一个命名空间下，直接指定模型的类名即可； 8. 

				除非你设置的关联模型，不在同一个命名空间下，就需要指定完整的路径； 
				//如果不在同一个命名空间下，请用命名空间路径指定关联 
				return $this->hasOne('app\model\Profile','user_id');	


		
		2、控制器测试

			namespace app\index\controller;

			use app\common\model\User;
			use think\Controller;
			
			class Grade extends Controller
			{
			    public function index()
			    {
			        $user = User::get(19);
			
			        dump($user->profile);//调用关联方法 返回hasOne对象
			
			        return $user->profile->hobby;
			    }
			}



	****关联方式，系统提供了 8 种

		例：
			模型方法			关联类型
			
			hasOne				一对一
			
			belongsTo			一对一
			
			hasMany				一对多
			
			hasManyThrough		远程一对多
			
			belongsToMany		多对多
			
			morphMany			多态一对多
			
			morphOne			多态一对一
			
			morphTo				多态
 

	****两个模型之间因为参照模型的不同就会产生相对的但不一定相同的关联关系，并且相对的关联关系只有在需要调用的时候才需要定义

			类型			关联关系			相对的关联关系
			
			一对一			hasOne				belongsTo
			
			一对多			hasMany				belongsTo
			
			多对多			belongsToMany		belongsToMany
			
			远程一对多		hasManyThrough		不支持
			
			多态一对一		morphOne			morphTo
			
			多态一对多		morphMany			morphTo



	二、反向关联

		1、Profile模型

			namespace app\common\model;

			use think\Model;
			
			class Profile extends Model
			{
			    public function user()
			    {
			        return $this->belongsTo('User');
			    }
			}



		2、控制器测试


			$profile = Profile::get(1);

         	return $profile->user->email;			