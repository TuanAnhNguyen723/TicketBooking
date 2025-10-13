<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            // =======================
            // 🔹 MIỀN BẮC
            // =======================
            [
                'name' => 'Xe Bus 2 Tầng City Sightseeing Hà Nội',
                'description' => 'Trải nghiệm tham quan Hà Nội bằng xe bus 2 tầng, ngắm phố cổ, lăng Bác và hồ Gươm từ trên cao.',
                'short_description' => 'Tham quan Hà Nội theo phong cách châu Âu.',
                'image' => 'hanoi-bus-main.jpg',
                'gallery' => ['hanoi-bus-1.jpg', 'hanoi-bus-2.jpg', 'hanoi-bus-3.jpg'],
                'adult_price' => 133000,
                'child_price' => 90000,
                'location' => 'Hà Nội',
                'start_date' => now()->addDays(1)->toDateString(),
                'end_date' => now()->addMonths(6)->toDateString(),
                'opening_time' => '08:00',
                'closing_time' => '20:00',
                'is_active' => true
            ],
            [
                'name' => 'VinKE & Vinpearl Aquarium Times City',
                'description' => 'Khu thủy cung lớn nhất miền Bắc kết hợp khu giáo trí hướng nghiệp cho trẻ em.',
                'short_description' => 'Thế giới dưới đại dương giữa lòng Hà Nội.',
                'image' => 'vinpearl-timescity-main.jpg',
                'gallery' => ['vinpearl-timescity-1.jpg', 'vinpearl-timescity-2.jpg', 'vinpearl-timescity-3.jpg'],
                'adult_price' => 330000,
                'child_price' => 250000,
                'location' => 'Hà Nội',
                'start_date' => now()->addDays(1)->toDateString(),
                'end_date' => now()->addMonths(6)->toDateString(),
                'opening_time' => '09:30',
                'closing_time' => '21:30',
                'is_active' => true
            ],
            [
                'name' => 'Sun World Hạ Long Complex',
                'description' => 'Khu vui chơi lớn nhất miền Bắc với công viên Rồng, cáp treo Nữ Hoàng và vòng quay Mặt Trời.',
                'short_description' => 'Điểm du lịch giải trí hấp dẫn tại Hạ Long.',
                'image' => 'ha-long-main.jpg',
                'gallery' => ['ha-long-1.jpg', 'ha-long-2.jpg', 'ha-long-3.jpg'],
                'adult_price' => 350000,
                'child_price' => 250000,
                'location' => 'Quảng Ninh',
                'start_date' => now()->addDays(1)->toDateString(),
                'end_date' => now()->addMonths(6)->toDateString(),
                'opening_time' => '08:30',
                'closing_time' => '21:30',
                'is_active' => true
            ],
            [
                'name' => 'Triển lãm công nghệ AI',
                'description' => 'Triển lãm công nghệ trí tuệ nhân tạo với nhiều sản phẩm và ứng dụng mới nhất. Có các buổi thuyết trình, workshop và demo sản phẩm.',
                'short_description' => 'Triển lãm công nghệ AI với nhiều sản phẩm mới nhất.',
                'image' => 'ai-exhibition-main.jpg',
                'gallery' => [
                    'ai-exhibition-1.jpg',
                    'ai-exhibition-2.jpg',
                    'ai-exhibition-3.jpg'
                ],
                'adult_price' => 150000,
                'child_price' => 100000,
                'location' => 'Hà Nội',
                'start_date' => now()->addDays(60)->toDateString(),
                'end_date' => now()->addDays(63)->toDateString(),
                'opening_time' => '09:00',
                'closing_time' => '17:00',
                'is_active' => true
            ],

            // =======================
            // 🔹 MIỀN TRUNG
            // =======================
            [
                'name' => 'Sun World Ba Na Hills',
                'description' => 'Khu du lịch nghỉ dưỡng và giải trí trên núi với khí hậu mát mẻ quanh năm. Có cầu Vàng nổi tiếng, làng Pháp cổ kính, và nhiều trò chơi cảm giác mạnh.',
                'short_description' => 'Khu du lịch nghỉ dưỡng trên núi với cầu Vàng nổi tiếng.',
                'image' => 'ba-na-hills-main.jpg',
                'gallery' => ['ba-na-hills-1.jpg', 'ba-na-hills-2.jpg', 'ba-na-hills-3.jpg'],
                'adult_price' => 750000,
                'child_price' => 600000,
                'location' => 'Đà Nẵng',
                'start_date' => now()->toDateString(),
                'end_date' => now()->addMonths(6)->toDateString(),
                'opening_time' => '08:00',
                'closing_time' => '23:00',
                'is_active' => true
            ],
            [
                'name' => 'Asia Park – Sun World Đà Nẵng Wonders',
                'description' => 'Công viên giải trí hiện đại với hàng chục trò chơi cảm giác mạnh, vòng quay Sun Wheel và khu ẩm thực quốc tế.',
                'short_description' => 'Thiên đường giải trí giữa lòng Đà Nẵng.',
                'image' => 'asia-park-main.jpg',
                'gallery' => ['asia-park-1.jpg', 'asia-park-2.jpg', 'asia-park-3.jpg'],
                'adult_price' => 180000,
                'child_price' => 120000,
                'location' => 'Đà Nẵng',
                'start_date' => now()->addDays(1)->toDateString(),
                'end_date' => now()->addMonths(6)->toDateString(),
                'opening_time' => '15:00',
                'closing_time' => '22:00',
                'is_active' => true
            ],
            [
                'name' => 'Khu du lịch Núi Thần Tài',
                'description' => 'Khu nghỉ dưỡng suối khoáng nóng thiên nhiên, với công viên nước khoáng và tắm onsen Nhật Bản.',
                'short_description' => 'Suối khoáng nóng nổi tiếng miền Trung.',
                'image' => 'nui-than-tai-main.jpg',
                'gallery' => ['nui-than-tai-1.jpg', 'nui-than-tai-2.jpg', 'nui-than-tai-3.jpg'],
                'adult_price' => 300000,
                'child_price' => 150000,
                'location' => 'Đà Nẵng',
                'start_date' => now()->addDays(1)->toDateString(),
                'end_date' => now()->addMonths(6)->toDateString(),
                'opening_time' => '08:00',
                'closing_time' => '18:00',
                'is_active' => true
            ],
            [
                'name' => 'VinWonders Nam Hội An',
                'description' => 'Tổ hợp giải trí – văn hóa – sinh thái với khu làng Việt, đảo dân gian và công viên nước hiện đại.',
                'short_description' => 'Trải nghiệm văn hóa và giải trí giữa miền Trung.',
                'image' => 'vinwonders-hoian-main.jpg',
                'gallery' => ['vinwonders-hoian-1.jpg', 'vinwonders-hoian-2.jpg', 'vinwonders-hoian-3.jpg'],
                'adult_price' => 295000,
                'child_price' => 220000,
                'location' => 'Quảng Nam',
                'start_date' => now()->addDays(1)->toDateString(),
                'end_date' => now()->addMonths(6)->toDateString(),
                'opening_time' => '08:30',
                'closing_time' => '21:30',
                'is_active' => true
            ],
            [
                'name' => 'VinWonders Nha Trang',
                'description' => 'Công viên giải trí hàng đầu Việt Nam trên đảo Hòn Tre, gồm khu trò chơi, thủy cung và bãi biển riêng.',
                'short_description' => 'Thiên đường giải trí trên biển.',
                'image' => 'vinwonders-nhatrang-main.jpg',
                'gallery' => ['vinwonders-nhatrang-1.jpg', 'vinwonders-nhatrang-2.jpg', 'vinwonders-nhatrang-3.jpg'],
                'adult_price' => 950000,
                'child_price' => 710000,
                'location' => 'Khánh Hòa',
                'start_date' => now()->addDays(1)->toDateString(),
                'end_date' => now()->addMonths(6)->toDateString(),
                'opening_time' => '09:00',
                'closing_time' => '22:00',
                'is_active' => true
            ],
            [
                'name' => 'Công viên nước Vinpearl Land',
                'description' => 'Công viên nước hiện đại với nhiều trò chơi nước thú vị, phù hợp cho cả gia đình.',
                'short_description' => 'Công viên nước hiện đại với nhiều trò chơi nước thú vị.',
                'image' => 'vinpearl-waterpark-main.jpg',
                'gallery' => ['vinpearl-waterpark-1.jpg', 'vinpearl-waterpark-2.jpg', 'vinpearl-waterpark-3.jpg'],
                'adult_price' => 300000,
                'child_price' => 200000,
                'location' => 'Nha Trang',
                'start_date' => now()->toDateString(),
                'end_date' => now()->addMonths(6)->toDateString(),
                'opening_time' => '09:00',
                'closing_time' => '18:00',
                'is_active' => true
            ],

            // =======================
            // 🔹 MIỀN NAM
            // =======================
            [
                'name' => 'Khu vui chơi VinWonders Phú Quốc',
                'description' => 'Khu vui chơi giải trí hàng đầu tại Phú Quốc với nhiều trò chơi thú vị và cảnh quan tuyệt đẹp.',
                'short_description' => 'Khu vui chơi giải trí hàng đầu tại Phú Quốc.',
                'image' => 'vinwonders-phu-quoc-main.jpg',
                'gallery' => ['vinwonders-phu-quoc-1.jpg', 'vinwonders-phu-quoc-2.jpg', 'vinwonders-phu-quoc-3.jpg'],
                'adult_price' => 500000,
                'child_price' => 350000,
                'location' => 'Phú Quốc, Kiên Giang',
                'start_date' => now()->toDateString(),
                'end_date' => now()->addMonths(6)->toDateString(),
                'opening_time' => '09:00',
                'closing_time' => '22:00',
                'is_active' => true
            ],
            [
                'name' => 'VinWonders & Safari Phú Quốc',
                'description' => 'Tổ hợp công viên chủ đề và vườn thú bán hoang dã đầu tiên tại Việt Nam.',
                'short_description' => 'Khám phá thiên nhiên và giải trí tại đảo ngọc.',
                'image' => 'vinwonders-phuquoc-main.jpg',
                'gallery' => ['vinwonders-phuquoc-1.jpg', 'vinwonders-phuquoc-2.jpg', ''],
                'adult_price' => 950000,
                'child_price' => 710000,
                'location' => 'Phú Quốc',
                'start_date' => now()->addDays(1)->toDateString(),
                'end_date' => now()->addMonths(6)->toDateString(),
                'opening_time' => '09:00',
                'closing_time' => '19:30',
                'is_active' => true
            ],
            [
                'name' => 'Sun World Hòn Thơm Nature Park',
                'description' => 'Cáp treo vượt biển dài nhất thế giới, nối liền Phú Quốc và đảo Hòn Thơm.',
                'short_description' => 'Trải nghiệm bay giữa biển xanh tuyệt đẹp.',
                'image' => 'hon-thom-main.jpg',
                'gallery' => ['hon-thom-1.jpg', 'hon-thom-2.jpg', 'hon-thom-3.jpg'],
                'adult_price' => 540000,
                'child_price' => 40000,
                'location' => 'Phú Quốc',
                'start_date' => now()->addDays(1)->toDateString(),
                'end_date' => now()->addMonths(6)->toDateString(),
                'opening_time' => '08:00',
                'closing_time' => '19:00',
                'is_active' => true
            ],
            [
                'name' => 'Sun World Núi Bà Đen',
                'description' => 'Khu du lịch tâm linh và cáp treo hiện đại, nơi có tượng Phật Bà bằng đồng lớn nhất châu Á.',
                'short_description' => 'Nóc nhà Nam Bộ – hành hương và ngắm cảnh.',
                'image' => 'ba-den-main.jpg',
                'gallery' => ['ba-den-1.jpg', 'ba-den-2.jpg', 'ba-den-3.jpg'],
                'adult_price' => 143000,
                'child_price' => 100000,
                'location' => 'Tây Ninh',
                'start_date' => now()->addDays(1)->toDateString(),
                'end_date' => now()->addMonths(6)->toDateString(),
                'opening_time' => '06:00',
                'closing_time' => '21:00',
                'is_active' => true
            ],
            [
                'name' => 'Minera Hot Springs Bình Châu',
                'description' => 'Khu nghỉ dưỡng và suối khoáng nóng tự nhiên lớn nhất miền Nam.',
                'short_description' => 'Thiên đường thư giãn giữa thiên nhiên Bình Châu.',
                'image' => 'minera-binhchau-main.jpg',
                'gallery' => ['minera-binhchau-1.jpg', 'minera-binhchau-2.jpg', 'minera-binhchau-3.jpg'],
                'adult_price' => 122000,
                'child_price' => 80000,
                'location' => 'Bà Rịa - Vũng Tàu',
                'start_date' => now()->addDays(1)->toDateString(),
                'end_date' => now()->addMonths(6)->toDateString(),
                'opening_time' => '08:00',
                'closing_time' => '22:00',
                'is_active' => true
            ],
            [
                'name' => 'Suối Tiên Theme Park',
                'description' => 'Công viên văn hóa giải trí lâu đời nhất TP.HCM, nổi bật với chủ đề dân gian.',
                'short_description' => 'Khu vui chơi mang đậm bản sắc Việt.',
                'image' => 'suoi-tien-main.jpg',
                'gallery' => ['suoi-tien-1.jpg', 'suoi-tien-2.jpg', 'suoi-tien-3.jpg'],
                'adult_price' => 260000,
                'child_price' => 130000,
                'location' => 'TP. Hồ Chí Minh',
                'start_date' => now()->addDays(1)->toDateString(),
                'end_date' => now()->addMonths(6)->toDateString(),
                'opening_time' => '08:00',
                'closing_time' => '18:00',
                'is_active' => true
            ],
            [
                'name' => 'Công viên văn hóa Đầm Sen',
                'description' => 'Khu vui chơi lâu đời tại TP.HCM, nổi tiếng với khu công viên nước và nhiều hoạt động lễ hội quanh năm.',
                'short_description' => 'Khu vui chơi sôi động giữa Sài Gòn.',
                'image' => 'dam-sen-main.jpg',
                'gallery' => ['dam-sen-1.jpg', 'dam-sen-2.jpg', 'dam-sen-3.jpg'],
                'adult_price' => 140000,
                'child_price' => 100000,
                'location' => 'TP. Hồ Chí Minh',
                'start_date' => now()->addDays(1)->toDateString(),
                'end_date' => now()->addMonths(6)->toDateString(),
                'opening_time' => '08:00',
                'closing_time' => '18:00',
                'is_active' => true
            ],
            [
                'name' => 'KDL Đại Nam Văn Hiến',
                'description' => 'Khu du lịch đa năng với vườn thú, khu đền thờ, biển nhân tạo và công viên nước rộng lớn.',
                'short_description' => 'Điểm vui chơi, tâm linh và khám phá ở Bình Dương.',
                'image' => 'dai-nam-main.jpg',
                'gallery' => ['dai-nam-1.jpg', 'dai-nam-2.jpg', 'dai-nam-3.jpg'],
                'adult_price' => 200000,
                'child_price' => 130000,
                'location' => 'Bình Dương',
                'start_date' => now()->addDays(1)->toDateString(),
                'end_date' => now()->addMonths(6)->toDateString(),
                'opening_time' => '08:00',
                'closing_time' => '17:30',
                'is_active' => true
            ],
            [
                'name' => 'Lễ hội âm nhạc quốc tế',
                'description' => 'Lễ hội âm nhạc quốc tế với sự tham gia của nhiều nghệ sĩ nổi tiếng trong và ngoài nước. Chương trình diễn ra trong 3 ngày với nhiều thể loại nhạc khác nhau.',
                'short_description' => 'Lễ hội âm nhạc quốc tế với nhiều nghệ sĩ nổi tiếng.',
                'image' => 'music-festival-main.jpg',
                'gallery' => [
                    'music-festival-1.jpg',
                    'music-festival-2.jpg',
                    'music-festival-3.jpg'
                ],
                'adult_price' => 800000,
                'child_price' => 500000,
                'location' => 'TP. Hồ Chí Minh',
                'start_date' => now()->addDays(30)->toDateString(),
                'end_date' => now()->addDays(33)->toDateString(),
                'opening_time' => '18:00',
                'closing_time' => '24:00',
                'is_active' => true
            ],
            [
                'name' => 'Triển lãm công nghệ AI',
                'description' => 'Triển lãm công nghệ trí tuệ nhân tạo với nhiều sản phẩm và ứng dụng mới nhất. Có các buổi thuyết trình, workshop và demo sản phẩm.',
                'short_description' => 'Triển lãm công nghệ AI với nhiều sản phẩm mới nhất.',
                'image' => 'ai-exhibition-main.jpg',
                'gallery' => [
                    'ai-exhibition-1.jpg',
                    'ai-exhibition-2.jpg',
                    'ai-exhibition-3.jpg'
                ],
                'adult_price' => 150000,
                'child_price' => 100000,
                'location' => 'Hà Nội',
                'start_date' => now()->addDays(60)->toDateString(),
                'end_date' => now()->addDays(63)->toDateString(),
                'opening_time' => '09:00',
                'closing_time' => '17:00',
                'is_active' => true
            ]
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
