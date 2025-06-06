@extends('layouts.guest')

@section('content')
    <div id="app">

         <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [{
                "@type": "ListItem",
                "position": 1,
                "name": "Home",
                "item": "https://nahomapp.com"
            },{
                "@type": "ListItem",
                "position": 2,
                "name": "Football League",
                "item": "https://nahomapp.com/league"
            }]
        }
        </script>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
               <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="https://nahomapp.com/storage/logos/banner.jpeg"
                         alt="Eritrean Cities League 2025 Banner"
                         class="img-fluid"
                         style="width:auto; height:100%;">
                </a>
                

                @auth
                @if(Auth::user() === 'admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">{{ __('admin') }}</a>
                </li>
                @endif
                @endauth

            </div>
        </nav>


               </div>
            </div>

            @Auth
            @if(Auth::user()->role === "admin")
            <a href="https://nahomapp.com/admin">
                <button class="btn btn-info end">admindashbord</button>
            </a>
            @endif
            @endauth
            <h1 class="text-center mb-4"> 🏆 Eritrean Cities Club League – Netherlands 2025! ⚽ </br> 🏆Nay Eritrea Ketematat Xewta Ab Nederland(Holland) ⚽ <br> 🏆ናይ ኤርትራ ከተማታት ጸውታ ኣብ    ነዘርላንድ (ሆላንድ)     2025
            ⚽ </h1> <button class="btn btn-success me-2  text-center"  onclick="window.location.reload();">
                <i class="fas fa-sync me-2"></i> click here to update the page </br> abzi bmtwq hadsih enet alo  ree </br>  ኣብዚ ብ ምጥዋቅ ሓድሽ እንተ ኣሎ ርአ
            </button>

            <!-- Nav Tabs -->
            <ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="fixtures-tab" data-bs-toggle="tab" data-bs-target="#fixtures" type="button" role="tab" aria-controls="fixtures" aria-selected="true">
                        🗓️ Fixtures</br>🗓️Gtmat <br>🗓️ግጥማት
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="standings-tab" data-bs-toggle="tab" data-bs-target="#standings" type="button" role="tab" aria-controls="standings" aria-selected="false">
                        📊 Standings  </br> 📊Dereja <br> 📊ደረጃ
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="players-tab" data-bs-toggle="tab" data-bs-target="#players" type="button" role="tab" aria-controls="players" aria-selected="false">
                        ⚽ Top Scores </br>  ⚽Amezgebti <br> ⚽ኣመዝገብቲ
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="playersLists-tab" data-bs-toggle="tab" data-bs-target="#playersLists" type="button" role="tab" aria-controls="playersLists" aria-selected="false">
                        📜 Rules    </br> 📜 hgata xewta <br>📜 ሕግታት ጸውታ
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade" id="players" role="tabpanel" aria-labelledby="players-tab">
                    <div class="card mt-2">
                        <div class="card-body">
                            <livewire:playerCards />
                        </div>
                    </div>
                </div>
                <!-- Fixtures Tab -->
                <div class="tab-pane fade show active" id="fixtures" role="tabpanel" aria-labelledby="fixtures-tab">
                    <div class="card mt-2">
                        <div class="card-body">
                            <livewire:ManageFixtures />
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="playersLists" role="tabpanel" aria-labelledby="playersLists-tab">
                    <div class="card mt-2">
                        <div class="card-body">
                            <livewire:add-club />
                        </div>
                    </div>
                </div>

                <!-- Standings Tab -->
                <div class="tab-pane fade" id="standings" role="tabpanel" aria-labelledby="standings-tab">
                    <div class="card mt-2">
                        <div class="card-body">
                            <livewire:ManageStandings />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Remit Ad Banner placement at the bottom of content before footer -->
            <div class="website-services bg-primary p-4 rounded">
                <h2 class="text-center mb-4">📱 NahomApp website መስርሒ ኣጎልጉሎት 📱 </h2>

                <div class="row">
                    <!-- Service Categories -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 bg-dark">
                            <div class="card-body">
                                <h4 class="text-warning">
                                    <i class="fas fa-utensils"></i> (ን ቤት መግብን መስተን)Restaurant Websites
                                </h4>
                                <ul class="list-unstyled">
                                    <li class="text-white">✅(ብ online ዝርዝር መግብታት ምስ ምስ ዋግኡ) Online Menu System</li>
                                    <li class="text-white">✅(ናይ ቆጸራ መትሓዚ ብ online) Table Reservation</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="card h-100 bg-dark">
                            <div class="card-body">
                                <h4 class="text-success">
                                    <i class="fas fa-store"></i> ናይ ካልእ ዝተፈላለዩ  Business Websites
                                </h4>
                                <ul class="list-unstyled">
                                    <li class="text-white">✅ (ናይ ንብረታት መሕበሪ)Product Catalog</li>
                                    <li class="text-white">✅(ናይ ቆጸራ መትሓዚ) Appointment Booking</li>

                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="card h-100 bg-dark">
                            <div class="card-body">
                                <h4 class="text-info">
                                    <i class="fas fa-cut"></i> ናይ እንዳ ቀምቃማይን መሻጢትን  Salon Websites
                                </h4>
                                <ul class="list-unstyled">
                                    <li class="text-white">✅(ናይ ትሰርሕዎ መርኣዩ) Service Portfolio</li>
                                    <li class="text-white">✅(ናይ ቆጽራ መትሓዚ) Online Booking</li>
                                    <li class="text-white">✅(ናይ መቀምቀሚ/መመሽጢ ዋጋታት) Prices </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing Section -->
                <div class="pricing-section mt-4 p-3 bg-secondary rounded">
                    <h3 class="text-center">💰 (ፍሉይ ምጉዳል ን መንእሰያት ኤርትራውያን ትካላት ዘለኩም)Special Offer for young Eritrean Businesses 💰</h3>

                </div>

                <!-- Contact Section -->
                <div class="contact-cta mt-4 text-center">
                    <h4 class="mb-3">📞 ን ዝይዳ ሓበሬታ Contact Us Today! 📧</h4>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="https://wa.me/31687073858" class="btn btn-success">
                            <i class="fab fa-whatsapp"></i> WhatsApp +31687073858
                        </a>
                        <a href="mailto:nahomcoder@gmail.com" class="btn btn-danger">
                            <i class="fas fa-envelope"></i> Email nahomcoder@gmail.com
                        </a>
                    </div>
                    <p class="mt-3">📌 ካባብና ናባና</p>
                </div>
            </div>
        </div>
