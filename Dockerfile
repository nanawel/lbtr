FROM php:cli-alpine

WORKDIR /app
EXPOSE 8080/tcp

COPY ./ /app/
RUN echo -e "expose_php = Off\nmax_input_vars = 32\nerror_reporting = 0" \
    > /usr/local/etc/php/conf.d/zz-lbtr.ini

CMD php -S 0.0.0.0:8080 index.php