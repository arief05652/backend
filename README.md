<p align="center">
    <img src="assets/readme/banner.png" width="400" alt="Laravel Logo">
</p>

## About System

Ini adalah core dari sistem pemesanan restoran digital karna disini semua alur mulai dari reservasi meja, pemesanan menu, hingga pembayaran dikelola di sistem ini.

-   Documentation: [Laporan](https://docs.google.com/document/d/1qJ1T8KTdarmu9vl6iZWbhiY04Dx-n3g0rSL8awmW69A/edit?usp=sharing)
-   Mobile Clent: [Mobile Repo](https://github.com/arief05652/restoapp)

---

## Features

<!-- Pelanggan -->
<details>
<summary>Fitur Pelanggan</summary>

### Fitur yang bisa dilakukan pelanggan

-   Melakukan autentikasi
-   Reservasi meja dan atur kedatangan
-   Pemesanan menu dari katalog digital
-   Pembayaran makanan
-   Menerima notifikasi

</details>
<!-- Pelayan -->
<details>
<summary>Fitur Pelayan</summary>

### Fitur yang bisa dilakukan pelayan

-   Verifikasi kehadiran pelanggan
-   Pemesanan langsung ditempat (untuk pelanggan walk-in)
-   Lihat status meja & Antrian

</details>
<!-- Koki -->
<details>
<summary>Fitur Koki</summary>

### Fitur yang bisa dilakukan koki

-   Dashboard untuk melihat urutan daftar pesanan
-   Bisa merubah status pesanan

</details>
<!-- Admin -->
<details>
<summary>Fitur Admin</summary>

### Fitur yang bisa dilakukan admin

-   Manajemen menu seperti harga, ketersediaan dan harga
-   Manajemen meja seperti mengatur kapasitas dan ketersediaan
-   Kelola reservasi & laporan seperti monitoring reservasi yang masuk dan status kehadiran

</details>

---

### REST API DOCS

#### Authentication Endpoint

<details>
<summary><code>POST</code> <code>api/auth/register</code></summary>
    Register user baru ke system

#### Headers

> | Key    | Value            |
> | ------ | ---------------- |
> | Accept | application/json |

#### Body

> | Key        | Type             |
> | ---------- | ---------------- |
> | first_name | string [max:20]  |
> | last_name  | string [max:20]  |
> | email      | string [max:255] |
> | phone      | string [max:15]  |
> | password   | string [max:255] |

#### Response

> | Status Code | Response    |
> | ----------- | ----------- |
> | 201         | JSON Format |
> | 302         | JSON Format |

</details>

<details>
<summary><code>POST</code> <code>api/auth/login</code></summary>
    Login credential sebelum user masuk ke sistem

#### Headers

> | Key    | Value            |
> | ------ | ---------------- |
> | Accept | application/json |

#### Body

> | Key      | Type             |
> | -------- | ---------------- |
> | email    | string           |
> | password | string [max:255] |

#### Response

> | Status Code | Response    |
> | ----------- | ----------- |
> | 200         | JSON Format |
> | 401         | JSON Format |
> | 404         | JSON Format |

</details>

<details>
<summary><code>DELETE</code> <code>api/auth/logout</code></summary>
    Logout & hapus token sistem

#### Headers

> | Key           | Value            |
> | ------------- | ---------------- |
> | Accept        | application/json |
> | Authorization | Bearer {token}   |

#### Response

> | Status Code | Response    |
> | ----------- | ----------- |
> | 200         | JSON Format |

</details>

#### User Endpoint

<details>
<summary><code>GET</code> <code>api/user/show-user</code></summary>
    Show profile current user

#### Headers

> | Key           | Value            |
> | ------------- | ---------------- |
> | Accept        | application/json |
> | Authorization | Bearer {token}   |

#### Parameters

> | Key | Value   |
> | --- | ------- |
> | id  | user ID |

#### Response

> | Status Code | Response    |
> | ----------- | ----------- |
> | 200         | JSON Format |

</details>

<details>
<summary><code>PATCH</code> <code>api/user/users-update</code></summary>
    Update profile user

#### Headers

> | Key           | Value            |
> | ------------- | ---------------- |
> | Accept        | application/json |
> | Authorization | Bearer {token}   |

#### Body

> | Key        | Value                     |
> | ---------- | ------------------------- |
> | id         | string                    |
> | first_name | string [max:20]           |
> | last_name  | string [max:20, optional] |
> | email      | string                    |
> | phone      | string [max:15]           |

#### Response

> | Status Code | Response    |
> | ----------- | ----------- |
> | 200         | JSON Format |

</details>

<details>
<summary><code>PATCH</code> <code>api/user/users-role</code></summary>
    Update role user

#### Headers

> | Key           | Value            |
> | ------------- | ---------------- |
> | Accept        | application/json |
> | Authorization | Bearer {token}   |

#### Body

> | Key                    | Value           |
> | ---------------------- | --------------- |
> | id                     | string          |
> | first_name             | string [max:20] |
> | Optional [ last_name ] | string [max:20] |
> | email                  | string          |
> | phone                  | string [max:15] |

#### Response

> | Status Code | Response    |
> | ----------- | ----------- |
> | 200         | JSON Format |

</details>

<details>
<summary><code>GET</code> <code>api/user/show-history-reserve</code></summary>
    Show history reservation

#### Headers

> | Key           | Value            |
> | ------------- | ---------------- |
> | Accept        | application/json |
> | Authorization | Bearer {token}   |

#### Parameter

> | Key     | Value  |
> | ------- | ------ |
> | user_id | string |

#### Response

> | Status Code | Response    |
> | ----------- | ----------- |
> | 200         | JSON Format |
> | 404         | JSON Format |

</details>

#### Table Management Endpoint

<details>
<summary><code>GET</code> <code>api/table/show-table</code></summary>
    Show all table / selected by status

#### Headers

> | Key           | Value            |
> | ------------- | ---------------- |
> | Accept        | application/json |
> | Authorization | Bearer {token}   |

#### Parameter

> | Key                 | Value                                      |
> | ------------------- | ------------------------------------------ |
> | Optional [ status ] | [ tersedia, maintenance. booking, hidden ] |

#### Response

> | Status Code | Response    |
> | ----------- | ----------- |
> | 200         | JSON Format |
> | 404         | JSON Format |

</details>

<details>
<summary><code>POST</code> <code>api/table/add-table</code></summary>
    Tambah table

#### Headers

> | Key           | Value            |
> | ------------- | ---------------- |
> | Accept        | application/json |
> | Authorization | Bearer {token}   |

#### Body

> | Key      | Value           |
> | -------- | --------------- |
> | code     | string [max:20] |
> | capacity | string [min:1]  |

#### Response

> | Status Code | Response    |
> | ----------- | ----------- |
> | 200         | JSON Format |
> | 302         | JSON Format |

</details>

<details>
<summary><code>POST</code> <code>api/table/update-table</code></summary>
    Update table

#### Headers

> | Key           | Value            |
> | ------------- | ---------------- |
> | Accept        | application/json |
> | Authorization | Bearer {token}   |

#### Body

> | Key      | Value                                      |
> | -------- | ------------------------------------------ |
> | id       | string                                     |
> | code     | string [max:20]                            |
> | capacity | string [min:1]                             |
> | status   | [ tersedia, maintenance. booking, hidden ] |

#### Response

> | Status Code | Response    |
> | ----------- | ----------- |
> | 200         | JSON Format |
> | 302         | JSON Format |

</details>

<details>
<summary><code>DELETE</code> <code>api/table/delete-table</code></summary>
    Delete table

#### Headers

> | Key           | Value            |
> | ------------- | ---------------- |
> | Accept        | application/json |
> | Authorization | Bearer {token}   |

#### Parameter

> | Key      | Value  |
> | -------- | ------ |
> | table_id | string |

#### Response

> | Status Code | Response    |
> | ----------- | ----------- |
> | 200         | JSON Format |

</details>

#### Reservation Endpoint

<details>
<summary><code>POST</code> <code>api/reserve/add-reserve</code></summary>
    Membuat reserve tempat

#### Headers

> | Key           | Value            |
> | ------------- | ---------------- |
> | Accept        | application/json |
> | Authorization | Bearer {token}   |

#### Parameter

> | Key                | Value           |
> | ------------------ | --------------- |
> | user_id            | string          |
> | user_id            | string          |
> | Optional [ notes ] | string          |
> | schedule           | string datetime |
> | capacity           | integer         |

#### Response

> | Status Code | Response    |
> | ----------- | ----------- |
> | 200         | JSON Format |
> | 403         | JSON Format |

</details>

<details>
<summary><code>GET</code> <code>api/reserve/check-reserve</code></summary>
    Check-In reserve

#### Headers

> | Key           | Value            |
> | ------------- | ---------------- |
> | Accept        | application/json |
> | Authorization | Bearer {token}   |

#### Parameter

> | Key            | Value  |
> | -------------- | ------ |
> | reservation_id | string |

#### Response

> | Status Code | Response    |
> | ----------- | ----------- |
> | 200         | JSON Format |
> | 404         | JSON Format |

</details>

<details>
<summary><code>GET</code> <code>api/reserve/show-reservation</code></summary>
    Show all reservation list / by status

#### Headers

> | Key           | Value            |
> | ------------- | ---------------- |
> | Accept        | application/json |
> | Authorization | Bearer {token}   |

#### Parameter

> | Key                 | Value                                                |
> | ------------------- | ---------------------------------------------------- |
> | Optional [ status ] | [ waiting, active, checked_in, complete, cancelled ] |

#### Response

> | Status Code | Response    |
> | ----------- | ----------- |
> | 200         | JSON Format |
> | 404         | JSON Format |

</details>

<details>
<summary><code>POST</code> <code>api/reserve/done-reserve</code></summary>
    Ketika user sudahan memakai tempatnya

#### Headers

> | Key           | Value            |
> | ------------- | ---------------- |
> | Accept        | application/json |
> | Authorization | Bearer {token}   |

#### Parameter

> | Key            | Value  |
> | -------------- | ------ |
> | reservation_id | string |

#### Response

> | Status Code | Response    |
> | ----------- | ----------- |
> | 200         | JSON Format |

</details>

<details>
<summary><code>POST</code> <code>api/reserve/cancel-reserve</code></summary>
    Ketika user membatalkan memakai tempatnya

#### Headers

> | Key           | Value            |
> | ------------- | ---------------- |
> | Accept        | application/json |
> | Authorization | Bearer {token}   |

#### Parameter

> | Key            | Value  |
> | -------------- | ------ |
> | reservation_id | string |

#### Response

> | Status Code | Response    |
> | ----------- | ----------- |
> | 200         | JSON Format |

</details>