<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page non trouvée · TogoGreenFund</title>

    <!-- Source Sans 3 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --tgf-primary: #1B4D3E;
            --tgf-primary-dark: #0F3328;
            --tgf-accent: #F5A623;
            --tgf-accent-light: #FFC857;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Source Sans 3', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #F0F5F2;
            padding: 20px;
        }

        .error-container {
            text-align: center;
            max-width: 600px;
            background: #fff;
            padding: 60px 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(27, 77, 62, 0.15);
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-icon {
            font-size: 4rem;
            color: var(--tgf-accent);
            margin-bottom: 20px;
        }

        .error-icon i {
            display: inline-block;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .error-code {
            font-weight: 900;
            font-size: 5rem;
            color: var(--tgf-primary);
            line-height: 1;
            margin-bottom: 10px;
        }

        .error-title {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--tgf-primary);
            margin-bottom: 12px;
        }

        .error-message {
            color: #6B8A7E;
            font-size: 1.05rem;
            margin-bottom: 30px;
        }

        .btn-tgf {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 32px;
            background: var(--tgf-primary);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: 'Source Sans 3', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-tgf:hover {
            background: var(--tgf-primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(27, 77, 62, 0.25);
            color: #fff;
        }

        .btn-tgf i {
            color: var(--tgf-accent);
        }

        .error-hint {
            margin-top: 20px;
            color: #A0B8AC;
            font-size: 0.85rem;
        }

        @media (max-width: 480px) {
            .error-container {
                padding: 40px 20px;
            }

            .error-code {
                font-size: 3.5rem;
            }

            .error-title {
                font-size: 1.4rem;
            }

            .error-message {
                font-size: 0.9rem;
            }

            .btn-tgf {
                padding: 10px 24px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<div class="error-container">
    <div class="error-icon">
        <i class="fas fa-leaf"></i>
    </div>

    <div class="error-code">404</div>

    <h1 class="error-title">Page non trouvée</h1>

    <p class="error-message">
        Oups ! La page que vous recherchez n'existe pas ou a été déplacée.
    </p>

    <a href="{{ route('dashboard') }}" class="btn-tgf">
        <i class="fas fa-home"></i>
        Retourner au tableau de bord
    </a>

    <div class="error-hint">
        <i class="fas fa-arrow-left me-1"></i>
        Ou utilisez la navigation ci-dessus
    </div>
</div>

</body>
</html>
