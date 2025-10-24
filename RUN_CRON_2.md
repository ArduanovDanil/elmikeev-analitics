Sail как и любое многоконтейнерное docker приложение, должен
быть максимально изолированной средой выполнения,
настроенной под работу из коробки, без любых дополнительных
зависимостей извне(либо с их минимумом). Таково моё мнение.

1).
sail artisan config:publish
context параметр секции build в docker-compose.yml будет
изменен автоматически, и в корне опубликована директория

doker с версиями php. В моем случае это 8.4 там и будем
шаманить.
2).
Supervisor
открываем docker/8.4/supervisord.conf и добавляем:
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/artisan queue:work
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=sail
numprocs=8
redirect_stderr=true
stdout_logfile=/var/www/html/storage/logs/worker.log
stopwaitsecs=3600
[program:laravel-schedule]
command=/bin/bash -c "while [ true ]; do (php /var/www/html/artisa
autostart=true
autorestart=true
redirect_stderr=true
stdout_logfile=/var/www/html/storage/logs/schedule.log
user=sail

тут всё ясно, добавили 2 новые директивы отвечающие за
запуск очередей и cron
3).
sail
sail down --rmi all -v
sail up -d
именно так, а не —force-recreate
P.S. Мудреная штука Supervisor, и безусловно полезная. Но вне
sail laravel для реализации cron задач вполне можно
обходиться стандартным cron сервисом притянув его даже в
«голый» php контейнер, в котором выпилен systemd. Правда для
этого нужно немножко «поизвращаться» в Dockerfile,
предварительно настроить sudo для пользователя(в этом
конечно концепция безопасности нарушается), и перед php-fpm
запустить сервис «вручную». Зато можно смапить затем файлик
из /etc/cron.d/ и задавать там в привычном синтаксисе всё что
угодно.

P.P.S: Лучше юзать свою логику на bash для cli php без всяких
супернадстроек, и стандартные php-fpm & nginx для бек-фронта
— много подводных камней пролетит мимо.