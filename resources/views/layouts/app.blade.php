<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - FamilyTree Pro</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine JS CDN -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.7/css/bootstrap.min.css" integrity="sha512-fw7f+TcMjTb7bpbLJZlP8g2Y4XcCyFZW8uy8HsRZsH/SwbMw0plKHFHr99DN3l04VsYNwvzicUX/6qurvIxbxw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.7/js/bootstrap.min.js" integrity="sha512-zKeerWHHuP3ar7kX2WKBSENzb+GJytFSBL6HrR2nPSR1kOX1qjm+oHooQtbDpDBSITgyl7QXZApvDfDWvKjkUw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('styles')
   
    <style>
            /* Your existing CSS styles here */

        :root {
            --primary-dark: hsl(140, 80%, 10%);
            --primary-light: hsl(60, 80%, 20%);
            --card-bg: hsl(22, 22%, 2%);
            --card-hover: hsl(140, 80%, 10%);
            --text-color: #e0e0e0;
            --border-color: #94a0b4;
            --connector-color: #5a6a80;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(var(--primary-dark), var(--primary-light));
            min-height: 100vh;
            font-family: 'Oxygen', sans-serif;
            color: var(--text-color);
            padding: 2rem 0;
        }

        #container {
            margin: 0 auto;
            max-width: 1200px;
            width: 90%;
        }

        .tree {
            width: 100%;
            position: relative;
            text-align: center;
        }

        /* Card Styling */
        .tree li a {
            display: inline-block;
            text-decoration: none;
            color: var(--text-color);
            background: var(--card-bg);
            border: 1px solid var(--connector-color);
            border-radius: 8px;
            padding: 1rem;
            margin: 0.5rem;
            width: 200px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .tree li a:hover {
            background: var(--card-hover);
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            border-color: var(--border-color);
        }

        /* Image Styling */
        .tree img {
            display: block;
            margin: 0 auto 0.75rem;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .tree li a:hover img {
            border-color: var(--text-color);
            transform: scale(1.05);
        }

        /* Name Styling */
        .tree .member-name {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
        }

        /* Date Styling */
        .tree time {
            display: block;
            font-size: 0.9rem;
            color: #aaa;
            font-style: italic;
        }

        /* Tree Connectors */
        .tree, .tree ul {
            padding-top: 20px;
            position: relative;
            transition: all 0.5s;
        }

        .tree li {
            display: inline-block;
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 10px 0 10px;
            vertical-align: top;
            transition: all 0.5s;
        }

        .tree li::before, .tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 2px solid var(--connector-color);
            width: 50%;
            height: 20px;
        }

        .tree li::after {
            right: auto;
            left: 50%;
            border-left: 2px solid var(--connector-color);
        }

        .tree li:only-child::after,
        .tree li:only-child::before {
            display: none;
        }

        .tree li:only-child {
            padding-top: 0;
        }

        .tree li:first-child::before,
        .tree li:last-child::after {
            border: 0 none;
        }

        .tree li:last-child::before {
            border-right: 2px solid var(--connector-color);
            border-radius: 0 5px 0 0;
        }

        .tree li:first-child::after {
            border-radius: 5px 0 0 0;
        }

        .tree ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 2px solid var(--connector-color);
            width: 0;
            height: 20px;
        }

        /* Hover effects on connectors */
        .tree li a:hover + ul li::after,
        .tree li a:hover + ul li::before,
        .tree li a:hover + ul::before,
        .tree li a:hover + ul ul::before {
            border-color: var(--border-color);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .tree li a {
                width: 180px;
                padding: 0.75rem;
            }
            
            .tree img {
                width: 80px;
                height: 80px;
            }
        }

        @media (max-width: 768px) {
            .tree li {
                display: block;
                text-align: left;
                padding: 10px 0 0 0;
            }
            
            .tree li a {
                width: auto;
                display: flex;
                align-items: center;
                text-align: left;
                padding: 0.75rem;
            }
            
            .tree img {
                width: 60px;
                height: 60px;
                margin-right: 1rem;
                margin-bottom: 0;
            }
            
            .tree ul::before,
            .tree li::before,
            .tree li::after {
                display: none;
            }
            
            .tree ul {
                padding-left: 2rem;
                padding-top: 0.5rem;
            }
        }

        @media (max-width: 576px) {
            .tree li a {
                flex-direction: column;
                text-align: center;
            }
            
            .tree img {
                margin-right: 0;
                margin-bottom: 0.5rem;
            }
            
            .tree ul {
                padding-left: 1rem;
            }
        }
        .tree li a {
    border: 1px solid #ccc;
    padding: 10px;
    text-decoration: none;
    width: min-content;
    color: #666;
    font-size: 1rem;
    display: inline-block;
    border-radius: 5px;
    transition: all 0.5s;
    width: 125px !important;
}
    </style>
</head>
<body class="bg-gray-50">
    @include('layouts.navigation')

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>