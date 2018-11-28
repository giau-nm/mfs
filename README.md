## Hệ thống quản lý, đăng ký mượn/trả thiết bị test

### Tình hình

- Số lượng thiết bị test của công ty có giới hạn
- Có team/cá nhân mượn thiết bị rất lâu, cầm không dùng đến nhưng lại ko trả
- Có team muốn mượn thiết bị thì phải tự đi tìm

### Chức năng mong muốn

- Import user từ CSV
- Admin import thiết bị từ CSV
- Admin/User login Dùng google sign-in
- Admin có thể edit thông tin thiết bị, restore password của user, edit được dự án của User gắn vào
- User/admin list thiết bị, search, sort
- User đăng ký mượn thiết bị. Từ list thiết bị có nút mượn, bấm vào ra form chọn time mượn
- Mode mượn thiết bị của user: Mượn 1->7 ngày.
- Khi đăng ký mượn có thông báo cho Admin (mail). Admin approve thông báo cho User
- Hết hạn nhắc nhở vào 7h30 hàng ngày cho User
- Admin có thể set cho thiết bị mượn ở thể loại dài hạn (không cần nhắc trả)
- Admin/User list danh sách các thiết bị đang mượn
- Chức năng report thông tin thiết bị đang mượn


## Cấu hình môi trường dev

- Clone code về local
- Bật docker
- Vào thư mục source code gõ `docker-compose build` để tạo image cho môi trường dev
- Gõ tiếp `docker-compose up -d` để khởi chạy container
- Chạy tiếp phần ##Install
- Bật browser vào localhost:8121 Nếu có trang default `phpinfo()` là ok

=============================================================================

## Install
- clone/copy code vào thư mục chứa file docker-compose.yml
- đổi tên file .env.example thành .env và sửa nội dung file cho phù hợp, .env.testing.example thành .env.testing
- Go to folder "public" and run command: `bower install --allow-root`
- Go to folder and run command: `composer install`
- Go to folder and run command:
    `composer install`
    `php artisan migrate:refresh --seed`


## list components used
### Breadcrumb: `https://github.com/yasiao/laravel-breadcrumb`
### Admin LTE 2.4: https://adminlte.io/
### multiselect-two-sides: https://crlcu.github.io/multiselect/
### jquery-csv: http://evanplaice.github.io/jquery-csv/

## Cấu hình google account auth(sử dụng để tạo google app)
Nếu dùng url khác so với bình thường thì phải tạo lại app khác. Như sau:
1. tạo OAuth2 client with Google và  theo hướng dẫn tại https://medium.com/@thomashellstrom/use-google-as-login-in-your-web-app-with-oauth2-352f6c7f10e6
2. Enable APIs theo hướng dẫn: https://support.google.com/cloud/answer/6158841?hl=en
3: Lấy 2 thông số ở bước 1: CLIENT_ID và CLIENT_SECRET điền vào file .env

## Seed database
- Develop
Chạy php artisan migrate:refresh --seed để tạo mới table và seed data
-Testing
Tạo mới database test bằng php artisan db:setup

## Config làm admin
Sửa file : config/constant : sửa trường EMAIL_ADMIN_DEFAULT thành email của mình là có thể đăng nhập như admin.
