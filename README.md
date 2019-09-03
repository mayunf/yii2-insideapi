# yii2-insideapi
基于 [mayunfeng/insideapi](https://github.com/mayunfeng0614/insideapi)
 
## 安装
```
composer require mayunfeng/yii2-insideapi
```

## 配置

在 `config/main.php` 中添加配置`component`  :

```php
'components' => [
	// ...
	'insideapi' => [
		'class' => 'mayunfeng\EasyApi\EasyApi'
		'config' => []
	],
	// ...
]
```

## 使用

### 1.登录
```php
$model = new UserLogon([
    'phone' => 'phone',
    'password' => 'password',
    'type' => 200,
]);

if ($model->logon()) {
    echo '登录成功';
} else {
    echo '登录失败';
}


```
### 2.调用api

```php
$easyApi = Yii::$pp->easyApi;

$easyApi->user->info()

```
### 3.其他

参考： 
[mayunfeng/insideapi](https://github.com/mayunfeng0614/insideapi)
