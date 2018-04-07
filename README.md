# Тестовое задание для zp.ru

Установка:
```
git clone https://github.com/pendalff/test.zp.git
cd test.zp
composer install
```

Настройка:
- Редактируем параметры соединения с бд в файле `config/db.php`
- Накатываем миграцию 
```
./yii migrate
```

Использование:
```
./yii top
```