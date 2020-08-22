# Redis介绍

## 概述

- Redis是Remote Dictionary Server(远程数据服务)的缩写.

> 由意大利人antirez(Salvatore Sanfilippo)开发的一款内存高速缓存数据库,诞生于08年。
>
> 根据月度排行网站DB-Engines.com的数据显示，Redis是最流行的键值对存储数据库。

- 该软件使用C语言编写，它的数据模型为key-value，

> 开源的，构建与内存的数据结构数据库，常用作数据存储，缓存处理和消息队列处理

- 支持多种数据结构类型，

> 包括string(字符串)、hash(哈希)、list(链表)、set(集合)、Zset(有序集合)。

- 为了保证效率数据都是缓存在内存中，它也可以周期性的把更新的数据写入磁盘或者把修改操作写入追加的记录文件。 

- 极高的读写性能，原子性操作

> Redis能读的速度是110000次/s,写的速度是81000次/s 。
>
> Redis所有单个命令的执行都是原子性的，这与它的单线程机制有关；
>
> Redis命令的原子性使得我们不用考虑并发问题，可以方便的利用原子性自增操作 实现简单计数器功能;



使用缓存减轻数据库的负载。

在开发网站的时候如果有一些数据在短时间之内不会发生变化，而它们还要被频繁访问，为了提高用户的请求速度和降低网站的负载，就把这些数据放到一个读取速度更快的介质上(或者是通过较少的计算量就可以获得该数据) ，该行为就称作对该数据的缓存。

 

该介质可以是：文件、数据库、内存，内存介子经常用于数据缓存。

  

缓存的两种形式：

- 页面缓存(磁盘缓存)：经常用在CMS(content manage system)内存管理系统里边(Smarty缓存)

index.php  ====  >index.html   就直接访问index.html页面；

- 数据缓存：经常会用在页面的具体数据里边

 ## 使用场合及其优势

- 高性能缓存，最常见的应用场景

- 多类型数据结构，适合各种类型数据，

- Redis分布式存储

- 数据有生命周期，Redis的键可以设置过期时长，一段时间以后自动删除。

- 高并发和海量数据的处理

- 数据持久化，数据存储到硬盘里面，服务器断电不丢失。

redis与memcache比较

> 1、数据类型：
>
> memcache支持的数据类型就是字符串，
>
> redis支持的数据类型有字符串，哈希，链表，集合，有序集合。
>
> 2、持久化：
>
> memcache数据是存储到内存里面，一旦断电，或重启，则数据丢失。
>
> redis数据也是存储到内存里面的，但是可以持久化，周期性的把数据给保存到硬盘里面，导致重启，或断电不会丢失数据。
>
> 3、数据量：
>
> memcahce一个键存储的数据最大是1M,
>
> 而redis的一个键值，存储的最大数据量是1G的数据量。

## 安装redis

```bash
#下载
wget http://download.redis.io/releases/redis-6.0.6.tar.gz
#解压
tar zxvf redis-6.0.6.tar.gz
#进入解压目录
cd redis-6.0.6

#无需配置，直接编译
make
```

**若出现如下提示，则说明未安装gcc**

> /bin/sh: cc: command not found
> make[1]: *** [adlist.o] Error 127
> make[1]: Leaving directory `/root/redis-6.0.6/src'
> make: *** [all] Error 2

解决：yum -y install gcc

**若出现如下提示**

>
> make[1]: *** [server.o] Error 1
>
> make[1]: Leaving directory `/root/redis-6.0.1/src'
>
> make: *** [all] Error 2

出现这个问题需要先确认GCC的版本，命令如下：

```bash
gcc -v
```

发现CentOS7默认的gcc版本为4.8.5，安装Redis6.0需要将gcc版本升级到5.3以上，则升级gcc命令如下：

```bash
yum -y install centos-release-scl
yum -y install devtoolset-9-gcc devtoolset-9-gcc-c++ devtoolset-9-binutils
 
#临时修改gcc版本
scl enable devtoolset-9 bash
#永久修改gcc版本
echo "source /opt/rh/devtoolset-9/enable" >>/etc/profile
```



安装

```bash
#(安装编译后的文件)到指定目录：
make PREFIX=/usr/local/redis install

注意：
	PREFIX必须大写、同时会自动为我们创建redis目录，并将结果安装此目录
```



安装完成后，会在redis的安装目录下面创建一个bin目录，该目录里面有5个文件。

> redis-benchmark 					命令性能测试命令
>
> redis-check-aof和redis-check-rdb    日志检测工具
>
> redis-server  	是服务器端启动的命令
>
> redis-cli 		是客户端连接服务器的命令

