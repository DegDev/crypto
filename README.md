# crypto
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
