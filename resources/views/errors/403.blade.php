<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            overflow: hidden;
            position: relative;
        }

        /* Animated Background Circles */
        .bg-decoration {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            animation: float 20s infinite ease-in-out;
            backdrop-filter: blur(2px);
        }

        .circle:nth-child(1) {
            width: 400px;
            height: 400px;
            top: -200px;
            left: -200px;
            animation-delay: 0s;
        }

        .circle:nth-child(2) {
            width: 250px;
            height: 250px;
            bottom: -125px;
            right: -125px;
            animation-delay: 7s;
        }

        .circle:nth-child(3) {
            width: 180px;
            height: 180px;
            top: 50%;
            left: 10%;
            animation-delay: 14s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) scale(1);
                opacity: 0.8;
            }

            50% {
                transform: translateY(-60px) scale(1.15);
                opacity: 1;
            }
        }

        /* Main Container */
        .error-container {
            max-width: 520px;
            width: 100%;
            position: relative;
            z-index: 1;
        }

        .error-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25), 0 8px 16px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            animation: slideUp 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .error-header {
            background: linear-gradient(135deg, #b91c1c 0%, #dc2626 50%, #ef4444 100%);
            padding: 2rem 1.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .error-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .error-icon {
            width: 85px;
            height: 85px;
            background: rgba(255, 255, 255, 0.15);
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            animation: pulse 2.5s infinite cubic-bezier(0.455, 0.03, 0.515, 0.955);
            position: relative;
            z-index: 1;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
            }

            50% {
                transform: scale(1.08);
                box-shadow: 0 0 0 15px rgba(255, 255, 255, 0);
            }
        }

        .error-icon i {
            font-size: 3rem;
            color: white;
        }

        .error-code {
            font-size: 4rem;
            font-weight: 900;
            color: white;
            margin-bottom: 0.5rem;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            letter-spacing: -2px;
            position: relative;
            z-index: 1;
        }

        .error-title {
            font-size: 1.375rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 0;
            position: relative;
            z-index: 1;
            letter-spacing: 0.3px;
        }

        .error-body {
            padding: 1.75rem 1.5rem;
            text-align: center;
        }

        .error-message {
            font-size: 1rem;
            color: #64748b;
            margin-bottom: 1.5rem;
            line-height: 1.6;
            font-weight: 500;
        }

        .error-details {
            background: linear-gradient(to right, #fef2f2, #fff);
            border-left: 4px solid #ef4444;
            padding: 1rem 1.125rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            text-align: left;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.08);
        }

        .error-details p {
            margin: 0;
            color: #475569;
            font-size: 0.875rem;
            line-height: 1.6;
        }

        .error-details strong {
            color: #dc2626;
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .error-details strong i {
            margin-right: 0.5rem;
        }

        .btn-group-custom {
            display: flex;
            gap: 0.875rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-custom {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-custom::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.5s, height 0.5s;
        }

        .btn-custom:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-custom span,
        .btn-custom i {
            position: relative;
            z-index: 1;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
            color: white;
        }

        .btn-secondary-custom {
            background: #f8fafc;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        .btn-secondary-custom:hover {
            background: #f1f5f9;
            color: #475569;
            border-color: #cbd5e1;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .btn-custom i {
            font-size: 1rem;
        }

        .footer-info {
            text-align: center;
            margin-top: 1.25rem;
            animation: fadeIn 1s ease-out 0.3s both;
        }

        .footer-info p {
            color: rgba(255, 255, 255, 0.95);
            font-size: 0.8125rem;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-weight: 500;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <!-- Background Decoration -->
    <div class="bg-decoration">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>

    <!-- Error Container -->
    <div class="error-container">
        <div class="error-card">
            <!-- Header -->
            <div class="error-header">
                <div class="error-icon">
                    <i class="bi bi-shield-x"></i>
                </div>
                <h1 class="error-code">403</h1>
                <h2 class="error-title">Akses Ditolak</h2>
            </div>

            <!-- Body -->
            <div class="error-body">
                <div class="error-message">
                    Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
                </div>

                <div class="error-details">
                    <strong>
                        <i class="bi bi-info-circle"></i>
                        Detail Error
                    </strong>
                    <p>{{ $exception->getMessage() ?? 'Akses ditolak. Anda tidak memiliki hak akses yang diperlukan.' }}
                    </p>
                </div>

                <div class="btn-group-custom">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-custom btn-primary-custom">
                            <i class="bi bi-house-door"></i>
                            <span>Kembali ke Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-custom btn-primary-custom">
                            <i class="bi bi-box-arrow-in-right"></i>
                            <span>Login</span>
                        </a>
                    @endauth

                    <button onclick="window.history.back()" class="btn-custom btn-secondary-custom">
                        <i class="bi bi-arrow-left"></i>
                        <span>Kembali</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="footer-info">
            <p>
                <i class="bi bi-question-circle"></i>
                Butuh bantuan? Hubungi administrator sistem.
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
