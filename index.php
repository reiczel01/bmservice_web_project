<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
<title>Moja pierwsza strona</title>
<link rel="stylesheet" href="/css/bootstrap-impostor.css">
<style type="text/css">
	@import url(scss/nav.css);
	@import url("scss/top-bar.css");
	@import url("scss/content.css");
	@import url("scss/login.css");
	@import url("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0");
</style>
    <style>
        /* Style dla slidera */
        .slider {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .slider-inner {
            width: 100%;
            height: 100%;
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slider-item {
            flex: 0 0 100%;
            height: 100%;
        }

        /* Style dla przycisków nawigacyjnych */
        .slider-controls {
            text-align: center;
            margin-top: 10px;
        }

        .slider-controls button {
            display: inline-block;
            width: 10px;
            height: 10px;
            margin: 0 5px;
            border-radius: 50%;
            background-color: gray;
            border: none;
            cursor: pointer;
        }

        .slider-controls button.active {
            background-color: black;
        }
    </style>
</head>

<body>
<?php
include('top-bar.php');
include('nav.php');
?>
<div class="content" style="background: none; border-left: 10px solid #FFFFFF00; border-right: 10px solid #FFFFFF00;">
    <div class="slider">
        <div class="slider-inner">
            <div class="slider-item">
                <img src="images/bmw1.jpeg" alt="Zdjęcie 1">
            </div>
            <div class="slider-item">
                <img src="images/bmw2.jpeg" alt="Zdjęcie 2">
            </div>
            <div class="slider-item">
                <img src="zdjecie3.jpg" alt="Zdjęcie 3">
            </div>
        </div>
    </div>

    <div class="slider-controls">
        <button class="active"></button>
        <button></button>
        <button></button>
    </div>

    <script>
        // Kod JavaScript do obsługi slidera
        const slider = document.querySelector('.slider');
        const sliderInner = document.querySelector('.slider-inner');
        const sliderItems = document.querySelectorAll('.slider-item');
        const sliderControls = document.querySelectorAll('.slider-controls button');

        let currentIndex = 0;
        const slideWidth = slider.clientWidth;

        function goToSlide(index) {
            sliderInner.style.transform = `translateX(-${index * slideWidth}px)`;

            // Zaznacz aktywny przycisk nawigacyjny
            sliderControls.forEach((button, i) => {
                button.classList.toggle('active', i === index);
            });
        }

        // Obsługa przycisków nawigacyjnych
        sliderControls.forEach((button, i) => {
            button.addEventListener('click', () => {
                currentIndex = i;
                goToSlide(currentIndex);
            });
        });

        // Automatyczne przewijanie slidera co 3 sekundy
        setInterval(() => {
            currentIndex = (currentIndex + 1) % sliderItems.length;
            goToSlide(currentIndex);
        }, 3000);
    </script>
</div>


</body>
<script type="text/javascript" src="js/nav.js"></script>
</html>
<!--meni edycji rezerwacji: https://codepen.io/havardob/pen/YzwzQgm-->
