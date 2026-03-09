<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Model\Forms;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client as GuzzleHttpClient;
use Krizalys\Onedrive\Client;
use Microsoft\Graph\Graph;
use App\TokenStore\TokenCache;

class SyncOneDrive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $form_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($form_id = '')
    {
        $this->form_id = intval($form_id);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $form_id = $this->form_id;
        $error = false;
        $TUpdate = Forms::find($form_id);

        $list_forms = Forms::where('approved', '!=', 2)
            ->where(function ($query) use ($form_id) {
                if ($form_id != 0) {
                    $query->where('id', $form_id);
                }
            })
            ->get();
        $tokenCache = new TokenCache();
        $graph = new Graph();
        $graph->setAccessToken($tokenCache->getAccessToken(Auth::user()));

        $onedrive = new Client(
            config('azure.appId'),
            $graph,
            new GuzzleHttpClient()
        );

        foreach ($list_forms as $TUpdate) {
            $id_folder = str_replace("folder.", "", $TUpdate->path_work);
            if (!empty($id_folder)) {
                $folder = $onedrive->fetchDriveItem($id_folder);

                if ($folder->isFolder()) {
                    $driveItems = $folder->fetchDriveItems($folder->getId());

                    $count_total = count($driveItems);

                    $TUpdate->drive_item = $count_total;
                    if ((int)$TUpdate->name_number < ($count_total + 1)) {

                        $TUpdate->approved = '2';
                        $TUpdate->save();
                    }
                }
            }
        }
    }
}
