<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\RequestRepository;
use App\Repositories\EmailHistoryRepository;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExpiredRequest;
use App\Models\EmailHistory;
use Carbon\Carbon;

class EmailExpiredRequest extends Command
{
    /** @var  RequestRepository */
    private $requestRepository;

    /** @var  EmailHistoryRepo */
    private $emailHistoryRepo;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:expired-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to expired request';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(RequestRepository $requestRepo, EmailHistoryRepository $emailHistoryRepo)
    {
        parent::__construct();
        $this->requestRepository = $requestRepo;
        $this->emailHistoryRepo  = $emailHistoryRepo;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $expiredRequests = $this->requestRepository->expiredRequests()->get();
        foreach ($expiredRequests as $request) {
            $user                       = $request->user;
            $device                     = $request->device;
            $project                    = $request->project;
            $emailHistory               = [];
            $emailHistory['user_id']    = $user->id;
            $emailHistory['user_email'] = $user->email;
            $emailHistory['type']       = EmailHistory::TYPE_EXPIRED_REQUEST;
            $emailHistory['status']     = EmailHistory::STATUS_SUCCESS;
            Mail::to($user)->send(new ExpiredRequest($user, $request, $device, $project));
            if (Mail::failures()) {
                $emailHistory['status'] = EmailHistory::STATUS_ERROR;
            }
            $this->emailHistoryRepo->create($emailHistory);
        }
        $this->info(EXPIRED_REQUEST_COMMAND_TEXT);
    }
}
