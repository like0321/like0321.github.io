<?php

		一个用户对应一个用户档案资料，是一对一关联； 

		一篇文章对应多个评论，是一对多关联； 



	一．多对多关联 

		多对多怎么理解，分解来看，一个用户对应多个角色，而一个角色对应多个用户；

		那么这种对应关系，就是多对多关系，最经典的应用就是权限控制；


		1、tp_user：用户表；tp_role：角色表；tp_access：中间表； 

			access 表包含了 user 和 role 表的关联 id，多对多模式


		2、User.php的模型中，设置多对多关联

			use think\Model;

			class User extends Model
			{
			    public function roles()
			    {
			    	//belongsToMany('关联模型','中间表',['外键','关联键']);
			    	
			        return $this->belongsToMany('Role', 'Access', 'role_id', 'user_id');
			    }
			}


			中间表   中间表模型类必须继承think\model\Pivot
			use think\model\Pivot;

			class Access extends Pivot
			{
			    //
			}


			附表   
			use think\Model;

			class Role extends Model
			{
			    //
			}


		////////////////////////////////////////控制器测试

		3、查询

			$user = User::get(19);

        	dump($user->roles);



        4、新增

        	$user = User::get(27);

      		$res = $user->roles()->save([
      		    'type'=>'测试管理员'
      		]);

      		dump($res);



      	5、只新增中间表数据

			$user = User::get(27);
			// 仅增加管理员权限（假设管理员的角色ID是1）
			$user->roles()->save(1);
			
				// 或者
			$role = Role::get(1);
			$user->roles()->save($role);
			
			// 批量增加关联数据
			$user->roles()->saveAll([1,2,3]);			



			$user = User::get(27);
			
			// 增加关联的中间表数据
			$user->roles()->attach(2);
			
			// 传入中间表的额外属性
			$user->roles()->attach(2,['remark'=>'test']);
			


		6、删除中间表数据

			$user->roles()->detach(2);
			
			$user->roles()->detach([1,2,3]);			