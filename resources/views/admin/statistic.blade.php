@extends('admin.index')

@section('content')
<div class="col-md-12 content">
    <div class="row content-header">
        <div class="col-md-3">
            <div class="metric border-blue">
                <div class="row">
                    <div class="col-md-3 content-header-icon">
                        <i class="nav-icon fa-solid fa-user-circle"></i>
                    </div>
                    <div class="col-md-9 text-center">
                        <h5 class="pad-10">Tổng số nhân viên </h5>
                        <h3>{{ $statistics['totalStaff'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric">
                <div class="row">
                    <div class="col-md-3 content-header-icon">
                        <i class="nav-icon fa-solid fa-hospital-user"></i>
                    </div>
                    <div class="col-md-9 text-center">
                        <h5 class="pad-10">Tổng số khách hàng</h5>
                        <h3>{{ $statistics['totalClient'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric">
                <div class="row">
                    <div class="col-md-3 content-header-icon">
                        <i class="fa-regular fa-calendar-check"></i>
                    </div>
                    <div class="col-md-9 text-center">
                        <h5 class="pad-10">Số lịch hẹn chưa hoàn thành</h5>
                        <h3>{{ $statistics['pendingAppointment'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric">
                <div class="row">
                    <div class="col-md-3 content-header-icon">
                        <i class="fa-regular fa-image"></i>
                    </div>
                    <div class="col-md-9 text-center">
                        <h5 class="pad-10">Tổng số gói chụp </h5>
                        <h3>{{ $statistics['totalConcept'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row content-body">
        <!-- Biểu đồ cột với phần chọn năm -->
        <div class="col-md-8">
            <div class="container barChart rounded">
                <form id="yearForm" class="d-flex align-items-center gap-3">
                    <label for="yearSelect"><b>Chọn Năm:</b></label>
                    <select id="yearSelect" class="form-control" style="width: 15%;">
                        @php
                            $currentYear = date('Y');
                            for ($year = $currentYear - 3; $year <= $currentYear; $year++) {
                                echo "<option value='$year' " . ($year == $selectedYear ? 'selected' : '') . ">$year</option>";
                            }
                        @endphp
                    </select>
                </form>
                <canvas id="chartRevenue"></canvas>
                <h5 class="text-center">Biểu đồ thống kê doanh thu hàng tháng</h5>
            </div>
        </div>

        <!-- Biểu đồ tròn -->
        <div class="col-md-4">
            <div class="container pieChart rounded">
                <form id="monthForm" class="d-flex align-items-center gap-3">
                    <label for="monthSelect"><b>Chọn Tháng:</b></label>
                    <input type="month" id="monthSelect" class="form-control" style="width: 45%;" 
                        value="{{ $selectedMonth }}">
                </form>
                <canvas id="pieChartRevenue"></canvas>
                <div id="noDataMessage" class="text-center text-muted mt-3" style="display: none;">
                    <em>Chưa có dữ liệu tháng này</em>
                </div>
                <h5 class="text-center" style="margin-top: 23px;">Biểu đồ tỉ lệ sử dụng concept</h5>
            </div>
        </div>
    </div>

</div>

<style>
    .metric {
        border: 1px solid black;
        padding: 25px;
        background: linear-gradient(to bottom,rgb(227, 236, 215), #9ad4b1);
        border-radius: 15px;
        height: 100%;
    }
    .pad-10 {
        padding-top: 10px;
    }
    .content-header {
        padding-top: 10px;
    }
    .content-header-icon {
        font-size: 60px;
    }

    .content-body {
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .chart-revenue {
        margin: 0 auto;
    }
    .checkRevenueYear {
        margin-top: 25px;
    }
    .btn-checkRevenue {
        bottom: 20px;
        left: 20px;
        padding: 10px 20px;
        background: linear-gradient(to left, #3cabb1, #2a7d8c);
        color: white;
        border-radius: 10px;
        text-decoration: none;
        font-size: 15px;
        vertical-align: middle;
        margin-left: 10px; 
        border-right: 1px solid black;
    }
    .barChart {
        border: 1px solid rgb(113, 211, 126);
        height: 100%;
        width: 100%;
    }
    .pieChart {
        border: 1px solid rgb(113, 211, 126);
        height: 100%;
        width: 100%;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    /**
     * Script for bar chart view
     */
    
    const revenueData = {!! json_encode($revenueData) !!};

    // Tạo một danh sách doanh thu với đủ 12 tháng
    const revenueMap = new Map(revenueData.map(item => [item.month, item.total_revenue]));

    const labels = Array.from({ length: 12 }, (_, i) => `Tháng ${i + 1}`);
    const data = labels.map((_, i) => revenueMap.get(i + 1) || 0); // Nếu tháng nào không có dữ liệu thì gán 0

    const barChartData = {
        labels: labels,
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: data,
            backgroundColor: 'rgb(54, 162, 235)',
        }]
    };

    const ctxBarChart = document.getElementById('chartRevenue').getContext('2d');
    new Chart(ctxBarChart, {
        type: 'bar',
        data: barChartData,
        options: { responsive: true }
    });

    // Khi chọn năm mới, tải lại trang với dữ liệu năm đó
    document.getElementById('yearSelect').addEventListener('change', (event) => {
        const selectedYear = event.target.value;
        window.location.href = `/admin/statistic?year=${selectedYear}`;
    });

    /**
     * Script for pie chart view
     */

    const conceptUsageData = {!! json_encode($conceptUsageData) !!};

    // Khởi tạo dữ liệu biểu đồ
    function updatePieChart(conceptUsageData) {
        const ctxPieChart = document.getElementById('pieChartRevenue').getContext('2d');
        const noDataMessage = document.getElementById('noDataMessage');

        if (!conceptUsageData || conceptUsageData.length === 0) {
            // Ẩn biểu đồ, hiện thông báo
            document.getElementById('pieChartRevenue').style.display = 'none';
            noDataMessage.style.display = 'block';
            return;
        }

        // Có dữ liệu: hiển thị biểu đồ, ẩn thông báo
        document.getElementById('pieChartRevenue').style.display = 'block';
        noDataMessage.style.display = 'none';

        const pieChartData = {
            labels: conceptUsageData.map(item => item.name),
            datasets: [{
                label: 'Số lần sử dụng concept',
                data: conceptUsageData.map(item => item.usage_count),
                backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)'],
            }]
        };

        new Chart(ctxPieChart, {
            type: 'pie',
            data: pieChartData,
            options: { responsive: true }
        });
    }


    // Cập nhật biểu đồ với dữ liệu hiện tại khi trang tải
    updatePieChart(conceptUsageData);

    // Xử lý thay đổi tháng, tải lại trang với tháng mới
    document.getElementById('monthSelect').addEventListener('change', (event) => {
        const selectedMonth = event.target.value;
        window.location.href = `/admin/statistic?month=${selectedMonth}`; // Chuyển trang với tháng mới
    });
</script>
@endsection
