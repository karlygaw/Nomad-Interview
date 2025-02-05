# Nomad Contacts App

Приложение для управления контактами с возможностью авторизации, регистрации, добавления и редактирования контактов.

## Как запустить проект

Есть два способа запустить проект: через Docker-Compose или вручную.

### 1. Запуск через Docker-Compose

#### Клонируйте репозиторий:
```bash
git clone https://github.com/karlygaw/Nomad-Interview.git
```

#### Перейдите в директорию проекта:
```bash
cd Nomad-Interview
```

#### Запустите Docker-Compose:
```bash
docker-compose up --build -d
```

> Убедитесь, что Docker Desktop запущен.

#### Выполните миграции и сиды:
Подключитесь к контейнеру backend и выполните команду для заполнения базы данных:
```bash
docker exec -it backend bash
php artisan db:seed
```

#### Откройте приложение:
- **Backend (API)** будет доступен по адресу: [http://localhost:8000](http://localhost:8000)
- ![image](https://github.com/user-attachments/assets/93f89e9d-7a43-4153-ac9c-653ddd3d8407)

- **Frontend** будет доступен по адресу: [http://localhost:8080](http://localhost:8080)
![image](https://github.com/user-attachments/assets/9c0113d7-469a-494d-90b2-a9f69d2d3c1e)

При переходе на [http://localhost:8080](http://localhost:8080) вы автоматически попадёте на страницу авторизации.
#### Чтобы остановить и удалить контейнеры
```bash
docker-compose down
'''

### 2. Запуск вручную (без Docker)

#### Клонируйте репозиторий:
```bash
git clone https://github.com/karlygaw/Nomad-Interview.git
```

#### Настройте Backend:
Перейдите в директорию backend:
```bash
cd Nomad-Interview/backend
```

Установите зависимости Composer:
```bash
composer install
```

Настройте `.env` файл для подключения к вашей базе данных (например, MySQL через XAMPP).

Выполните миграции и сиды:
```bash
php artisan migrate
php artisan db:seed
```

Запустите сервер:
```bash
php artisan serve
```

#### Настройте Frontend:
Откройте новый терминал и перейдите в директорию frontend:
```bash
cd ../frontend
```

Установите зависимости:
```bash
npm install
```

Запустите сервер разработки:
```bash
npm run dev
```

#### Откройте приложение:
**Frontend** будет доступен по адресу: [http://localhost:5173](http://localhost:5173)

## Как использовать приложение

### Авторизация
Вы можете войти в систему с помощью следующих тестовых данных:

| Email | Пароль |
|-----------------------------|-------------|
| usenkarlygash@gmail.com     | 12345678    |
| john.doe@example.com        | password123 |
| jane.smith@example.com      | password456 |
| aliya.kenzhebek@example.com | password789 |

Или зарегистрируйтесь с новыми данными на странице регистрации.

### Основные функции

#### My Contacts:
- Просматривайте свои контакты.
- Удаляйте контакты или редактируйте их псевдонимы (нажмите на кнопку с иконкой карандаша ✏️).
- Если контактов нет, перейдите на страницу **Users**, чтобы добавить новых.
![image](https://github.com/user-attachments/assets/bde9b7a1-da11-409f-ae81-641874eb18d5)

#### Users:
- Просматривайте список всех пользователей.
- Добавляйте пользователей в свои контакты, нажав на кнопку ➕ **Add Contact**.
![image](https://github.com/user-attachments/assets/1341a894-8344-4611-a45c-a625cbab9dd6)


#### Logout:
- Выйдите из системы, нажав на кнопку **Logout**. Это удалит ваш токен авторизации.

### Модели
#### User
#### Contact

## Если возникли проблемы
Если приложение не запускается или вы столкнулись с ошибками, напишите мне на почту:
📧 **usenkarlygash@gmail.com**

Счастливого кодинга! 🚀

## Примеры команд

### Docker-Compose:
```bash
docker-compose up --build -d
docker exec -it backend bash
php artisan db:seed
```

### Ручной запуск:
```bash
cd backend
php artisan migrate
php artisan db:seed
php artisan serve

cd ../frontend
npm install
npm run dev
```


