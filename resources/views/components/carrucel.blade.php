<div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-bs-ride="carousel" >
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-slide-to="0">
      <img class="d-block w-100 " src="{{ asset('images/Slider/slider1.png') }}" alt="First slide">
    </div>
    <div class="carousel-item" data-bs-slide-to="1">
      <img class="d-block w-100" src="{{ asset('images/Slider/slider2.png') }}" alt="Second slide">
    </div>
    <div class="carousel-item" data-bs-slide-to="2">
      <img class="d-block w-100" src="{{ asset('images/Slider/slider3.png') }}" alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev " href="#carouselExampleControls" role="button" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previo</span>
  </a>
  <a class="carousel-control-next " href="#carouselExampleControls" role="button" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Siguiente</span>
  </a>
</div>      