FROM php:cli-alpine

WORKDIR /app
EXPOSE 8080/tcp

COPY ./ /app/

CMD php -S 0.0.0.0:8080 index.php