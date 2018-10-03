# crypto
<h1> Задание  </h1>

Нужно написать приложение, которые в реальном времени показывает/обновляет стоимость/%роста крипто-валют из разных источников.

* Страничка <br>
а) Таблица с колонками: Name, Avg. Price, % Change(24h) <br>
б) Должен быть один фильтр по имени, если я ввожу имя, без перезагрузки надо отфильтровать список и показать только эту валюту и ее данные <br>
в) Так же, если курс или % растет, надо подсветить зеленым, если падает, то красным <br>
г) Сортировка по умолчанию должна быть по самому большому "% Change(24h)" <br>

* Бакенд<br>
а) В базе должен быть список валют, последние данные, исторические данные<br>
б) Список валют, которые надо парсить: Bitcoin, Ethereum, Ripple, Litecoin, NEO<br>

Kурсы и проценты надо брать отсюда(два источника. нужно сделать так, чтобы можно было легко добавить еще источник в будущем):<br>
1. https://coinmarketcap.com/<br>
2. http://coincap.io/<br>

НБ! простое бакенд приложение, которое дергает и агрегирует цены и фронт-енд, который показывает результат<br>

Использовать: Laravel 5.2+, jQuery, MySQL.<br>

Залить эти все на гитхаб так, чтобы мы смогли склонировать и запустить у себя это приложение без проблем

<h1> Installation </h1>

1. Clone repository<br>
2. Rename .env.example to .env and create MySQL database and setup DB options (.env.example has PUSHER_APP credentials, make sure your .env have the same)<br>
3. Run: Composer install <br>
4. Run: php artisan migrate:fresh --seed
5. Setup Laravel Task Scheduling, https://laravel.com/docs/5.7/scheduling#introduction<br>
   For Windows OpenServer: https://hsto.org/files/5b6/04d/a58/5b604da58f894e3cb6dfdcd47bf6a76d.png<br>

<h1> How to use </h1>

Laravel task scheduler will run command that parse and agregate information about crypto currencies one per minute.<br>

You can also run the command in any time: php artisan get-crypto-info<br>

Once new data is recived, it's get saved into database and update all connected clients in real time.<br>
