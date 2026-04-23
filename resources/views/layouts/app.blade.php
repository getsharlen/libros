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
            --font-display: 'Sora', sans-serif;
            --brand-50: #fff7ed;
            --brand-100: #ffedd5;
            --brand-200: #fed7aa;
            --brand-300: #fdba74;
            --brand-400: #fb923c;
            --brand-500: #f97316;
            --brand-600: #ea580c;
            --slate-900: #0f172a;
            --surface: #ffffff;
            --line: #e2e8f0;
        }
        
        body {
            font-family: var(--font-sans);
            color: #1e293b;
        }

        .font-display {
            font-family: var(--font-display);
        }

        .bg-shell {
            background:
                radial-gradient(circle at 10% 0%, rgba(249, 115, 22, 0.22), transparent 34%),
                radial-gradient(circle at 100% 10%, rgba(251, 191, 36, 0.18), transparent 30%),
                linear-gradient(180deg, #fff7ed 0%, #fff 26%, #f8fafc 100%);
        }

        .aurora {
            position: fixed;
            inset: 0;
            pointer-events: none;
            background:
                radial-gradient(circle at 90% 70%, rgba(249, 115, 22, 0.16), transparent 34%),
                radial-gradient(circle at 10% 82%, rgba(251, 191, 36, 0.14), transparent 32%);
        }

        .glass {
            border-radius: 1.2rem;
            border: 1px solid rgba(226, 232, 240, 0.95);
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(6px);
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
        }

        .panel {
            border: 1px solid var(--line);
            border-radius: 1.2rem;
            background: linear-gradient(180deg, #ffffff, #fffaf5);
            box-shadow: 0 20px 46px rgba(15, 23, 42, 0.08);
        }

        .eyebrow {
            font-size: 0.73rem;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--brand-600);
            font-weight: 700;
        }

        .stat-card {
            border: 1px solid #f5d0a9;
            border-radius: 1rem;
            padding: 0.9rem;
            background: linear-gradient(180deg, #fff7ed, #ffffff);
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.8rem;
            border: 1px solid #ea580c;
            background: linear-gradient(90deg, var(--brand-500), #fb923c);
            color: #ffffff;
            font-weight: 700;
            padding: 0.62rem 1rem;
            transition: transform 0.2s ease, filter 0.2s ease;
            box-shadow: 0 12px 28px rgba(249, 115, 22, 0.28);
            text-decoration: none;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            filter: brightness(1.07);
        }

        .btn-danger {
            border-radius: 0.72rem;
            border: 1px solid #fecaca;
            color: #b91c1c;
            font-weight: 600;
            padding: 0.45rem 0.8rem;
            background: #fff1f2;
            text-decoration: none;
        }

        .chip {
            border-radius: 999px;
            border: 1px solid #fdba74;
            color: #9a3412;
            background: #fff7ed;
            padding: 0.42rem 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .chip:hover {
            background: #ffedd5;
            border-color: #fb923c;
        }

        .field {
            display: grid;
            gap: 0.35rem;
            font-size: 0.92rem;
        }

        .field > span {
            color: #334155;
            font-weight: 600;
        }

        .field-input {
            border-radius: 0.8rem;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #0f172a;
            padding: 0.68rem 0.86rem;
            font-weight: 500;
            transition: border-color 0.2s ease;
        }

        .field-input:focus {
            outline: none;
            border-color: #fb923c;
            box-shadow: 0 0 0 3px rgba(251, 146, 60, 0.2);
        }

        .field input,
        .field select,
        .field textarea,
        .input-min {
            border-radius: 0.8rem;
            border: 1px solid #cbd5e1;
            background: #fff;
            color: #0f172a;
            padding: 0.64rem 0.78rem;
            width: 100%;
        }

        .field input:focus,
        .field select:focus,
        .field textarea:focus,
        .input-min:focus {
            outline: none;
            border-color: #fb923c;
            box-shadow: 0 0 0 3px rgba(251, 146, 60, 0.2);
        }

        .link-nav {
            color: #64748b;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .link-nav:hover {
            color: #ea580c;
        }

        .menu-card {
            border-radius: 1rem;
            border: 1px solid #f5d0a9;
            padding: 1.2rem;
            background: linear-gradient(180deg, #fff, #fff7ed);
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
        }

        .menu-card:hover {
            border-color: #fb923c;
            background: linear-gradient(180deg, #fff7ed, #ffedd5);
            transform: translateY(-2px);
        }

        .table-row {
            border-bottom: 1px solid #e2e8f0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #fff7ed;
            padding: 0.8rem;
            text-align: left;
            font-weight: 600;
            color: #9a3412;
        }

        td {
            padding: 0.8rem;
            color: #334155;
        }

        tr:hover {
            background: #fffaf5;
        }

        .table-modern {
            width: 100%;
            border-collapse: collapse;
        }

        .table-modern th,
        .table-modern td {
            padding: 0.8rem;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
            vertical-align: top;
        }

        .table-modern th {
            font-size: 0.78rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #9a3412;
            background: #fff7ed;
        }

        .book-cover {
            width: 64px;
            height: 92px;
            object-fit: cover;
            border-radius: 0.7rem;
            border: 1px solid #fdba74;
            box-shadow: 0 8px 18px rgba(30, 41, 59, 0.14);
        }

        .hero-banner {
            border: 1px solid #fdba74;
            border-radius: 1.3rem;
            padding: 1.25rem;
            background: linear-gradient(120deg, #fff7ed, #fff);
        }

        .reveal {
            animation: revealUp 0.65s ease both;
        }

        @keyframes revealUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-shell min-h-screen antialiased">
    <div class="aurora"></div>
    <div class="relative z-10 min-h-screen px-4 py-6 md:px-8">
        <div class="mx-auto w-full max-w-7xl">
            @auth
                @include('partials.nav')
            @endauth

            @if (session('success'))
                <div class="glass mb-6 border border-emerald-200 bg-emerald-50 p-4 text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="glass mb-6 border border-rose-200 bg-rose-50 p-4 text-rose-700">
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({toast: true, position: 'top-end', icon: 'success', title: @json(session('success')), showConfirmButton: false, timer: 3000});
            @endif

            @if(session('error'))
                Swal.fire({toast: true, position: 'top-end', icon: 'error', title: @json(session('error')), showConfirmButton: false, timer: 4000});
            @endif

            @if($errors->any())
                Swal.fire({title: 'Terjadi kesalahan', html: @json(implode('<br>', $errors->all())), icon: 'error'});
            @endif
        });
    </script>
</body>

</html>
