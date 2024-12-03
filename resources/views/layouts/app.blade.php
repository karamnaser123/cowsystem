<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/cowd.png') }}" type="image/x-icon">

    <title>نظام ادارة مزارع البقر</title>

    {{-- 
    <title>{{ config('app.name', 'Laravel') }}</title> --}}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-xzQ2KXeZ2n9xlyTz3+OE2Fi7UMPCbHAxLWbG+ptXF5p8+2uUE5ktMUgJByFyNXkHc3Ulw7tkRuoFYfUDt4s2Xg=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <style>
        select {
            padding-right: 30px
        }
    </style>
</head>

@if (session('success'))
    <div class="success-message" id="successMessage">
        <span>{{ session('success') }}</span>
        <button class="close-button">إغلاق</button>
    </div>
@endif




@if (session('error'))
    <div class="success-error" id="successMessage">
        <span>{{ session('error') }}</span>
        <button class="close-button">إغلاق</button>
    </div>
@endif

@if ($errors->any())
    <div class="success-error" id="successMessage">
        <span>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </span>
        <button class="close-button">إغلاق</button>
    </div>
@endif




<style>
    .success-message {
        position: fixed;
        bottom: 10px;
        left: 10px;
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        border-radius: 5px;
        z-index: 999;
        opacity: 0;
        animation: slideIn 0.5s forwards;
    }

    .success-error {
        position: fixed;
        bottom: 10px;
        left: 10px;
        background-color: red;
        color: white;
        padding: 10px;
        border-radius: 5px;
        z-index: 999;
        opacity: 0;
        animation: slideIn 0.5s forwards;
    }

    .success-toob {
        position: fixed;
        top: 10px;
        left: 10px;
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        border-radius: 5px;
        z-index: 999;
        opacity: 0;
        animation: slideOut 0.5s forwards;
        font-size: 17px;
        padding: 40px;
    }

    .success-right {
        position: fixed;
        top: 10px;
        right: 10px;
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        border-radius: 5px;
        z-index: 999;
        opacity: 0;
        animation: slideOut 0.5s forwards;
        font-size: 17px;
        padding: 40px;
    }

    .success-bottom {
        position: fixed;
        left: 10px;
        bottom: 10px;
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        border-radius: 5px;
        z-index: 999;
        opacity: 0;
        animation: slidebottom 0.5s forwards;
        font-size: 17px;
        padding: 40px;
    }

    .success-bottom-right {
        position: fixed;
        right: 10px;
        bottom: 10px;
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        border-radius: 5px;
        z-index: 999;
        opacity: 0;
        animation: slidebottom 0.5s forwards;
        font-size: 17px;
        padding: 40px;
    }

    .success-bottom-rr {
        position: fixed;
        left: 50%;
        top: 5px;
        transform: translateX(-50%);
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        border-radius: 5px;
        z-index: 999;
        opacity: 0;
        animation: slideOut 0.5s forwards;
        font-size: 17px;
    }

    @keyframes slideOut {
        from {
            top: -50px;
            opacity: 0;
        }

        to {
            top: 10px;
            opacity: 1;
        }
    }

    @keyframes slidebottom {
        from {
            bottom: -50px;
            opacity: 0;
        }

        to {
            bottom: 10px;
            opacity: 1;
        }
    }

    .close-button {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        margin-left: 10px;
    }

    /* Define the opening animation */
    @keyframes slideIn {
        from {
            bottom: -50px;
            opacity: 0;
        }

        to {
            bottom: 10px;
            opacity: 1;
        }
    }
</style>
<script>
    const successMessage = document.getElementById('successMessage');
    const closeButton = successMessage.querySelector('.close-button');

    // Function to close the success message
    function closeSuccessMessage() {
        successMessage.style.animation = 'slideOut 0.5s';
        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 500); // Delay hiding for the duration of the slideOut animation
    }

    closeButton.addEventListener('click', closeSuccessMessage);

    // Automatically close the message after a few seconds (optional)
    setTimeout(closeSuccessMessage, 30000); // Close after 5 seconds (adjust as needed)




    const successright = document.getElementById('successright');
    const closeButton2 = successright.querySelector('.close-button');

    // Function to close the success message
    function closeSuccessMessage2() {
        successright.style.animation = 'slideOut 0.5s';
        setTimeout(() => {
            successright.style.display = 'none';
        }, 500); // Delay hiding for the duration of the slideOut animation
    }

    closeButton2.addEventListener('click', closeSuccessMessage2);

    // Automatically close the message after a few seconds (optional)
    setTimeout(closeSuccessMessage2, 30000); // Close after 5 seconds (adjust as needed)




    const successbottom = document.getElementById('successbottom');
    const closeButton3 = successbottom.querySelector('.close-button');

    // Function to close the success message
    function closeSuccessMessage3() {
        successbottom.style.animation = 'slidebottom 0.5s';
        setTimeout(() => {
            successbottom.style.display = 'none';
        }, 500); // Delay hiding for the duration of the slideOut animation
    }

    closeButton3.addEventListener('click', closeSuccessMessage3);

    // Automatically close the message after a few seconds (optional)
    setTimeout(closeSuccessMessage3, 30000); // Close after 5 seconds (adjust as needed)



    const successbottomright = document.getElementById('successbottomright');
    const closeButton5 = successbottomright.querySelector('.close-button');

    // Function to close the success message
    function closeSuccessMessage5() {
        successbottomright.style.animation = 'slidebottom 0.5s';
        setTimeout(() => {
            successbottomright.style.display = 'none';
        }, 500); // Delay hiding for the duration of the slideOut animation
    }

    closeButton5.addEventListener('click', closeSuccessMessage5);

    // Automatically close the message after a few seconds (optional)
    setTimeout(closeSuccessMessage5, 30000); // Close after 5 seconds (adjust as needed)



    // const successbottomrr = document.getElementById('successbottomrr');
    // const closeButton6 = successbottomrr.querySelector('.close-button');

    // // Function to close the success message
    // function closeSuccessMessage6() {
    //     successbottomrr.style.animation = 'slideOut 0.5s';
    //     setTimeout(() => {
    //         successbottomrr.style.display = 'none';
    //     }, 500); // Delay hiding for the duration of the slideOut animation
    // }

    // closeButton6.addEventListener('click', closeSuccessMessage6);

    // // Automatically close the message after a few seconds (optional)
    // setTimeout(closeSuccessMessage6, 30000); // Close after 5 seconds (adjust as needed)
</script>


<body class="font-sans antialiased" style="direction: rtl">
    <div class="min-h-screen bg-gray-100">

        @include('layouts.navigation')


        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>

            @if (isset($slot))
                {{ $slot }}
            @endif
            @yield('body')


        </main>
    </div>
</body>

</html>
