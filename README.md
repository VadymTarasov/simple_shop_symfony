
Описание как развернуть проект в docker
-
#### Прежде чем начать, убедитесь, что в вашей системе установлен docker-compose, git.

**1**. Выполните клонирование данного репозитория.
```shell script
git clone https://github.com/VadymTarasov/simple_shop_symfony.git dir_name
```

**2**. Запустите докер контейнеры (имена контейнеров не должны повторятся)

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

**4**. Обновите базу данных в контейнере php используя команды:
* команда для входа в контейнер
```shell script
docker exec -it project_php bash
```
* команда для обновления базы
```shell script
php bin/console doctrine:schema:update --force
```

**5**. Добавьте администратора в контейнере mysql
* команда для входа в контейнер
```shell script
docker exec -it project_mysql bash
```
* команда для входа в mysql
```shell script
mysql -u root -p
```
* SQL-запрос
```shell script
INSERT INTO simple_shop_symfony.user (email, roles, password,name) \
  VALUES ( 'admin@mail.com', '[\"ROLE_ADMIN\"]', 
  '$2y$13$aL1VbJm6CiketRhGKdN.DuAhzuk8UrSNvypCPxfeAT4gHP6RRnrFC', 'admin');
```
* логин - admin@mail.com
* пароль - 123456789

**6**. Теперь вы можете создать категории и продукты в админ панели или используйте SQL-запрос:
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