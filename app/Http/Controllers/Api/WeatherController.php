<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * Lấy thông tin thời tiết cho ngày cụ thể
     */
    public function getWeather(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'date' => 'required|date|after_or_equal:today',
                'city' => 'nullable|string|max:255'
            ]);

            $date = $request->input('date');
            $city = $request->input('city', 'Hanoi');
            
            $weather = $this->weatherService->getWeatherForDate($date, $city);
            
            return response()->json([
                'success' => true,
                'data' => $weather
            ], 200, [
                'Content-Type' => 'application/json; charset=utf-8',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422, [
                'Content-Type' => 'application/json; charset=utf-8'
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            \Log::error('Weather API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể lấy thông tin thời tiết',
                'error' => $e->getMessage()
            ], 500, [
                'Content-Type' => 'application/json; charset=utf-8'
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}
