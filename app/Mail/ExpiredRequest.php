<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Request;
use App\Models\User;
use App\Models\Device;
use App\Models\Project;

class ExpiredRequest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The request instance.
     *
     * @var Request
     */
    public $request;

    /**
     * The user instance.
     *
     * @var User
     */
    public $user;

    /**
     * The device instance.
     *
     * @var Device
     */
    public $device;

    /**
     * The project instance.
     *
     * @var Project
     */
    public $project;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Request $request, Device $device, Project $project)
    {
        $this->request = $request;
        $this->device  = $device;
        $this->request = $request;
        $this->project = $project;
        $this->user    = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('request.expiredRequest'))
                    ->view('emails.expired_request');
    }
}
