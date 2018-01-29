# wp-route
простой роутинг и mvc для WordPress

#### Установка
    composer require sau/wp_route

Регистрация библиотеки

    new SFP();

Регистрация новых роутов

    Route::add( 'User.profile', 'profile' );
где
- **User.profile** - (Контроллер.метод)
- **profile** - роут

Контроллеры находятся в корне темы дирректория **controllers**


...  
