<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap"
      rel="stylesheet"
    />

    <!-- Icon Font Stylesheet -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="./css/style.css" />

    <title>Clever academia | Learning platform</title>
  </head>
  <body>
    <!-- Spinner Start -->
    <!-- <div
      id="spinner"
      class="show bg-white fixed translate-middle w-full h-screen top-1/2 left-1/2 flex items-center justify-center"
    >
      <div
        class="spinner-border text-blue-400"
        style="width: 3rem; height: 3rem"
        role="status"
      >
        <span class="sr-only text-red-400">Loading...</span>
      </div>
    </div> -->
    <!-- Spinner End -->
    <!-- Navbar Start -->
    <nav class="navbar bg-white shadow p-4 sm:p-0 lg:pl-16">
      <a href="index.html" class="navbar-brand text-xl md:text-2xl">
        <h2 class=""><i class="fa fa-book"></i>Clever academia</h2>
      </a>
      <button type="button" class="sm:hidden">
        <i class="fas fa-bars"></i>
      </button>
      <div
        class="navbar-items hidden sm:flex text-sm"
        id="navbarCollapse"
      >
        <div class="navbar-nav">
          <a href="#home" class="active">Home</a>
          <a href="#about" class="">About</a>
          <a href="#testimony" class="">Testimony</a>
          <a href="#contact" class="">Contact us</a>
        </div>
        <a href="./pages/login.php" class="join-btn"
          >Join Now<i class="fa fa-arrow-right"></i
        ></a>
      </div>
    </nav>
    <!-- Navbar End -->
    <!-- Carousel Start -->
    <section id="home" class="carousel-container p-0 bg-gray-50">
      <div class="w-full owl-carousel relative">
        <div class="image w-full flex justify-end pt-12">
          <img class="img-fluid" src="img/looking-at-phone.png" alt="" />
        </div>

        <div
          class="carousel-text absolute inset-0 flex items-center p-5"
          style="background: rgba(216, 224, 224, 0.575)"
        >
          <div class="container mx-auto">
            <div class="flex justify-start w-full md:w-2/3 lg:w-1/2 lg:pl-28">
              <div class="">
                <h5 class="uppercase text-teal-800">Best Online Community/</h5>
                <h1 class="w-11/12">The Best Enhanced Learning Platform</h1>
                <p class="mb-4 pb-4 text-base">
                  Vero elitr justo clita lorem. Ipsum dolor at sed stet sit diam
                  no. Kasd rebum ipsum et diam justo clita et kasd rebum sea
                  sanctus eirmod elitr.
                </p>
                <a href="#about" class="btn btn-primary py-md-3 px-md-5 text-sm"
                  >Read More</a
                >
                <a
                  href="./pages/create-account.php"
                  class="btn btn-light md:py-3 md:px-5 text-sm"
                  >Join Now</a
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Carousel End -->
    <!-- features post start -->
    <section class="features lg:px-20 -mt-12 ">
      <div class="container mx-auto px-5">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 text-base">
          <div class="single-feature hover:shadow-xl">
            <div class="content-show">
              <h4><i class="fa fa-graduation-cap"></i>Group studies</h4>
            </div>
            <div class="content-hide">
              <p>
                Curabitur id eros vehicula, tincidunt libero eu, lobortis mi. In
                mollis eros a posuere imperdiet. Donec maximus elementum ex.
                Cras convallis ex rhoncus, laoreet libero eu, vehicula libero.
              </p>
              <p class="hidden-sm">
                Curabitur id eros vehicula, tincidunt libero eu, lobortis mi. In
                mollis eros a posuere imperdiet.
              </p>
              <div class="scroll-to-section mt-3">
                <a href="#section2">More Info.</a>
              </div>
            </div>
          </div>
          <div class="single-feature hover:shadow-lg">
            <div class="content-show">
              <h4><i class="fa fa-graduation-cap"></i>Academic resources</h4>
            </div>
            <div class="content-hide">
              <p>
                Curabitur id eros vehicula, tincidunt libero eu, lobortis mi. In
                mollis eros a posuere imperdiet. Donec maximus elementum ex.
                Cras convallis ex rhoncus, laoreet libero eu, vehicula libero.
              </p>
              <p class="hidden-sm">
                Curabitur id eros vehicula, tincidunt libero eu, lobortis mi. In
                mollis eros a posuere imperdiet.
              </p>
              <div class="scroll-to-section">
                <a href="#section2">More Info.</a>
              </div>
            </div>
          </div>
          <div class="single-feature hover:shadow-lg">
            <div class="content-show">
              <h4><i class="fa fa-graduation-cap"></i>Find a mentors</h4>
            </div>
            <div class="content-hide">
              <p>
                Curabitur id eros vehicula, tincidunt libero eu, lobortis mi. In
                mollis eros a posuere imperdiet. Donec maximus elementum ex.
                Cras convallis ex rhoncus, laoreet libero eu, vehicula libero.
              </p>
              <p class="hidden-sm">
                Curabitur id eros vehicula, tincidunt libero eu, lobortis mi. In
                mollis eros a posuere imperdiet.
              </p>
              <div class="scroll-to-section">
                <a href="#section2">More Info.</a>
              </div>
            </div>
          </div>
          <div class="single-feature hover:shadow-lg">
            <div class="content-show">
              <h4><i class="fa fa-graduation-cap"></i>Counseling</h4>
            </div>
            <div class="content-hide">
              <p>
                Curabitur id eros vehicula, tincidunt libero eu, lobortis mi. In
                mollis eros a posuere imperdiet. Donec maximus elementum ex.
                Cras convallis ex rhoncus, laoreet libero eu, vehicula libero.
              </p>
              <p class="hidden-sm">
                Curabitur id eros vehicula, tincidunt libero eu, lobortis mi. In
                mollis eros a posuere imperdiet.
              </p>
              <div class="scroll-to-section">
                <a href="#section2">More Info.</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- features post end -->
    <!-- about us start -->
    <section id="about" class="about lg:px-20 my-5 pt-16  ">
      <div class="container mx-auto px-5">
        <div class="section__title py-10 text-4xl flex justify-center">
          <h2>Why choose us</h2>
        </div>
        <div class="about__tabs p-2">
          <ul class="flex flex-col sm:grid">
            <li data-tab-target="#tab-1" class="active">
              Improve your grade 1
            </li>
            <li data-tab-target="#tab-2" class="">Improve your grade 2</li>
            <li data-tab-target="#tab-3" class="">Improve your grade 3</li>
          </ul>
          <div class="section__content">
            <div class="tab-panel visible" id="tab-1">
              <div
                class="section-inside flex items-center flex-col md:flex-row px-0 md:px-10"
              >
                <div class="image-holder h-full w-full">
                  <img src="./img/man-with-laptop.png" alt="" />
                </div>

                <div class="tab-content h-full w-full">
                  <h1 class="text-2xl md:text-4xl pt-0 md:pt-20">
                    Improving your grade 1
                  </h1>
                  <p>
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                    Atque voluptas officia ducimus nam ratione aliquid, aliquam
                    repellat sapiente tempora impedit! Sequi temporibus tempore
                    ex alias eaque praesentium odit, id nobis!
                  </p>
                </div>
              </div>
            </div>
            <div class="tab-panel" id="tab-2">
              <div
                class="section-inside flex items-center flex-col md:flex-row px-0 md:px-10"
              >
                <div class="image-holder h-full w-full">
                  <img src="./img/man-with-laptop.png" alt="" />
                </div>

                <div class="tab-content h-full w-full">
                  <h1 class="text-2xl md:text-5xl pt-0 md:pt-20">
                    Improving your grade 2
                  </h1>
                  <p>
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                    Atque voluptas officia ducimus nam ratione aliquid, aliquam
                    repellat sapiente tempora impedit! Sequi temporibus tempore
                    ex alias eaque praesentium odit, id nobis!
                  </p>
                </div>
              </div>
            </div>
            <div class="tab-panel" id="tab-3">
              <div
                class="section-inside flex items-center flex-col md:flex-row px-0 md:px-10"
              >
                <div class="image-holder h-full w-full">
                  <img src="./img/man-with-laptop.png" alt="" />
                </div>

                <div class="tab-content h-full w-full">
                  <h1 class="text-2xl md:text-5xl pt-0 md:pt-20">
                    Improving your grade 3
                  </h1>
                  <p>
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                    Atque voluptas officia ducimus nam ratione aliquid, aliquam
                    repellat sapiente tempora impedit! Sequi temporibus tempore
                    ex alias eaque praesentium odit, id nobis!
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- about us end -->
    <!-- testimony section start -->
    <section id="testimony" class="testimony lg:px-20 my-5 pt-14 ">
      <div class="container mx-auto px-5">
        <div class="section__title pt-14  text-4xl  flex justify-center">
          <h2>What students say !!</h2>
        </div>
        <div
          class="section__testimony p-2 overflow-x-scroll lg:scrollbar-default scrollbar-hide "
        >
          <div class="ins">
            <div class="testimony__card">
              <div class="image_holder">
                <img src="./img/looking-at-phone.png" alt="" />
              </div>

              <div class="relative testimony-text shadow-md">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                  Facilis inventore adipisci velit fugiat at consequatur
                  provident veniam sint tenetur exercitationem amet voluptatem
                  fuga neque non rerum, voluptate delectus itaque quia!
                </p>
                <span></span>
              </div>
            </div>
            <div class="testimony__card">
              <div class="image_holder">
                <img src="./img/looking-at-phone.png" alt="" />
              </div>

              <div class="relative testimony-text shadow-md">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                  Facilis inventore adipisci velit fugiat at consequatur
                  provident veniam sint tenetur exercitationem amet voluptatem
                  fuga neque non rerum, voluptate delectus itaque quia!
                </p>
                <span></span>
              </div>
            </div>
            <div class="testimony__card">
              <div class="image_holder">
                <img src="./img/looking-at-phone.png" alt="" />
              </div>

              <div class="relative testimony-text shadow-md">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                  Facilis inventore adipisci velit fugiat at consequatur
                  provident veniam sint tenetur exercitationem amet voluptatem
                  fuga neque non rerum, voluptate delectus itaque quia!
                </p>
                <span></span>
              </div>
            </div>
            <div class="testimony__card">
              <div class="image_holder">
                <img src="./img/looking-at-phone.png" alt="" />
              </div>

              <div class="relative testimony-text shadow-md">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                  Facilis inventore adipisci velit fugiat at consequatur
                  provident veniam sint tenetur exercitationem amet voluptatem
                  fuga neque non rerum, voluptate delectus itaque quia!
                </p>
                <span></span>
              </div>
            </div>
            <div class="testimony__card">
              <div class="image_holder">
                <img src="./img/looking-at-phone.png" alt="" />
              </div>

              <div class="relative testimony-text shadow-md">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                  Facilis inventore adipisci velit fugiat at consequatur
                  provident veniam sint tenetur exercitationem amet voluptatem
                  fuga neque non rerum, voluptate delectus itaque quia!
                </p>
                <span></span>
              </div>
            </div>
            <div class="testimony__card">
              <div class="image_holder">
                <img src="./img/looking-at-phone.png" alt="" />
              </div>

              <div class="relative testimony-text shadow-md">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                  Facilis inventore adipisci velit fugiat at consequatur
                  provident veniam sint tenetur exercitationem amet voluptatem
                  fuga neque non rerum, voluptate delectus itaque quia!
                </p>
                <span></span>
              </div>
            </div>
            <div class="testimony__card">
              <div class="image_holder">
                <img src="./img/looking-at-phone.png" alt="" />
              </div>

              <div class="relative testimony-text shadow-md">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                  Facilis inventore adipisci velit fugiat at consequatur
                  provident veniam sint tenetur exercitationem amet voluptatem
                  fuga neque non rerum, voluptate delectus itaque quia!
                </p>
                <span></span>
              </div>
            </div>
            <div class="testimony__card">
              <div class="image_holder">
                <img src="./img/looking-at-phone.png" alt="" />
              </div>

              <div class="relative testimony-text shadow-md">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                  Facilis inventore adipisci velit fugiat at consequatur
                  provident veniam sint tenetur exercitationem amet voluptatem
                  fuga neque non rerum, voluptate delectus itaque quia!
                </p>
                <span></span>
              </div>
            </div>
            
              
            </div>
          </div>
        </div>
        <div class="dots flex justify-center items-center">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </section>
    <!-- testimony section end -->
    <!-- contact us start -->
    <section id="contact" class=" lg:px-20 my-5 ">
      <div class="container mx-auto px-5 ">
        <div class="section__title mt-14 py-10 text-4xl flex justify-center">
          <h2>Let's Keep in Touch ! !!</h2>
        </div>
        <div class="contact_section flex  justify-center lg:px-[10%] flex-col-reverse md:flex-row">
          <div class="feedback  w-full md:w-3/5 mr-10">
            <form action="#" class="mt-6 " method="POST">
              <div class="flex flex-col md:flex-row items-start mt-4 md:-mx-4">
                <div class="w-full md:mx-4">
                  <label for="" class="block text-gray-700">Full name <span class="text-red-500 text-sm">*</span></label>
                  <input type="text" placeholder="Enter your Full name" class="w-full px-4 py-3 rounded bg-gray-50 mt-1 border focus:border-teal-600 focus:bg-white focus:outline-none"  required>
                </div>
                <div class="w-full md:mx-4 mt-4 md:mt-0">
                  <label for="" class="block text-gray-700">Your email <span class="text-red-500 text-sm">*</span></label>
                  <input type="text" placeholder="Enter your email" class="w-full px-4 py-3 rounded bg-gray-50 mt-1 border focus:border-teal-600 focus:bg-white focus:outline-none" required>
                </div>
              </div>
              <div>
                <label for="" class="block text-gray-700"> Subject </label>
                <input type="text" placeholder="Enter the subject" class="w-full px-4 py-3 rounded bg-gray-50 mt-1 border focus:border-teal-600 focus:bg-white focus:outline-none" >
              </div>
              <div class="w-full mt-4">
                <label for=""  class="block text-gray-700">Message <span class="text-red-500 text-sm">*</span></label>
                <textarea name="" id="" placeholder="Write message" class="w-full px-4 py-3 rounded bg-gray-50 mt-1 border focus:border-teal-600 focus:bg-white focus:outline-none resize-none" rows="5" required spellcheck="true"></textarea>
              </div>
              <button type="submit" class="w-full block bg-teal-700 hover:bg-teal-600 focus:bg-teal-600 text-white font-semibold rounded
              px-4 py-3 mt-4">Submit</button>
            </form>
          </div>
          <div class="loaction bg-teal-700 md:w-2/5 shadow-sm rounded-lg p-5 text-white font-semibold text-sm">
            <div class="border-b-2 border-b-teal-600 py-3">
              <label >
                <i class="fa fa-phone"></i>
                Phone number</label>
              <p>+254791072238</p>
            </div>
            <div class="border-b-2 border-b-teal-600 py-3">
              <label >
                <i class="fa fa-mail"></i>
                Email address</label>
              <p>juniorbalamage@gmail.com</p>
            </div>
            <div class="border-b-2 border-b-teal-600 py-3">
              <label >
                <i class="fa fa-location"></i>
                location</label>
              <p>Nairoi, Kenya</p>
            </div>
          </div>
        </div>
      </div>
        
    </section>
    <!-- contact us end -->
    <!-- Footer start -->
    <section class=" lg:px-20 bg-teal-700">
      <div class="container mx-auto py-5  flex flex-col items-center">
        <div class="icon text-white text-xl">
          <span><i class="fa fa-instagram" aria-hidden="true"></i></span>
          <span><i class="fa fa-twitter" aria-hidden="true"></i></span>
          <span><i class="fa fa-linkedin" aria-hidden="true"></i></span>
          <span><i class="fa fa-github" aria-hidden="true"></i></span>
        </div>
        <div class="text-white font-extralight text-sm pt-3">
            Copyright 2022 &copy;Balibonera Junior. All rights reserved.
        </div>
      </div>
    </section>
    <!-- Footer end -->
    <script src="./js/app.js"></script>
    <script src="https://use.fontawesome.com/f000861c02.js"></script>
  </body>
</html>