## 配置文件详解

从redis的解压目录里面把redis.conf配置文件复制到redis的安装目录下面(与bin目录同级)。

```
cp ~/redis-6.0.6/redis.conf /usr/local/redis
```

1、redis默认不是以守护进程的方式运行，可以通过该配置项修改，使用yes启用守护进程

	daemonize no // 改为 yes，让redis的进程在后台执行，不占据当前终端。

2、当Redis以守护进程方式运行时，Redis默认会把pid写入/var/run/redis.pid文件，可以通过pidfile指定

	pidfile /var/run/redis.pid

3、指定Redis监听端口，默认端口为6379，

	port 6379

![image-20200816232331993](https://gitee.com/li_ke321/Image/raw/master/img/Redis/image-20200816232331993.png)

4、安全认证

```
requirepass 321612
```

注意：
			设置的密码是明文的，因此要对redis.conf配置文件，进行严格的授权。

5、外网php客户端连接Linux的redis

开启redis-server后，redis-cli只能访问到127.0.0.1，因为在配置文件中固定了ip，

```
bind 127.0.0.1   改为 #bind 127.0.0.1

protected-mode yes 改为 protected-mode no
```

> redis从3.2版本后增加了protected-mode参数，protected-mode参数是为了禁止外网访问redis，
> 如果启用了，则只能通过lookbackip(127.0.0.1)访问redis，如果外网访问redis，会报出异常。



## 启动

`启动redis服务`

语法：
		redis-server(写路径) redis.conf(写路径)

```bash
cd /usr/local/redis/bin
./redis-server ../redis.conf
```

![image-20200816232753691](https://gitee.com/li_ke321/Image/raw/master/img/Redis/image-20200816232753691.png)

`启动redis客户端`

语法： redis-cli  -h  主机ip  -p端口号

```
./redis-cli
```

![image-20200816233210305](https://gitee.com/li_ke321/Image/raw/master/img/Redis/image-20200816233210305.png)

PING命令，该命令用于检测redis服务是否启动

`redis关闭服务`

- 断电、非正常关闭。容易数据丢失

	ps -ef | grep redis
	kill -9 PID

* 正常关闭、数据保存

	通过客户端进行shutdown，关闭redis服务
		exit
		/usr/local/redis/bin/redis-cli shutdown    
## 安装php的redis扩展

[CentOS7为php7.2安装php-redis扩展 ](https://www.sohu.com/a/384207854_120128131)

```bash
yum -y install php-pecl-redis
```

开放6379端口

```
firewall-cmd --zone=public --add-port=6379/tcp --permanent

firewall-cmd --reload
```

selinux临时关闭（不用重启机器）：

```bash
setenforce 0          #设置SELinux 成为permissive模式
```



## php操作redis

```php
$redis = new Redis();
$redis->connect('localhost');
$redis->auth('321612');

// 字符串类型
$redis->set('age',12);
$redis->set('username','libai');

//哈希类型
$redis -> hset('user:id:1', 'name', 'songjiang');
$redis -> hmset('user:id:2', ['name'=>'xiaohei','age'=>12,'email'=>'xiaohei@souhu.com']);

//链表类型
$redis -> lpush('user_list', '王刚');
$redis -> lpush('user_list', '宋江');
$redis -> lpush('user_list', '李白');

//字符串
$username = $redis->get('username');
$age = $redis->get('age');

//哈希
$data = $redis -> hgetall('user:id:2');

//链表
$info = $redis->lrange('user_list',0,-1);
```

***

案例：  记住密码错误次数

```php
$username = $_POST['username'];
$password = $_POST['password'];

$redis = new Redis();
$redis->connect('localhost');

// 构建键
$login_key = $username.'login_num';
$num = $redis->get($login_key);

if($num>=3){
	//设定过期时间
	$redis->setTimeout($login_key,3600*24);
	exit('锁定账号');
}

// 密码
$pwd = '123456';

if ($password == $pwd) {
	echo 'login success';
} else {
	$redis->incr($login_key);
	echo '密码错误!';
}
```



# key命名规范

key 单词与单词之间以 ： 分开

一般情况下：

> 第一段放置项目名或缩写，如 project
>
> 第二段把表名转换为key前缀，如 user:
>
> 第三段放置用于区分区key的字段，对应mysql中的主键的列名，如 userid
>
> 第四段放置主键值，如18,16

例：

```
user:id:3506728370			{id:3506728370,name:春晚,fans:12210947,blogs:6164,focus:83}

#表名:主键名:主键值:属性名	
user:id:3506728370:fans      12210947

user:id:3506728370:blogs     6164

user:id:3506728370:focus     83
```



# string(字符串)

redis的string可以包含任何数据，包括序列化的对象、数组。

单个value值最大上限是1G字节，如果只用string类型，redis就可以被看做加上持久化特性(服务器重启之后，数据不丢失)的memcache。	

## 基本操作

- set  添加/修改数据

	语法：
		set 键名称 值
	
	返回值：
		设置成功返回OK，设置失败返回nil
	
	例：
		添加一个name="xiaoqian"的键值对
		set name xiaoqian
		
		注意：
			重新设置则直接覆盖。



- get 

	获取key对应的string值，如果key不存在返回nil
	
	语法：
		get key 
	
		如果key不是string类型，返回错误信息。



- del  删除数据

	语法：	
		del key



- mset

	语法：
		mset key value [key value]
	
		同时设置多个key，如果key存在会覆盖，
		该命令是原子的，所有的键会同时设置成功或失败，成功返回OK
	
	例：
		mset name xiaohei age 12 email xiaohei@163.com



- mget 

	语法：
		mget key [key...]
	
		查询所有key的值
	
	返回值：
		列出所有键的值，绝不会执行失败，
		如果键是string类型，返回其值，
		如果键不存在或者不是string类型，返回nil
	
	例：
		mget name email title
		// xiaohei
		// xiaogei@163.com
		// nil



- strlen  返回key的字符串长度


	语法：
		strlen key 
		
	返回值：
		如果key不存在返回0
		如果不是字符串类型，返回错误信息。
	
	例：
		set age 300
	
		strlen age //3

- append 追加信息到原始信息后部(如果原始信息存在就追加，否则新建)

	语法：
		append key value
	
	例： 
		append age 200
	
		get age //300200
## 数值增减

- incr

	对key的值做加加操作，每执行一次值加1，值类型要是数据类型。
	
	语法：
		incr key
	
		将key中存储的数字值增一操作，
		如果key不存在，则key的值会先被初始化为0，
		然后再执行incr操作，key的值必须是整型。
	
	例：age原先12
	
		incr age
		//13



- incrby

	执行加法的命令，可以指定相加的值
	
	语法：
		incrby key 相加的值

- decr(减1)  decrby(减指定的值)

注意：

> string在redis内部存储默认就是一个字符串，当遇到增减类操作incr，decr时会转成数值型进行计算
>
> redis所有的操作都是原子性的，采用单线程处理所有业务，命令是一个一个执行的，因此无需考虑并发带来的数据影响。

## 时效性

- setex	设置失效时间

	语法：
		setex key seconds value
	
		给一个键设置为字符串类型，并指定生存时间(单位：秒)，
		该命令是原子的，如果设置失败或指定生存时间失败，会恢复初始状态。
	
	返回值：
		如果设置成功，返回OK，如果设置失败，返回错误信息。
	
	例：
		setex height 10 198
## 其他

- setnx	(判断键是否存在)

	语法：
		setnx key value
	
		如果key不存在，将其设置为字符串类型
	
	返回值：
		如果设置成功，返回1，设置失败，返回0
	
	例：name已经存在时，body不存在
	
		setnx name xiaobai
		// 0
		
		setnx body 1234
		//1



- getset

	语法：
		getset key value
	
		原子的给一个key设置新值，并且将旧值返回，
	
	返回值：
		如果key不是字符串类型，返回一个错误
	
	应用场景：
		比如获取计数器并且重置为0。
	
	例：
		get name
		//xiaohei
		getset name xiaohuihui
		//xiaohei
		get name
		//xiaohuihui
# hash(哈希)

> hash类型可以看成是具有key和value的容器，该类型非常适合存储对象信息，类似于关联数组。
>
> 一个存储空间保存多个键值对数据

## 基本操作

- hset	设置哈希里面的field和value的值。

	语法：
		hset key field value
	
	例：
		hset user:id:1 name xiaobai
	
		hset user:id:1 age 12
		
		hset user:id:1 email xiaobai@sohu.com



- hget	获取哈希里面的field的值

	语法：
		hget key 指定的field
	
	例：
		hget user:id:1 name
		//xiaobai
	
		hget user:id:1 age
		//12



- hgetall	获取指定哈希中所有的field和value

	语法：
		hgetall key
	
	例：
		hgetall user:id:2
		//name
		//xiaohong
		//age
		//12
		//email
		//xiaohong@sohu.com



- hdel	删除数据

	语法：
		hdel field1 [field2]



- hmset	一次性设置多个field和value。

	语法：
		hmset key field1 value1 field2 value2	
	
	例：
		hmset user:id:2 name xiaohong age 12 email xiaohong@sohu.com



- hmget	一次性获取 多个field的value

	语法：
		hmget key field1 field2......
	
	例：
		hmget user:id:2 name age email
		//xiaohong
		//12
		//xiaohong@souhu.com



- hlen 	获取哈希表中字段的数量

	语法：
		hlen key 
	
	例：
		hlen user:id:2
		//3
	
	注意：
		看的是field的数量



- hexists	获取哈希表中是否存在指定的字段

	语法：
		hexists key field
	
	例：
		hexists user:id:2 age 
## 其他

- hkeys	获取哈希表中所有的字段名

	语法：
		hkeys key 



- hvals	获取哈希表中所有的字段值

	 语法：
		hvals key

- 设置指定字段的数值数据增加指定范围的值

	hincrby key field increment 
	
	hincrbyfloat key field increment

**hash实现购物车**

业务分析

* 仅分析购物车的redis存储模型：添加、浏览、更改数量、删除、清空

* 购物车与数据库间持久化同步(不讨论)

* 购物车与订单间关系(不讨论)

  ​	提交购物车：读取数据生成订单

  ​	商家临时价格调整：隶属于订单级别

* 未登录用户购物车信息存储(不讨论)

  ​	cookie存储

解决方案：

* 以客户id作为key，每位客户创建一个hash存储结构存储对应的购物车信息

* 将商品编号作为field，购买数量作为value进行存储
* 添加商品：追加全新的field与value
* 浏览：遍历hash
* 更改数量：自增/自减，设置value值
* 删除商品：删除field
* 清空：删除key

```
hmset user:id:1 g1 100 g2 200
hmset user:id:2 g2 1 g4 7 g5 100

//添加商品
hset user:id:1 g3 5

//查看购物车
hgetall user:id:1

//删除商品
hdel user:id:1 g1

//更改数量
hincrby user:id:1 g3 100
```

当前设计仅仅是将数据存储到了redis中，并没有起到加速的作用，商品信息还需要二次查询数据库

* 每条购物车中的商品记录保存成两条field
* field1专用于保存购买数量
  * 命名格式：商品id:nums
  * 保存数据：数值

* field2专用于保存购物车中显示的信息，包含文字描述，图片地址，所属商家信息等
  * 命名格式：商品id:info
  * 保存数据：json

```
hmset user:id:3 g1:nums 100 g1:info {……}
hmset user:id:4 g1:nums 100 g1:info {……}
```

当前设计有很大的冗余，商品信息重复存储了

* 可以把商品信息做成单独的hash

```
hset user:id:3 g1:nums 200 
hsetnx goods:info g1:info {……}

hset user:id:4 g1:nums 100 
hsetnx goods:info g1:info {……}
```

**hash实现抢购**

销售手机充值卡的商家对移动、联通、电信的30元、50元、100元商品推出抢购活动，每种商品抢购上限1000张

解决方案：

* 将商家id作为key
* 将参与抢购的商品id作为field
* 将参与抢购的商品数量作为对应的value
* 抢购时使用降值的方式控制产品数量

* 实际业务中还有超卖等实际问题，这里不做讨论

```
hmset business:id:1 c30 1000 c50 1000 c100 1000

hincrby business:id:1 c50 -1
```



# list(列表)

> list 类型其实就是一个字符串的双向链表，按照插入顺序排序。
>
> 可以添加一个元素到链表的头部(左边)或者尾部(右边)，一个链表最多可以包含2<sup>32</sup> -1 个元素(4294967295，每个链表超过40亿个元素)，
>
> 这使得list既可以用作栈，也可以用作队列。

应用场景：

> 粉丝列表
> 最新文章
> 消息队列等



## 添加/修改

- lpush    从链表的头部添加一个或多个元素

	语法：
		lpush key value1 [value2] 
	
		操作为原子性操作，如果key不存在，一个空列表会被创建并执行lpush操作。
	
	返回值：
		执行lpush命令后，列表的长度。
	
	例：
		lpush user_list libai
		//1
		lpush user_list lihei
		//2
		lpush user_list songjiang
		//3



- rpush 	从链表的尾部添加元素

	语法：
		rpush key value1 [value2] 
	
	例：
		rpush user_list wusong
		//5
	
		lrange user_list 0 -1
		//wuyong
		//dufu
		//lihei
		//libai
		//wusong



- linsert	将元素插入到链表中某个元素之前或之后

	语法：
		linsert key before|after 链表中的某个元素 新的元素
	
	返回值：
		执行成功，返回插入操作完成之后，列表的长度
		如果没有找到链表中的元素，返回-1
		如果链表不存在或空链表，返回0
	
	例：
		linsert user_list before lihei dufu
		//4

- lset(改值)	修改链表中指定下标的元素。

	语法：
		lset key 下标 新值
	
	例：
		lset user_list 0 wuyong
	
		lrange user_list 0 -1
		//wuyong
		//dufu
		//lihei
		//libai
## 获取

- lrange   获取链表里面的元素

	语法：
		lrange key start(索引) stop(索引)
	
	注意：
		如果开始下标是0，结束下标是-1，则返回链表中所有的元素。
		链表里面的元素是序号的(从0开始，头部开始)，类似于索引数组。
	
	例：
		lrange user_list 0 -1
		//songjiang
		//lihei
		//libai

- lindex 	返回列表中指定下标的元素

	语法：
		lindex key index
	
	例：
		lindex user_list 2
		//lihei

- llen	返回列表的长度

	语法：
		llen key
	
	例：
		llen user_list
		//5
## 获取并移除

- lpop	删除并返回链表中头部的元素

	语法：
		lpop key 
	
	例：
		lpop user_list
		//wuyong
		
		lrange user_list 0 -1
		//dufu
		//lihei
		//libai
		//wusong

- rpop	删除并返回链表尾部的元素

	语法：
		rpop key 
## 删除

- lrem	删除链表中的元素

	语法：
		lrem key count value
	
		根据参数count的值，删除链表中与value相等的元素。
		count>0，
			从表头开始向表尾搜索，删除与value相等的元素，数量为count。
		count<0,
			从表尾开始向表头搜索，删除与value相等的元素，数量为count。
		count=0，
			删除表中所有与value相等的值。
	
	返回值：
		被删除的元素的数量。
	
	例：
		从尾部删一个
		lrange user_list -1 lihei		



- ltrem	保留指定范围的元素，其他的删除

	语法：
		ltrim 链表的名称 开始下标 结束下标 
	
	例：
		lrange user_list 0 -1
		//lihei
		//dufu
		//libai
		//wusong
	
		ltrim user_list 1 2
		//ok 
		
		lrange user_list 0 -1
		//dufu
		//libai 
## 阻塞数据获取

规定时间内获取并移除数据

blpop key1 [key2] timeout

```
blpop list0 30
```

brpop key1 [key2] timeout

***

案例：一个网站中，想要获取最新登录的10个用户。

> 如果通过list链表实现以上功能，可以在list链表中只保留最新的10个数据，每进来一个新数据就删除一个旧数据。
>
> 每次就可以从链表中直接获得需要的数据。极大节省各方面资源消耗。

	例：
		lpush user_login songjiang 
		
		if (llen(user_login)>10) {
			//从尾部弹出元素
			rpop user_login
		}
	
		//查
		lrange user_login 0 -1
秒杀案例：

> 原理：
> 		使用redis链表中队列，进行pop操作，
> 		因为pop操作是原子的，即使有很多用户同时到达，也是依次执行。

```php
$redis = new Redis();
$redis->connect('127.0.0.1',6379); 
$redis->auth('321612');

//1、先将商品库存加入队列
//商品数量
$goods_num = 100;
//添加到队列
for ($i=0; $i < $goods_num; $i++) { 
	$redis -> lpush('goods_store',1); //实际存商品id
}
```

```php
$redis = new Redis();
$redis->connect('127.0.0.1',6379); 
$redis->auth('321612');

//2、开始抢购
//设置库存的失效时间
$redis->setTimeout('goods_store',30);
```

```php
$redis = new Redis();
$redis->connect('127.0.0.1',6379); 
$redis->auth('321612');

//3、客户端执行下单操作，下单前判断redis队列库存量
$id = $redis->lpop('goods_store');
if(!$id){
	echo '抢购失败！';
	return;  
}

echo '抢购成功！'; 
//跳转到下单页面，完成下单操作
```

案例：注册发邮箱

register.php

```php
$username = $_POST['username'];
$email = $_POST['email'];
//完成注册，插入到mysql数据库

//发送邮件到邮箱，让用户激活

$redis = new Redis();
$redis->connect('127.0.0.1');
$redis->auth('321612');

//把发送邮件的操作添加到一个队列里面(异步操作)
$redis->lpush('email',json_encode(['email'=>$email,'username'=>$username]));
echo  'register success';
```

send_email.php

```php
$redis = new Redis();
$redis->connect('127.0.0.1');
$redis->auth('321612');

//根据列表里面的队列执行发送邮件的操作
while(true){
    $info = $redis->lpop('email');
    
    //发送邮件
    
}
```



# set(集合)

redis 的 set 是string类型的无序集合。

set元素最大可以包含(2<sup>32</sup>-1)(整型最大值)个元素。

关于set集合类型除了基本的添加、删除操作，其他有用的操作还包含集合的取 并集(union)，交集(intersection)，差集(difference)。

sina公司的好友关注关系就大量使用了set集合类型。

注意：
		每个集合中的各个元素不能重复。

## 基本操作

- sadd    向集合中添加元素


	语法：
		sadd key member1 [member2]
	
	例：
		sadd libai_friend likui
		// 1
		sadd libai_friend xionger
		// 1
		sadd libai_friend xiongda
		// 1
		sadd libai_friend yangguo limochou
		// 2



- smembers   获取集合中的全部元素


	语法：
		smembers key
	
	例：
		smembers libai_friend
		//xiongda
		//xionger
		//limochou
		//likui
		//yangguo



- srem 	删除集合中的元素

	语法：
		srem  key member1 member2



- scard 	获取集合中元素的个数

	语法：
		scard 集合名称
	
	例：
		scard libai_friend
		// 6 
	
		scard dufu_friend
		// 5		



- sismember  判断集合中是否包含指定数据

	语法：	
		sismember key member
## 操作随机数据

- srandmember	随机获取集合中指定数量的数据

	语法：
		srandmember  key [count]
	
	例：
		sadd news n1	
		sadd news n2	
		sadd news n3	
		sadd news n4	
	
		srandmember news 2
		//n4
		//n1
		
		srandmember news 2
		//n2
		//n1



- spop	随机获取集合中的某个数据并将该数据移出集合

	语法：
		spop  key
	
	例：
		spop news 
		//n5
## 交并差集

交集：两个集合中共有的元素

差集：在第一个集合里面有的，在第二个集合里面没有的。

并集：两个集合合并在一块，去掉重复部分

![image-20200818234204534](https://gitee.com/li_ke321/Image/raw/master/img/Redis/image-20200818234204534.png)

- sinter	获取交集(在两个集合中都存在的元素)

	语法：
		sinter key1 key2
	
	例：
		sinter libai_friend dufu_friend
		//xionger
		//likui

- sunion	求并集(两个集合合并后，去掉重复的元素)

	语法：
		sunion key1 key2 
	
	例：
		sunion libai_friend dufu_friend



- sdiff	获取集合中的差集(在集合1中存在，不在集合2中存在的元素)

	语法：
		sdiff key1 key2
	
	例：
		sdiff libai_friend dufu_friend
	
		sdiff dufu_friend libai_friend
- 求两个集合的交并差集并存储到指定集合中

```

sinterstore destination  key1 key2

例：
	sinterstore u3 u1 u2


sunionstore destination  key1 key2

例：
	sunionstore u3 u1 u2


sdiffstore destination  key1 key2

例：
	sdiffstore u3 u1 u2
```

* smove source destination  key1 key2	将指定数据从原始集合中移动到目标集合中

```
例：
	把u2的w1移动到u1里
	smove u2 u1 w1
```



# zset(sorted set: 有序集合)

sorted set 是 set 的一个升级版本，在set的基础上增加了一个顺序属性(权值)，

这一属性在添加修改元素的时候可以指定，每次指定后，zset会自动重新按新的值调整顺序。

注意：
	添加进去的元素，会自动根据序号排序。

​	只要元素不一样即可，有序集合里面可以有相同序号

​	取值的时候，索引跟序号没关系
​	

![image-20200818235006602](https://gitee.com/li_ke321/Image/raw/master/img/Redis/image-20200818235006602.png)

## 基本操作

- zadd	向有序集合中添加元素。如果该元素存在，则更新其序号。

	语法：
		zadd key score1 member1 [score2 member2]
	
	例：
		zadd zst1 23 xiaolong
		zadd zst1 67 libai
		zadd zst1 88 xiaolong   //元素存在，则更新其顺序。
		zadd zst1 67 liubei     //可以有相同序号
	
	
	
- zrange 	按序号升序获取有序集合中的内容。

(把集合排序后，返回名次[start, stop]的元素，默认是升序排列，withscores 是把score也打印出来)


	语法：
		zrange key start stop [WITHSCORES] 
	
	例：
		zrange zset1 0 -1 withscores 
		//xiaolonog
		//12
		//libai
		//23
		//liubei
		//23
		//xiaolong
		//45
	
	注意：
		下标不是序号，是数据的索引


- zrevrange	按序号降序获取有序集合中的内容。

	语法：
		zrevrange key start(索引) stop(索引) [WITHSCORES] 
	
	例：
		zrevrange zset1 0 -1 withscores
		//xiaolong
		//45
		//liubei
		//23
		//libai
		//23
		//xiaolonog
		//12
	
	
* 按条件获取数据

```
	zrangebyscore key min max [withscores] [limit]
	zrevrangebyscore key max min [withscores]

	例：
		zrangebyscore scores 50 80 withscores
		//zhangsan 
		//67
		//zhouqi
		//71
```



* zrem key member [member]	删除数据

  

* 按条件删除数据

	zremrangebyrank		删除集合中 排名 在指定范围的元素（顺序从小到大排序）
	
	zremrangebyscore key min max 	
	
	语法：
		zremrangebyrank key start stop
	
	> 第一步：从小到大排序(根据序号)
	> 第二步：删除元素(根据索引范围)
	
		例：删除根据序号从小到大排序后的索引从0到0的元素，也就是删除第一个元素(下标是0的)
			zremrangebyrank zset1 0 0
	

![image-20200818235314923](https://gitee.com/li_ke321/Image/raw/master/img/Redis/image-20200818235314923.png)





* 集合交并操作

zinterstore destination mumkeys key [key ……]

zunionstore destination numkeys key [key……]



## 元素个数

- zcard key 	返回有序集合中元素的个数

```
zcard zset1 
//5
```



- zcount key min max 	指定范围内集合中元素的个数





## 索引(排名)

* zrank key member

* zrevrank key member

```
zadd movies 143 aa 97 bb 201 cc

zrank movies bb
//0

zrevrank movies bb
//2
```



## score值

* zscore key member	获取给定元素对应的score

```
zscore movies aa
//143

zscore movies cc
//201
```



* zincrby key increment member	修改给定元素对应的score	

```
zincrby movies 1 aa

zscore movies aa
//144
```



***

案例：利用 sort set 实现获取最热门的前5帖子信息

![image-20200819001150091](https://gitee.com/li_ke321/Image/raw/master/img/Redis/image-20200819001150091.png)

思路：

> 以mysql中的id作为元素，回复量作为序号，
> 判断元素数量是否大于5个，
> 大于5个则 通过 zremrangebyrank hot_message 0 0
> 查的时候查redis，不查mysql

![image-20200819001501438](https://gitee.com/li_ke321/Image/raw/master/img/Redis/image-20200819001501438.png)


	zadd hotmsg 2345 12 
	zadd hotmsg 3678 100
	zadd hotmsg 23456 89 
	zadd hotmsg 1234 13
	zadd hotmsg 1234 78


​	
	//每增加一个新元素，就删除一个权值最小的旧元素，保留权值最高的5个元素
	zadd hotmsg 5678 90


​		

***

**案例：时效性任务管理**

例如观影试用VIP、游戏VIP体验、云盘下载体验VIP、数据查看体验VIP。当VIP体验到期后，如何有效管理此类信息。即便对于正式VIP用户也存在对应的管理方式。

网站会定期开启投票、讨论，限时进行，逾期作废。如何有效管理此类过期信息。

解决方案：

* 对于基于时间线限定的任务管理，将处理时间记录为score值，利用排序功能区分处理的先后顺序
* 记录下一个要处理的时间，到期后处理对应任务，移除redis中的记录，并记录下一个要处理的时间
* 当新任务加入时，判定并更新当前下一个要处理的任务时间
* 为提升sorted_set的性能，通常将任务根据特征存储成若干个sorted_set。例如1小时内，1天内，周内，月内，季内，年度等，操作时逐级提升，将即将操作的若干个任务纳入到1小时内处理的队列中

```
zadd tx 1509802345 uid:1
zadd tx 1509802390 uid:7
zadd tx 1510384284 uid:888

zrange tx 0 -1 withscores
//uid:1
//1509802345
//uid:7
//1509802390
//uid:888
//1510384284
```



**案例：带有权重的任务/消息队列**

当任务或者消息待处理，形成了任务队列或消息队列时，对于高优先级的任务要保障对其优先处理，如何实现任务权重管理

解决方案：对于带有权重的任务，优先处理权重高的任务，采用score记录权重即可

```
zadd tasks 4 order:id:5
zadd tasks 1 order:id:425
zadd tasks 9 order:id:345


zrevrange tasks 0 0
//order:id:345

zrem tasks order:id:345
```

**多条件任务权重设定**

如果权重条件过多时，需要对排序score值进行处理，保障score值能够兼容2条件或者多条件，

例如外贸订单优先于国内订单，总裁订单优先于员工订单，经理订单优先于员工订单

* 因score长度受限，需要对数据进行阶段处理，尤其是时间设置为小时或分钟级即可(折算后)
* 先设定订单类别，后设定订单发起角色类别，整体score长度必须是统一的，不足位补0。第一排序规则首位不得是0
  * 例如外贸101，国内102，经理004，员工008
  * 员工下的外贸单score值为101008
  * 经理下的国内单score值为102004

```
zadd tt 102004 order:id:1
zadd tt 101008 order:id:2
```



# 通用指令

Redis提供了丰富的命令对数据库和各种数据类型进行操作

1、键值相关的命令
2、服务器相关的命令

## key基本操作

- DEL	该命令用于在 key 存在时删除 key。

	语法：
		del key
	
	例：
		del name



- EXISTS	判断一个 key 是否存在。

	语法：
		exists key
	
	返回值：
		1代表存在(表示存在的数量)，0代表不存在
	
	例：
	
		exists name
		//1
		exists name
		//1
		exists age
		//1



- TYPE	返回 key 所储存的值的类型。

	语法：
		type key 
	
	例：
	
		type email 
		//string 
		
		type user:id:2
		//hash 
		
		type user_list
		//list
## key时效性控制

**1、为指定key设置有效期**

- EXPIRE 	为给定 key 设置过期时间，以秒计。

	语法：
		expire key seconds
	
	例：
		expire user_list 10



- PEXPIRE key milliseconds 	设置 key 的过期时间以毫秒计。



- EXPIREAT key timestamp 

> EXPIREAT 的作用和 EXPIRE 类似，都用于为 key 设置过期时间。 
> 不同在于 EXPIREAT 命令接受的时间参数是 UNIX 时间戳(unix timestamp)。



- PEXPIREAT key milliseconds-timestamp 	设置 key 过期时间的时间戳(unix timestamp) 以毫秒计



**2、获取key的有效时间**

- TTL 	以秒为单位，返回给定 key 的剩余生存时间(TTL, time to live)。

	语法：
		ttl key 
	
	例：
		ttl user_list

- PTTL key 	以毫秒为单位返回 key 的剩余的过期时间。



**3、切换key从时效性转换为永久性**

- PERSIST key 	移除 key 的过期时间，key 将持久保持。

## key查询

1、keys  pattern	返回当前数据库里面的键

> \* 匹配任意数量的任意符号
>
> ? 配合一个任意符号
>
> [] 匹配一个指定符号


例：	

	keys *  查询所有
	
	keys it* 查询所有以it开头
	
	keys *heima 查询所有以heima结尾
	
	keys ??heima 查询所有前面两个字符任意，后面以heima结尾
	
	keys user:? 查询所有以user:开头，最后一个字符任意
	
	keys u[st]er:1 查询所有以u开头，以er:1结尾，中间包含一个字母，s或t

## 其他key通用操作

- RENAME key newkey 	修改 key 的名称



- RENAMENX key newkey 	仅当 newkey 不存在时，将 key 改名为 newkey



* sort	对所有key排序



* DUMP key 	序列化给定 key ，并返回被序列化的值。

## db操作

- select 

	选择数据库，在redis里面默认有0-15号数据库，
	默认在0号数据库操作，可以通过redis.conf配置文件进行设置
	
	语法：
		select 数据库的编号
	
	例：
	
	```
	select 1
	// ok
	
	keys *
	// empty lisr or set
	
	select 0
	// ok 
	
	keys *
	//email
	```
	
	
	
- MOVE key db 	将当前数据库的 key 移动到给定的数据库 db 当中。

	例：
		move name 1
	
	
* flushdb (慎重使用)	清空当前数据库里面所有的键

	例：
	
	```
	flushdb
	//ok
	keys *
	//empty list or set
	```
	
	
	
* flushall (慎重使用)	清空所有数据库里面的所有的键



* dbsize  	返回当前数据库里面键的个数

	例：
		dbsize
		// 8 

* RANDOMKEY 	从当前数据库中随机返回一个 key 。