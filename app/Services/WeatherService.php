<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherService
{
    private $apiKey;
    private $baseUrl = 'http://api.openweathermap.org/data/2.5';

    public function __construct()
    {
        $this->apiKey = config('services.openweather.api_key', env('OPENWEATHER_API_KEY', 'your_api_key_here'));
    }

    /**
     * Lấy thông tin thời tiết cho một ngày cụ thể
     */
    public function getWeatherForDate($date, $city = 'Hanoi')
    {
        // Nếu không có API key, trả về dữ liệu mẫu
        if ($this->apiKey === 'your_api_key_here' || empty($this->apiKey)) {
            return $this->getSampleWeatherData($date);
        }

        $cacheKey = "weather_{$city}_{$date}";
        
        return Cache::remember($cacheKey, 3600, function () use ($date, $city) {
            try {
                // Lấy tọa độ của thành phố
                $coordinates = $this->getCityCoordinates($city);
                
                if (!$coordinates) {
                    return $this->getDefaultWeather();
                }

                // Gọi API forecast để lấy dự báo 5 ngày
                $response = Http::timeout(10)->get($this->baseUrl . '/forecast', [
                    'lat' => $coordinates['lat'],
                    'lon' => $coordinates['lon'],
                    'appid' => $this->apiKey,
                    'units' => 'metric',
                    'lang' => 'vi'
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return $this->findWeatherForDate($data, $date);
                }

                return $this->getDefaultWeather();
            } catch (\Exception $e) {
                \Log::error('Weather API Error: ' . $e->getMessage());
                return $this->getDefaultWeather();
            }
        });
    }

    /**
     * Lấy tọa độ của thành phố
     */
    private function getCityCoordinates($city)
    {
        $cities = [
            'Hanoi' => ['lat' => 21.0285, 'lon' => 105.8542],
            'Ho Chi Minh City' => ['lat' => 10.8231, 'lon' => 106.6297],
            'Da Nang' => ['lat' => 16.0544, 'lon' => 108.2022],
            'Hue' => ['lat' => 16.4637, 'lon' => 107.5909],
            'Nha Trang' => ['lat' => 12.2388, 'lon' => 109.1967],
            'Quang Ninh' => ['lat' => 20.9101, 'lon' => 107.1839],
        ];

        return $cities[$city] ?? $cities['Hanoi'];
    }

    /**
     * Tìm thông tin thời tiết cho ngày cụ thể
     */
    private function findWeatherForDate($forecastData, $targetDate)
    {
        $targetTimestamp = strtotime($targetDate);
        
        foreach ($forecastData['list'] as $forecast) {
            $forecastDate = date('Y-m-d', $forecast['dt']);
            $targetDateFormatted = date('Y-m-d', $targetTimestamp);
            
            if ($forecastDate === $targetDateFormatted) {
                return $this->formatWeatherData($forecast);
            }
        }

        return $this->getDefaultWeather();
    }

    /**
     * Format dữ liệu thời tiết
     */
    private function formatWeatherData($weatherData)
    {
        $weather = $weatherData['weather'][0];
        $main = $weatherData['main'];
        
        return [
            'temperature' => round($main['temp']),
            'description' => $weather['description'],
            'icon' => $weather['icon'],
            'humidity' => $main['humidity'],
            'wind_speed' => $weatherData['wind']['speed'] ?? 0,
            'advice' => $this->getWeatherAdvice($weather['main'], $weather['description'])
        ];
    }

    /**
     * Tạo lời khuyên dựa trên thời tiết
     */
    private function getWeatherAdvice($mainCondition, $description)
    {
        $advices = [
            'Clear' => [
                'message' => '☀️ Trời nắng đẹp! Hãy mang theo kem chống nắng và nước uống.',
                'color' => 'warning'
            ],
            'Clouds' => [
                'message' => '☁️ Trời nhiều mây, thời tiết mát mẻ. Rất thích hợp để tham quan!',
                'color' => 'info'
            ],
            'Rain' => [
                'message' => '🌧️ Có mưa! Nhớ mang theo áo mưa hoặc ô che. Cẩn thận đường trơn trượt.',
                'color' => 'primary'
            ],
            'Thunderstorm' => [
                'message' => '⛈️ Có bão! Nên hoãn chuyến đi hoặc ở trong nhà để đảm bảo an toàn.',
                'color' => 'danger'
            ],
            'Snow' => [
                'message' => '❄️ Có tuyết! Mang theo quần áo ấm và giày chống trượt.',
                'color' => 'secondary'
            ],
            'Mist' => [
                'message' => '🌫️ Có sương mù! Lái xe cẩn thận và mang theo đèn pin.',
                'color' => 'secondary'
            ],
            'Fog' => [
                'message' => '🌫️ Có sương mù dày! Tầm nhìn hạn chế, lái xe cẩn thận.',
                'color' => 'secondary'
            ],
            'Haze' => [
                'message' => '😷 Không khí có bụi mịn! Nên đeo khẩu trang khi ra ngoài.',
                'color' => 'warning'
            ]
        ];

        // Kiểm tra từ khóa trong description để có lời khuyên cụ thể hơn
        $descriptionLower = strtolower($description);
        
        if (strpos($descriptionLower, 'heavy') !== false) {
            return [
                'message' => '⚠️ Thời tiết khắc nghiệt! Nên cân nhắc hoãn chuyến đi.',
                'color' => 'danger'
            ];
        }
        
        if (strpos($descriptionLower, 'light') !== false) {
            return [
                'message' => '🌦️ Mưa nhẹ, không ảnh hưởng nhiều. Vẫn có thể đi chơi!',
                'color' => 'info'
            ];
        }

        return $advices[$mainCondition] ?? [
            'message' => '🌤️ Thời tiết ổn định. Chúc bạn có chuyến đi vui vẻ!',
            'color' => 'success'
        ];
    }

    /**
     * Dữ liệu thời tiết mẫu khi không có API key
     */
    private function getSampleWeatherData($date)
    {
        $dayOfWeek = date('N', strtotime($date)); // 1 = Monday, 7 = Sunday
        
        $sampleData = [
            1 => [ // Monday
                'temperature' => 28,
                'description' => 'Nắng đẹp',
                'icon' => '01d',
                'advice' => [
                    'message' => '☀️ Trời nắng đẹp! Hãy mang theo kem chống nắng và nước uống.',
                    'color' => 'warning'
                ]
            ],
            2 => [ // Tuesday
                'temperature' => 26,
                'description' => 'Nhiều mây',
                'icon' => '02d',
                'advice' => [
                    'message' => '☁️ Trời nhiều mây, thời tiết mát mẻ. Rất thích hợp để tham quan!',
                    'color' => 'info'
                ]
            ],
            3 => [ // Wednesday
                'temperature' => 24,
                'description' => 'Mưa nhẹ',
                'icon' => '10d',
                'advice' => [
                    'message' => '🌦️ Mưa nhẹ, không ảnh hưởng nhiều. Vẫn có thể đi chơi!',
                    'color' => 'info'
                ]
            ],
            4 => [ // Thursday
                'temperature' => 30,
                'description' => 'Nắng nóng',
                'icon' => '01d',
                'advice' => [
                    'message' => '🔥 Trời nắng nóng! Nhớ mang theo nước và tránh nắng giữa trưa.',
                    'color' => 'danger'
                ]
            ],
            5 => [ // Friday
                'temperature' => 25,
                'description' => 'Thời tiết đẹp',
                'icon' => '02d',
                'advice' => [
                    'message' => '🌤️ Thời tiết đẹp! Hoàn hảo cho chuyến đi cuối tuần.',
                    'color' => 'success'
                ]
            ],
            6 => [ // Saturday
                'temperature' => 27,
                'description' => 'Nắng nhẹ',
                'icon' => '01d',
                'advice' => [
                    'message' => '☀️ Nắng nhẹ, thời tiết lý tưởng để tham quan.',
                    'color' => 'success'
                ]
            ],
            7 => [ // Sunday
                'temperature' => 23,
                'description' => 'Mát mẻ',
                'icon' => '03d',
                'advice' => [
                    'message' => '🌥️ Thời tiết mát mẻ, rất thích hợp để nghỉ ngơi.',
                    'color' => 'info'
                ]
            ]
        ];

        $weather = $sampleData[$dayOfWeek] ?? $sampleData[1];
        $weather['humidity'] = rand(60, 85);
        $weather['wind_speed'] = rand(3, 8);
        
        return $weather;
    }

    /**
     * Dữ liệu thời tiết mặc định khi không thể lấy từ API
     */
    private function getDefaultWeather()
    {
        return [
            'temperature' => 25,
            'description' => 'Thời tiết ổn định',
            'icon' => '01d',
            'humidity' => 70,
            'wind_speed' => 5,
            'advice' => [
                'message' => '🌤️ Thời tiết ổn định. Chúc bạn có chuyến đi vui vẻ!',
                'color' => 'success'
            ]
        ];
    }
}
