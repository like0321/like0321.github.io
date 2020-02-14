<?php


	一、csrf验证   表单令牌

        在验证规则中，添加token验证规则即可


        例如，如果使用的是验证器的话：

            protected $rule = [
                'name'  =>  'require|max:25|token',
                'email' =>  'email',
            ];


        在模板中：
            {:token()}



            ajax：验证



            {:token()}

            let token = $("[name='__token__']").val();

            $.ajax({
				url:"{:url('onlineMessage')}",
				type:"post",
				dataType:"json",
				data:{
					name,
					phone,
					company,
					msg,
					"__token__":token,
				},
				success:function(res){
					alert(res['msg']);

					if(res['status']==1){
						$("#name").val('');
						$("#phone").val('');
						$("#company").val('');
						$("#msg").val('');
					}
				},
				error:function(err){
					console.log(err);
				},

			});
	 