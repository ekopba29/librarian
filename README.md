1.sesuaikan .env, mulai dari base_url dan database
<p> tambah MIX_VUE_BASE_API_LIBRARY="http://librarian-main.test/api/" di .env (librarian-main.test = url projek laravel)
<p>
2. install depencies [ npm intall , composer install ]
<p>
3. run migration
    <p>
4. run sesuai base url
  <p>
      5. registrasi user dulu<p>
      6. ubah salah satu user menjadi admin lewat database langsung, ada di tabel users kolom role, ubah ke admin
<p>
    7. tambah data buku di admin
    <p>
        8. setelah buku ada baru bisa user lain pinjam buku
