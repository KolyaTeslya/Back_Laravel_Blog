Развертывание проекта на Laravel
Следуйте инструкциям ниже, чтобы развернуть проект на Laravel:

Предварительные требования
Убедитесь, что на вашем компьютере установлены следующие программы:

PHP - Скачать PHP
Composer - Скачать Composer
Шаги по развертыванию
Клонируйте репозиторий проекта:

git clone https://github.com/KolyaTeslya/Back_Laravel_Blog.git

Перейдите в директорию проекта:

cd <название проекта>

Установите зависимости проекта:

composer install

Скопируйте файл .env.example и переименуйте его в .env. Настройте соединение с базой данных и другие параметры проекта в файле .env.

cp .env.example .env

Для простой настройки бд в папке database создайте файл database.sqlite
Если работаете в PhpStorm в правом верхнем углу нажмите на иконку database и в выпавшем окне выберите
выберите + (New) - Data Source from Path и там выберите ранее созданый файл database.sqlite и нажмите test connection and Apply

Сгенерируйте ключ приложения:

php artisan key:generate

Выполните миграции базы данных:

php artisan migrate
Запустите сервер разработки:

php artisan serve
Проект будет доступен по адресу http://localhost:8000/.
