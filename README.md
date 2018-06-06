# wp-route
простой роутинг и mvc для WordPress

#### Установка
    composer require sau/wp_route

####Регистрация библиотеки роутов
Используется экшн `sau_simple_route`. Callback-функция принимает в качестве параметра объект `RouteCollector` из 
[библиотеки](https://packagist.org/packages/nikic/fast-route)
```php
    add_action( 'sau_simple_route', function ( RouteCollector $r ) {
        $r->addRoute( [ 'POST', 'GET' ], '/auth', 'User.logIn' );
        // Регистрация ваших роутов...
    } );
```
Где:
 - `[ 'POST', 'GET' ]` - методы при которых есть доступ к роуту в иных случаях 405 ошибка;
 - `/auth` - Сам роут по которому откроется страница;
 - `User.logIn` - имя класса и метод.
  
Класс в котором находится метод ожет быть описан двумя способами:
 - Название класса который лежит в дирректории темы, в каталоге `controllers`; 
 - namespace указывающий на класс.
 
Метод всегда должен возвращать объект класса `Sau\WP\Theme\SimpleRouter\BaseResponse`
  
На данный момент существует 2 возможных ответа 