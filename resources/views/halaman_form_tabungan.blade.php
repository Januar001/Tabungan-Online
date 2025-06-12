<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembukaan Tabungan - Bank Digital</title>
    @livewireStyles()
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #775fff;
            --secondary-color: #182da8;
            --accent-color: #e74c3c;
            --light-bg: #f8f9fa;
            --dark-text: #2c3e50;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-text);
        }

        .form-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 15px;
        }

        .form-header h2 {
            color: var(--primary-color);
            font-weight: 700;
        }

        .form-header .step-indicator {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }

        .simade-type-card {
            border: 2px solid #e0e0e0;
            border-radius: 1rem;
            background: #f8f9fa;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            min-width: 180px;
            max-width: 220px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            cursor: pointer;
        }

        .simade-type-card.active {
            border-color: #0d6efd;
            background: #eaf4ff;
            box-shadow: 0 4px 16px rgba(13, 110, 253, 0.08);
        }

        .simade-type-card:hover {
            border-color: #0d6efd;
        }

        .step {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            font-weight: bold;
            color: white;
        }

        .step.active {
            background-color: var(--primary-color);
        }

        .step.completed {
            background-color: var(--secondary-color);
        }

        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .required-field::after {
            content: " *";
            color: var(--accent-color);
        }

        .file-upload {
            border: 2px dashed #ddd;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .file-upload:hover {
            border-color: var(--primary-color);
            background-color: rgba(52, 152, 219, 0.05);
        }

        .file-upload i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .file-name {
            margin-top: 10px;
            font-size: 0.9rem;
            color: #666;
        }

        /* Updated product-card styles */
        .product-card {
            cursor: pointer;
            background: linear-gradient(135deg, #f8fafc 0%, #e9ecef 100%);
            box-shadow: 0 2px 12px 0 rgba(0,0,0,0.04);
            transition: box-shadow .2s, background .3s;
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
        }
        .product-card.selected {
            box-shadow: 0 6px 32px 0 rgba(0,123,255,0.13);
            border-width: 2px !important;
            background-color: rgba(52, 152, 219, 0.05);
        }
        .product-card.bg-primary-subtle {
            background: linear-gradient(135deg, #e3f0ff 0%, #f8fafc 100%) !important;
        }
        .product-card.bg-success-subtle {
            background: linear-gradient(135deg, #e6f9f0 0%, #f8fafc 100%) !important;
        }
        .product-card:hover,
        .product-card.selected {
            box-shadow: 0 6px 32px 0 rgba(0,123,255,0.13);
        }
        .product-card:hover .product-img,
        .product-card.selected .product-img {
            transform: scale(1.15);
            filter: drop-shadow(0 4px 12px rgba(0,0,0,0.10));
        }
        .product-img {
            transition: transform .3s, filter .3s;
        }

        .product-card .icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .conditional-field {
            display: none;
        }

        .summary-item {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .summary-item:last-child {
            border-bottom: none;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @livewire('form-tabungan')
            </div>
        </div>
    </div>
    <!-- Bootstrap 5 JS Bundle with Popper -->
    @livewireScripts()
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
