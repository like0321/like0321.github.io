<?php


	一．关联统计 

	1. 使用 withCount()方法，可以统计主表关联附表的个数，输出用 profile_count； 


		$list = UserModel::withCount('profile')->all([19,20,21]); 

		foreach ($list as $user) { 
			echo $user->profile_count; 
		}


	2. 关联统计的输出采用“关联方法名”_ count，这种结构输出； 

	3. 不单单支持 Count，还有如下统计方法，均可支持；

	4. withMax()、withMin()、withSum()、withAvg()等； 


	5. 除了 withCount()不需要指定字段，其它均需要指定统计字段； 

	 	$list = UserModel::withSum('profile', 'status')->all([19,20,21]);

	  	foreach ($list as $user) { 
	  		echo $user->profile_sum.'<br>'; 
	  	}


	6. 对于输出的属性，可以自定义： 

	   	$list = UserModel::withSum(['profile'=>'p_s'], 'status')->all([19,20,21]); 

	   	foreach ($list as $user) { 
	   		echo $user->p_s.'<br>'; 
	   	}