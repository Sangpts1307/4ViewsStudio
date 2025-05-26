<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@gmail.com';
        $user->password = Hash::make('12345678');
        $user->role = 2;
        $user->save();

        $staffs = [
            "Nguyễn Văn An",
            "Trần Thị Bình",
            "Lê Văn Cường",
            "Phạm Thị Dung",
            "Hoàng Văn Dũng",
            "Đặng Thị Hương",
            "Đỗ Văn Hậu",
            "Bùi Thị Lan",
            "Nguyễn Thị Mai",
            "Trần Văn Nam"
        ];
$provinces = [
    "Hà Nội",
    "TP. Hồ Chí Minh",
    "Đà Nẵng",
    "Hải Phòng",
    "Cần Thơ",
    "An Giang",
    "Bà Rịa - Vũng Tàu",
    "Bắc Giang",
    "Bắc Kạn",
    "Bạc Liêu",
    "Bắc Ninh",
    "Bến Tre",
    "Bình Định",
    "Bình Dương",
    "Bình Phước",
    "Bình Thuận",
    "Cà Mau",
    "Cao Bằng",
    "Đắk Lắk",
    "Đắk Nông",
    "Điện Biên",
    "Đồng Nai",
    "Đồng Tháp",
    "Gia Lai",
    "Hà Giang",
    "Hà Nam",
    "Hà Tĩnh",
    "Hải Dương",
    "Hậu Giang",
    "Hòa Bình",
    "Hưng Yên",
    "Khánh Hòa",
    "Kiên Giang",
    "Kon Tum",
    "Lai Châu",
    "Lâm Đồng",
    "Lạng Sơn",
    "Lào Cai",
    "Long An",
    "Nam Định",
    "Nghệ An",
    "Ninh Bình",
    "Ninh Thuận",
    "Phú Thọ",
    "Phú Yên",
    "Quảng Bình",
    "Quảng Nam",
    "Quảng Ngãi",
    "Quảng Ninh",
    "Quảng Trị",
    "Sóc Trăng",
    "Sơn La",
    "Tây Ninh",
    "Thái Bình",
    "Thái Nguyên",
    "Thanh Hóa",
    "Thừa Thiên Huế",
    "Tiền Giang",
    "Trà Vinh",
    "Tuyên Quang",
    "Vĩnh Long",
    "Vĩnh Phúc",
    "Yên Bái"
];

        for ($i = 0; $i < count($staffs); $i++) {
            DB::table('users')->insert([
                'name' => $staffs[$i],
                'email' => 'staff' . ($i + 1) . '@gmail.com',
                'password' => Hash::make('12345678'),
                'phone' => '09'.rand(10000000, 99999999),
                'address' => $provinces[array_rand($provinces)],
                'birth_date' => rand(1990, 2000) . '-' . rand(1, 12) . '-' . rand(1, 28),
                'account_number' => 'AdXiBqqyv4Fgj0zB3mgUa51mIlk3iyqPBWP-SymxvcDDNBcyPjwKdPVBzQiMfL3M_h4C6C4Y1aTFKRWq',
                'role' => 1
            ]);
        }

        $names = [
            "Ngô Minh Khoa",
            "Phạm Thị Vân",
            "Lê Trung Hiếu",
            "Nguyễn Thị Hồng",
            "Trần Văn Kiên",
            "Võ Thị Thủy",
            "Hoàng Văn Sơn",
            "Đinh Thị Yến",
            "Bùi Văn Khánh",
            "Trịnh Thị Ngọc"
        ];

        for ($i = 0; $i < count($names); $i++) {
            DB::table('users')->insert([
                'name' => $names[$i],
                'email' => 'user' . ($i + 1) . '@gmail.com',
                 'phone' => '09'.rand(10000000, 99999999),
                  'address' => $provinces[array_rand($provinces)],
                 'birth_date' => rand(1996, 2006) . '-' . rand(1, 12) . '-' . rand(1, 28),
                'password' => Hash::make('12345678'),
                'role' => 0
            ]);
        }
    }
}
