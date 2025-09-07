@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Dashboard</li>
@stop

@section('admin-content')
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-card">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h2 class="welcome-title">Welcome back, {{ Auth::user()->name }}! 👋</h2>
                        <p class="welcome-subtitle">Here's what's happening with your jewelry marketplace today.</p>
                    </div>
                    <div class="welcome-stats">
                        <div class="stat-item">
                            <div class="stat-number">{{ date('d') }}</div>
                            <div class="stat-label">{{ date('M Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="modern-stat-card bg-gradient-primary">
                <div class="card-body">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">1,247</div>
                        <div class="stat-label">Total Orders</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> +12.5%
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="modern-stat-card bg-gradient-success">
                <div class="card-body">
                    <div class="stat-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">₹8,92,470</div>
                        <div class="stat-label">Total Revenue</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> +8.2%
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="modern-stat-card bg-gradient-warning">
                <div class="card-body">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">2,847</div>
                        <div class="stat-label">Active Users</div>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> +15.3%
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="modern-stat-card bg-gradient-info">
                <div class="card-body">
                    <div class="stat-icon">
                        <i class="fas fa-gem"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">847</div>
                        <div class="stat-label">Products</div>
                        <div class="stat-change negative">
                            <i class="fas fa-arrow-down"></i> -2.1%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <!-- Sales Analytics -->
        <div class="col-xl-8 mb-4">
            <div class="modern-card">
                <div class="card-header">
                    <div class="card-title">
                        <h5 class="mb-0">Sales Analytics</h5>
                        <small class="text-muted">Monthly revenue overview</small>
                    </div>
                    <div class="card-actions">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary active">7D</button>
                            <button type="button" class="btn btn-sm btn-outline-primary">30D</button>
                            <button type="button" class="btn btn-sm btn-outline-primary">90D</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="col-xl-4 mb-4">
            <div class="modern-card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Stats</h5>
                </div>
                <div class="card-body">
                    <div class="quick-stat-item">
                        <div class="quick-stat-icon bg-primary">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="quick-stat-content">
                            <div class="quick-stat-number">24,847</div>
                            <div class="quick-stat-label">Page Views</div>
                        </div>
                        <div class="quick-stat-trend">
                            <span class="trend-up">+5.2%</span>
                        </div>
                    </div>
                    
                    <div class="quick-stat-item">
                        <div class="quick-stat-icon bg-success">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="quick-stat-content">
                            <div class="quick-stat-number">1,247</div>
                            <div class="quick-stat-label">Orders Today</div>
                        </div>
                        <div class="quick-stat-trend">
                            <span class="trend-up">+12.5%</span>
                        </div>
                    </div>
                    
                    <div class="quick-stat-item">
                        <div class="quick-stat-icon bg-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="quick-stat-content">
                            <div class="quick-stat-number">47</div>
                            <div class="quick-stat-label">Pending Orders</div>
                        </div>
                        <div class="quick-stat-trend">
                            <span class="trend-down">-8.1%</span>
                        </div>
                    </div>
                    
                    <div class="quick-stat-item">
                        <div class="quick-stat-icon bg-info">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="quick-stat-content">
                            <div class="quick-stat-number">4.8</div>
                            <div class="quick-stat-label">Avg Rating</div>
                        </div>
                        <div class="quick-stat-trend">
                            <span class="trend-up">+0.3</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Top Products -->
    <div class="row mb-4">
        <!-- Recent Orders -->
        <div class="col-xl-8 mb-4">
            <div class="modern-card">
                <div class="card-header">
                    <div class="card-title">
                        <h5 class="mb-0">Recent Orders</h5>
                        <small class="text-muted">Latest customer orders</small>
                    </div>
                    <div class="card-actions">
                        <a href="#" class="btn btn-sm btn-primary">View All</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table modern-table mb-0">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="order-id">#ORD-2024-001</span>
                                    </td>
                                    <td>
                                        <div class="customer-info">
                                            <img src="https://ui-avatars.com/api/?name=John+Doe&background=007bff&color=fff&size=32" alt="Customer" class="customer-avatar">
                                            <div class="customer-details">
                                                <div class="customer-name">John Doe</div>
                                                <div class="customer-email">john@example.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="product-info">
                                            <div class="product-name">Diamond Ring</div>
                                            <div class="product-sku">SKU: DR-001</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="amount">₹2,49,900</span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-completed">Completed</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-success" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="order-id">#ORD-2024-002</span>
                                    </td>
                                    <td>
                                        <div class="customer-info">
                                            <img src="https://ui-avatars.com/api/?name=Jane+Smith&background=28a745&color=fff&size=32" alt="Customer" class="customer-avatar">
                                            <div class="customer-details">
                                                <div class="customer-name">Jane Smith</div>
                                                <div class="customer-email">jane@example.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="product-info">
                                            <div class="product-name">Gold Necklace</div>
                                            <div class="product-sku">SKU: GN-002</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="amount">₹1,29,900</span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-pending">Pending</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-success" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="order-id">#ORD-2024-003</span>
                                    </td>
                                    <td>
                                        <div class="customer-info">
                                            <img src="https://ui-avatars.com/api/?name=Bob+Johnson&background=ffc107&color=000&size=32" alt="Customer" class="customer-avatar">
                                            <div class="customer-details">
                                                <div class="customer-name">Bob Johnson</div>
                                                <div class="customer-email">bob@example.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="product-info">
                                            <div class="product-name">Silver Bracelet</div>
                                            <div class="product-sku">SKU: SB-003</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="amount">₹59,900</span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-processing">Processing</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-success" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Top Sellers -->
        <div class="col-xl-4 mb-4">
            <div class="modern-card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Top Sellers</h5>
                </div>
                <div class="card-body">
                    <div class="seller-item">
                        <div class="seller-avatar">
                            <img src="https://ui-avatars.com/api/?name=Luxury+Gems&background=007bff&color=fff&size=40" alt="Seller">
                        </div>
                        <div class="seller-info">
                            <div class="seller-name">Luxury Gems</div>
                            <div class="seller-sales">₹45,28,000 in sales</div>
                        </div>
                        <div class="seller-badge">
                            <span class="badge badge-gold">Gold</span>
                        </div>
                    </div>
                    
                    <div class="seller-item">
                        <div class="seller-avatar">
                            <img src="https://ui-avatars.com/api/?name=Diamond+Palace&background=28a745&color=fff&size=40" alt="Seller">
                        </div>
                        <div class="seller-info">
                            <div class="seller-name">Diamond Palace</div>
                            <div class="seller-sales">₹38,95,000 in sales</div>
                        </div>
                        <div class="seller-badge">
                            <span class="badge badge-silver">Silver</span>
                        </div>
                    </div>
                    
                    <div class="seller-item">
                        <div class="seller-avatar">
                            <img src="https://ui-avatars.com/api/?name=Golden+Touch&background=ffc107&color=000&size=40" alt="Seller">
                        </div>
                        <div class="seller-info">
                            <div class="seller-name">Golden Touch</div>
                            <div class="seller-sales">₹32,47,000 in sales</div>
                        </div>
                        <div class="seller-badge">
                            <span class="badge badge-bronze">Bronze</span>
                        </div>
                    </div>
                    
                    <div class="seller-item">
                        <div class="seller-avatar">
                            <img src="https://ui-avatars.com/api/?name=Precious+Stones&background=dc3545&color=fff&size=40" alt="Seller">
                        </div>
                        <div class="seller-info">
                            <div class="seller-name">Precious Stones</div>
                            <div class="seller-sales">₹28,19,000 in sales</div>
                        </div>
                        <div class="seller-badge">
                            <span class="badge badge-regular">Regular</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="row">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Performance Metrics</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="metric-card">
                                <div class="metric-icon bg-primary">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="metric-content">
                                    <div class="metric-title">Conversion Rate</div>
                                    <div class="metric-value">3.24%</div>
                                    <div class="metric-progress">
                                        <div class="progress">
                                            <div class="progress-bar bg-primary" style="width: 65%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="metric-card">
                                <div class="metric-icon bg-success">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="metric-content">
                                    <div class="metric-title">Avg. Order Time</div>
                                    <div class="metric-value">2.5 min</div>
                                    <div class="metric-progress">
                                        <div class="progress">
                                            <div class="progress-bar bg-success" style="width: 80%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="metric-card">
                                <div class="metric-icon bg-warning">
                                    <i class="fas fa-undo"></i>
                                </div>
                                <div class="metric-content">
                                    <div class="metric-title">Return Rate</div>
                                    <div class="metric-value">1.8%</div>
                                    <div class="metric-progress">
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" style="width: 25%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="metric-card">
                                <div class="metric-icon bg-info">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="metric-content">
                                    <div class="metric-title">Customer Satisfaction</div>
                                    <div class="metric-value">4.8/5</div>
                                    <div class="metric-progress">
                                        <div class="progress">
                                            <div class="progress-bar bg-info" style="width: 96%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('css')
    <style>
        /* Modern Dashboard Styles */
        .content-wrapper {
            background: #ffffff !important;
            min-height: 100vh;
            padding: 15px;
        }
        
        .admin-content-area {
            background: #ffffff;
            border-radius: 0;
            padding: 0;
        }
        
        /* Welcome Card */
        .welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 30px;
            color: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .welcome-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .welcome-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .welcome-subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 0;
        }
        
        .welcome-stats .stat-item {
            text-align: center;
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 20px;
            backdrop-filter: blur(10px);
        }
        
        .welcome-stats .stat-number {
            font-size: 1.8rem;
            font-weight: 600;
        }
        
        .welcome-stats .stat-label {
            font-size: 0.75rem;
            opacity: 0.8;
        }
        
        /* Modern Stat Cards */
        .modern-stat-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
        }
        
        .modern-stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .modern-stat-card .card-body {
            padding: 30px;
            display: flex;
            align-items: center;
            color: white;
        }
        
        .modern-stat-card .stat-icon {
            font-size: 3rem;
            opacity: 0.3;
            margin-right: 20px;
        }
        
        .modern-stat-card .stat-content {
            flex: 1;
        }
        
        .modern-stat-card .stat-number {
            font-size: 1.8rem;
            font-weight: 600;
            line-height: 1;
            margin-bottom: 4px;
        }
        
        .modern-stat-card .stat-label {
            font-size: 0.85rem;
            opacity: 0.9;
            margin-bottom: 8px;
        }
        
        .modern-stat-card .stat-change {
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .modern-stat-card .stat-change.positive {
            color: rgba(255,255,255,0.9);
        }
        
        .modern-stat-card .stat-change.negative {
            color: rgba(255,255,255,0.7);
        }
        
        /* Modern Cards */
        .modern-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            background: white;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .modern-card:hover {
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        
        .modern-card .card-header {
            background: white;
            border-bottom: 1px solid #f0f0f0;
            padding: 25px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modern-card .card-title h5 {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 4px;
            font-size: 1.1rem;
        }
        
        .modern-card .card-body {
            padding: 30px;
        }
        
        /* Quick Stats */
        .quick-stat-item {
            display: flex;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .quick-stat-item:last-child {
            border-bottom: none;
        }
        
        .quick-stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            margin-right: 15px;
        }
        
        .quick-stat-content {
            flex: 1;
        }
        
        .quick-stat-number {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            line-height: 1;
        }
        
        .quick-stat-label {
            font-size: 0.8rem;
            color: #7f8c8d;
            margin-top: 2px;
        }
        
        .quick-stat-trend {
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .trend-up {
            color: #27ae60;
        }
        
        .trend-down {
            color: #e74c3c;
        }
        
        /* Modern Table */
        .modern-table {
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .modern-table thead th {
            background: #f8f9fa;
            border: none;
            padding: 20px 25px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .modern-table tbody td {
            padding: 20px 25px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }
        
        .modern-table tbody tr:hover {
            background: #f8f9fa;
        }
        
        .order-id {
            font-weight: 600;
            color: #3498db;
        }
        
        .customer-info {
            display: flex;
            align-items: center;
        }
        
        .customer-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 15px;
        }
        
        .customer-name {
            font-weight: 500;
            color: #2c3e50;
            font-size: 0.8rem;
        }
        
        .customer-email {
            font-size: 0.7rem;
            color: #7f8c8d;
        }
        
        .product-name {
            font-weight: 500;
            color: #2c3e50;
            font-size: 0.8rem;
        }
        
        .product-sku {
            font-size: 0.7rem;
            color: #7f8c8d;
        }
        
        .amount {
            font-weight: 600;
            color: #27ae60;
            font-size: 0.85rem;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 15px;
            font-size: 0.7rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .status-completed {
            background: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-processing {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .action-buttons .btn {
            margin-right: 5px;
            border-radius: 8px;
        }
        
        /* Seller Items */
        .seller-item {
            display: flex;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .seller-item:last-child {
            border-bottom: none;
        }
        
        .seller-avatar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }
        
        .seller-info {
            flex: 1;
        }
        
        .seller-name {
            font-weight: 500;
            color: #2c3e50;
            font-size: 0.8rem;
        }
        
        .seller-sales {
            font-size: 0.7rem;
            color: #7f8c8d;
        }
        
        .badge-gold {
            background: linear-gradient(45deg, #f39c12, #e67e22);
            color: white;
        }
        
        .badge-silver {
            background: linear-gradient(45deg, #95a5a6, #7f8c8d);
            color: white;
        }
        
        .badge-bronze {
            background: linear-gradient(45deg, #d35400, #e67e22);
            color: white;
        }
        
        .badge-regular {
            background: #ecf0f1;
            color: #2c3e50;
        }
        
        /* Metric Cards */
        .metric-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            display: flex;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        
        .metric-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }
        
        .metric-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-right: 20px;
        }
        
        .metric-content {
            flex: 1;
        }
        
        .metric-title {
            font-size: 0.75rem;
            color: #7f8c8d;
            margin-bottom: 4px;
        }
        
        .metric-value {
            font-size: 1.4rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }
        
        .metric-progress .progress {
            height: 6px;
            border-radius: 3px;
            background: #ecf0f1;
        }
        
        .metric-progress .progress-bar {
            border-radius: 3px;
        }
        
        /* Enhanced Responsive Design */
        @media (max-width: 1200px) {
            .content-wrapper {
                padding: 10px;
            }
            
            .modern-card .card-header,
            .modern-card .card-body {
                padding: 20px;
            }
            
            .welcome-title {
                font-size: 1.3rem;
            }
            
            .modern-stat-card .stat-number {
                font-size: 1.6rem;
            }
        }
        
        @media (max-width: 992px) {
            .welcome-content {
                flex-direction: column;
                text-align: center;
            }
            
            .welcome-stats {
                margin-top: 15px;
            }
            
            .modern-stat-card .card-body {
                padding: 15px;
            }
            
            .quick-stat-item {
                padding: 15px 0;
            }
            
            .seller-item {
                padding: 15px 0;
            }
        }
        
        @media (max-width: 768px) {
            .content-wrapper {
                padding: 8px;
            }
            
            .welcome-card {
                padding: 20px;
                margin-bottom: 20px;
            }
            
            .welcome-title {
                font-size: 1.2rem;
            }
            
            .welcome-subtitle {
                font-size: 0.8rem;
            }
            
            .modern-stat-card .card-body {
                padding: 12px;
            }
            
            .modern-stat-card .stat-number {
                font-size: 1.4rem;
            }
            
            .modern-stat-card .stat-label {
                font-size: 0.75rem;
            }
            
            .modern-card .card-header,
            .modern-card .card-body {
                padding: 15px;
            }
            
            .modern-table thead th,
            .modern-table tbody td {
                padding: 12px 15px;
            }
            
            .customer-avatar,
            .seller-avatar img {
                width: 30px;
                height: 30px;
            }
            
            .metric-card {
                padding: 15px;
                margin-bottom: 15px;
            }
            
            .metric-icon {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
                margin-right: 15px;
            }
            
            .metric-value {
                font-size: 1.2rem;
            }
        }
        
        @media (max-width: 576px) {
            .content-wrapper {
                padding: 5px;
            }
            
            .welcome-card {
                padding: 15px;
            }
            
            .welcome-title {
                font-size: 1.1rem;
            }
            
            .modern-stat-card .card-body {
                padding: 10px;
                flex-direction: column;
                text-align: center;
            }
            
            .modern-stat-card .stat-icon {
                margin-right: 0;
                margin-bottom: 10px;
                font-size: 2rem;
            }
            
            .modern-stat-card .stat-number {
                font-size: 1.3rem;
            }
            
            .modern-card .card-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .card-actions {
                margin-top: 10px;
            }
            
            .modern-table {
                font-size: 0.75rem;
            }
            
            .modern-table thead th,
            .modern-table tbody td {
                padding: 8px 10px;
            }
            
            .customer-info {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .customer-avatar {
                margin-bottom: 5px;
                margin-right: 0;
            }
            
            .action-buttons {
                display: flex;
                flex-direction: column;
            }
            
            .action-buttons .btn {
                margin-bottom: 2px;
                margin-right: 0;
            }
            
            .quick-stat-item,
            .seller-item {
                padding: 10px 0;
            }
            
            .metric-card {
                padding: 10px;
                flex-direction: column;
                text-align: center;
            }
            
            .metric-icon {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        $(function () {
            // Initialize Sales Chart
            const ctx = document.getElementById('salesChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                        datasets: [{
                            label: 'Revenue',
                            data: [120000, 190000, 150000, 250000, 220000, 300000, 280000],
                            borderColor: '#667eea',
                            backgroundColor: 'rgba(102, 126, 234, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#667eea',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#7f8c8d'
                                }
                            },
                            y: {
                                grid: {
                                    color: '#f0f0f0'
                                },
                                ticks: {
                                    color: '#7f8c8d',
                                    callback: function(value) {
                                        return '₹' + value.toLocaleString('en-IN');
                                    }
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });
            }
            
            // Animate numbers on load
            $('.stat-number, .quick-stat-number, .metric-value').each(function() {
                const $this = $(this);
                const countTo = parseInt($this.text().replace(/[^0-9]/g, ''));
                if (countTo) {
                    $({ countNum: 0 }).animate({
                        countNum: countTo
                    }, {
                        duration: 2000,
                        easing: 'swing',
                        step: function() {
                            const prefix = $this.text().match(/^\$/) ? '$' : '';
                            const suffix = $this.text().match(/\%$/) ? '%' : '';
                            $this.text(prefix + Math.floor(this.countNum).toLocaleString() + suffix);
                        },
                        complete: function() {
                            const prefix = $this.text().match(/^\$/) ? '$' : '';
                            const suffix = $this.text().match(/\%$/) ? '%' : '';
                            $this.text(prefix + this.countNum.toLocaleString() + suffix);
                        }
                    });
                }
            });
            
            // Add hover effects to cards
            $('.modern-stat-card, .modern-card, .metric-card').hover(
                function() {
                    $(this).addClass('shadow-lg');
                },
                function() {
                    $(this).removeClass('shadow-lg');
                }
            );
            
            console.log('Modern Dashboard UI loaded successfully!');
        });
    </script>
@endpush