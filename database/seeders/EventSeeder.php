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
            [
                'name' => 'Khu vui chơi VinWonders Phú Quốc',
                'description' => 'Khu vui chơi giải trí hàng đầu tại Phú Quốc với nhiều trò chơi thú vị và cảnh quan tuyệt đẹp. Bao gồm các khu vực như: Công viên nước, Khu vui chơi trong nhà, Show biểu diễn, và nhiều hoạt động khác.',
                'short_description' => 'Khu vui chơi giải trí hàng đầu tại Phú Quốc với nhiều trò chơi thú vị.',
                'image' => 'vinwonders-phu-quoc-main.jpg',
                'gallery' => [
                    'vinwonders-phu-quoc-1.jpg',
                    'vinwonders-phu-quoc-2.jpg',
                    'vinwonders-phu-quoc-3.jpg'
                ],
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
                'name' => 'Sun World Ba Na Hills',
                'description' => 'Khu du lịch nghỉ dưỡng và giải trí trên núi với khí hậu mát mẻ quanh năm. Có cầu Vàng nổi tiếng, làng Pháp cổ kính, và nhiều trò chơi cảm giác mạnh.',
                'short_description' => 'Khu du lịch nghỉ dưỡng trên núi với cầu Vàng nổi tiếng.',
                'image' => 'ba-na-hills-main.jpg',
                'gallery' => [
                    'ba-na-hills-1.jpg',
                    'ba-na-hills-2.jpg',
                    'ba-na-hills-3.jpg'
                ],
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
                'name' => 'Công viên nước Vinpearl Land',
                'description' => 'Công viên nước hiện đại với nhiều trò chơi nước thú vị, phù hợp cho cả gia đình. Có các slide nước, bể bơi sóng, và khu vực dành cho trẻ em.',
                'short_description' => 'Công viên nước hiện đại với nhiều trò chơi nước thú vị.',
                'image' => 'vinpearl-waterpark-main.jpg',
                'gallery' => [
                    'vinpearl-waterpark-1.jpg',
                    'vinpearl-waterpark-2.jpg',
                    'vinpearl-waterpark-3.jpg'
                ],
                'adult_price' => 300000,
                'child_price' => 200000,
                'location' => 'Nha Trang',
                'start_date' => now()->toDateString(),
                'end_date' => now()->addMonths(6)->toDateString(),
                'opening_time' => '09:00',
                'closing_time' => '18:00',
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
