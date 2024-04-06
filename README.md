## Load balancing with Docker, Nginx and PHP
The example demonstrates load balancing between PHP services using NGINX. 
Redis is used to store sessions.

![Schema load balancer](https://github.com/kyn07c0/docker-nginx-php-load-balancer/assets/50650263/0cdd3c29-ade7-43c8-b535-fdcf76a4367c)

## Project structure
```
docker-nginx-php-load-balancer
├── config
│   ├── nginx
│   |   └── default.conf
│   └── php
│       └── php.ini
├── data
│   ├── log
│   ├── redis
│   └── web
│       └── index.php
├── docker
│   └── php8.3-fpm
│       └── Dockerfile
└── docker-compose.yml
```

## NGINX load balancing methods
The example uses the Round Robin method of evenly distributing the load between applications.
Load balancing is described in the default.conf file and consists of two segments: upstream and fastcgi_pass.
All internal servers across which the load is distributed must be listed in the upstream block:
```
upstream php-backend {
    server php1:9000;
    server php2:9000;
    server php3:9000;
}
```

To tell Nginx which URLs it should forward requests to, you need to configure the location element using the fastcgi_pass entry in the configuration file.
```
location ~ \.php$ {
   ...
   fastcgi_pass php-backend;
   ...
}
```

## PHP-FPM configuration
The configuration file config/php/php.ini configures PHP to store sessions in Redis.
```
...
session.save_handler = redis
session.save_path = redis:6379
...
```

## Beginning of work
Run docker-compose up -d --build to start all containers.
In your browser, go to http://localhost:8080.
The page will display information about the server that processed the request, the session ID and the number of page updates by the above server.
```
host: php1.net
session id: nb8err1575g089b9tcc17is6qh
page updates: 1
```
If load balancing is working correctly, each page refresh should cause the handler server name to change and the page refresh counter to increment. The session ID should not change.

To check that Redis is working, you can go to http://localhost:8082 and make sure that the session identifier is stored there.
