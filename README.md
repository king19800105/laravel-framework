# 项目框架

### 支持
- [x] 完全 api 路由
- [x] 统一 Response 响应处理
- [x] 统一 Request 请求参数校验
- [x] 统一异常处理，实现各类异常的不同处理
- [x] Excel 导入导出（组件和C扩展方式）
- [x] 文件上传和下载
- [x] 本地 apc 缓存实现
- [x] 自定义日志实现，本地环境写文件，真实环境写队列
- [x] 自定义队列实现，支持延时队列
- [x] Email 发送
- [x] 计划任务，以及 cli 模式脚本运行
- [x] 整数值与 hash 字符串的序列化和反序列化处理
- [x] 断路器和服务降级支持
- [x] 接口自定义限流支持
- [x] 图片和图形处理
- [x] i18n 本地化处理
- [x] sql 根据请求参数条件过滤
- [x] RBAC 权限控制
- [x] jwt 无状态 token 授权
- [x] 微信开发
- [x] http 的 curl 请求
- [x] 查询 sql 结果缓存
- [x] 模型定义和仓储数据操作分离
- [x] 用户登入状态下，敏感操作二次密码验证中间件
- [x] 软删除
- [x] 自定义 make 指令创建 responder 和 repository
- [x] 所有 command 常用指令简化版
- [x] 字符串压缩和解压操作，大幅度减少 redis 存储压力
- [x] 支持路由中间件方式实现权限管理，包括 resource 路由
- [x] 使用 phpreids 代替 predis
- [x] 支持一条指令生成业务模块（整个业务流）
- [x] 限流改支持用户id + ip限流
- [ ] 使用redis的bitmap实现布隆过滤器中间件
- [ ] 使用优化后的事件监听机制，Laravel8特有
- [ ] 编写excel导入和导出的demo，其他项目中应该已经有demo（README.md）

### app下结构说明
- 控制器 Http/Controller
- 中间件 Http/Middleware
- 统一校验 Http/Requests
- 统一响应 Http/Responders
- 模型目录 Models
- 特性目录 Traits
- 异常处理 Exceptions
- 业务组件 Components
- 命令处理 Console
- 业务服务目录 Services
- todo...
- 辅助函数库 helpers.php

### 常用命令操作
- composer dump-autoload
- php artisan vendor:publish 发布配置文件
- php artisan full --name=User --fields=name:姓名,age:年龄 [--rollback=true] [--except=table,request]
- php artisan cmd ctr Backend/UserController --opt=resource
  - demo：php artisan cmd ctr User --opt=resource 等价于 php artisan make:controller UserController --resource
- php artisan cmd srv User
- php artisan cmd md Models/User
- php artisan cmd repo User
- php artisan cmd mgt users
- php artisan cmd mg ... yes
- php artisan cmd rq DangerousGoodsCategory/Store
- php artisan cmd rp DangerousGoodsCategory/Show
- php artisan cmd ob Observes/UserObserve
- php artisan cmd mf User
- php artisan cmd cd Task/DataHandler
- php artisan cmd plc PostPolicy
- php artisan cmd vp
- php artisan cmd sd User
  - https://www.cnblogs.com/jxl1996/p/10335920.html
- 软连接使用
  - 命令：php artisan storage:link
  - storage/app/public => public/storage
  - 访问：xx.com/storage/1.png => storage/app/public/1.png

### 常用辅助操作
- Str::plural('instrument') : 单数转复数
- optional() : 对象为null的处理
- withTrashed() : 查询软删除后的数据
- lockForUpdate() : select for update 操作，一般配合事务使用
- scope 设置

```php
// 设置
public function scopeActive(Builder $query) {
    return $query->where('status', 0);
}

// 使用
$this->model
    ->select(['id'])
    ->active()
    ->paginate(static::PAGE_NUM);
```

### 项目部署
- cp .env.example .env
- php artisan key:generate
- php artisan jwt:secret
- php artisan storage:link
- php artisan opcache:clear

### 其他
- 依赖注入顺序：Model -> Repository -> Service -> Controller
- 访问 docker 内服务要使用别名：Http::get('http://micro:9602/mydata') 
- sometimes 和 nullable 校验规则的区别：前者字段里面存在就验证，为""，为 null 也校验，后者字段为空，为 null 都不校验
- 微信封装 https://www.easywechat.com/
- 常用扩展包 https://learnku.com/courses/laravel-package/2019
- 上线优化部署 https://learnku.com/courses/laravel-performance/6.x/preface/4808

### php7.4 支持

-   箭头函数

```php
// 可以限定参数和返回值类型
$a = fn(int $a, int $b): int => $a + $b;
$a(10, 20);
// 返回值可以使用三元运算符
$b = fn($tmp) => $tmp > 0 ? 10 : 20;
$b(10);
// 直接使用外部变量
$param = 100;
$c = fn() => $param;
$c();
// 函数中的闭包
$users = [['id' => 1], ['id' => 2]];
$ids = array_map(fn($user) => $user['id'], $users);
```

-   spread 运算符

```php
// 元素合并
$a = [1, 2, 3];
$b = [4, 5, 6];
$c = [...$a, ...$b];
$d = [...$c, 7, 8, 9];
// 函数使用
$f = fn(...$param) => array_sum($param);
$f(1, 2, 3);
```

-   null 赋值运算符

```php
$arr = [];
// 等价于：$arr['a'] = $arr['a'] ?? null;
$arr['a'] ??= null;
```

-   系统函数修改

```php
// 新增mb系列函数，分割操作
mb_str_split("中国", 1); // 中 国
// merge变更，支持...语法
$arr = [[1, 2, 3], [4, 5, 6]];
$merge = array_merge(...$arr); // 1 2 3 4 5 6
// 去除html标签新增可以指定保留的标签
$str = 'this is a <a>hello</a> <span>span</span>';
strip_tags($str, ['<a>']);
```
