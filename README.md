
Описание как развернуть проект в docker
-
#### Прежде чем начать, убедитесь, что в вашей системе установлен docker-compose, git.

**1**. Выполните клонирование данного репозитория.
```shell script
git clone https://github.com/VadymTarasov/simple_shop_symfony.git dir_name
```

**2**. Запустите докер контейнеры 

```shell script
docker compose build && docker compose up -d
```

**3**. В терминале откройте папку с проектом и  введите следующие команды:

```shell script
composer update
```
```shell script
npm install
```
```shell script
npm run dev
```
**4**. Импорт базы данных MySQL в Docker (после импорта бд проект готов к работе, также будет зарегистрирован пользователь с правами администратора).
* логин - admin@mail.com
* пароль - 123456789

```shell script
docker exec -i symfony_mysql mysql -uroot --password=123654789 simple_shop_symfony < /var/www/simple_shop_symfony/damp_db.sql
```

**5**. Вы также можете создать базу данных, используя приведенные ниже команды:
* команда для входа в контейнер
```shell script
docker exec -it symfony_php bash
```
* команда для обновления базы
```shell script
php bin/console doctrine:schema:update --force
```

**6**. Добавить администратора
* команда для входа в контейнер
```shell script
docker exec -it symfony_mysql bash
```
* команда для входа в mysql
```shell script
mysql -u root --password=123654789
```
* SQL-запрос
```shell script
INSERT INTO simple_shop_symfony.user (email, roles, password,name) \
  VALUES ( 'admin@mail.com', '[\"ROLE_ADMIN\"]', 
  '$2y$13$aL1VbJm6CiketRhGKdN.DuAhzuk8UrSNvypCPxfeAT4gHP6RRnrFC', 'admin');
```
* логин - admin@mail.com
* пароль - 123456789

**7**. Теперь вы можете создать категории и продукты в админ панели или используйте SQL-запрос:
```shell script
INSERT INTO simple_shop_symfony.category (title) \
  VALUES ( 'fruit');
INSERT INTO simple_shop_symfony.category (title) \
  VALUES ( 'vegetables');
INSERT INTO simple_shop_symfony.shop_item (category_id, price, title, description, image) \
  VALUES ( '1', '20','apple','green', 'AC.svg');
INSERT INTO simple_shop_symfony.shop_item (category_id, price, title, description, image) \
  VALUES ( '2', '15','corn','yellow', 'AD.svg');
```
