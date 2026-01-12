@extends('layouts.app_admin')

@section('css')
    <style>
        .stat-card {
            border-radius: 15px;
            background: #fff;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .icon-wrapper {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 24px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .fw-bold {
            font-weight: 600 !important;
        }

        /* Clock Style */
        #live-clock {
            font-size: 18px;
            font-weight: 600;
            color: #007bff;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 8px 16px;
            display: inline-block;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            min-width: 110px;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper" style="padding-left: 280px; padding-right: 20px;">
        <div class="content-body">
            <section id="dashboard-stats" class="mt-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="text-center flex-grow-1">
                        <h2 class="fw-bold text-dark mb-1">Admin Dashboard</h2>
                        <p class="text-secondary mb-0">Overview of your platform’s key statistics</p>
                    </div>
                    <div id="live-clock"></div>
                </div>

                <hr class="w-50 mx-auto mb-4" style="border-top: 2px solid #007bff;">

                <!-- Cards Row -->
                <div class="row justify-content-center">

                    <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                        <div class="card border-0 shadow-sm stat-card">
                            <div class="card-body text-center">
                                <div class="icon-wrapper bg-info mb-3">
                                    <i class="fa fa-user text-white"></i>
                                </div>
                                <h4 class="fw-bold text-dark">{{ $totalUsers }}</h4>
                                <p class="text-muted mb-0">Counselee's</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                        <div class="card border-0 shadow-sm stat-card">
                            <div class="card-body text-center">
                                <div class="icon-wrapper bg-success mb-3">
                                    <i class="fa fa-user-tie text-white"></i>
                                </div>
                                <h4 class="fw-bold text-dark">{{ $totalCounselors }}</h4>
                                <p class="text-muted mb-0">Counselor's</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                        <div class="card border-0 shadow-sm stat-card">
                            <div class="card-body text-center">
                                <div class="icon-wrapper bg-warning mb-3">
                                    <i class="fa fa-pen text-white"></i>
                                </div>
                                <h4 class="fw-bold text-dark">{{ $totalPosts }}</h4>
                                <p class="text-muted mb-0">Posts</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                        <div class="card border-0 shadow-sm stat-card">
                            <div class="card-body text-center">
                                <div class="icon-wrapper bg-danger mb-3">
                                    <i class="fa fa-comments text-white"></i>
                                </div>
                                <h4 class="fw-bold text-dark">{{ $totalComments }}</h4>
                                <p class="text-muted mb-0">Comments</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                        <div class="card border-0 shadow-sm stat-card">
                            <div class="card-body text-center">
                                <div class="icon-wrapper bg-primary mb-3">
                                    <i class="fa fa-thumbs-up text-white"></i>
                                </div>
                                <h4 class="fw-bold text-dark">{{ $totalLikes }}</h4>
                                <p class="text-muted mb-0">Likes</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
                        <div class="card border-0 shadow-sm stat-card">
                            <div class="card-body text-center">
                                <div class="icon-wrapper bg-secondary mb-3">
                                    <i class="fa fa-calendar-alt text-white"></i>
                                </div>
                                <h4 class="fw-bold text-dark">{{ $totalEvents }}</h4>
                                <p class="text-muted mb-0">Events</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        function updateClock() {
            const clock = document.getElementById('live-clock');
            const now = new Date();

            let hours = now.getHours();
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';

            hours = hours % 12;
            hours = hours ? hours : 12;

            const timeString = `${hours}:${minutes}:${seconds} ${ampm}`;
            clock.textContent = timeString;
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
@endsection
