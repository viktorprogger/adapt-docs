# Документация Adapt

Простейшая документация, написанная в файлах с [markdown-разметкой](https://github.com/sandino/Markdown-Cheatsheet). Сама документация содержится в папке `src/docs`.

## Как начать работать с проектом

1. `git clone`
1. Скопировать файл `env.example` в `.env`. Заменить все неподходящие значения на нужные сейчас. При необходимости можно дописать туда строки:
    1. `BUILD_TAG = latest` - какой тэг использовать для основного докер-образа. Последний стабильный - это `latest` или `master`, так же тэг с названием git-ветки (нижний регистр, `-` вместо пробелов) указывает на билд с последним коммитом ветки.
    1. `WEB_PORT = 80` - можно указать кастомный порт для веб-сервера, если 80 у вас уже занят
1. Выполнить команду `make pull up` (для windows - `docker-compose pull` и `docker-compose up -d --remove-orphans`)
1. При необходимости активировать gii:
    1. Создать файл `src/common/config/main-local.php`
    1. Вставить туда следующее содержимое: 
        ```php
        $config = [];
    
        if (YII_ENV_DEV) {
            $config['bootstrap'][] = 'gii';
            $config['modules']['gii'] = [
                'class' => 'yii\gii\Module',
                'allowedIPs' => ['*']
            ];
        }
        
        return $config;
        ```
    
    

## Команды из Makefile

1. Поднять сервера:
    - nix: команда `make up`
    - win: команда `docker-compose up -d --remove-orphans`
1. Остановить все контейнеры (сервера):
    - nix: `make down`
    - win: `docker-compose down`
1. Выполнить команду в контейнере с php:
    - nix: `make exec c='команда'` (напр., `make exec c='ls -la'`) 
    - win: `docker-compose exec app команда` (напр., `docker-compose exec app ls -la`)
1. Выполнить команду для файла `yii`:
    - nix: `make yii c='команда'` (напр., `make yii c=migrate`)
    - win: `docker-compose exec app php yii команда` (напр., `docker-compose exec app php yii migrate`)
1. Посмотреть, какие еще команды и комплексы команд есть в `Makefile`:
    - команда `make` (отобразится хелп)
    - открыть файл `Makefile` (и почитать его)
