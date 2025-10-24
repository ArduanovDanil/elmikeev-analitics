Configuring scheduled jobs in Laravel is easy! Configuring the scheduler to run in a Docker environment like Laravel Sail is not so obvious, especially those new to Docker or cron jobs in general.

First, you’ll need to execute the sail:publish command in order to customize the Docker configuration for Sail. This will create a docker directory in the root of your project with subdirectories for the versions of PHP configured for the project.

1. Supervisord
Diving into the PHP version you are using, take a look at supervisord.conf. This configuration file configures the services that should always be running, and supervisord is the application that ensures they are.

This is what supervisord.conf looks like out of the box

[supervisord]
nodaemon=true
user=root
logfile=/var/log/supervisor/supervisord.log
pidfile=/var/run/supervisord.pid

[program:php]
command=/usr/bin/php -d variables_order=EGPCS /var/www/html/artisan serve --host=0.0.0.0 --port=80
user=sail
environment=LARAVEL_SAIL="1"
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0
You’ll want to add another entry for cron in order to make sure the daemon is running

[program:cron]
command=/usr/sbin/cron -f -l 8
autostart=true
stdout_logfile=/var/log/cron.out.log
stderr_logfile=/var/log/cron.err.log
2. Scheduler
Create a new file in the same directory as supervisor.conf named scheduler

* * * * * root cd /var/www/html && php artisan schedule:run >> /dev/null 2>&1
This tells the cron daemon to run php artisan schedule:run every minute, to ensure that all scheduled jobs are run.

Cron files that will be placed in the /etc/cron.d directory (like this one) need to have a trailing newline.

3. Dockerfile
Open up Dockerfile and add this section to install cron after the timezone installation section of the file

RUN apt-get update \
    && apt-get install -y cron
Next, add the following block to the file before the section copying the other configuration files to the container

COPY scheduler /etc/cron.d/scheduler
RUN chmod 0644 /etc/cron.d/scheduler \
    && crontab /etc/cron.d/scheduler
At this point, you’ll need to rebuild the Docker Sail image

sail build --no-cache
Start up Sail and you should be good to go!

sail up -d
This approach can be applied to any other Docker image to run cron jobs. Good luck!