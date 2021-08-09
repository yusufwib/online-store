
## Analisa Masalah
Menurut pengalaman saya, kasus tersebut dikarenakan oleh beberapa hal berikut:

1. data stock yang tidak sama antara di warehouse dan database

2. manajemen backend checkout flow yang bocor karena banyaknya request 12.12 (updated stock, and queue stock)

## Solusi

Menurut saya ada beberapa solusi untuk menangani case tersebut:

1. membuat sebuah service untuk pegawai warehouse untuk update last stock setiap hari

2. membuat sistem yang meminimalisasi offset stock

3. kalau di golang bisa memanfaatkan go-routine untuk request yang besar