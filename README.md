# [Backend] - Online Store

## Analisa Masalah
Menurut pengalaman saya, kasus tersebut dikarenakan oleh beberapa hal berikut:

1. data stock yang tidak sama antara di warehouse dan database

2. manajemen backend checkout flow yang bocor karena banyaknya request 12.12 (updated stock, and queue stock)

## Solusi

Menurut saya ada beberapa solusi untuk menangani case tersebut:

1. membuat sebuah service untuk pegawai warehouse untuk update last stock setiap hari

2. membuat sistem yang meminimalisasi offset stock

3. kalau di golang bisa memanfaatkan go-routine untuk request yang besar


## Treasure Hunt Endpoint

http://evermos-test.gantangansultan.com/public/api/v1/treasure-hunt

# How to install

requirements:
 - php 7.4.19
 - composer 2.0.14
 - mysql

script:
```bash
 - composer install
 - cp .env.example .env
 - php artisan key:generate
 - php artisan migrate --seed
 - php artisan optimize
 - php artisan storage:link
```

### Puclic API

http://evermos-test.gantangansultan.com/public/

### POSTMAN

https://www.getpostman.com/collections/75912deadcd75968230b