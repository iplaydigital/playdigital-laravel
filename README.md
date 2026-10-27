# Play Digital Website — Laravel Edition (`playdigital.co.th`)

เว็บไซต์บริษัท **Play Digital Co., Ltd.** ("Turn on our ideas, Let’s play to win") พัฒนาบน **Laravel** (Blade + Eloquent ORM + SQLite/MySQL Ready) โดยคงเอกลักษณ์ดีไซน์ดั้งเดิมของ `playdigital.co.th` (`#642f96` Purple, `#fff` Fixed Header, `#333` Dark Contact Footer, YouTube Showreel Hero, Portfolio 3-Column Grid, Play's Rules, 13 Services และ 32 Client Logos) พร้อมระบบฟอร์มติดต่อเก็บ Lead ลงฐานข้อมูล (`contact_inquiries`) และรองรับ Redirect จากลิงก์เก่า (`?page=...`) อัตโนมัติ

---

## โครงสร้างหน้าเว็บและระบบ (Features & Routes)

| URL Route | Legacy URL ที่รองรับ (302 Redirect) | รายละเอียด |
|---|---|---|
| `GET /` | `/?page=home` | หน้าแรก: Hero YouTube Showreel (`gBPHuwaHQQc`), ผลงานเด่น 18 ชิ้น, About & Play's Rules (4 ข้อ), Services (13 บริการ) และ Contact Footer |
| `GET /work` | `/?page=work` | รวมผลงานทั้งหมดพร้อมแถบกรองหมวดหมู่ |
| `GET /work/category/{category}` | `/?page=category&cid={cid}` | กรองผลงานตามหมวดหมู่ (รองรับทั้ง slug เช่น `video-campaign` และรหัสเดิม `cid`) |
| `GET /work/{work}` | `/?page=detail-work&id={id}`, `/?page=detail-vdo&id={id}` | รายละเอียดผลงาน (รองรับทั้ง YouTube Video Embed / Lightbox และภาพแกลเลอรี + ข้อมูล Client / Product / Campaign / Media / Detail / Link) |
| `GET /clients` | `/?page=clients` | รายชื่อแบรนด์ลูกค้าทั้ง 32 แบรนด์ |
| `GET /blog`, `GET /blog/{slug}` | `/?page=blog` | บทความและความรู้ด้าน Digital Marketing |
| `GET /contact` | `/?page=contact` | หน้าติดต่อบริษัท อาคาร Park Silom Tower ชั้น 19 |
| `POST /contact` | — | บันทึกข้อมูลผู้ติดต่อลงตาราง `contact_inquiries` (รองรับทั้ง HTML Form & Progressive AJAX JSON, Validation, Rate Limit และ Honeypot ป้องกันบอท) |

---

## โครงสร้างฐานข้อมูล (Database Tables)

- `work_categories` — หมวดหมู่ผลงาน 6 หมวด (`VIDEO CAMPAIGN`, `WEB DESIGN & DEVELOPMENT`, `SOCIAL MEDIA MANAGEMENT`, `MOBILE APPLICATION`, `MEDIA ADS`, `VIDEO CONTENT`)
- `works` — ข้อมูลผลงานพอร์ตโฟลิโอ แกลเลอรี และรหัสวิดีโอ YouTube
- `about_rules` — หลักการทำงาน Play's Rules ทั้ง 4 ข้อ
- `services` — บริการด้านดิจิทัลทั้ง 13 รายการ
- `clients` — โลโก้ลูกค้าทั้ง 32 แบรนด์
- `posts` — บทความบล็อก
- `contact_inquiries` — ตารางเก็บข้อมูล Lead ที่ส่งมาจากฟอร์มติดต่อหน้าเว็บไซต์

---

## การติดตั้งและรันโปรเจกต์ (Local Setup)

```bash
# 1. ติดตั้งแพ็กเกจ PHP
composer install

# 2. ตั้งค่าไฟล์ .env และสร้าง APP_KEY (หากยังไม่มี)
cp -n .env.example .env
php artisan key:generate

# 3. สร้างตารางฐานข้อมูลและ Seed ข้อมูลเริ่มต้นของ Play Digital
touch database/database.sqlite
php artisan migrate:fresh --seed

# 4. รันเซิร์ฟเวอร์พัฒนา
php artisan serve
```

## การรันชุดทดสอบ (Automated Tests)

```bash
./vendor/bin/phpunit
```
