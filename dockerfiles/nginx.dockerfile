FROM nginx:alpine

COPY ./conf/nginx.conf /etc/nginx/

RUN apk update \
    && apk upgrade \
    && apk add --no-cache bash

RUN apk add --no-cache curl

RUN set -x ; \
    addgroup -g 1000 -S www-data ; \
    adduser -u 1000 -D -S -G www-data www-data && exit 0 ; exit 1

EXPOSE 80 81 443
