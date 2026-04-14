<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Libros - Perpustakaan Digital' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --font-sans: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
        }
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-display {
            font-family: 'Sora', sans-serif;
        }

        .bg-shell {
            background: radial-gradient(circle at 10% 10%, #1e3a5f 0%, transparent 36%),
                radial-gradient(circle at 90% 20%, #124f43 0%, transparent 32%),
                linear-gradient(145deg, #0f172a 0%, #111827 46%, #1f2937 100%);
        }

        .aurora {
            position: fixed;
            inset: 0;
            pointer-events: none;
            background: radial-gradient(circle at 70% 80%, rgba(34, 211, 238, 0.15), transparent 30%),
                radial-gradient(circle at 20% 70%, rgba(45, 212, 191, 0.15), transparent 30%);
        }

        .glass {
            border-radius: 1.2rem;
            backdrop-filter: blur(14px);
            box-shadow: 0 20px 35px rgba(2, 6, 23, 0.28);
        }

        .panel {
            border: 1px solid rgba(148, 163, 184, 0.28);
            border-radius: 1.2rem;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.78), rgba(30, 41, 59, 0.68));
            box-shadow: 0 16px 34px rgba(2, 6, 23, 0.24);
        }

        .eyebrow {
            font-size: 0.73rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: rgba(103, 232, 249, 0.9);
        }

        .stat-card {
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 1rem;
            padding: 0.9rem;
            background: rgba(15, 23, 42, 0.7);
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.8rem;
            background: linear-gradient(90deg, #14b8a6, #22d3ee);
            color: #022c22;
            font-weight: 700;
            padding: 0.62rem 1rem;
            transition: transform 0.2s ease, filter 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            filter: brightness(1.05);
        }

        .btn-danger {
            border-radius: 0.72rem;
            border: 1px solid rgba(251, 113, 133, 0.5);
            color: #fecdd3;
            font-weight: 600;
            padding: 0.45rem 0.8rem;
            background: rgba(159, 18, 57, 0.25);
        }

        .chip {
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, 0.35);
            color: #cbd5e1;
            background: rgba(15, 23, 42, 0.45);
            padding: 0.42rem 0.9rem;
            font-weight: 600;
        }

        .field {
            display: grid;
        }

        .field-input {
            border-radius: 0.8rem;
            border: 1px solid rgba(148, 163, 184, 0.28);
            background: rgba(15, 23, 42, 0.5);
            color: #e2e8f0;
            padding: 0.68rem 0.86rem;
            font-weight: 500;
            transition: border-color 0.2s ease;
        }

        .field-input:focus {
            outline: none;
            border-color: rgba(34, 211, 238, 0.6);
        }

        .link-nav {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .link-nav:hover {
            color: #67e8f9;
        }

        .menu-card {
            border-radius: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.2);
            padding: 1.2rem;
            background: rgba(30, 41, 59, 0.5);
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
        }

        .menu-card:hover {
            border-color: rgba(107, 230, 212, 0.4);
            background: rgba(15, 23, 42, 0.8);
            transform: translateY(-2px);
        }

        .table-row {
            border-bottom: 1px solid rgba(148, 163, 184, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: rgba(15, 23, 42, 0.6);
            padding: 0.8rem;
            text-align: left;
            font-weight: 600;
            color: #67e8f9;
        }

        td {
            padding: 0.8rem;
            color: #e2e8f0;
        }

        tr:hover {
            background: rgba(34, 211, 238, 0.05);
        }
    </style>
</head>

<body class="bg-shell text-slate-100 min-h-screen antialiased">
    <div class="aurora"></div>
    <div class="relative z-10 min-h-screen px-4 py-6 md:px-8">
        <div class="mx-auto w-full max-w-7xl">
            @auth
                @include('partials.nav')
            @endauth

            @if (session('success'))
                <div class="glass mb-6 border border-emerald-300/40 bg-emerald-300/10 p-4 text-emerald-100">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="glass mb-6 border border-rose-300/40 bg-rose-300/10 p-4 text-rose-100">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>

</html>
