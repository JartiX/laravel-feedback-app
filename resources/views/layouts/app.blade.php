<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Feedback App')</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        main {
            flex: 1;
            padding: 40px 0;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 0;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 22px;
            font-weight: 700;
        }

        .logo-icon {
            background: white;
            color: #667eea;
            border-radius: 50%;
            font-size: 16px;
            font-weight: 700;
            padding: 8px 12px;
        }

        .logo-text {
            color: white;
            font-weight: 600;
        }

        .nav a {
            color: #f7fafc;
            text-decoration: none;
            font-weight: 500;
            margin-left: 25px;
            transition: color 0.3s, border-bottom 0.3s;
            padding-bottom: 3px;
        }

        .nav a:hover {
            color: #c3dafe;
            border-bottom: 2px solid #c3dafe;
        }

        .footer {
            text-align: center;
            padding: 25px 15px;
            margin-top: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #f7fafc;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            font-size: 15px;
            box-shadow: 0 -2px 15px rgba(0,0,0,0.08);
        }

        .footer p {
            margin: 0;
            line-height: 1.6;
        }

        .footer strong {
            color: #fff;
            font-weight: 600;
        }

        .footer-meta {
            font-size: 14px;
            color: #e2e8f0;
        }

        @yield('styles')
    </style>
</head>
<body>

    @include('partials.header')

    <main class="container">
        @yield('content')
    </main>

    @include('partials.footer')

</body>
</html>
