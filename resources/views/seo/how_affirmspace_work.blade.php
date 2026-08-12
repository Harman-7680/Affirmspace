<style>
    /* ===================================
   HOW IT WORKS SECTION
=================================== */

.how-it-works-section{
    width:100%;
    background:#fff;
    padding:80px 6%;
    overflow:hidden;
    font-family:sans-serif;
    text-align:center;
}

/* ===================================
   TITLE
=================================== */

.how-title{
    font-size:46px;
    color:#17153a;
    font-weight:800;
    margin-bottom:70px;
    text-align: center;
}

/* ===================================
   STEPS CONTAINER
=================================== */

.how-steps-container{
    max-width:1300px;
    margin:auto;
    display:flex;
    align-items:flex-start;
    justify-content:center;
    gap:28px;
    flex-wrap:wrap;
}

/* ===================================
   SINGLE STEP
=================================== */

.how-step{
    width:220px;
    position:relative;
}

/* ===================================
   CIRCLE
=================================== */

.step-circle{
    width:140px;
    height:140px;
    border:2px solid #eee;
    border-radius:50%;
    margin:auto;
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#fff;
    transition:0.35s ease;
}

/* HOVER */

.step-circle:hover{
    transform:translateY(-8px);
    box-shadow:0 18px 40px rgba(124,58,237,0.12);
}

/* ===================================
   STEP NUMBER
=================================== */

.step-number{
    position:absolute;
    top:-8px;
    right:10px;
    width:38px;
    height:38px;
    background:#7c3aed;
    color:#fff;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:16px;
    font-weight:700;
}

/* OTHER COLORS */

.pink-number{
    background:#ff4fa0;
}

.yellow-number{
    background:#f5b400;
}

.green-number{
    background:#4caf50;
}

/* ===================================
   ICON
=================================== */

.step-icon{
    font-size:48px;
    transition:0.35s ease;
}

/* ICON HOVER */

.step-circle:hover .step-icon{
    transform:scale(1.15);
}

/* ===================================
   TEXT
=================================== */

.how-step h3{
    font-size:22px;
    color:#17153a;
    margin-top:28px;
    margin-bottom:12px;
    font-weight:700;
    line-height:1.4;
}

.how-step p{
    font-size:16px;
    line-height:1.7;
    color:#666;
    margin:0;
}

/* ===================================
   ARROW
=================================== */

.step-arrow{
    font-size:52px;
    color:#b9a5d8;
    margin-top:35px;
    font-weight:300;
}

/* ===================================
   RESPONSIVE
=================================== */

@media(max-width:1000px){

    .how-steps-container{
        gap:45px;
    }

    .step-arrow{
        display:none;
    }

}

@media(max-width:700px){

    .how-title{
        font-size:34px;
        margin-bottom:50px;
    }

    .how-step{
        width:100%;
        max-width:320px;
    }

    .step-circle{
        width:120px;
        height:120px;
    }

    .step-icon{
        font-size:42px;
    }

    .how-step h3{
        font-size:20px;
    }

    .how-step p{
        font-size:15px;
    }

}
</style>






<section class="how-it-works-section">

    <!-- SECTION TITLE -->
    <h2 class="how-title">
        How Affirmspace Works
    </h2>


    <!-- STEPS -->
    <div class="how-steps-container">


        <!-- STEP 1 -->
        <div class="how-step">

            <div class="step-circle">

                <div class="step-number">1</div>

                <div class="step-icon">
                    👤
                </div>

            </div>

            <h3>Create Your Account</h3>

            <p>
                Sign up and set up your
                profile in seconds.
            </p>

        </div>



        <!-- ARROW -->
        <div class="step-arrow">
            →
        </div>



        <!-- STEP 2 -->
        <div class="how-step">

            <div class="step-circle">

                <div class="step-number pink-number">2</div>

                <div class="step-icon">
                    💖
                </div>

            </div>

            <h3>Choose Your Vibe</h3>

            <p>
                Tell us what you're
                looking for.
            </p>

        </div>



        <!-- ARROW -->
        <div class="step-arrow">
            →
        </div>



        <!-- STEP 3 -->
        <div class="how-step">

            <div class="step-circle">

                <div class="step-number yellow-number">3</div>

                <div class="step-icon">
                    👥
                </div>

            </div>

            <h3>Discover & Connect</h3>

            <p>
                Explore people, rooms,
                and counsellors.
            </p>

        </div>



        <!-- ARROW -->
        <div class="step-arrow">
            →
        </div>



        <!-- STEP 4 -->
        <div class="how-step">

            <div class="step-circle">

                <div class="step-number green-number">4</div>

                <div class="step-icon">
                    💬
                </div>

            </div>

            <h3>Chat, Connect & Grow</h3>

            <p>
                Build real relationships
                and feel at home.
            </p>

        </div>

    </div>

</section>