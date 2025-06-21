<?php

namespace App\Mail;

use App\Models\Certificate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CertificateIssued extends Mailable
{
    use Queueable, SerializesModels;

    public $certificate;

    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    public function build()
    {
        return $this->subject('🎉 Chúc mừng! Bạn đã nhận được chứng chỉ hoàn thành khóa học')
            ->view('emails.certificate-issued')
            ->with([
                'studentName' => $this->certificate->student->name,
                'courseName' => $this->certificate->course->title,
                'certificateNumber' => $this->certificate->certificate_number,
                'downloadUrl' => $this->certificate->download_url,
                'verificationUrl' => $this->certificate->verification_url,
            ]);
    }
}

