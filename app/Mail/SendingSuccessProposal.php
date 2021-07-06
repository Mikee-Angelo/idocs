<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendingSuccessProposal extends Mailable
{
    private $prop_no; 
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($prop_no)
    {
        //

        $this->prop_no = $prop_no;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.proposal.email.success')
        ->subject('Proposal Review')
        ->with([
            'prop_no' => $this->prop_no,
            'date' => date('Y'),
        ]);
    }
}
