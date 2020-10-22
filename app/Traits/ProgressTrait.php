<?php

namespace App\Traits;


trait ProgressTrait
{
    public function progress()
    {
        switch ($this->status) {
            case 'WSTF Approved':
                $progress = 100;
                break;
            case 'WASREB Approved':
                $progress = 75;
                break;
            case 'Needs Approval':
                $progress = 50;
                break;
            case 'Needs Review':
                $progress = 25;
                break;
            case 'Pending':
                $progress = 10;
                break;
            default:
                $progress = 0;
        }
        return $progress;
    }

}
