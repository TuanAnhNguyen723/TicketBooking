document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.chartConfig !== 'undefined') {
        // Tạo URL với parameters
        var chartUrl = window.chartConfig.url;
        var params = 'period=' + window.chartConfig.period + 
                    '&start_date=' + window.chartConfig.startDate + 
                    '&end_date=' + window.chartConfig.endDate + 
                    '&ticket_type=' + window.chartConfig.ticketType;
        
        // Lấy dữ liệu cho biểu đồ
        fetch(chartUrl + '?' + params)
        .then(response => response.json())
        .then(data => {
            // Vẽ biểu đồ
            const ctx = document.getElementById('revenueChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Doanh thu (₫)',
                        data: data.revenue,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Biểu đồ Doanh thu theo ' + (window.chartConfig.period === 'day' ? 'Ngày' : 
                                                               window.chartConfig.period === 'month' ? 'Tháng' : 'Năm')
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat('vi-VN').format(value) + ' ₫';
                                }
                            }
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error loading chart data:', error);
        });
    }
});
