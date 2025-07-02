<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class AdditionalPaymentEnrollmentSeeder extends Seeder
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

        // Lấy các enrollment combinations đã tồn tại để tránh duplicate
        $existingEnrollments = DB::table('enrollments')
            ->select('student_id', 'course_id')
            ->get()
            ->map(function($item) {
                return $item->student_id . '-' . $item->course_id;
            })->toArray();

        $payments = [];
        $enrollments = [];

        $paymentId = 154; // Bắt đầu từ 154
        $enrollmentId = DB::table('enrollments')->max('id') + 1; // Tự động lấy ID tiếp theo

        // Tạo tất cả các combinations có thể
        $allCombinations = [];
        foreach ($students as $studentId) {
            foreach ($availableCourses as $courseId) {
                $combinationKey = $studentId . '-' . $courseId;
                // Chỉ thêm nếu chưa tồn tại enrollment
                if (!in_array($combinationKey, $existingEnrollments)) {
                    $allCombinations[] = ['student_id' => $studentId, 'course_id' => $courseId];
                }
            }
        }

        // Shuffle để random
        shuffle($allCombinations);

        // Lấy 30 combinations đầu tiên
        $selectedCombinations = array_slice($allCombinations, 0, 30);

        // Tạo 30 records từ 30/6/2025 đến 30/7/2025
        foreach ($selectedCombinations as $index => $combination) {
            $courseId = $combination['course_id'];
            $studentId = $combination['student_id'];

            // Tạo ngày random trong khoảng thời gian
            $startDate = Carbon::create(2025, 6, 30);
            $endDate = Carbon::create(2025, 7, 30);
            $randomDate = $faker->dateTimeBetween($startDate, $endDate);
            $paidAt = Carbon::instance($randomDate);

            // Tính toán giá
            $originalPrice = $coursePrices[$courseId];
            $hasDiscount = $faker->boolean(35); // 35% chance có discount
            $discountAmount = $hasDiscount ? $faker->numberBetween(150000, 600000) : 0;
            $finalAmount = $originalPrice - $discountAmount;

            // Tạo transaction ID
            $transactionId = 'TXN_' . strtoupper($faker->bothify('????####')) . '_' . $paidAt->format('Ymd');

            // Payment status (92% completed, 8% các status khác)
            $paymentStatus = $faker->randomElement([
                'completed', 'completed', 'completed', 'completed', 'completed',
                'completed', 'completed', 'completed', 'completed', 'completed',
                'completed', 'completed', 'completed', 'completed', 'completed',
                'completed', 'completed', 'completed', 'failed', 'pending'
            ]);

            // Tạo payment details
            $paymentDetails = json_encode([
                'stripe_payment_intent_id' => 'pi_' . strtolower($faker->bothify('??????????')),
                'stripe_charge_id' => 'ch_' . strtolower($faker->bothify('??????????')),
                'card_last4' => $faker->numberBetween(1000, 9999),
                'card_brand' => $faker->randomElement(['visa', 'mastercard', 'jcb', 'amex']),
                'receipt_url' => 'https://pay.stripe.com/receipts/' . $faker->bothify('??????????'),
                'billing_country' => 'VN',
                'customer_email' => $faker->email
            ]);

            $failureReason = null;
            if ($paymentStatus === 'failed') {
                $failureReason = $faker->randomElement([
                    'Insufficient funds',
                    'Card declined',
                    'Expired card',
                    'Invalid card number'
                ]);
            }

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
                'failure_reason' => $failureReason,
                'paid_at' => $paymentStatus === 'completed' ? $paidAt : null,
                'created_at' => $paidAt,
                'updated_at' => $paidAt,
            ];

            // Chỉ tạo enrollment nếu payment completed
            if ($paymentStatus === 'completed') {
                // Enrollment status - mới nên chủ yếu active
                $enrollmentStatus = $faker->randomElement([
                    'active', 'active', 'active', 'active', 'active',
                    'active', 'active', 'active', 'completed', 'active'
                ]);

                // Progress (vì mới nên thấp hơn)
                if ($enrollmentStatus === 'completed') {
                    $progressPercentage = 100;
                    $lessonsCompleted = $faker->numberBetween(10, 20);
                } else {
                    $progressPercentage = $faker->numberBetween(0, 50); // Mới học nên progress thấp
                    $lessonsCompleted = $faker->numberBetween(0, 8);
                }

                $quizzesCompleted = $faker->numberBetween(0, 3);
                $averageQuizScore = $quizzesCompleted > 0 ? $faker->randomFloat(2, 65, 95) : 0;

                // Completion date
                $completedAt = null;
                if ($enrollmentStatus === 'completed') {
                    $completedAt = Carbon::instance($paidAt)->addDays($faker->numberBetween(15, 45));
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
        if (!empty($payments)) {
            foreach (array_chunk($payments, 20) as $chunk) {
                DB::table('payments')->insert($chunk);
            }
        }

        // Insert enrollments
        if (!empty($enrollments)) {
            foreach (array_chunk($enrollments, 20) as $chunk) {
                DB::table('enrollments')->insert($chunk);
            }
        }

        $this->command->info('Created ' . count($payments) . ' additional payments and ' . count($enrollments) . ' additional enrollments');
        $this->command->info('Available combinations remaining: ' . (count($allCombinations) - 30));
    }
}
