<?php
/**
 * Premium Hello World Implementation
 * Features: PHP backend, Modern Glassmorphism UI, Responsive Design
 */

$greeting = "Hello World";
$timestamp = date("F j, Y, g:i a");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium PHP Experience</title>
    <!-- Modern Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #a855f7;
            --bg-dark: #0f172a;
            --text-main: #f8fafc;
            --glass: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated Mesh Gradient Background */
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: radial-gradient(circle at 20% 30%, rgba(99, 102, 241, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 80% 70%, rgba(168, 85, 247, 0.15) 0%, transparent 50%);
            animation: pulse 10s ease-in-out infinite alternate;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            100% { transform: scale(1.1); }
        }

        .container {
            background: var(--glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            padding: 3rem;
            border-radius: 2rem;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            max-width: 500px;
            width: 90%;
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 600;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        p {
            font-size: 1.1rem;
            color: #94a3b8;
            margin-bottom: 2rem;
            font-weight: 300;
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(99, 102, 241, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            color: var(--primary);
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .dot {
            width: 8px;
            height: 8px;
            background: var(--primary);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--primary);
            animation: blink 2s infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        .footer {
            margin-top: 2rem;
            font-size: 0.75rem;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="container">
        <div class="status">
            <span class="dot"></span>
            PHP Runtime Active
        </div>
        <h1><?php echo $greeting; ?></h1>
        <p>Welcome to a state-of-the-art PHP implementation. Designed for performance, built for aesthetics.</p>
        
        <div class="footer">
            Server Time: <?php echo $timestamp; ?>
        </div>
    </div>
</body>
</html>
