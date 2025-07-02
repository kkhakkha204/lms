<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class PaymentEnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        // Courses có sẵn (loại trừ 19, 21, 23, 25, 27, 33, 34, 40)
        $availableCourses = [20, 22, 24, 26, 28, 29, 30, 31, 32, 35, 36, 37, 38, 39];

        // Students có sẵn (từ 20-39)
        $students = range(20, 39);

        // Giá khóa học mẫu (VND)
        $coursePrices = [
            20 => 2990000, 22 => 1990000, 24 => 3990000, 26 => 2490000,
            28 => 1490000, 29 => 3490000, 30 => 2990000, 31 => 1990000,
            32 => 4990000, 35 => 2490000, 36 => 3990000, 37 => 1990000,
            38 => 2990000, 39 => 3490000
        ];

        $payments = [];
        $enrollments = [];
        $usedCombinations = []; // Track student-course combinations

        $paymentId = 54;
        $enrollmentId = 53;

        // Tạo tất cả các combinations có thể
        $allCombinations = [];
        foreach ($students as $studentId) {
            foreach ($availableCourses as $courseId) {
                $allCombinations[] = ['student_id' => $studentId, 'course_id' => $courseId];
            }
        }

        // Shuffle để random
        shuffle($allCombinations);

        // Lấy 100 combinations đầu tiên
        $selectedCombinations = array_slice($allCombinations, 0, 100);

        // Tạo 100 records từ 2/7/2024 đến 2/7/2025
        foreach ($selectedCombinations as $index => $combination) {
            $courseId = $combination['course_id'];
            $studentId = $combination['student_id'];

            // Tạo ngày random trong khoảng thời gian
            $startDate = Carbon::create(2024, 7, 2);
            $endDate = Carbon::create(2025, 7, 2);
            $randomDate = $faker->dateTimeBetween($startDate, $endDate);
            $paidAt = Carbon::instance($randomDate);

            // Tính toán giá
            $originalPrice = $coursePrices[$courseId];
            $hasDiscount = $faker->boolean(30); // 30% chance có discount
            $discountAmount = $hasDiscount ? $faker->numberBetween(100000, 500000) : 0;
            $finalAmount = $originalPrice - $discountAmount;

            // Tạo transaction ID
            $transactionId = 'TXN_' . strtoupper($faker->bothify('????####')) . '_' . $paidAt->format('Ymd');

            // Payment status (95% completed, 5% các status khác)
            $paymentStatus = $faker->randomElement([
                'completed', 'completed', 'completed', 'completed', 'completed',
                'completed', 'completed', 'completed', 'completed', 'completed',
                'completed', 'completed', 'completed', 'completed', 'completed',
                'completed', 'completed', 'completed', 'completed', 'failed'
            ]);

            // Tạo payment details
            $paymentDetails = json_encode([
                'stripe_payment_intent_id' => 'pi_' . strtolower($faker->bothify('??????????')),
                'stripe_charge_id' => 'ch_' . strtolower($faker->bothify('??????????')),
                'card_last4' => $faker->numberBetween(1000, 9999),
                'card_brand' => $faker->randomElement(['visa', 'mastercard', 'jcb']),
                'receipt_url' => 'https://pay.stripe.com/receipts/' . $faker->bothify('??????????')
            ]);

            // Payment record
            $payments[] = [
                'id' => $paymentId,
                'student_id' => $studentId,
                'course_id' => $courseId,
                'transaction_id' => $transactionId,
                'payment_method' => 'stripe',
                'amount' => $originalPrice,
                'discount_amount' => $discountAmount,
                'final_amount' => $finalAmount,
                'currency' => 'VND',
                'status' => $paymentStatus,
                'payment_details' => $paymentDetails,
                'failure_reason' => $paymentStatus === 'failed' ? 'Insufficient funds' : null,
                'paid_at' => $paymentStatus === 'completed' ? $paidAt : null,
                'created_at' => $paidAt,
                'updated_at' => $paidAt,
            ];

            // Chỉ tạo enrollment nếu payment completed
            if ($paymentStatus === 'completed') {
                // Enrollment status
                $enrollmentStatus = $faker->randomElement([
                    'active', 'active', 'active', 'active', 'active',
                    'active', 'active', 'completed', 'active', 'active'
                ]);

                // Progress (0-100%)
                $progressPercentage = $enrollmentStatus === 'completed' ? 100 : $faker->numberBetween(5, 95);
                $lessonsCompleted = $faker->numberBetween(1, 15);
                $quizzesCompleted = $faker->numberBetween(0, 5);
                $averageQuizScore = $quizzesCompleted > 0 ? $faker->randomFloat(2, 60, 100) : 0;

                // Completion date
                $completedAt = null;
                if ($enrollmentStatus === 'completed') {
                    $completedAt = Carbon::instance($paidAt)->addDays($faker->numberBetween(30, 180));
                }

                // Expiration date (1 năm từ ngày enroll)
                $expiresAt = Carbon::instance($paidAt)->addYear();

                // Enrollment record
                $enrollments[] = [
                    'id' => $enrollmentId,
                    'student_id' => $studentId,
                    'course_id' => $courseId,
                    'paid_amount' => $finalAmount,
                    'status' => $enrollmentStatus,
                    'enrolled_at' => $paidAt,
                    'expires_at' => $expiresAt,
                    'completed_at' => $completedAt,
                    'progress_percentage' => $progressPercentage,
                    'lessons_completed' => $lessonsCompleted,
                    'quizzes_completed' => $quizzesCompleted,
                    'average_quiz_score' => $averageQuizScore,
                    'created_at' => $paidAt,
                    'updated_at' => $completedAt ?? $paidAt,
                ];

                $enrollmentId++;
            }

            $paymentId++;
        }

        // Insert payments
        foreach (array_chunk($payments, 50) as $chunk) {
            DB::table('payments')->insert($chunk);
        }

        // Insert enrollments
        foreach (array_chunk($enrollments, 50) as $chunk) {
            DB::table('enrollments')->insert($chunk);
        }

        $this->command->info('Created ' . count($payments) . ' payments and ' . count($enrollments) . ' enrollments');
    }
}
