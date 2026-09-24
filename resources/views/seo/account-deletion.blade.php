@extends('layouts.seo')

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Delete Your AffirmSpace Account – Account Deletion</title>

    <meta name="description"
        content="Learn how to permanently delete your AffirmSpace account, what happens to your data after deletion, and what to do before deleting your account.">

    <meta name="author" content="AffirmSpace">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
@endsection


@section('css')
<style>

    /* =========================================================
       AFFIRMSPACE ACCOUNT DELETION PAGE
       Scoped styles only
    ========================================================= */

    .as-delete-page {
        font-family: 'Inter', sans-serif;
        color: #222;
        background: #fff;
    }

    .as-delete-page *,
    .as-delete-page *::before,
    .as-delete-page *::after {
        box-sizing: border-box;
    }


    /* =========================================================
       HERO
    ========================================================= */

    .as-delete-hero {
        position: relative;
        min-height: 430px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 110px 7%;
        overflow: hidden;
        text-align: center;
        color: #fff;
    }

    .as-delete-hero-image {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 0;
    }

    .as-delete-hero-overlay {
        position: absolute;
        inset: 0;
        background:
            linear-gradient(
                135deg,
                rgba(255, 81, 47, 0.70),
                rgba(221, 36, 118, 0.73)
            ),
            rgba(0, 0, 0, 0.42);
        z-index: 1;
    }

    .as-delete-hero-content {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 850px;
        margin: 0 auto;
    }

    .as-delete-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 18px;
        padding: 8px 16px;
        border: 1px solid rgba(255,255,255,0.35);
        border-radius: 50px;
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .as-delete-eyebrow i {
        font-size: 13px;
    }

    .as-delete-hero h1 {
        margin: 0 0 18px;
        font-size: clamp(2.2rem, 5vw, 4rem);
        line-height: 1.08;
        font-weight: 800;
        letter-spacing: -1.5px;
    }

    .as-delete-hero-description {
        max-width: 720px;
        margin: 0 auto;
        color: rgba(255,255,255,0.93);
        font-size: 17px;
        line-height: 1.75;
    }


    /* =========================================================
       INTRO
    ========================================================= */

    .as-delete-intro {
        padding: 75px 7% 30px;
        background: #fff;
    }

    .as-delete-container {
        max-width: 1050px;
        margin: 0 auto;
    }

    .as-delete-intro-box {
        position: relative;
        padding: 30px 34px;
        border: 1px solid #f1e3e8;
        border-radius: 20px;
        background: linear-gradient(
            135deg,
            #fff7f9,
            #fff
        );
        box-shadow: 0 10px 35px rgba(221,36,118,0.06);
        overflow: hidden;
    }

    .as-delete-intro-box::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(
            180deg,
            #ff512f,
            #dd2476
        );
    }

    .as-delete-intro-box p {
        margin: 0;
        color: #555;
        font-size: 15px;
        line-height: 1.8;
    }

    .as-delete-intro-box strong {
        color: #222;
    }


    /* =========================================================
       MAIN CONTENT
    ========================================================= */

    .as-delete-content {
        padding: 35px 7% 100px;
        background: #fff;
    }


    /* =========================================================
       SECTION HEADING
    ========================================================= */

    .as-delete-section-heading {
        margin-bottom: 24px;
    }

    .as-delete-section-heading h2 {
        margin: 0 0 9px;
        color: #181818;
        font-size: 27px;
        line-height: 1.25;
        font-weight: 800;
        letter-spacing: -0.4px;
    }

    .as-delete-section-heading p {
        margin: 0;
        color: #707070;
        font-size: 14px;
        line-height: 1.7;
    }


    /* =========================================================
       DELETE STEPS
    ========================================================= */

    .as-delete-steps {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 15px;
        margin-bottom: 65px;
    }

    .as-delete-step {
        position: relative;
        padding: 25px 19px 22px;
        border: 1px solid #eeeeee;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 8px 28px rgba(0,0,0,0.045);
        transition:
            transform 0.25s ease,
            box-shadow 0.25s ease,
            border-color 0.25s ease;
    }

    .as-delete-step:hover {
        transform: translateY(-4px);
        border-color: rgba(221,36,118,0.18);
        box-shadow: 0 14px 35px rgba(221,36,118,0.08);
    }

    .as-delete-step-number {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        border-radius: 13px;
        background: linear-gradient(
            135deg,
            #fff0f4,
            #fff6f1
        );
        color: #dd2476;
        font-size: 15px;
        font-weight: 800;
    }

    .as-delete-step h3 {
        margin: 0 0 9px;
        color: #191919;
        font-size: 15px;
        line-height: 1.4;
        font-weight: 750;
    }

    .as-delete-step p {
        margin: 0;
        color: #686868;
        font-size: 13px;
        line-height: 1.65;
    }


    /* =========================================================
       WARNING CARD
    ========================================================= */

    .as-delete-warning {
        display: flex;
        align-items: flex-start;
        gap: 17px;
        margin: 0 0 65px;
        padding: 24px 26px;
        border: 1px solid #f3dce3;
        border-radius: 18px;
        background: #fff7f9;
    }

    .as-delete-warning-icon {
        flex-shrink: 0;
        width: 43px;
        height: 43px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: linear-gradient(
            135deg,
            #ff512f,
            #dd2476
        );
        color: #fff;
        font-size: 17px;
    }

    .as-delete-warning h3 {
        margin: 1px 0 7px;
        color: #222;
        font-size: 16px;
        font-weight: 750;
    }

    .as-delete-warning p {
        margin: 0;
        color: #626262;
        font-size: 14px;
        line-height: 1.7;
    }


    /* =========================================================
       TWO COLUMN INFORMATION
    ========================================================= */

    .as-delete-info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
        margin-bottom: 65px;
    }

    .as-delete-info-card {
        padding: 30px;
        border: 1px solid #eeeeee;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 8px 30px rgba(0,0,0,0.045);
        transition:
            transform 0.25s ease,
            box-shadow 0.25s ease,
            border-color 0.25s ease;
    }

    .as-delete-info-card:hover {
        transform: translateY(-3px);
        border-color: rgba(221,36,118,0.16);
        box-shadow: 0 14px 38px rgba(221,36,118,0.07);
    }

    .as-delete-info-icon {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        border-radius: 13px;
        background: #fff1f5;
        color: #dd2476;
        font-size: 18px;
    }

    .as-delete-info-card h3 {
        margin: 0 0 13px;
        color: #191919;
        font-size: 19px;
        font-weight: 750;
    }

    .as-delete-info-card p {
        margin: 0 0 12px;
        color: #626262;
        font-size: 14px;
        line-height: 1.75;
    }

    .as-delete-info-card p:last-child {
        margin-bottom: 0;
    }

    .as-delete-info-card ul {
        margin: 0;
        padding-left: 20px;
        color: #5e5e5e;
    }

    .as-delete-info-card li {
        margin-bottom: 9px;
        padding-left: 3px;
        font-size: 14px;
        line-height: 1.6;
    }

    .as-delete-info-card li:last-child {
        margin-bottom: 0;
    }

    .as-delete-info-card li::marker {
        color: #dd2476;
    }


    /* =========================================================
       BEFORE YOU DELETE
    ========================================================= */

    .as-delete-before {
        margin-bottom: 65px;
        padding: 32px 34px;
        border-radius: 20px;
        background: #fafafa;
        border: 1px solid #eeeeee;
    }

    .as-delete-before-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 13px;
    }

    .as-delete-before-icon {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 12px;
        background: linear-gradient(
            135deg,
            #fff1f4,
            #fff7f0
        );
        color: #dd2476;
    }

    .as-delete-before h2 {
        margin: 0;
        color: #1b1b1b;
        font-size: 21px;
        font-weight: 750;
    }

    .as-delete-before > p {
        margin: 0 0 18px;
        color: #646464;
        font-size: 14px;
        line-height: 1.75;
    }

    .as-delete-before-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .as-delete-before-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 14px 15px;
        border-radius: 12px;
        background: #fff;
        border: 1px solid #eeeeee;
        color: #555;
        font-size: 13px;
        line-height: 1.55;
    }

    .as-delete-before-item i {
        flex-shrink: 0;
        margin-top: 3px;
        color: #dd2476;
        font-size: 12px;
    }


    /* =========================================================
       HELP / CONTACT
    ========================================================= */

    .as-delete-help {
        padding: 55px 30px;
        border-radius: 24px;
        text-align: center;
        color: #fff;
        background: linear-gradient(
            135deg,
            #ff512f,
            #dd2476
        );
        box-shadow: 0 18px 45px rgba(221,36,118,0.20);
    }

    .as-delete-help-icon {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 17px;
        border-radius: 16px;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.25);
        font-size: 20px;
    }

    .as-delete-help h2 {
        margin: 0 0 11px;
        font-size: 30px;
        font-weight: 800;
    }

    .as-delete-help p {
        max-width: 620px;
        margin: 0 auto 23px;
        color: rgba(255,255,255,0.92);
        font-size: 15px;
        line-height: 1.7;
    }

    .as-delete-email {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 13px 23px;
        border-radius: 50px;
        background: #fff;
        color: #dd2476;
        font-size: 14px;
        font-weight: 750;
        text-decoration: none;
        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease;
    }

    .as-delete-email:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(0,0,0,0.15);
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1050px) {

        .as-delete-steps {
            grid-template-columns: repeat(3, 1fr);
        }
    }


    @media (max-width: 800px) {

        .as-delete-hero {
            min-height: 390px;
            padding: 95px 6%;
        }

        .as-delete-intro,
        .as-delete-content {
            padding-left: 5%;
            padding-right: 5%;
        }

        .as-delete-steps {
            grid-template-columns: repeat(2, 1fr);
        }

        .as-delete-info-grid {
            grid-template-columns: 1fr;
        }
    }


    @media (max-width: 600px) {

        .as-delete-hero {
            min-height: 360px;
            padding: 85px 20px 70px;
        }

        .as-delete-hero h1 {
            font-size: 2.15rem;
            letter-spacing: -0.8px;
        }

        .as-delete-hero-description {
            font-size: 15px;
            line-height: 1.65;
        }

        .as-delete-intro {
            padding: 45px 18px 20px;
        }

        .as-delete-content {
            padding: 25px 18px 70px;
        }

        .as-delete-intro-box {
            padding: 24px 22px;
        }

        .as-delete-steps {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .as-delete-step {
            padding: 23px 20px;
        }

        .as-delete-warning {
            padding: 21px;
        }

        .as-delete-info-card {
            padding: 25px 22px;
        }

        .as-delete-before {
            padding: 25px 22px;
        }

        .as-delete-before-list {
            grid-template-columns: 1fr;
        }

        .as-delete-help {
            padding: 43px 20px;
            border-radius: 20px;
        }

        .as-delete-help h2 {
            font-size: 25px;
        }
    }


    @media (max-width: 380px) {

        .as-delete-hero h1 {
            font-size: 1.9rem;
        }

        .as-delete-hero-description {
            font-size: 14px;
        }

        .as-delete-warning {
            flex-direction: column;
        }

        .as-delete-before-header {
            align-items: flex-start;
        }
    }

</style>
@endsection


@section('content')

<div class="as-delete-page">

    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="as-delete-hero">

        <img
            src="{{ asset('images/coursel.png') }}"
            class="as-delete-hero-image"
            alt="LGBTQ community celebrating together">

        <div class="as-delete-hero-overlay"></div>

        <div class="as-delete-hero-content">

            <div class="as-delete-eyebrow">
                <i class="fa-solid fa-user-slash"></i>
                Account &amp; Privacy
            </div>

            <h1>Delete Your AffirmSpace Account</h1>

            <p class="as-delete-hero-description">
                You can permanently delete your AffirmSpace account directly
                from the app. Deletion is immediate and cannot be undone.
            </p>

        </div>

    </section>


    {{-- =====================================================
         INTRO
    ====================================================== --}}

    <section class="as-delete-intro">

        <div class="as-delete-container">

            <div class="as-delete-intro-box">

                <p>
                    You can delete your AffirmSpace account at any time,
                    directly from the app. Once deleted, your account and
                    personal data are permanently removed from our systems
                    immediately.
                </p>

                <p style="margin-top:12px;">
                    <strong>This action cannot be undone.</strong>
                    There is no separate "deactivate" option, so make sure
                    you are ready before confirming deletion.
                </p>

            </div>

        </div>

    </section>


    {{-- =====================================================
         HOW TO DELETE
    ====================================================== --}}

    <section class="as-delete-content">

        <div class="as-delete-container">

            <div class="as-delete-section-heading">

                <h2>How to Delete Your Account</h2>

                <p>
                    Follow these steps from inside the AffirmSpace mobile app.
                </p>

            </div>


            <div class="as-delete-steps">

                <div class="as-delete-step">

                    <div class="as-delete-step-number">
                        01
                    </div>

                    <h3>Go to Your Profile</h3>

                    <p>
                        Open AffirmSpace and navigate to your Profile.
                    </p>

                </div>


                <div class="as-delete-step">

                    <div class="as-delete-step-number">
                        02
                    </div>

                    <h3>Open the Menu</h3>

                    <p>
                        Tap the three dots in the top-right corner.
                    </p>

                </div>


                <div class="as-delete-step">

                    <div class="as-delete-step-number">
                        03
                    </div>

                    <h3>Select Delete Account</h3>

                    <p>
                        Choose <strong>Delete Account</strong> from the menu.
                    </p>

                </div>


                <div class="as-delete-step">

                    <div class="as-delete-step-number">
                        04
                    </div>

                    <h3>Review the Warning</h3>

                    <p>
                        A confirmation popup will explain that deletion
                        cannot be undone.
                    </p>

                </div>


                <div class="as-delete-step">

                    <div class="as-delete-step-number">
                        05
                    </div>

                    <h3>Confirm Deletion</h3>

                    <p>
                        Confirm to permanently delete your account and
                        associated data immediately.
                    </p>

                </div>

            </div>


            {{-- =================================================
                 CONFIRMATION WARNING
            ================================================== --}}

            <div class="as-delete-warning">

                <div class="as-delete-warning-icon">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>

                <div>

                    <h3>
                        Deletion is permanent
                    </h3>

                    <p>
                        The confirmation popup will ask:
                        <strong>
                            "Are you sure you want to permanently delete
                            your account? This action cannot be undone."
                        </strong>
                        Once you confirm, your account and associated data
                        will be deleted immediately.
                    </p>

                </div>

            </div>


            {{-- =================================================
                 WHAT HAPPENS
            ================================================== --}}

            <div class="as-delete-section-heading">

                <h2>What Happens When You Delete Your Account</h2>

                <p>
                    Account deletion is permanent and takes effect immediately.
                </p>

            </div>


            <div class="as-delete-info-grid">


                {{-- REMOVED DATA --}}

                <div class="as-delete-info-card">

                    <div class="as-delete-info-icon">
                        <i class="fa-solid fa-trash-can"></i>
                    </div>

                    <h3>Your Data Is Permanently Removed</h3>

                    <ul>

                        <li>
                            Your profile, photos, bio, and posts are
                            permanently removed.
                        </li>

                        <li>
                            Your chats and messages are permanently removed.
                        </li>

                        <li>
                            Your counselling session data is permanently
                            removed.
                        </li>

                        <li>
                            The email address used to create your account
                            is fully removed from our systems, with no trace
                            left.
                        </li>

                    </ul>

                </div>


                {{-- PERMANENT ACTION --}}

                <div class="as-delete-info-card">

                    <div class="as-delete-info-icon">
                        <i class="fa-solid fa-lock"></i>
                    </div>

                    <h3>Deletion Cannot Be Reversed</h3>

                    <p>
                        Your account cannot be recovered or restored once
                        it has been deleted.
                    </p>

                    <p>
                        There is no separate
                        <strong>"deactivate"</strong> option. If you confirm
                        deletion, the account is permanently removed.
                    </p>

                </div>

            </div>


            {{-- =================================================
                 BEFORE YOU DELETE
            ================================================== --}}

            <div class="as-delete-before">

                <div class="as-delete-before-header">

                    <div class="as-delete-before-icon">
                        <i class="fa-solid fa-box-archive"></i>
                    </div>

                    <h2>Before You Delete</h2>

                </div>

                <p>
                    Since this action is permanent and immediate, we recommend
                    saving anything you want to keep before confirming deletion.
                    Once the account is deleted, this information won't be
                    recoverable afterward.
                </p>


                <div class="as-delete-before-list">

                    <div class="as-delete-before-item">

                        <i class="fa-solid fa-check"></i>

                        <span>
                            Save any chat conversations you may want to keep.
                        </span>

                    </div>


                    <div class="as-delete-before-item">

                        <i class="fa-solid fa-check"></i>

                        <span>
                            Save any counselling notes or information you
                            want to retain.
                        </span>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 NEED HELP
            ================================================== --}}

            <div class="as-delete-help">

                <div class="as-delete-help-icon">
                    <i class="fa-solid fa-headset"></i>
                </div>

                <h2>Need Help?</h2>

                <p>
                    If you run into any issue while deleting your account,
                    or have questions before you do, reach out to the
                    AffirmSpace support team.
                </p>

                <a
                    href="mailto:info@affirmspace.com"
                    class="as-delete-email">

                    <i class="fa-solid fa-envelope"></i>

                    info@affirmspace.com

                </a>

            </div>

        </div>

    </section>

</div>

@endsection