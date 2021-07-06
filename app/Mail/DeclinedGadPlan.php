<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeclinedGadPlan    extends Mailable
{
    private $date;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($date)
    {
        //

        $this->date = $date; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.gad-plan.email.declined')
        ->subject('GAD Plan and Budget Review Result')
        ->with([
            'date' => $this->date
        ]);
    }
}
