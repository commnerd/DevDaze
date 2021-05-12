FROM ubuntu:latest

SHELL ["/bin/bash", "-c"]

ENV USER ${USER}
ENV PHP_VERSION 8.0

ADD ./ /var/www/html/
WORKDIR /var/www/html

RUN apt-get update -y && \
    apt-get install -y software-properties-common && \
    add-apt-repository ppa:ondrej/php && \
    apt-get update -y && \
    apt-get install -y \
    bind9 \
    nginx \
    supervisor \
    php${PHP_VERSION} \
    php${PHP_VERSION}-fpm \
    php${PHP_VERSION}-mcrypt \
    php${PHP_VERSION}-sqlite \
    php${PHP_VERSION}-tokenizer && \
    apt-get clean autoclean && \
    apt-get autoremove --yes && \
    rm -rf /var/lib/{apt,dpkg,cache,log}/

RUN echo "" > database/database.sqlite
RUN php artisan migrate


RUN mkdir -p /var/named && \
    echo $'[unix_http_server]\n\
file=/var/run/supervisor.sock\n\
chmod=0700\n\
\n\
[supervisord]\n\
user=root\n\
logfile=/var/log/supervisor/supervisord.log\n\
pidfile=/var/run/supervisord.pid\n\
childlogdir=/var/log/supervisor\n\
\n\
[rpcinterface:supervisor]\n\
supervisor.rpcinterface_factory = supervisor.rpcinterface:make_main_rpcinterface\n\
\n\
[supervisorctl]\n\
serverurl=unix:///var/run/supervisor.sock\n\
\n\
[include]\n\
files = /etc/supervisor/conf.d/*.conf' > /etc/supervisor/supervisord.conf && \
    echo $'[program:named]\n\
command=/usr/sbin/named -f\n\
process_name=%(program_name)s\n\
numprocs=1\n\
directory=/var/named\n\
priority=100\n\
autostart=true\n\
autorestart=true\n\
startsecs=5\n\
startretries=3\n\
exitcodes=0,2\n\
stopsignal=TERM\n\
stopwaitsecs=10\n\
redirect_stderr=false\n\
stdout_logfile=/var/log/named_supervisord.log\n\
stdout_logfile_maxbytes=1MB\n\
stdout_logfile_backups=10\n\
stdout_capture_maxbytes=1MB' > /etc/supervisor/conf.d/named.conf

RUN mkdir -p /run/php && \
    mkdir -p /var/log/php-fpm && \
    touch /var/log/php-fpm/stdout.log && \
    touch /var/log/php-fpm/stderr.log && \
    echo $'[program:php-fpm]\n\
command=/usr/sbin/php-fpm'${PHP_VERSION}$' -F\n\
autostart=true\n\
autorestart=true\n\
stdout_logfile=/var/log/php-fpm/stdout.log\n\
stdout_logfile_maxbytes=0\n\
stderr_logfile=/dev/stderr\n\
stderr_logfile_maxbytes=0\n\
exitcodes=0' > /etc/supervisor/conf.d/php-fpm.conf

RUN echo $'[program:nginx]\n\
command=/usr/sbin/nginx -g "daemon off;"\n\
priority=900\n\
stdout_logfile=/dev/stdout\n\
stdout_logfile_maxbytes=0\n\
stderr_logfile=/dev/stderr\n\
stderr_logfile_maxbytes=0\n\
username=www-data\n\
autorestart=true\n\
autostart=true' > /etc/supervisor/conf.d/nginx.conf

RUN echo $'server {\n\
        listen 80;\n\
        listen [::]:80;\n\
\n\
        root /var/www/html/public;\n\
\n\
        index index.php index.html index.htm index.nginx-debian.html;\n\
\n\
        server_name localhost example.com www.example.com;\n\
\n\
        location / {\n\
                try_files $uri $uri/ /index.php?$query_string;\n\
        }\n\
\n\
        location ~ \.php$ {\n\
                include snippets/fastcgi-php.conf;\n\
                fastcgi_pass unix:/run/php/php'${PHP_VERSION}$'-fpm.sock;\n\
        }\n\
\n\
        location ~ /\.ht {\n\
                deny all;\n\
        }\n\
\n\
        location ~ /.well-known {\n\
                allow all;\n\
        }\n\
}' > /etc/nginx/sites-available/default

RUN echo $'[program:nginx]\n\
command=/usr/sbin/nginx -g "daemon off;"\n\
priority=800\n\
stdout_logfile=/dev/stdout\n\
stdout_logfile_maxbytes=0\n\
stderr_logfile=/dev/stderr\n\
stderr_logfile_maxbytes=0\n\
username=root\n\
autorestart=true\n\
autostart=true' > /etc/supervisor/conf.d/nginx.conf

RUN mkdir -p /var/log/laravel-worker && \
echo $'[program:laravel-worker]\n\
process_name=%(program_name)s_%(process_num)02d\n\
command=php /var/www/html/artisan queue:work --sleep=3 --tries=3 --max-time=3600\n\
autostart=true\n\
autorestart=true\n\
stopasgroup=true\n\
killasgroup=true\n\
user=root\n\
numprocs=8\n\
redirect_stderr=true\n\
stdout_logfile=/var/log/laravel-worker/worker.log\n\
stopwaitsecs=3600' > /etc/supervisor/conf.d/laravel-worker.conf

RUN chown -fR www-data:www-data /var/www/html

EXPOSE 80 953

CMD [ "supervisord", "--nodaemon", "-c", "/etc/supervisor/supervisord.conf" ]