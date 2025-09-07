<?php
     include "navbar.php";
    // session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Online Library Management</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>


    <div class="wrapper">
        <section class="sec_img"> 

          <div class="w3-content w3-section" style="width: 600px; position: relative;">
                
                <!-- Information slides -->

                <div class="mySlides  info-slide ">
                    <h2>Library Hours</h2>
                    <p>Library starts at 9:00 AM</p>
                    <p>Closes at 8:00 PM</p>
                </div>
                
                <div class="mySlides  info-slide ">
                    <h2>Services</h2>
                    <p>Book lending and returning</p>
                    <p>Study rooms available</p>
                    <p>Computer and internet access</p>
                </div>
                
                <div class="mySlides  info-slide ">
                    <h2>Contact Information</h2>
                    <p>Phone: +8801700000000</p>
                    <p>Email: library@example.com</p>
                    <p>Address: 123 Library Street</p>
                </div>

                <div class="mySlides  info-slide ">
                    <h2>Library Rules</h2>
                    <p>Keep silence in reading areas</p>
                    <p>Return books on time</p>
                    <p>No food or drinks allowed</p>
                </div>

                <!-- Navigation buttons -->
                <!-- <button class="slide-btn prev-btn" onclick="changeSlide(-1)">❮</button>
                <button class="slide-btn next-btn" onclick="changeSlide(1)">❯</button> -->

                <!-- Dots indicator -->
                <div class="dots-container">
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                    <span class="dot" onclick="currentSlide(4)"></span>
                </div>
            </div> 

        <script type="text/JavaScript"> 
            let slideIndex = 1;
            showSlide(slideIndex);

            function changeSlide(n) {
                showSlide(slideIndex += n);
            }

            function currentSlide(n) {
                showSlide(slideIndex = n);
            }

            function showSlide(n) {
                let slides = document.getElementsByClassName("mySlides");
                let dots = document.getElementsByClassName("dot");
                
                if (n > slides.length) {slideIndex = 1}
                if (n < 1) {slideIndex = slides.length}
                
                for (let i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";
                }
                
                for (let i = 0; i < dots.length; i++) {
                    dots[i].classList.remove("active");
                }
                
                slides[slideIndex-1].style.display = "block";
                dots[slideIndex-1].classList.add("active");
            }

            // Auto slide (optional) 
            setInterval(function() {
                changeSlide(1);
            }, 5000);
        </script>


        </section>
        
        
    </div>

 <style>
    .info-slide {
        background: linear-gradient(5deg, #610795 0%, #610795 100%) !important;
        color: white;
        padding: 60px 40px;
        text-align: center;
        height: 300px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        margin-top: 120px;
        opacity: 0.7;
    }

    .info-slide h2 {
        font-size: 2.5em;
        margin-bottom: 30px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .info-slide p {
        font-size: 1.3em;
        margin: 10px 0;
        opacity: 0.8;
    }

    .slide-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0,0,0,0.5);
        color: white;
        border: none;
        padding: 16px 20px;
        font-size: 24px;
        cursor: pointer;
        border-radius: 0 3px 3px 0;
        user-select: none;
        transition: 0.3s ease;
    }

    .prev-btn {
        left: 0;
        border-radius: 3px 0 0 3px;
    }

    .next-btn {
        right: 0;
    }

    .slide-btn:hover {
        background-color: rgba(0,0,0,0.8);
    }

    .dots-container {
        text-align: center;
        margin-top: 20px;
    }

    .dot {
        cursor: pointer;
        height: 15px;
        width: 15px;
        margin: 0 5px;
        background-color: #bbb;
        border-radius: 90%;
        display: inline-block;
        transition: background-color 0.3s ease;
    }

    .dot:hover, .dot.active {
        background-color: #717171;
    }
    </style>


    <?php
        include "footer.php";
    ?>

    <!-- index.html -->
<script>
// 3 minute পরে session destroy
setTimeout(() => fetch('student/session_destroy.php'), 180000);
setTimeout(() => fetch('admin/session_destroy.php'), 180000);

</script>

</body>
</html>