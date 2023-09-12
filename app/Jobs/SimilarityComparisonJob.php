<?php

namespace App\Jobs;

use App\Repositories\ComparisonRepository;
use App\Services\ApiClient;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SimilarityComparisonJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $brandId;

    protected $path;

    protected $userId;

    protected $filter;

    protected $aspects;

    protected $subaspects;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($brandId = null, $path, $userId, $filter, $aspects = null, $subaspects = null)
    {
        if(isset($brandId)){
            $this->brandId = $brandId;
        }

        $this->path = $path;

        $this->userId = $userId;

        $this->filter = $filter;

        if(isset($aspects)){
            $this->aspects = $aspects;
        }

        if(isset($subaspects)){
            $this->subaspects = $subaspects;
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        set_time_limit(0);

        $token = session()->get('token');

        $response = $this->switchBetweenFilters($token);


        if ($response->status() == 401) {
            $token = ApiClient::setToken();
            $response = $this->switchBetweenFilters($token);
        }

        if ($response->status() == 200) {
            $comparisons = $response->json();

            $keys = array_column($comparisons, 'meanValue');
            array_multisort($keys, SORT_ASC, $comparisons);

            $path = 'comparisons/' . uniqid() . '.json';

            Storage::disk('s3')->put(
                $path,
                json_encode($comparisons),
                'public'
            );

            $repository = new ComparisonRepository();

            $urlComparison = Storage::disk('s3')->url($path);

            $comparison = [
                'filter' => $this->filter,
                'path' => $this->path,
                'result' => $urlComparison,
                'userId' => $this->userId,
            ];

            if(isset($this->brandId)){
                $comparison['brandId'] = $this->brandId;
            }

            $repository->save($comparison);
        }
    }

    public function switchBetweenFilters($token)
    {
        switch ($this->filter) {
            case 'default':
                return ApiClient::similarityVerification($this->path, $token);
                break;
            case 'aspects':
                return ApiClient::similarityVerificationWithAspects($this->path, $token, $this->aspects);
                break;
            case 'subaspects':
                return ApiClient::similarityVerificationWithSubaspects($this->path, $token, $this->subaspects);
                break;
        }
    }
}
