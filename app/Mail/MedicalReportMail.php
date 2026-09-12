<?php

namespace App\Mail;

use App\Models\Pet_info;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MedicalReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public Pet_info $pet;
    public User $doctor;
    public string $diagnosis;
    public ?string $treatment;
    public ?string $visitDate;

    public function __construct(Pet_info $pet, User $doctor, string $diagnosis, ?string $treatment = null, ?string $visitDate = null)
    {
        $this->pet = $pet;
        $this->doctor = $doctor;
        $this->diagnosis = $diagnosis;
        $this->treatment = $treatment;
        $this->visitDate = $visitDate ?? date('Y-m-d');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Medical Report for {$this->pet->name} - PetCare",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.medical-report',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
