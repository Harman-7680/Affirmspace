<?php
namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Seeder;

class SpecializationsTableSeeder extends Seeder
{
    public function run()
    {
        $items = [
            "Doctors",
            "Endocrinologists",
            "Gender-Affirming Surgeons",
            "Voice Therapists",
            "Dermatologists",
            "Gynecologists / Andrologists",
            "Primary Care Physicians",
            "Clinical Psychologists",
            "Psychiatrists",
            "LGBTQ+ Counselors / Therapists",
            "Couples & Family Therapists",
            "Sex Therapists",
            "Sexual Health Physicians / HIV Specialists",
            "OB-GYNs familiar with LGBTQ+ patients",
            "Urologists",
            "Fertility Specialists",
            "Nutritionists / Dietitians",
            "Physiotherapists",
            "Immunologists / Infectious Disease Specialists",
            "Community Health Workers",
            "Alternative Medicine Practitioners",
            "Telehealth Specialists",
        ];

        foreach ($items as $name) {
            Specialization::firstOrCreate(['name' => $name], ['is_active' => true]);
        }
    }
}
