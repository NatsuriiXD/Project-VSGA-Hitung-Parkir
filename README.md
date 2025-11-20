# 💡 Aplikasi Hitung Biaya Parkir Mall

## 📘 Deskripsi
Aplikasi ini merupakan program berbasis **PHP dan Bootstrap** untuk menghitung biaya parkir kendaraan di mall berdasarkan jenis kendaraan, 
durasi parkir, dan status keanggotaan (Member atau Non-Member).  
Tampilan web didesain modern dengan warna biru lembut, animasi halus, dan tata letak responsif menggunakan Bootstrap.

---

## 📂 Struktur Folder
```
/parkir/
│
├── php
|     |──index.php
|     └──functions.php
├── assets/
│   ├── css/bootstrap.css
│   └── images/logo.png
└── data/
    └── data.json
```

---

## ⚙️ Cara Menjalankan
1. Letakkan folder proyek ke dalam direktori `htdocs` (jika menggunakan **XAMPP**).
2. Jalankan **Apache** dari XAMPP Control Panel.
3. Buka browser dan akses:
   ```
   http://localhost/project/index.php
   ```
4. Isi form dengan plat nomor, jenis kendaraan, jam masuk dan keluar, serta keanggotaan.
5. Klik tombol **Hitung** untuk melihat hasil perhitungan biaya parkir.

---

## 🚗 Ketentuan Perhitungan
### Jenis Kendaraan dan Tarif:
| Jenis Kendaraan | 1 Jam Pertama | Jam Berikutnya |
|-----------------|----------------|----------------|
| Mobil | Rp5.000 | Rp3.000 |
| Motor | Rp2.000 | Rp1.000 |
| Truk | Rp6.000 / jam | - |

### Keanggotaan:
- **Member** → Diskon 10%
- **Non-Member** → Tidak ada diskon

### Contoh:
- Mobil, durasi 4 jam = (1×5000) + (3×3000) = **Rp14.000**
- Motor, durasi 1 jam = (1×2000) = **Rp2.000**
- Truk, durasi 3 jam = (3×6000) = **Rp18.000**

---

## ✨ Tampilan dan Animasi
Desain tampilan menggunakan **Bootstrap CSS bawaan**, ditambah kustomisasi warna dan animasi langsung dari `index.php`:

- Background gradasi biru muda.
- Card/form putih dengan sudut membulat dan bayangan lembut.
- Logo mall memiliki efek hover (sedikit berputar & membesar).
- Tombol "Hitung" berwarna biru gradasi dengan efek **hover glow**.
- Form muncul dengan animasi **slide-up fade-in**.
- Input dan select memiliki efek fokus bercahaya biru.

---

## 📄 Fitur Utama
✅ Input data kendaraan dan waktu parkir  
✅ Hitung otomatis durasi & biaya parkir  
✅ Diskon otomatis untuk Member  
✅ Simpan hasil ke file `data/data.json`  
✅ Desain modern, ringan, dan responsif dengan animasi halus  

---

## 📸 Contoh Hasil Tampilan
```
Plat Nomor Kendaraan: N 4321 AC
Jenis Kendaraan: Mobil
Durasi Parkir: 5 jam
Keanggotaan: Member
Total Biaya Parkir: Rp18.900,-
```
