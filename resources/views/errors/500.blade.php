<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Erreur serveur · TogoGreenFund</title>

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
            --tgf-danger: #DC3545;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

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
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .error-icon {
            font-size: 4rem;
            color: var(--tgf-danger);
            margin-bottom: 20px;
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

        .btn-tgf i { color: var(--tgf-accent); }
        .btn-tgf .fas.fa-redo { color: #fff; }
    </style>
</head>
<body>

<div class="error-container">
    <div class="error-icon">
        <i class="fas fa-exclamation-triangle"></i>
    </div>

    <div class="error-code">500</div>

    <h1 class="error-title">Erreur serveur</h1>

    <p class="error-message">
        Une erreur interne est survenue. Nous travaillons à résoudre le problème.
    </p>

    <a href="{{ route('dashboard') }}" class="btn-tgf">
        <i class="fas fa-home"></i>
        Retourner au tableau de bord
    </a>

    <div class="mt-3">
        <button onclick="location.reload()" class="btn-tgf" style="background: var(--tgf-accent);">
            <i class="fas fa-redo"></i>
            Réessayer
        </button>
    </div>
</div>

</body>
</html>
