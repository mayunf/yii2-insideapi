# yii2-insideapi
EasyApi SDK for yii2 , based on [mayunfeng/insideapi](https://github.com/mayunfeng0614/insideapi).     
This extension helps you access `mayunfeng/insideapi` application in a simple & familiar way:   `Yii::$app->easyapi`.
   
## Installation
```
composer require mayunfeng/yii2-insideapi
```

## Configuration

Add the SDK as a yii2 application `component` in the `config/main.php`:

```php

'components' => [
	// ...
	'easyapi' => [
		'class' => 'mayunfeng\EasyApi'
	],
	// ...
]
```
## Usage
```php

// 登录:
$result = Yii::$app->easyapi->user_not_login->login(...$arg)
if ($result['Success']) {
    # success
} else {
    # fail
}

```


### How to load Wechat configures?
the `mayunfeng/insideapi` application always constructs with a `$options` parameter. 
I made the options as a yii2 param in the `params.php`:

recomended way:
```php
// in this way you need to create a wechat.php in the same directory of params.php
// put contents in the insideapi.php like:
// return [ 
// 		// wechat options here 
// ];
'WECHAT' => require(__DIR__.'/insideapi.php'),
```
OR 
```php
'insideapi' => [ // insideapi options here ]
```

[ mayunfeng/insideapi options configure help docs.](https://github.com/mayunfeng0614/insideapi)
