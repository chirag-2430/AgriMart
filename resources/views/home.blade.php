@extends('layouts.app')

@section('content')
<!-- Hero Section with Background -->
<div class="container-fluid p-0">
    <div class="position-relative" style="height: 100vh;" id="home">
        <div class="position-absolute w-100 h-100" style="
            background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: brightness(0.7);
        "></div>
        <div class="position-relative" style="height: 100%;">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 text-center">
                    <h1 class="display-1 fw-bold" style="
                        font-family: 'Poppins', sans-serif;
                        font-size: 5rem;
                        color: #ffffff;
                        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
                        letter-spacing: 2px;
                    ">AgriMart</h1>
                    <p class="text-white mt-3" style="font-size: 1.5rem; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);">
                        Your One-Stop Agricultural Marketplace
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- About Section -->
<section id="about" class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="mb-4" style="color: #2e7d32; font-family: 'Poppins', sans-serif;">About Us</h2>
                <p class="lead">
                    AgriMart is a revolutionary platform connecting farmers, suppliers, and buyers in the agricultural sector.
                    Our mission is to create a seamless marketplace where agricultural products and services can be exchanged
                    efficiently and transparently.
                </p>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-seedling fa-3x mb-3" style="color: #2e7d32;"></i>
                                <h5>Farmers</h5>
                                <p>Connect directly with buyers and showcase your produce</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-truck fa-3x mb-3" style="color: #2e7d32;"></i>
                                <h5>Suppliers</h5>
                                <p>Provide agricultural supplies and equipment</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-shopping-cart fa-3x mb-3" style="color: #2e7d32;"></i>
                                <h5>Buyers</h5>
                                <p>Find fresh produce and supplies in one place</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="mb-4" style="color: #2e7d32; font-family: 'Poppins', sans-serif;">Contact Us</h2>
                <p class="lead mb-4">
                    Have questions or need assistance? We're here to help!
                </p>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <form>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" placeholder="Your Name">
                                    </div>
                                    <div class="mb-3">
                                        <input type="email" class="form-control" placeholder="Your Email">
                                    </div>
                                    <div class="mb-3">
                                        <textarea class="form-control" rows="4" placeholder="Your Message"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100">Send Message</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 