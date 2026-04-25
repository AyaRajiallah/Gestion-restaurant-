<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManageraHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        (() => {
            const storedTheme = localStorage.getItem('managerahub-theme')
            const theme = storedTheme === 'dark' ? 'dark' : 'light'
            document.documentElement.setAttribute('data-theme', theme)
        })()
    </script>
    <style>
        :root {
            --layout-bg: #f1faee;
            --layout-text: #222827;
            --layout-glass: rgba(255, 255, 255, 0.48);
            --layout-border: rgba(255, 255, 255, 0.58);
            --layout-shadow: rgba(85, 92, 113, 0.16);
            --layout-accent: #4f0c28;
        }

        html[data-theme='dark'] {
            --layout-bg: #11141b;
            --layout-text: #edf3ef;
            --layout-glass: rgba(30, 34, 43, 0.62);
            --layout-border: rgba(197, 210, 248, 0.18);
            --layout-shadow: rgba(0, 0, 0, 0.34);
            --layout-accent: #dca7b2;
            color-scheme: dark;
        }

        body {
            background: var(--layout-bg);
            color: var(--layout-text);
            transition: background 0.25s ease, color 0.25s ease;
        }

        .theme-toggle {
            position: fixed;
            right: 1rem;
            bottom: 1rem;
            z-index: 999;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            border: 1px solid var(--layout-border);
            border-radius: 999px;
            background: var(--layout-glass);
            color: var(--layout-accent);
            box-shadow: 0 18px 40px var(--layout-shadow);
            backdrop-filter: blur(20px) saturate(160%);
            -webkit-backdrop-filter: blur(20px) saturate(160%);
            cursor: pointer;
        }

        .theme-toggle svg {
            width: 1.2rem;
            height: 1.2rem;
            fill: currentColor;
        }
    </style>
</head>
<body>
    @yield('content')
    <button type="button" id="themeToggle" class="theme-toggle" aria-label="Changer le theme">
        <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M21 12.79A9 9 0 1 1 11.21 3c0 .25-.01.5-.01.75A7.5 7.5 0 0 0 18.75 11.3c.75 0 1.5-.11 2.25-.31Z"/>
        </svg>
    </button>
</body>
</html>

